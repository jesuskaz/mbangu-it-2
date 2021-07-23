<?php
class Ecole extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$ide = $this->session->ecole_session) {
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->idecole = $ide;
        $this->idannee = $this->session->annee_scolaire;
    }

    function index()
    {
        $data["devises"] = $this->db->get('devise')->result();
        $data["sections"] = $this->db->where('idecole', $this->idecole)->get('section')->result();

        $this->db->join('classe', 'classe.idclasse=eleve.idclasse');
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=classe.idannee_scolaire_ecole');
        $this->db->where('annee_scolaire_ecole.idannee_scolaire_ecole', $this->idannee);
        $data["tot_eleve"] = $te = count($this->db->get('eleve')->result());

        $sql = "SELECT * from eleve where ideleve 
            in (select paiement_ecole.ideleve from paiement_ecole join eleve ON paiement_ecole.ideleve=eleve.ideleve join classe on classe.idclasse=eleve.idclasse 
            join annee_scolaire_ecole on classe.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole
            where annee_scolaire_ecole.idannee_scolaire_ecole=$this->idannee)";
        $data["eleve_paie"] = $ep = count($this->db->query($sql)->result());

        $data["eleve_pas_paie"] = $te - $ep;

        $this->load->view("ecole/index", $data);
    }

    function solde()
    {

        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'ecole.idecole=annee_scolaire_ecole.idecole');
        $data['frais'] = $this->db->where(['ecole.idecole' =>  $this->idecole, 'frais_ecole.idannee_scolaire_ecole' => $this->idannee])->get('frais_ecole')->result();

        $this->db->select("sum(paiement_ecole.montant) total, nomDevise devise, frais_ecole.intitulefrais frais");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'ecole.idecole=annee_scolaire_ecole.idecole');
        $this->db->where(['ecole.idecole' =>  $this->idecole, 'frais_ecole.idannee_scolaire_ecole' => $this->idannee]);

        $this->db->group_by('paiement_ecole.iddevise');

        $data['solde'] = $this->db->get('paiement_ecole')->result();

        $this->load->view("ecole/solde", $data);
    }

    public function frais()
    {
        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        $this->db->join('devise', 'devise.iddevise = frais_ecole.iddevise');
        $data["frais"] = $this->db->where(['idannee_scolaire_ecole' => $this->idannee])->get('frais_ecole')->result_array();
        $data["anneescolaires"] = $this->db->get_where('annee_scolaire_ecole', ['idecole' => $this->idecole])->result_array();
        $data['devise'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $this->load->view("ecole/frais", $data);
    }

    function delete_f($idfrais = null)
    {
        $idfrais = (int) $idfrais;
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        if (!count($this->db->where(['idfrais_ecole' => $idfrais, 'idecole' => $this->idecole])->get('frais_ecole')->result())) {
            redirect();
        }
        if (count($this->db->where(['paiement_ecole.idfrais_ecole' => $idfrais])->get('paiement_ecole')->result())) {
            $this->session->set_flashdata(['message2' => "Vous ne pouvez plus supprimer ce frais, car il existe déjà un paiement lié à ce frais.", 'classe2' => 'danger']);
        } else {
            $this->db->delete('frais_ecole', ['idfrais_ecole' => $idfrais]);
            $this->session->set_flashdata(['message2' => "Le frais a été supprimé.", 'classe2' => 'success']);
        }
        redirect('ecole/frais');
    }

    function edit_f($id_frais = null)
    {
        $id_frais = (int) $id_frais;
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        if (!count($et = $this->db->where('idfrais_ecole', $id_frais)->get('frais_ecole')->result())) {
            redirect('ecole/frais');
        }
        $et = $et[0];
        $data['frais'] = "$et->intitulefrais : $et->montant $et->nomDevise";
        $data["anneescolaires"] = $this->db->get_where('annee_scolaire_ecole', ['idecole' => $this->idecole])->result_array();
        $data['devises'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $data['idfrais'] = $id_frais;
        $data['nom_f'] = $et->intitulefrais;
        $data['compte'] = $et->compte;
        $data['idbanque'] = $et->idbanque;
        $data['montant'] = $et->montant;
        $data['devise'] = $et->iddevise;
        $data['annee'] = $et->idannee_scolaire_ecole;
        $this->load->view("ecole/edit_frais", $data);
    }

    function update_f()
    {
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
            $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
            $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
            $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
            if (!count($this->db->where(['idfrais_ecole' => $fr, 'idecole' => $this->idecole])->get('frais_ecole')->result())) {
                redirect();
            }

            if (count($this->db->where(['paiement_ecole.idfrais_ecole' => $fr])->get('paiement_ecole')->result())) {
                $this->session->set_flashdata(['message' => "Vous ne pouvez plus modifier ce frais, car il existe déjà un paiement lié à ce frais.", 'classe' => 'danger']);
            } else {
                $this->db->update('frais_ecole', [
                    'idannee_scolaire_ecole' => $this->input->post('annee'),
                    'iddevise' => $this->input->post('devise'),
                    'compte' => $this->input->post('compte'),
                    'idbanque' => $this->input->post('banque'),
                    'intitulefrais' => $this->input->post('frais'),
                    'montant' => $this->input->post('montant'),
                ], ['idfrais_ecole' => $fr]);
                $this->session->set_flashdata(['message' => "Le frais a été mis à jour.", 'classe' => 'success']);
            }
            redirect('ecole/edit_f/' . $fr);
        } else {
            redirect('ecole/edit_f');
        }
    }

    public function frais_a()
    {

        $banque = $this->input->post("banque");
        $compte = $this->input->post("compte");
        $frais = $this->input->post("frais");
        $montant = $this->input->post("montant");
        $devise = $this->input->post("devise");
        $anne = $this->input->post('annee');

        $data = [
            "intitulefrais" => $frais,
            "compte" => $compte,
            "idbanque" => $banque,
            "montant" => $montant,
            "iddevise" => $devise,
            "idannee_scolaire_ecole" => $anne,
        ];

        $this->db->insert('frais_ecole', $data);

        $id = $this->session->universite_session;
        $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $id])->result_array();

        $this->session->set_flashdata(['message' => "Frais ajouté avec succès", 'classe' => 'success']);

        redirect('ecole/frais');
    }

    function anneescolaire()
    {
        $this->db->order_by('actif', 'desc');
        $data["anneescolaires"] = $this->db->get_where('annee_scolaire_ecole', ['idecole' => $this->idecole])->result();
        $this->load->view("ecole/anneescolaire", $data);
    }

    public function annee_a()
    {

        $to = $this->input->post("to");
        $from = $this->input->post("from");

        $data = array(
            "date_debut" => $from,
            "date_fin" => $to,
            "idecole" => $this->idecole,
        );

        $this->db->insert('annee_scolaire_ecole', $data);
        $message["message"] = "L'année ajoutée avec succès ";
        $message["classe"] = "success";
        $this->session->set_flashdata($message);
        redirect('ecole/anneescolaire');
    }

    function active_a($idann = null)
    {
        if (is_null($idann)) redirect('ecole/anneescolaire');
        if (!count($a = $this->db->where(['idecole' => $this->idecole, 'idannee_scolaire_ecole' => $idann])->get('annee_scolaire_ecole')->result()))  redirect('ecole/anneescolaire');

        $a = $a[0];
        $a = "$a->date_debut $a->date_fin";

        $this->db->trans_start();
        $this->db->update('annee_scolaire_ecole', ['actif' => 0], ['idecole' => $this->idecole]);
        $this->db->update('annee_scolaire_ecole', ['actif' => 1], ['idannee_scolaire_ecole' => $idann]);
        $this->db->trans_complete();
        $this->session->set_flashdata(['message2' => "Année '$a' activée avec succès.",]);
        $this->session->set_flashdata(['classe2' => "success",]);
        redirect('ecole/anneescolaire');
    }

    function section()
    {
        $this->db->order_by('idsection', 'desc');
        $data["sections"] = $this->db->get_where('section', ['idecole' => $this->idecole])->result();
        $this->load->view("ecole/section", $data);
    }

    public function section_a()
    {
        $section = $this->input->post("section");

        if (empty($section)) {
            $message["message"] = "champ vide ";
            $message["classe"] = "danger";
            redirect('ecole/section');
        }

        $sections = explode(',', $section);

        $ignoreliste = $addliste = '';
        foreach ($sections as $sec) {
            $sec = trim($sec);
            $data = array(
                "intitulesection" => $sec,
                "idecole" => $this->idecole,
            );

            if (count($this->db->where($data)->get('section')->result())) {
                $ignoreliste .= $sec . ', ';
            } else {
                if (!empty($sec)) {
                    $this->db->insert('section', $data);
                    $addliste .= $sec . ', ';
                } else {
                    $message["message3"] = "Format de données incorrect : $section";
                    $message["classe3"] = "danger";
                }
            }
        }

        if (!empty($addliste)) {
            $message["message"] = "Section(s) ajoutée(s) avec succès : " . substr($addliste, 0, -2);
            $message["classe"] = "success";
        }
        if (!empty($ignoreliste)) {
            $message["message3"] = "Section(s) existante(s) : " . substr($ignoreliste, 0, -2);
            $message["classe3"] = "warning";
        }

        $this->session->set_flashdata($message ?? []);
        redirect('ecole/section');
    }

    function delete_s($idsection = null)
    {
        $idsection = (int) $idsection;
        if (!count($this->db->where(['idsection' => $idsection, 'idecole' => $this->idecole])->get('section')->result())) {
            redirect();
        }
        $this->db->join('section', 'section.idsection=optionecole.idsection');
        if (count($this->db->where(['optionecole.idsection' => $idsection])->get('optionecole')->result())) {
            $this->session->set_flashdata(['message2' => "Vous ne pouvez plus supprimer cette section, car elle contient une ou plusieurs options.", 'classe2' => 'danger']);
        } else {
            $this->db->delete('section', ['idsection' => $idsection]);
            $this->session->set_flashdata(['message2' => "Section supprimée.", 'classe2' => 'success']);
        }
        redirect('ecole/section');
    }

    function option()
    {
        $this->db->order_by('idsection', 'desc');
        $data["sections"] = $this->db->get_where('section', ['idecole' => $this->idecole])->result_array();
        $data["classes"] = $this->db->get_where('classe', ['idannee_scolaire_ecole' => $this->idannee])->result_array();
        $this->load->view("ecole/option", $data);
    }

    public function option_a()
    {
        $option = $this->input->post("option");
        $section = $this->input->post("section");
        $classe = $this->input->post("classe");

        // var_dump($_POST);
        // die;

        if (!count($this->db->where(['idsection' => $section, 'idecole' => $this->idecole])->get('section')->result())) {
            redirect();
        }

        if (empty($classe)) {
            $message["message"] = "champ vide pour la classe.";
            $message["classe"] = "danger";
            redirect('ecole/option');
        }


        $ignoreliste = $addliste = '';
        $isoption = false;

        if (empty($option)) {
            $isoption = true;
            foreach ($classe as $cl) {
                if (count($this->db->where(['idsection' => $section, 'idclasse' => $cl])->get('section_has_classe')->result())) {
                    $r = @$this->db->where(['idclasse' => $cl, 'idannee_scolaire_ecole' => $this->idannee])->get('classe')->result()[0];
                    $ignoreliste .= @$r->intituleclasse . ', ';
                } else {
                    $this->db->insert('section_has_classe', ['idsection' => $section, 'idclasse' => $cl]);
                    $r = @$this->db->where(['idclasse' => $cl, 'idannee_scolaire_ecole' => $this->idannee])->get('classe')->result()[0];
                    $addliste .= @$r->intituleclasse . ', ';
                }
            }
        } else {
            $options = explode(',', $option);
            foreach ($classe as $cl) {
                foreach ($options as $opt) {
                    $opt = trim($opt);
                    $this->db->join('section', 'section.idsection=optionecole.idsection');
                    if (count($this->db->where(["section.idecole" => $this->idecole, 'optionecole.intituleOption' => $opt, 'idclasse' => $cl, 'optionecole.idsection' => $section])->get('optionecole')->result())) {
                        $ignoreliste .= $opt . ', ';
                    } else {
                        if (!empty($opt)) {
                            $this->db->insert('optionecole', [
                                'intituleOption' => $opt,
                                'idsection' => $section,
                                'idclasse' => $cl
                            ]);
                            $addliste .= $opt . ', ';
                        } else {
                            $message["message3"] = "Format de données incorrect : $option";
                            $message["classe3"] = "danger";
                        }
                    }
                }
            }
        }

        if (!empty($addliste)) {
            if ($isoption) {
                $message["message"] = "Classe(s) ajoutée(s) avec succès : " . substr($addliste, 0, -2);
                $message["classe"] = "success";
            } else {
                $message["message"] = "Option(s) ajoutée(s) avec succès : " . substr($addliste, 0, -2);
                $message["classe"] = "success";
            }
        }
        if (!empty($ignoreliste)) {
            if ($isoption) {
                $message["message3"] = "Classe(s) existante(s) : " . substr($ignoreliste, 0, -2);
                $message["classe3"] = "warning";
            } else {
                $message["message3"] = "Option(s) existante(s) : " . substr($ignoreliste, 0, -2);
                $message["classe3"] = "warning";
            }
        }

        $this->session->set_flashdata($message ?? []);
        redirect('ecole/option');
    }

    public function classe($idoption = null)
    {
        $idoption = (int) $idoption;

        $ann = $this->session->annee_scolaire;
        $this->db->where(['idoptionecole' => $idoption, 'idannee_scolaire_ecole' => $ann]);
        $data['classes'] = $this->db->get('classe')->result();

        $this->load->view("ecole/classe", $data);
    }

    public function classes()
    {
        $this->db->order_by('idclasse', 'desc');
        $data["classes"] = $this->db->get_where('classe', ['idannee_scolaire_ecole' => $this->idannee])->result();
        $this->load->view("ecole/classes", $data);
    }

    public function options($idsection = null)
    {
        $idsection = (int) $idsection;

        if (!count($fac = $this->db->where(['idsection' => $idsection, 'idecole' => $this->idecole])->get('section')->result())) {
            redirect('ecole/section');
        }

        $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
        $this->db->group_by('optionecole.idoptionecole');
        $o = $this->db->where(['idsection' => $idsection])->get('optionecole')->result();

        $this->db->join('section_has_classe', 'section_has_classe.idclasse=classe.idclasse');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->group_by('classe.idclasse');
        $this->db->order_by('classe.idclasse');
        $oo = $this->db->where(['section.idsection' => $idsection])->get('classe')->result();

        $data["options"] = $o;
        $data["options2"] = $oo;
        $data["section"] = $fac[0]->intitulesection;
        $this->load->view("ecole/liste-options", $data);
    }

    function delete_c($idclasse = null)
    {
        $idclasse = (int) $idclasse;
        $ann = $this->session->annee_scolaire;

        if (!count($this->db->where(['idclasse' => $idclasse, 'idannee_scolaire_ecole' => $ann])->get('classe')->result())) {
            $this->session->set_flashdata(['message' => "Erreur", "classe" => "danger"]);
            redirect('ecole/classes');
        }
        if (count($this->db->where(['idclasse' => $idclasse])->get('eleve')->result())) {
            $this->session->set_flashdata(['message' => "Vous ne pouvez pas supprimer cette classe, car elle contient un plusieurs élèves.", "classe" => "warning"]);
            redirect('ecole/classes');
        }

        $this->db->where('idclasse', $idclasse)->delete('classe');
        $this->session->set_flashdata(['message' => "Classe supprimée.", "classe" => "success"]);
        redirect('ecole/classes');
    }

    public function eleves()
    {
        $this->db->order_by('idsection', 'desc');
        $data["sections"] = $this->db->get_where('section', ['idecole' => $this->idecole])->result();
        $data["classes"] = $this->db->get_where('classe', ['idannee_scolaire_ecole' => $this->idannee])->result();
        $this->load->view("ecole/eleves", $data);
    }

    public function rapport()
    {
        $this->db->select("paiement_ecole.*, eleve.nom, eleve.postnom,
        eleve.prenom, eleve.matricule, section.intitulesection section, 
        optionecole.intituleOption option, frais_ecole.intitulefrais frais, frais_ecole.compte, banque.denomination banque, 
        paiement_ecole.montant, devise.nomDevise devise, classe.intituleclasse classe ");

        $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
        $this->db->join('classe', 'classe.idclasse=eleve.idclasse');
        $this->db->join('optionecole', 'optionecole.idclasse=classe.idclasse');
        $this->db->join('section', 'section.idsection=optionecole.idsection');

        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->where('frais_ecole.idannee_scolaire_ecole', $this->idannee);
        $this->db->where('section.idecole', $this->idecole);

        $this->db->group_by('paiement_ecole.idpaiement_ecole');
        $data["paies"] = $r = $this->db->get('paiement_ecole')->result_array();

        $this->load->view("ecole/rapport", $data);
    }
    function profil()
    {
        $this->load->view("ecole/profil");
    }

    function detail_eleve($ideleve = null)
    {
        $ideleve = (int) $ideleve;
        $where = [
            'eleve.ideleve' => $ideleve,
            'classe.idannee_scolaire_ecole' => $this->idannee,
            'section.idecole' => $this->idecole,
        ];

        $this->db->select('eleve.ideleve, classe.idclasse, eleve.nom, eleve.postnom, eleve.prenom, eleve.matricule, eleve.adresse, 
        classe.intituleclasse, optionecole.intituleOption, section.intitulesection
        ');
        $this->db->join('classe', 'eleve.idclasse=classe.idclasse');
        $this->db->join('optionecole', 'optionecole.idclasse=classe.idclasse');
        $this->db->join('section', 'optionecole.idsection=section.idsection');
        $this->db->group_by('eleve.ideleve');
        $a = $this->db->where($where)->get('eleve')->result();

        $this->db->select('eleve.ideleve, classe.idclasse, eleve.nom, eleve.postnom, eleve.prenom, eleve.matricule, eleve.adresse, 
        classe.intituleclasse, section.intitulesection
        ');
        $this->db->join('classe', 'eleve.idclasse=classe.idclasse');
        $this->db->join('section_has_classe', 'section_has_classe.idclasse=classe.idclasse');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->group_by('eleve.ideleve');
        $b = $this->db->where($where)->get('eleve')->result();

        if (!count($a) && !count($b)) {
            redirect('index/login');
        }

        $et = count($a) ? $a : $b;

        // var_dump($a, $b);
        // die;

        $data['eleve'] = $et[0];

        $listfrais = $this->db->where(['idannee_scolaire_ecole' => $this->idannee])->get('frais_ecole')->result();

        $tabpaie = [];
        foreach ($listfrais as $lf) {
            $sql = "SELECT paiement_ecole.idpaiement_ecole, paiement_ecole.ideleve, frais_ecole.idfrais_ecole, 
                frais_ecole.montant montant_frais, paiement_ecole.montant montant_paye, 
                frais_ecole.intitulefrais frais, devise.nomDevise devise, date,
                devise.iddevise,
                (
                    SELECT sum(f2.montant) from paiement_ecole f2 where f2.idpaiement_ecole <= paiement_ecole.idpaiement_ecole and 
                    ideleve = $ideleve and f2.idfrais_ecole=$lf->idfrais_ecole
                    group by ideleve order by f2.idfrais_ecole
                ) cumule
                from paiement_ecole
                join frais_ecole on frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole 
                join devise on devise.iddevise=paiement_ecole.iddevise 
                where paiement_ecole.ideleve = $ideleve and frais_ecole.idfrais_ecole=$lf->idfrais_ecole 
                group by paiement_ecole.idpaiement_ecole order by paiement_ecole.idfrais_ecole

            ";
            $paie = $this->db->query($sql)->result();
            foreach ($paie as $p) {
                array_push($tabpaie, $p);
            }
        }
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

        $this->load->view("ecole/detail_eleve", $data);
    }

    function print($ideleve = null)
    {
        // ideleve - idpaiement //
        $d = explode('-', $ideleve);
        if (count($d) != 2) {
            redirect('index/login');
        }
        $ideleve = (int) $d[0];
        $idpaiement = (int) $d[1];
        $where = [
            'eleve.ideleve' => $ideleve,
            'classe.idannee_scolaire_ecole' => $this->idannee,
            'section.idecole' => $this->idecole,
        ];
        $this->db->join('classe', 'eleve.idclasse=classe.idclasse');
        $this->db->join('optionecole', 'optionecole.idoptionecole=classe.idoptionecole');
        $this->db->join('section', 'optionecole.idsection=optionecole.idsection');
        $this->db->group_by('eleve.ideleve');
        if (!count($et = $this->db->where($where)->get('eleve')->result())) {
            redirect('index/login');
        }

        $data['eleve'] = $et[0];
        $this->db->join('devise', 'devise.iddevise=paiement_ecole.iddevise');
        $this->db->select('ecole.*, devise.nomDevise,frais_ecole.intitulefrais, frais_ecole.montant montant_frais,frais_ecole.compte, paiement_ecole.date, paiement_ecole.montant montant_paye');
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'ecole.idecole=annee_scolaire_ecole.idecole');

        $p = $this->db->where(['idpaiement_ecole' => $idpaiement, 'ideleve' => $ideleve])->get('paiement_ecole')->result();
        $data['paie'] = @$p[0];

        $this->load->view("ecole/print", $data);
    }

    function eleve_e($ideleve = null)
    {
        $ideleve = (int) $ideleve;

        $this->db->join('classe', 'classe.idclasse=eleve.idclasse');
        $this->db->where(['classe.idannee_scolaire_ecole' => $this->idannee, 'eleve.ideleve' => $ideleve]);

        if (!count($el = $this->db->get('eleve')->result())) {
            redirect('ecole/eleves');
        }

        $el = $el[0];
        $data['eleve'] = $el;
        $this->load->view("ecole/eleve_e", $data);
    }

    function update_e()
    {
        $ideleve = $this->input->post('ideleve');
        $nom = $this->input->post('nom');
        $postnom = $this->input->post('postnom');
        $prenom = $this->input->post('prenom');
        $tel = $this->input->post('tel');
        $adresse = $this->input->post('adresse');

        $this->db->update('eleve', ['nom' => $nom, 'postnom' => $postnom, 'prenom' => $prenom, 'telephoneparent' => $tel, 'adresse' => $adresse], ['ideleve' => $ideleve]);
        $this->session->set_flashdata('message', 'informations mises à jour.');
        redirect('ecole/eleve-e/' . $ideleve);
    }

    function eleve_s($ideleve = '')
    {
        $this->db->join('classe', 'classe.idclasse=eleve.idclasse');
        $this->db->where(['classe.idannee_scolaire_ecole' => $this->idannee, 'eleve.ideleve' => $ideleve]);

        if (!count($el = $this->db->get('eleve')->result())) {
            $this->session->set_flashdata('message', 'Erreur');
            $this->session->set_flashdata('classe', 'danger');
            redirect('ecole/eleves');
        }

        if (count($this->db->where('ideleve', $ideleve)->get('paiement_ecole')->result())) {
            $this->session->set_flashdata('message', 'Impossible de supprimer cet eleve, car il a déjà effectué un paiement.');
            $this->session->set_flashdata('classe', 'warning');
            redirect('ecole/eleves');
        }

        $this->db->trans_start();
        $this->db->where('ideleve', $ideleve);
        $this->db->delete('parent_has_eleve');
        $this->db->where('ideleve', $ideleve);
        $this->db->delete('eleve');

        $this->db->trans_complete();
        $this->session->set_flashdata('message', 'Eleve supprimé.');
        $this->session->set_flashdata('classe', 'success');
        redirect('ecole/eleves');
    }

    function annonces()
    {
        $this->load->view('ecole/annonces');
    }

    function magasin()
    {
        $this->load->view('ecole/magasin', ['devises' => $this->db->get('devise')->result()]);
    }

    function achat()
    {
        $this->db->select('devise.nomDevise devise, sum(prix) total');
        $this->db->join('article_ecole', 'article_ecole.idarticle=achat_article_ecole.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $this->db->group_by('devise.iddevise');
        $this->db->where('article_ecole.idecole', $this->idecole);
        $data['solde'] = $this->db->get('achat_article_ecole')->result();

        $this->db->select('article_ecole.idarticle, devise.nomDevise devise, sum(prix) total, article_ecole.prix, article_ecole.description article');
        $this->db->join('article_ecole', 'article_ecole.idarticle=achat_article_ecole.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $this->db->group_by('article_ecole.idarticle');
        $this->db->order_by('achat_article_ecole.idachat', 'desc');
        $this->db->where('article_ecole.idecole', $this->idecole);
        $data['achats'] = $this->db->get('achat_article_ecole')->result();

        $this->load->view('ecole/achat', $data);
    }

    function detail_achat($idarticle = null)
    {
        $idarticle = (int) $idarticle;

        $this->db->where('article_ecole.idarticle', $idarticle);
        $this->db->where('article_ecole.idecole', $this->idecole);
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $article = $this->db->get('article_ecole')->result();
        if (!count($article)) {
            redirect('faculte/achat');
        }

        $this->db->select('eleve.nom, eleve.postnom, eleve.prenom, eleve.matricule, devise.nomDevise devise,
         article_ecole.prix, article_ecole.description article, achat_article_ecole.date');
        $this->db->join('eleve', 'eleve.ideleve=achat_article_ecole.ideleve');
        $this->db->join('article_ecole', 'article_ecole.idarticle=achat_article_ecole.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $this->db->order_by('achat_article_ecole.idachat', 'desc');
        $this->db->where('article_ecole.idarticle', $idarticle);
        $this->db->where('article_ecole.idecole', $this->idecole);
        $data['achats']  = $ar = $this->db->get('achat_article_ecole')->result();

        $data['article'] = $article[0];

        $tot = 0;
        foreach ($ar as $aaa) {
            $tot += $aaa->prix;
        }
        $data['total'] = $tot;

        $this->load->view('ecole/detail-achat', $data);
    }
}
