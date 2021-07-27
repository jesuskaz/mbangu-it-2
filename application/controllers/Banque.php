<?php
class Banque extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("BanqueModel");
        $this->load->model("Manager");
    }
    //Get Banque Data in liste scroll
    // public function loadCompte()
    // {
    //     if (!$this->session->universite_session) {
    //         redirect();
    //     }

    //     $id = $this->session->universite_session;

    //     $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $id])->result_array();

    //     $data['devise'] = $this->db->get('devise')->result();
    //     $data['banques'] = $this->db->get('banque')->result();

    //     $this->load->view("universite/ajouter-compte", $data);
    // }
    public function listeCompte()
    {
        if (!$this->session->universite_session) {
            redirect();
        }
        $login = $this->session->userdata("universite_session");
        $iduniv = $this->session->universite_session;

        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise = frais.iddevise');
        $data["frais"] = $this->db->where(['iduniversite' => $iduniv])->get('frais')->result_array();
        $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $iduniv])->result_array();
        $data['devise'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $this->load->view("universite/liste-compte", $data);
    }

    function edit_f($id_frais = null)
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }

        $id_frais = (int) $id_frais;
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        if (!count($et = $this->db->where('idfrais', $id_frais)->get('frais')->result())) {
            redirect('banque/listecompte');
        }
        $et = $et[0];
        $data['frais'] = "$et->designation : $et->montant $et->nomDevise";
        $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $iduniv])->result_array();
        $data['devises'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $data['idfrais'] = $id_frais;
        $data['nom_f'] = $et->designation;
        $data['compte'] = $et->numeroCompte;
        $data['idbanque'] = $et->idbanque;
        $data['montant'] = $et->montant;
        $data['devise'] = $et->iddevise;
        $data['annee'] = $et->idanneeAcademique;
        $this->load->view("universite/edit_frais", $data);
    }

    function update_f()
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }
        // var_dump($_POST);
        $this->load->library('form_validation');
        $validation = new CI_Form_validation();

        $validation->set_rules('idfrais', '', 'required');
        $validation->set_rules('annee', '', 'required');
        $validation->set_rules('banque', '', 'required');
        $validation->set_rules('compte', '', 'required');
        $validation->set_rules('frais', '', 'required');
        $validation->set_rules('montant', '', 'required');
        $validation->set_rules('devise', '', 'required');

        if ($validation->run()) {
            $fr = $this->input->post('idfrais');
            if (!count($this->db->where(['idfrais' => $fr, 'iduniversite' => $iduniv])->get('frais')->result())) {
                redirect();
            }
            if (count($this->db->where(['paiement.idfrais' => $fr])->get('paiement')->result())) {
                $this->session->set_flashdata(['message' => "Vous ne pouvez plus modifier ce frais, car il existe déjà un paiement lié à ce frais.", 'classe' => 'danger']);
            } else {
                $this->db->update('frais', [
                    'idanneeAcademique' => $this->input->post('annee'),
                    'iddevise' => $this->input->post('devise'),
                    'numeroCompte' => $this->input->post('compte'),
                    'idbanque' => $this->input->post('banque'),
                    'designation' => $this->input->post('frais'),
                    'montant' => $this->input->post('montant'),
                ], ['idfrais' => $fr]);
                $this->session->set_flashdata(['message' => "Le frais a été mis à jour.", 'classe' => 'success']);
            }
            redirect('banque/edit_f/' . $fr);
        } else {
            redirect('banque/edit_f');
        }
    }

    function delete_f($idfrais = null)
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }
        $idfrais = (int) $idfrais;
        if (!count($this->db->where(['idfrais' => $idfrais, 'iduniversite' => $iduniv])->get('frais')->result())) {
            redirect();
        }
        if (count($this->db->where(['paiement.idfrais' => $idfrais])->get('paiement')->result())) {
            $this->session->set_flashdata(['message2' => "Vous ne pouvez plus supprimer ce frais, car il existe déjà un paiement lié à ce frais.", 'classe2' => 'danger']);
        } else {
            $this->db->delete('frais', ['idfrais' => $idfrais]);
            $this->session->set_flashdata(['message2' => "Le frais a été supprimé.", 'classe2' => 'success']);
        }
        redirect('banque/listecompte');
    }
    

    public function createBanque()
    {
        // Login n'est pas unique pour le moment
        $login = $this->session->userdata("login");

        $banque = $this->input->post("banque");
        $compte = $this->input->post("compte");
        $frais = $this->input->post("frais");
        $montant = $this->input->post("montant");
        $devise = $this->input->post("devise");
        $anneAcad = $this->input->post('annee');

        $idUversite = $this->session->universite_session;
        $idannee = $this->session->annee_academique;

        $data = [
            "designation" => $frais,
            "numeroCompte" => $compte,
            "idbanque" => $banque,
            "montant" => $montant,
            "iduniversite" => $idUversite,
            "idanneeAcademique" => $idannee,
            "iddevise" => $devise,
            "idanneeAcademique" => $anneAcad,
        ];

        $insertion = $this->db->insert('frais', $data);
        if ($insertion) {
            $id = $this->session->universite_session;
            $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $id])->result_array();

            $data['devise'] = $this->db->get('devise')->result();
            $data['banques'] = $this->db->get('banque')->result();
            $this->session->set_flashdata(['message' => "Compte ajoute avec succes", 'classe' => 'success']);
        } else {
            $id = $this->session->universite_session;
            $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $id])->result_array();

            $data['devise'] = $this->db->get('devise')->result();
            $data['banques'] = $this->db->get('banque')->result();
            $this->session->set_flashdata(['message' => "Echec lors de l'ajout du compte", 'classe' => 'error']);
        }
        redirect('banque/listecompte');
    }
    public function listeRapport()
    {
        if (!$this->session->universite_session) {
            redirect();
        }
        $iduniv = $this->session->userdata("universite_session");
        // $denomination = $this->Manager->rapportPayement($iduniv);

        $this->db->select("paiement.*, etudiant.nom, etudiant.postnom,
            etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, 
            promotion.intitulePromotion, frais.designation, frais.numeroCompte,banque.denomination, 
            paiement.montant, devise.nomDevise, promotion.idpromotion, options.idoptions");

        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');
        $this->db->where('frais.iduniversite', $iduniv);

        $this->db->group_by('paiement.idpaiement');
        $data["paies"] = $r = $this->db->get('paiement')->result_array();

        // $this->db->select('*');
        // $this->db->from('promotion');
        // $this->db->group_by('intitulePromotion');
        // $data["promotion"] = $r = $this->db->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('faculte');
        // $this->db->group_by('nomFaculte');
        // $data["faculte"] = $r = $this->db->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('options');
        // $this->db->group_by('intituleOptions');
        // $data["option"] = $r = $this->db->get()->result_array();

        $this->load->view("universite/liste-rapport", $data);
    }
    public function listeEtudiant()
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }
        $data["promotions"] = $this->db->where(['iduniversite' => $iduniv])->get('promotion')->result_array();
        $data["facultes"] = $this->db->where(['iduniversite' => $iduniv])->get('faculte')->result_array();
        $this->load->view("universite/liste-etudiant", $data);
    }

    public function rapportPayement()
    {
        if ($this->session->userdata("login")) {
            $idUversite = $this->session->userdata("login");
            $data = $this->Manager->rapportPayement($idUversite);
            if ($data) {
                $this->load->view("universite/index", $data);
            }
        } else {
            redirect("AdminCredential");
        }
    }

    function detail_etudiant($idetudiant = null)
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }
        $idetudiant = (int) $idetudiant;
        $ann = (int)  $this->session->annee_academique;
        $where = [
            'etudiant.idetudiant' => $idetudiant,
            'anneeAcademique.idanneeAcademique' => $ann,
            'anneeAcademique.iduniversite' => $iduniv,
        ];
        $this->db->join('anneeAcademique', 'etudiant.idanneeAcademique=anneeAcademique.idanneeAcademique');
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');
        if (!count($et = $this->db->where($where)->get('etudiant')->result())) {
            redirect('index/login');
        }

        // $this->db->select('paiement.idpaiement,paiement.idetudiant, frais.idfrais, 
        // frais.montant montant_frais, paiement.montant montant_paye, 
        // frais.designation frais, devise.nomDevise devise, date,
        // devise.iddevise
        // ');
        // $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        // $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        // $this->db->where('paiement.idetudiant', $idetudiant);
        // $this->db->group_by('paiement.idpaiement');

        // $data['paiements'] = $paie = $this->db->get('paiement')->result();
        $data['etudiant'] = $et[0];

        // SELECT
        // date,
        // montant,
        //     (
        //     SELECT
        //         SUM(f2.montant)
        //     FROM
        //         paiement f2
        //     WHERE
        //         f2.idpaiement <= paiement.idpaiement
        // ) AS "montant cumule"
        // FROM
        //     paiement
        // ORDER BY
        //     idpaiement

        // $sql = "SELECT paiement.idpaiement,paiement.idetudiant, frais.idfrais, 
        //     frais.montant montant_frais, paiement.montant montant_paye, 
        //     frais.designation frais, devise.nomDevise devise, date,
        //     devise.iddevise,
        //     (
        //         SELECT sum(f2.montant) from paiement f2 where f2.idpaiement <= paiement.idpaiement and 
        //         idetudiant = $idetudiant 
        //         group by idetudiant
        //     ) cumule
        //     from paiement
        //     join frais on frais.idfrais=paiement.idfrais 
        //     join devise on devise.iddevise=paiement.iddevise 
        //     where paiement.idetudiant = $idetudiant group by paiement.idpaiement, paiement.iddevise
        // ";
        // $data['paiements'] = $paie = $this->db->query($sql)->result();

        $listfrais = $this->db->where(['iduniversite' => $iduniv, 'idanneeAcademique' => $ann])->get('frais')->result();

        $tabpaie = [];
        foreach ($listfrais as $lf) {
            $sql = "SELECT paiement.idpaiement, paiement.idetudiant, frais.idfrais, 
                frais.montant montant_frais, paiement.montant montant_paye, 
                frais.designation frais, devise.nomDevise devise, date,
                devise.iddevise,
                (
                    SELECT sum(f2.montant) from paiement f2 where f2.idpaiement <= paiement.idpaiement and 
                    idetudiant = $idetudiant and f2.idfrais=$lf->idfrais
                    group by idetudiant order by f2.idfrais
                ) cumule
                from paiement
                join frais on frais.idfrais=paiement.idfrais 
                join devise on devise.iddevise=paiement.iddevise 
                where paiement.idetudiant = $idetudiant and frais.idfrais=$lf->idfrais 
                group by paiement.idpaiement order by paiement.idfrais

            ";
            $paie = $this->db->query($sql)->result();
            foreach ($paie as $p) {
                array_push($tabpaie, $p);
            }
            // var_dump($paie);
            // die;
        }
        // var_dump($final);
        // die;
        $data['paiements'] = $paie = $tabpaie;

        $devise = $this->db->get('devise')->result();
        $final = [];
        foreach ($devise as $dev) {
            $tab = [];
            foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $mois) {
                $montantPaie = 0;
                foreach ($paie as $p) {
                    $date = explode('-', $p->date);
                    $_mois = (int) $date[1];
                    if ($mois == $_mois and $dev->iddevise == $p->iddevise) {
                        $montantPaie += $p->montant_paye;
                    }
                }
                array_push($tab, $montantPaie);
            }
            $final[$dev->nomDevise] = $tab;
        }

        $data['graph'] = json_encode($final);

        $this->load->view("universite/detail_etudiant", $data);
    }

    function print($idetudiant = null)
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }
        // idetudiant - idpaiement //
        $d = explode('-', $idetudiant);
        if (count($d) != 2) {
            redirect('index/login');
        }
        $ann = (int)  $this->session->annee_academique;
        $idetudiant = (int) $d[0];
        $idpaiement = (int) $d[1];
        $where = [
            'etudiant.idetudiant' => $idetudiant,
            'anneeAcademique.idanneeAcademique' => $ann,
            'anneeAcademique.iduniversite' => $iduniv,
        ];
        $this->db->join('anneeAcademique', 'etudiant.idanneeAcademique=anneeAcademique.idanneeAcademique');
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');
        if (!count($et = $this->db->where($where)->get('etudiant')->result())) {
            redirect('index/login');
        }

        $data['etudiant'] = $et[0];
        $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        $this->db->select('universite.*, devise.nomDevise,frais.designation, frais.montant montant_frais,frais.numeroCompte,paiement.date, paiement.montant montant_paye');
        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('universite', 'universite.iduniversite=frais.iduniversite');

        $p = $this->db->where(['idpaiement' => $idpaiement, 'idetudiant' => $idetudiant])->get('paiement')->result();
        $data['paie'] = @$p[0];

        $this->load->view("universite/print", $data);
    }

    function profil()
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect();
        }
        $u = $this->db->where('iduniversite', $iduniv)->get('universite')->result()[0];
        $this->load->view("universite/profil", ['univ' => $u]);
    }
}
