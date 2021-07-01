<?php
class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            http_response_code(403);
            die('Not allowed');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("Manager");
    }

    function login()
    {
        $this->load->library('form_validation');
        $validation  = new CI_Form_validation();
        $validation->set_rules('login', '', 'required', ['required' => "Votre login est requis."]);
        $validation->set_rules('code', '', 'required', ['required' => "Votre mot de passe est requis."]);

        $re['status'] = false;
        if ($validation->run()) {
            $login = $this->input->post('login', true);
            $code = $this->input->post('code', true);

            if (count($r = $this->db->where(['login' => $login, 'password' => $code])->get('admin')->result())) {
                $re['status'] = true;
                $re['url'] = site_url('manager');
                $this->session->set_userdata(['isadmin' => true]);
            } else if (count($r = $this->db->where(['login' => $login, 'password' => $code])->get('banque')->result())) {
                $re['status'] = true;
                $re['url'] = site_url('banquee');
                $r = $r[0];
                $this->session->set_userdata(['bank_session' =>  $r->idbanque]);
            } else if (count($r = $this->db->where(['login' => $login, 'code' => $code])->get('universite')->result())) {
                $r = $r[0];
                $re['status'] = true;
                $re['url'] = site_url('index/home');
                // $this->session->set_userdata("login", $login);
                $this->session->set_userdata(['universite_session' =>  $r->iduniversite]);
                $r2 = $this->db->where(['iduniversite' => $r->iduniversite, 'actif' => 1])->get('anneeAcademique')->result();
                if (!count($r2)) {
                    $debut =  (new DateTime('first day of this month'))->format('Y-m-d');
                    $fin =  date('Y-m-d', strtotime((new DateTime('last day of this month'))->format('Y-m-d') . " + 365 day"));
                    $this->db->insert('anneeAcademique', [
                        'actif' => 1,
                        'iduniversite' => $r->iduniversite,
                        'annee' => "$debut $fin"
                    ]);
                    $ida = $this->db->insert_id();
                } else {
                    $ida = $r2[0]->idanneeAcademique;
                }
                $this->session->set_userdata(['annee_academique' =>  $ida]);
            } else {
                $re['message'] = 'login ou mot de passe incorrect.';
            }
        } else {
            $re['error'] = $validation->error_array();
        }

        echo json_encode($re);
    }

    function checktype($type)
    {
        if (!in_array($type, ['univ', 'admin', 'banque'])) {
            echo json_encode(['ERROR']);
            die;
        }

        if ($type == 'univ' and empty($this->session->userdata("universite_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'admin' and empty($this->session->userdata("isadmin"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'banque' and empty($this->session->userdata("bank_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }
    }

    function getallrapport()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);

        // var_dump($_GET); die;

        $faculte = $this->input->get('faculte', true);
        $promotion = $this->input->get('promotion', true);
        $option = $this->input->get('option', true);
        $d = $this->input->get('date', true);
        $d = explode('-', $d);
        $debut = str_replace('/', '-', trim(@$d[0]));
        $fin =  str_replace('/', '-', trim(@$d[1]));
        // var_dump($date_fin, $date_debut);
        // die;
        $devise = $this->input->get('devise', true);


        $this->db->select("paiement.idpaiement, paiement.date, etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, frais.numeroCompte, 
        frais.designation, promotion.intitulePromotion, faculte.nomFaculte, paiement.montant, devise.nomDevise");

        $this->db->where('cast(paiement.date as date) >=', $debut);
        $this->db->where('cast(paiement.date as date) <=', $fin);

        $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');


        // var_dump($_GET);
        // die;

        if ($type == 'univ') {
            $this->db->where('universite.iduniversite', $this->session->userdata("universite_session"));
        }

        if (!empty($faculte)) {
            $this->db->where('faculte.idfaculte', $faculte);
        }
        if (!empty($promotion)) {
            $this->db->where('promotion.idpromotion', $promotion);
        }
        if (!empty($option)) {
            $this->db->where('options.idoptions', $option);
        }
        if (!empty($devise)) {
            $this->db->where('paiement.iddevise', $devise);
        }

        $this->db->group_by('paiement.idpaiement');
        $r = $this->db->get('paiement')->result();

        echo json_encode([
            'data' => $r
        ]);
    }
    public function chart_universite()
    {
        $devise = (int) $this->input->get('devise');
        if ($devise) {
            $this->db->where('paiement.iddevise', $devise);
        }

        // var_dump($_GET, $devise);die;

        $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        $this->db->group_by('date');
        $paie = $this->db->get('paiement')->result();
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
                        $montantPaie += $p->montant;
                    }
                }
                array_push($tab, $montantPaie);
            }

            $final[$dev->nomDevise] = $tab;
        }

        // var_dump($final);
        echo json_encode($final);
    }


    function chart_data()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);

        $devise = (int) $this->input->get('devise');
        if ($devise) {
            $this->db->where('paiement.iddevise', $devise);
        }
        $this->db->join('devise', 'devise.iddevise=paiement.iddevise');

        if ($type == 'univ') {
            $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
            $this->db->where('frais.iduniversite', $this->session->userdata("universite_session"));
        }

        if ($type == 'admin') {
            $iduniv = (int) $this->input->get('universite');
            if ($iduniv) {
                $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
                $this->db->where('frais.iduniversite', $iduniv);
            }
        }

        $this->db->group_by('paiement.idpaiement');
        $paie = $this->db->get('paiement')->result();
        $devise = $this->db->get('devise')->result();

        // var_dump($paie);die;

        $final = [];
        foreach ($devise as $dev) {
            $tab = [];
            foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $mois) {
                $montantPaie = 0;
                foreach ($paie as $p) {
                    $date = explode('-', $p->date);
                    $_mois = (int) $date[1];
                    if ($mois == $_mois and $dev->iddevise == $p->iddevise) {
                        $montantPaie += $p->montant;
                    }
                }
                array_push($tab, $montantPaie);
            }

            $final[$dev->nomDevise] = $tab;
        }

        // var_dump($final);
        echo json_encode($final);
    }

    function select_data()
    {
        $faculte = (int) $this->input->get('faculte');
        $promotion = (int) $this->input->get('promotion');

        $this->db->select('options.idoptions,options.idfaculte,options.idpromotion, intituleOptions, promotion.intitulePromotion promotion');
        if ($faculte) {
            $where['options.idfaculte'] = $faculte;
        }
        if ($promotion) {
            $where['options.idpromotion'] = $promotion;
        }
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $where['faculte.iduniversite'] = $this->session->universite_session;
        $this->db->group_by('options.idoptions');
        $r = $this->db->where($where)->get('options')->result();

        // var_dump($_GET, $r);
        // die;
        echo json_encode($r);
    }

    function liste_etudiant()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);
        $faculte = $this->input->get('faculte', true);
        $promotion = $this->input->get('promotion', true);
        $option = $this->input->get('option', true);

        $this->db->select("etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, 
            etudiant.matricule, etudiant.adresse, etudiant.email, faculte.nomFaculte faculte, 
            promotion.intitulePromotion promotion, etudiant.telephone ");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion', 'left');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion', 'left');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');
        $iduniv = $this->session->userdata("universite_session");
        $this->db->where('promotion.iduniversite', $iduniv);

        if ($faculte) {
            $this->db->where('faculte.idfaculte', $faculte);
        }

        if ($promotion) {
            $this->db->where('promotion.idpromotion', $promotion);
        }

        if ($option) {
            $this->db->where('options.idoptions', $option);
        }
        $this->db->group_by('etudiant.idetudiant');
        $r = $this->db->get('etudiant')->result();
        echo json_encode(['data' => $r]);
    }

    function facultes()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);
        $iduniv = $this->input->get('universite', true);

        if ($iduniv) {
            $this->db->where('universite.iduniversite', $iduniv);
        }
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->select('nomFaculte faculte, nomUniversite universite');
        echo json_encode(['data' => $this->db->get('faculte')->result()]);
    }

    function liste_paie()
    {

        $type = $this->input->get('type', true);
        $this->checktype($type);
        $iduniv = (int) $this->input->get('universite', true);
        $date = $this->input->get('date', true);
        $date = explode('-', $date);
        $debut = str_replace('/', '-', $date[0]);
        $fin = str_replace('/', '-', $date[1]);

        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, 
        etudiant.matricule, etudiant.email, faculte.nomFaculte faculte, promotion.intitulePromotion promotion, options.intituleOptions option,
        frais.designation frais, frais.numeroCompte compte, banque.denomination banque, paiement.montant, paiement.commission, devise.nomDevise devise, nomUniversite universite");

        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');
        $this->db->group_by('paiement.idpaiement');

        $this->db->where('cast(paiement.date as date) >=', $debut);
        $this->db->where('cast(paiement.date as date) <=', $fin);

        $universite = '';
        if ($iduniv) {
            $this->db->where('universite.iduniversite', $iduniv);
        }
        $r = $this->db->get('paiement')->result();

        if ($iduniv) {
            // penser a filtre selon les annees academiques
            $total_paiement = $this->db->query("SELECT SUM(paiement.montant) total, SUM(commission) commission, nomDevise devise, devise.iddevise 
            FROM paiement join devise on devise.iddevise=paiement.iddevise join frais on paiement.idfrais=frais.idfrais 
            WHERE frais.iduniversite=$iduniv and cast(paiement.date as date) >='$debut' and cast(paiement.date as date) <='$fin'
            GROUP BY paiement.iddevise ")->result();
            $universite = ($this->db->where('iduniversite', $iduniv)->get('universite')->result())[0]->nomUniversite;
        } else {
            // penser a filtre selon les annees academiques
            $total_paiement = $this->db->query("SELECT SUM(paiement.montant) total, SUM(commission) commission, nomDevise devise, devise.iddevise 
             FROM paiement join devise on devise.iddevise=paiement.iddevise join frais on paiement.idfrais=frais.idfrais 
             where cast(paiement.date as date) >='$debut' and cast(paiement.date as date) <='$fin'
             GROUP BY paiement.iddevise ")->result();
        }

        echo json_encode(['data' => $r, 'paiement' => $total_paiement, 'universite' => $universite]);
    }

    function update_logo()
    {
        $this->checktype('univ');
        $path =  "upload/logo/";
        $f = $_FILES['logo']['name'] ?? '';
            $f = explode('.', $f);
            if (count($f) >= 2) {
                $exe = end($f);
                $f = time() . rand(1, 1000) . '.' . $exe;
            } else {
                $f = '';
            }
        $config = array(
            'upload_path' => $path,
            'overwrite' => TRUE,
            'allowed_types' => "jpg|jpeg|png|gif",
            'file_name' => $f
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('logo')) {
            $d = $this->upload->data();
            $nomFichier = $path . $d['file_name'];
            $where = ['iduniversite' => $this->session->universite_session];
            $r = $this->db->where($where)->get('universite')->result()[0];
            @unlink($r->logo);
            $this->db->update('universite', ['logo' => $nomFichier], $where);
            $reponse['status'] = true;
            $reponse['message'] = 'logo ajouté.';
            $reponse['logo'] = base_url($nomFichier);
        } else {
            $reponse['status'] = false;
            $reponse['message'] = 'Echec, vérifiez le fichier séléctionné.';
        }
        echo json_encode($reponse);
    }

    function update_pass()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $this->load->library('form_validation');
        $validation  = new CI_Form_validation();
        $validation->set_rules('pass', '', 'required', ['required' => "Tapez le mot de passe actuel."]);
        $validation->set_rules('new', '', 'required', ['required' => "Tapez votre nouveau mot de passe"]);
        $validation->set_rules('cnew', '', 'required|matches[new]', ['required' => "Confirmer votre nouveau mot de passe", 'matches' => "les deux mots de passe sont différents."]);

        $re['status'] = false;
        if ($validation->run()) {
            if ($type == 'univ') {
                $pass = $this->input->post('pass');
                $newpass = $this->input->post('new');
                $iduniv = $this->session->universite_session;

                if (count($this->db->where(['code' => $pass, 'iduniversite' => $iduniv])->get('universite')->result())) {
                    $this->db->update('universite', ['code' => $newpass], ['iduniversite' => $iduniv]);
                    $re['message'] = 'Le mot de passe a été mis à jour.';
                    $re['status'] = true;
                } else {
                    $re['message'] = 'Le mot de passe actuel que vous avez saisi est incorrect.';
                }
            }
        } else {
            $re['error'] = $validation->error_array();
        }

        echo json_encode($re);
    }

    function update_profil()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $this->load->library('form_validation');
        $validation  = new CI_Form_validation();
        $validation->set_rules('universite', '', 'required', ['required' => "Tapez le nom de votre université."]);

        $re['status'] = false;
        if ($validation->run()) {
            if ($type == 'univ') {
                $univ = $this->input->post('universite');
                $iduniv = $this->session->universite_session;

                if (!count($this->db->where(['nomUniversite' => $univ, 'iduniversite !=' => $iduniv])->get('universite')->result())) {
                    $this->db->update('universite', ['nomUniversite' => $univ], ['iduniversite' => $iduniv]);
                    $re['message'] = 'Le nom de votre université a été mis à jour.';
                    $re['status'] = true;
                } else {
                    $re['message'] = "Vous ne pouvez pas utiliser ce nom  < <i>$univ</i> >.";
                }
            }
        } else {
            $re['error'] = $validation->error_array();
        }

        echo json_encode($re);
    }

    function solde()
    {
        $this->checktype('univ');
        $frais = (int) $this->input->get('frais');
        $d = $this->input->get('date', true);
        $d = explode('-', $d);
        $debut = str_replace('/', '-', trim(@$d[0]));
        $fin =  str_replace('/', '-', trim(@$d[1]));

        $iduniv = $this->session->universite_session;
        $annee = $this->session->annee_academique;

        $this->db->where(['frais.iduniversite' => $iduniv, 'frais.idanneeAcademique' => $annee]);

        $this->db->where('cast(paiement.date as date) >=', $debut);
        $this->db->where('cast(paiement.date as date) <=', $fin);

        if ($frais) {
            $this->db->where('frais.idfrais', $frais);
        }

        $this->db->select("sum(paiement.montant) total, nomDevise devise, frais.designation frais");

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        $this->db->group_by('paiement.iddevise');
        $r = $this->db->get('paiement')->result();
        echo json_encode($r);
    }
}
