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
            } else if (count($r = $this->db->where(['login' => $login, 'password' => $code])->get('ecole')->result())) {
                $r = $r[0];
                $re['status'] = true;
                $re['url'] = site_url('ecole');
                $this->session->set_userdata(['ecole_session' =>  $r->idecole]);
                $r2 = $this->db->where(['idecole' => $r->idecole, 'actif' => 1])->get('annee_scolaire_ecole')->result();
                if (!count($r2)) {
                    $debut =  (new DateTime('first day of this month'))->format('Y-m-d');
                    $fin =  date('Y-m-d', strtotime((new DateTime('last day of this month'))->format('Y-m-d') . " + 365 day"));
                    $this->db->insert('annee_scolaire_ecole', [
                        'actif' => 1,
                        'idecole' => $r->idecole,
                        'date_debut' => $debut,
                        'date_fin' => $fin
                    ]);
                    $ida = $this->db->insert_id();
                } else {
                    $ida = $r2[0]->idannee_scolaire_ecole;
                }
                $this->session->set_userdata(['annee_scolaire' =>  $ida]);
                $this->db->query("UPDATE ecole SET derniere_activite = CURRENT_TIMESTAMP where idecole=$ida");
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
        if (!in_array($type, ['univ', 'admin', 'banque', 'ecole'])) {
            echo json_encode(['TYPE ERROR']);
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

        if ($type == 'ecole' and empty($this->session->userdata("ecole_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }
    }

    function getallrapport()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);

        $d = $this->input->get('date', true);
        $d = explode('-', $d);
        $debut = str_replace('/', '-', trim(@$d[0]));
        $fin =  str_replace('/', '-', trim(@$d[1]));

        $devise = $this->input->get('devise', true);

        if ($type != 'ecole') {
            $faculte = $this->input->get('faculte', true);
            $promotion = $this->input->get('promotion', true);
            $option = $this->input->get('option', true);

            $this->db->select("paiement.idpaiement, paiement.date, etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, frais.numeroCompte, 
            frais.designation, promotion.intitulePromotion, faculte.nomFaculte, paiement.montant, devise.nomDevise");

            $this->db->where('cast(paiement.date as date) >=', $debut);
            $this->db->where('cast(paiement.date as date) <=', $fin);

            $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
            $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
            $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
            $this->db->join('options', 'options.idoptions=etudiant.idoptions');
            $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
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
                $this->db->where('options.intituleOptions', $option);
            }
            if (!empty($devise)) {
                $this->db->where('paiement.iddevise', $devise);
            }

            $this->db->group_by('paiement.idpaiement');
            $r = $this->db->get('paiement')->result();
        } else {
            $section = (int) $this->input->get('section', true);
            $option = $this->input->get('option', true);
            $classe = (int) $this->input->get('classe', true);
            $idecole = $this->session->ecole_session;

            $this->db->select("paiement_ecole.idpaiement_ecole, paiement_ecole.date, eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, eleve.matricule, compte, 
            intitulefrais frais, intituleclasse classe, intituleOption option, paiement_ecole.montant, devise.nomDevise devise");

            $this->db->where('cast(paiement_ecole.date as date) >=', $debut);
            $this->db->where('cast(paiement_ecole.date as date) <=', $fin);
            $this->db->where('section.idecole', $idecole);

            if ($section) {
                $this->db->where('section.idsection', $section);
            }

            if ($option) {
                $this->db->where('optionecole.intituleOption', $option);
            }

            if ($classe) {
                $this->db->where('classe.idclasse', $classe);
            }

            if ($devise) {
                $this->db->where('frais_ecole.iddevise', $devise);
            }

            $annee = $this->session->annee_scolaire;
            $this->db->where('frais_ecole.idannee_scolaire_ecole', $annee);

            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
            $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
            $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
            $this->db->join('optionecole', 'optionecole.idoptionecole=eleve.idoptionecole');
            $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
            $this->db->join('section', 'section.idsection=optionecole.idsection');

            $this->db->group_by('paiement_ecole.idpaiement_ecole');
            $this->db->order_by('paiement_ecole.idpaiement_ecole', 'desc');
            $r = $this->db->get('paiement_ecole')->result();

            $ide = '';
            foreach ($r as $el) {
                $ide .= $el->ideleve . ", ";
            }
            $ide = substr($ide, 0, -2);

            //////////
            $r2 = [];
            $this->db->select("paiement_ecole.idpaiement_ecole, paiement_ecole.date, eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, eleve.matricule, compte, 
            intitulefrais frais, intituleclasse classe, paiement_ecole.montant, devise.nomDevise devise");

            $this->db->where('cast(paiement_ecole.date as date) >=', $debut);
            $this->db->where('cast(paiement_ecole.date as date) <=', $fin);
            $this->db->where('section.idecole', $idecole);

            if ($section) {
                $this->db->where('section.idsection', $section);
            }

            if ($classe) {
                $this->db->where('classe.idclasse', $classe);
            }

            if ($devise) {
                $this->db->where('frais_ecole.iddevise', $devise);
            }

            $annee = $this->session->annee_scolaire;
            $this->db->where('frais_ecole.idannee_scolaire_ecole', $annee);

            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
            $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
            $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
            $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe=eleve.idsection_has_classe');
            $this->db->join('section', 'section.idsection=section_has_classe.idsection');
            $this->db->join('classe', 'classe.idclasse=section_has_classe.idclasse');
            if (!empty($ide)) {
                $this->db->where("`eleve`.`ideleve` NOT IN ($ide)", NULL, FALSE);
            }
            $this->db->group_by('paiement_ecole.idpaiement_ecole');
            $this->db->order_by('paiement_ecole.idpaiement_ecole', 'desc');
            $r2 = $this->db->get('paiement_ecole')->result();
            /////////////          

            foreach ($r2 as $ele) {
                $e = $ele;
                array_push($r, $e);
            }
        }
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
            if ($type == 'ecole') {
                $this->db->where('frais_ecole.iddevise', $devise);
            } else {
                $this->db->where('paiement.iddevise', $devise);
            }
        }

        if ($type == 'ecole') {
            //
        } else {
            $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        }

        if ($type == 'univ') {
            $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
            $this->db->where('frais.iduniversite', $this->session->userdata("universite_session"));
            $this->db->where('frais.idanneeAcademique', $this->session->userdata("annee_academique"));
        }
        if ($type == 'admin') {
            $iduniv = (int) $this->input->get('universite');
            if ($iduniv) {
                $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
                $this->db->where('frais.iduniversite', $iduniv);
            }
        }

        if ($type == 'banque') {
        } else {
        }

        if ($type == 'ecole') {
            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');

            if ($type == 'banque') {
                $idbank = $this->session->bank_session;
                $this->db->join('banque', 'frais_ecole.idbanque=banque.idbanque');
                $this->db->where('banque.idbanque', $idbank);
            }
            $this->db->where('frais_ecole.idannee_scolaire_ecole', $this->session->userdata("annee_scolaire"));
            $this->db->select('paiement_ecole.montant, paiement_ecole.date, paiement_ecole.iddevise');
            $this->db->group_by('paiement_ecole.idpaiement_ecole');
            $paie = $this->db->get('paiement_ecole')->result();
        } else {
            if ($type == 'banque') {
                $idbank = $this->session->bank_session;
                $this->db->join('frais', 'paiement.idfrais=frais.idfrais');
                $this->db->join('banque', 'frais.idbanque=banque.idbanque');
                $this->db->where('banque.idbanque', $idbank);
            }
            $this->db->select('paiement.montant, paiement.date, paiement.iddevise');
            $this->db->group_by('paiement.idpaiement');
            $paie = $this->db->get('paiement')->result();
        }

        $devise = $this->db->get('devise')->result();

        // var_dump($paie);
        // die;
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
        // die;
        echo json_encode($final);
    }

    function chart_data_2()
    {
        $type = $this->input->get('type', true);
        $idecole = (int) $this->input->get('ecole', true);
        $this->checktype($type);

        $devise = (int) $this->input->get('devise');
        if ($devise) {
            $this->db->where('frais_ecole.iddevise', $devise);
        }

        if ($idecole) {
            $this->db->where('eleve.idecole', $idecole);
        }

        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
        $this->db->select('paiement_ecole.montant, paiement_ecole.date, paiement_ecole.iddevise');
        $this->db->group_by('paiement_ecole.idpaiement_ecole');
        $paie = $this->db->get('paiement_ecole')->result();

        $devise = $this->db->get('devise')->result();

        // var_dump($paie);
        // die;
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
        // die;
        echo json_encode($final);
    }


    function select_data()
    {
        $type = $this->input->get('type');
        $this->checktype($type);
        $faculte = (int) $this->input->get('faculte');
        $iduniv = $this->session->universite_session;

        $r = [];
        if ($faculte) {
            if (!count($this->db->where(['iduniversite' => $iduniv, 'idfaculte' => $faculte])->get('faculte')->result())) {
                echo json_encode(['error']);
                exit;
            }
            $this->db->where(['options.idfaculte' => $faculte]);
            $this->db->where('faculte.iduniversite', $iduniv);

            $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
            $this->db->select('idoptions id, intituleOptions option, faculte.nomFaculte faculte');
            $this->db->group_by('options.intituleOptions');
            $r = $this->db->get('options')->result();
        }
        // var_dump($_GET, $r);
        // die;
        echo json_encode(['options' => $r]);
    }

    function promotion()
    {
        $type = $this->input->get('type');
        $this->checktype($type);
        $univ = $this->session->universite_session;

        $option = $this->input->get('option');

        $this->db->select('intitulePromotion promotion, promotion.idpromotion');
        $this->db->group_by('promotion.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('universite', 'universite.iduniversite=promotion.iduniversite');
        $this->db->where('options.intituleOptions', $option);
        $r = $this->db->where('universite.iduniversite', $univ)->get('promotion')->result();
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
        $this->db->join('options', 'options.idoptions=etudiant.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
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
            $this->db->where('options.intituleOptions', $option);
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
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
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
        $type = $this->input->post('type', true);
        $this->checktype($type);

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

            if ($type == 'univ') {
                $where = ['iduniversite' => $this->session->universite_session];
                $r = $this->db->where($where)->get('universite')->result()[0];
                @unlink($r->logo);
                $this->db->update('universite', ['logo' => $nomFichier], $where);
            } else if ($type == 'banque') {
                $where = ['idbanque' => $this->session->bank_session];
                $r = $this->db->where($where)->get('banque')->result()[0];
                @unlink($r->logo);
                $this->db->update('banque', ['logo' => $nomFichier], $where);
            } else if ($type == 'ecole') {
                $where = ['idecole' => $this->session->ecole_session];
                $r = $this->db->where($where)->get('ecole')->result()[0];
                @unlink($r->logo);
                $this->db->update('ecole', ['logo' => $nomFichier], $where);
            }

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
            } else if ($type == 'banque') {
                $pass = $this->input->post('pass');
                $newpass = $this->input->post('new');
                $idbank = $this->session->bank_session;

                if (count($this->db->where(['password' => $pass, 'idbanque' => $idbank])->get('banque')->result())) {
                    $this->db->update('banque', ['password' => $newpass], ['idbanque' => $idbank]);
                    $re['message'] = 'Le mot de passe a été mis à jour.';
                    $re['status'] = true;
                } else {
                    $re['message'] = 'Le mot de passe actuel que vous avez saisi est incorrect.';
                }
            } else if ($type == 'ecole') {
                $pass = $this->input->post('pass');
                $newpass = $this->input->post('new');
                $idecole = $this->session->ecole_session;

                if (count($this->db->where(['password' => $pass, 'idecole' => $idecole])->get('ecole')->result())) {
                    $this->db->update('ecole', ['password' => $newpass], ['idecole' => $idecole]);
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

        if ($type == 'univ') {
            $validation->set_rules('universite', '', 'required', ['required' => "Tapez le nom de votre université."]);
        } elseif ($type == 'banque') {
            $validation->set_rules('banque', '', 'required', ['required' => "Tapez le nom de votre banue."]);
        } elseif ($type == 'ecole') {
            $validation->set_rules('ecole', '', 'required', ['required' => "Tapez le nom de votre ecole."]);
        }

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
            } else if ($type == 'banque') {
                $banque = $this->input->post('banque');
                $idbanque = $this->session->bank_session;

                if (!count($this->db->where(['denomination' => $banque, 'idbanque !=' => $idbanque])->get('banque')->result())) {
                    $this->db->update('banque', ['denomination' => $banque], ['idbanque' => $idbanque]);
                    $re['message'] = 'Le nom de votre banque a été mis à jour.';
                    $re['status'] = true;
                } else {
                    $re['message'] = "Vous ne pouvez pas utiliser ce nom  < <i>$banque</i> >.";
                }
            } else if ($type == 'ecole') {
                $ecole = $this->input->post('ecole');
                $idecole = $this->session->ecole_session;

                if (!count($this->db->where(['nomecole' => $ecole, 'idecole !=' => $idecole])->get('ecole')->result())) {
                    $this->db->update('ecole', ['nomecole' => $ecole], ['idecole' => $idecole]);
                    $re['message'] = 'Le nom de votre ecole a été mis à jour.';
                    $re['status'] = true;
                } else {
                    $re['message'] = "Vous ne pouvez pas utiliser ce nom  < <i>$ecole</i> >.";
                }
            }
        } else {
            $re['error'] = $validation->error_array();
        }

        echo json_encode($re);
    }

    function solde()
    {
        $type = $this->input->get('type');
        $this->checktype($type);

        $frais = (int) $this->input->get('frais');
        $d = $this->input->get('date', true);
        $d = explode('-', $d);
        $debut = str_replace('/', '-', trim(@$d[0]));
        $fin =  str_replace('/', '-', trim(@$d[1]));

        if ($type == 'univ') {
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
        } else if ($type == 'ecole') {
            $annee = $this->session->annee_scolaire;

            $this->db->where(['frais_ecole.idannee_scolaire_ecole' => $annee]);

            $this->db->where('cast(paiement_ecole.date as date) >=', $debut);
            $this->db->where('cast(paiement_ecole.date as date) <=', $fin);

            if ($frais) {
                $this->db->where('frais_ecole.idfrais_ecole', $frais);
            }

            $this->db->select("sum(paiement_ecole.montant) total, nomDevise devise, frais_ecole.intitulefrais frais");

            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
            $this->db->join('devise', 'devise.iddevise=paiement_ecole.iddevise');
            $this->db->group_by('paiement_ecole.iddevise');
            $r = $this->db->get('paiement_ecole')->result();
        } else {
            die();
        }

        echo json_encode($r);
    }

    function options_ecole()
    {
        $type = $this->input->get('type');
        $this->checktype($type);

        $idsection = (int) $this->input->get('section');

        if ($idsection) {
            $idecole = $this->session->ecole_session;
            if (!count($this->db->where(['idecole' => $idecole, 'idsection' => $idsection])->get('section')->result())) {
                echo json_encode(['error']);
                exit;
            }
            $this->db->where(['optionecole.idsection' => $idsection]);
        }

        $idecole = $this->session->ecole_session;
        $this->db->where('section.idecole', $idecole);

        $this->db->join('section', 'section.idsection=optionecole.idsection');
        $this->db->select('idoptionecole id, intituleOption option, section.intitulesection section');
        $this->db->group_by('optionecole.intituleOption');
        $r = $this->db->get('optionecole')->result();

        $cl = [];
        if (!count($r)) {
            $this->db->join('section_has_classe', 'section_has_classe.idclasse=classe.idclasse');
            $this->db->join('section', 'section.idsection=section_has_classe.idsection');
            $this->db->where(['section.idsection' => $idsection]);
            $cl = $this->db->get('classe')->result();
        }
        echo json_encode(['options' => $r, 'classes' => $cl]);
    }



    function classes_ecole()
    {
        $type = $this->input->get('type');
        $this->checktype($type);
        $annee = $this->session->annee_scolaire;

        $option = $this->input->get('option');

        $this->db->select('intituleclasse classe, classe.idclasse');
        $this->db->group_by('classe.idclasse');
        $this->db->order_by('classe.idclasse', 'desc');
        $this->db->join('optionecole', 'optionecole.idclasse=classe.idclasse');
        $this->db->where('optionecole.intituleOption', $option);
        $r = $this->db->where('idannee_scolaire_ecole', $annee)->get('classe')->result();
        echo json_encode($r);
    }

    function classes_ecole_2()
    {
        $type = $this->input->get('type');
        $this->checktype($type);
        $annee = $this->session->annee_scolaire;
        $this->db->select('intituleclasse classe, classe.idclasse');
        $this->db->order_by('classe.idclasse', 'desc');
        $r = $this->db->where('idannee_scolaire_ecole', $annee)->get('classe')->result();
        echo json_encode($r);
    }

    function add_classe()
    {
        $classe = $this->input->post('classe');
        $annee = $this->session->annee_scolaire;

        $classes = explode(',', $classe);

        $ignoreliste = $addliste = '';
        foreach ($classes as $opt) {
            $opt = trim($opt);
            if (count($this->db->where(["idannee_scolaire_ecole" => $annee, 'intituleclasse' => $opt])->get('classe')->result())) {
                $ignoreliste .= $opt . ', ';
            } else {
                if (!empty($opt)) {
                    $this->db->insert('classe', [
                        'intituleclasse' => $opt,
                        'idannee_scolaire_ecole' => $annee
                    ]);
                    $addliste .= $opt . ', ';
                } else {
                    $message["message1"] = "Format de données incorrect : $classe";
                    $message["classe1"] = "danger";
                }
            }
        }
        $message['status'] = false;

        if (!empty($addliste)) {
            $message["message"] = "Classe(s) ajoutée(s) avec succès : " . substr($addliste, 0, -2);
            $message["classe"] = "success";
            $message['status'] = true;
        }
        if (!empty($ignoreliste)) {
            $message["message1"] = "Classe(s) existante(s) : " . substr($ignoreliste, 0, -2);
            $message["classe1"] = "warning";
        }
        echo json_encode($message);
    }

    function liste_eleve()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);
        $section = $this->input->get('section', true);
        $option = $this->input->get('option', true);
        $classe = $this->input->get('classe', true);

        $this->db->select("eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, 
            eleve.matricule, password code, telephoneparent, eleve.adresse, section.intitulesection section, 
            optionecole.intituleOption option, intituleclasse classe, optionecole.intituleOption option");
        $this->db->join('optionecole', 'optionecole.idoptionecole=eleve.idoptionecole');
        $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
        $this->db->join('section', 'section.idsection=optionecole.idsection');

        $idecole = $this->session->ecole_session;
        $annee = $this->session->annee_scolaire;

        $this->db->where('section.idecole', $idecole);
        $this->db->where('classe.idannee_scolaire_ecole', $annee);

        if ($classe) {
            $this->db->where('classe.idclasse', $classe);
        }
        if ($section) {
            $this->db->where('section.idsection', $section);
        }
        if ($option) {
            $this->db->where('optionecole.intituleOption', $option);
        }

        $this->db->group_by('eleve.ideleve');
        $r = $this->db->get('eleve')->result();
        $ide = '';
        foreach ($r as $el) {
            $ide .= "$el->ideleve, ";
        }
        $ide = substr($ide, 0, -2);

        //////////
        $r2 = [];

        $this->db->select("eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, 
            eleve.matricule, password code, telephoneparent, eleve.adresse, section.intitulesection section, 
            intituleclasse classe");
        $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe=eleve.idsection_has_classe');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->join('classe', 'classe.idclasse=section_has_classe.idclasse');

        $this->db->where('section.idecole', $idecole);
        $this->db->where('classe.idannee_scolaire_ecole', $annee);
        if (!empty($ide)) {
            $this->db->where("`ideleve` NOT IN ($ide)", NULL, FALSE);
        }

        if ($classe) {
            $this->db->where('classe.idclasse', $classe);
        }
        if ($section) {
            $this->db->where('section.idsection', $section);
        }

        $this->db->group_by('eleve.ideleve');
        $r2 = $this->db->get('eleve')->result();

        foreach ($r2 as $ele) {
            $e = $ele;
            array_push($r, $e);
        }

        $r = array_reverse($r);

        echo json_encode(['data' => $r]);
    }

    function annonce_a()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $date = $this->input->post('date');
        $titre = $this->input->post('titre');

        if (strlen($titre) > 128) {
            $rep['status'] = false;
            $rep['message'] = 'Le titre doit avoir moins de 128 caractères.';
            echo json_encode($rep);
            exit;
        }


        $path =  "upload/annonce/";
        $f = $_FILES['file']['name'] ?? '';
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
            'file_name' => $f,
            'max_width' => 1000,
            'max_height' => 500,
            'max_size' => 120 // Ko
        );


        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $d = $this->upload->data();
            $nomFichier = $path . $d['file_name'];

            if ($type == 'ecole') {
                $idecole = $this->session->ecole_session;
                $this->db->insert('annonce', ['type' => 'ecole', 'id' => $idecole, 'titre' => $titre, 'dateexpiration' => $date, 'image' => $nomFichier]);
            } else if ($type == 'univ') {
                $id = $this->session->universite_session;
                $this->db->insert('annonce', ['type' => 'universite', 'id' => $id, 'titre' => $titre, 'dateexpiration' => $date, 'image' => $nomFichier]);
            } else if ($type == 'banque') {
                $id = $this->session->bank_session;
                $this->db->insert('annonce', ['type' => 'banque', 'id' => $id, 'titre' => $titre, 'dateexpiration' => $date, 'image' => $nomFichier]);
            } else if ($type == 'admin') {
                $id = $this->session->isadmin;
                $this->db->insert('annonce', ['type' => 'admin', 'id' => $id, 'titre' => $titre, 'dateexpiration' => $date, 'image' => $nomFichier]);
            }

            $rep['status'] = true;
            $rep['message'] = 'Annonce ajoutée.';
        } else {
            $rep['status'] = false;
            $rep['message'] = 'Echec, vérifiez le fichier séléctionné : ' . @$this->upload->error_msg[0];
        }

        echo json_encode($rep);
    }

    function annonce()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);

        if ($type == 'ecole') {

            $idecole = $this->session->ecole_session;
            $this->db->order_by('idannonce', 'desc');
            $this->db->where(['type' => 'ecole', 'id' => $idecole]);
            $r = $this->db->get('annonce')->result();
        }

        if ($type == 'univ') {
            $iduniv = $this->session->universite_session;
            $this->db->order_by('idannonce', 'desc');
            $this->db->where(['type' => 'universite', 'id' => $iduniv]);
            $r = $this->db->get('annonce')->result();
        }

        if ($type == 'banque') {
            $id = $this->session->bank_session;
            $this->db->order_by('idannonce', 'desc');
            $this->db->where(['type' => 'banque', 'id' => $id]);
            $r = $this->db->get('annonce')->result();
        }

        if ($type == 'admin') {
            $id = $this->session->isadmin;
            $this->db->order_by('idannonce', 'desc');
            $this->db->where(['type' => 'admin', 'id' => $id]);
            $r = $this->db->get('annonce')->result();
        }


        echo json_encode($r ?? []);
    }


    function annonce_d()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $annonce = $this->input->post('annonce', true);

        if ($type == 'ecole') {
            $idecole = $this->session->ecole_session;
            if (count($a = $this->db->where(['type' => 'ecole', 'id' => $idecole, 'idannonce' => $annonce])->get('annonce')->result())) {

                $a = $a[0];
                @unlink($a->image);
                $this->db->where('idannonce', $annonce)->delete('annonce');
                $rep['status'] = true;
                $rep['message'] = 'Annonce supprimée.';
            } else {
                $rep['status'] = false;
                $rep['message'] = 'Erreur de suppression.';
            }
        }

        if ($type == 'univ') {
            $id = $this->session->universite_session;
            if (count($a = $this->db->where(['type' => 'universite', 'id' => $id, 'idannonce' => $annonce])->get('annonce')->result())) {

                $a = $a[0];
                @unlink($a->image);
                $this->db->where('idannonce', $annonce)->delete('annonce');
                $rep['status'] = true;
                $rep['message'] = 'Annonce supprimée.';
            } else {
                $rep['status'] = false;
                $rep['message'] = 'Erreur de suppression.';
            }
        }

        if ($type == 'banque') {
            $id = $this->session->bank_session;
            if (count($a = $this->db->where(['type' => 'banque', 'id' => $id, 'idannonce' => $annonce])->get('annonce')->result())) {

                $a = $a[0];
                @unlink($a->image);
                $this->db->where('idannonce', $annonce)->delete('annonce');
                $rep['status'] = true;
                $rep['message'] = 'Annonce supprimée.';
            } else {
                $rep['status'] = false;
                $rep['message'] = 'Erreur de suppression.';
            }
        }

        if ($type == 'admin') {
            $id = $this->session->isadmin;
            if (count($a = $this->db->where(['type' => 'admin', 'id' => $id, 'idannonce' => $annonce])->get('annonce')->result())) {

                $a = $a[0];
                @unlink($a->image);
                $this->db->where('idannonce', $annonce)->delete('annonce');
                $rep['status'] = true;
                $rep['message'] = 'Annonce supprimée.';
            } else {
                $rep['status'] = false;
                $rep['message'] = 'Erreur de suppression.';
            }
        }

        echo json_encode($rep ?? []);
    }

    function article()
    {
        $type = $this->input->get('type', true);
        $this->checktype($type);

        if ($type == 'ecole') {
            $idecole = $this->session->ecole_session;
            $this->db->order_by('idarticle', 'desc');
            $this->db->where(['idecole' => $idecole]);
            $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
            $r = $this->db->get('article_ecole')->result();
        }

        if ($type == 'univ') {
            $iduniv = $this->session->universite_session;
            $this->db->order_by('idarticle', 'desc');
            $this->db->where(['iduniversite' => $iduniv]);
            $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
            $r = $this->db->get('article_universite')->result();
        }


        echo json_encode($r ?? []);
    }

    function article_a()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $devise = $this->input->post('devise');
        $titre = $this->input->post('titre');
        $prix = $this->input->post('prix');

        if (strlen($titre) > 128) {
            $rep['status'] = false;
            $rep['message'] = 'Le titre doit avoir moins de 128 caractères.';
            echo json_encode($rep);
            exit;
        }

        if (!file_exists('upload/article/')) {
            mkdir('upload/article/');
        }
        $path =  "upload/article/";
        $f = $_FILES['file']['name'] ?? '';
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
            'file_name' => $f,
            'max_width' => 1000,
            'max_height' => 500,
            'max_size' => 120 // Ko
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $d = $this->upload->data();
            $nomFichier = $path . $d['file_name'];

            if ($type == 'ecole') {
                $idecole = $this->session->ecole_session;
                $this->db->insert('article_ecole', ['idecole' => $idecole, 'iddevise' => $devise, 'description' => $titre, 'prix' => $prix, 'image' => $nomFichier]);
            } else if ($type == 'univ') {
                $id = $this->session->universite_session;
                $this->db->insert('article_universite', ['iduniversite' => $id, 'iddevise' => $devise, 'description' => $titre, 'prix' => $prix, 'image' => $nomFichier]);
            }
            $rep['status'] = true;
            $rep['message'] = 'Article ajouté.';
        } else {
            $rep['status'] = false;
            $rep['message'] = 'Echec, vérifiez le fichier séléctionné : ' . @$this->upload->error_msg[0];
        }

        echo json_encode($rep);
    }

    function article_d()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $idarticle = $this->input->post('id', true);

        if ($type == 'ecole') {
            $idecole = $this->session->ecole_session;
            if (count($a = $this->db->where(['idecole' => $idecole, 'idarticle' => $idarticle])->get('article_ecole')->result())) {
                $this->db->join('achat_article_ecole', 'achat_article_ecole.idarticle=article_ecole.idarticle');
                if (count($this->db->where(['article_ecole.idecole' => $idecole, 'article_ecole.idarticle' => $idarticle])->get('article_ecole')->result())) {
                    $rep['status'] = false;
                    $rep['message'] = 'Il existe deja un paiement pour cet article.';
                    echo json_encode($rep);
                    exit;
                }

                $a = $a[0];
                @unlink($a->image);
                $this->db->where('idarticle', $idarticle)->delete('article_ecole');
                $rep['status'] = true;
                $rep['message'] = 'Article supprimé.';
            } else {
                $rep['status'] = false;
                $rep['message'] = 'Erreur de suppression.';
            }
        }

        if ($type == 'univ') {
            $iduniversite = $this->session->universite_session;
            if (count($a = $this->db->where(['iduniversite' => $iduniversite, 'idarticle' => $idarticle])->get('article_universite')->result())) {
                $this->db->join('achat_article_universite', 'achat_article_universite.idarticle=article_universite.idarticle');
                if (count($this->db->where(['article_universite.iduniversite' => $iduniversite, 'article_universite.idarticle' => $idarticle])->get('article_universite')->result())) {
                    $rep['status'] = false;
                    $rep['message'] = 'Il existe deja un paiement pour cet article.';
                    echo json_encode($rep);
                    exit;
                }

                $a = $a[0];
                @unlink($a->image);
                $this->db->where('idarticle', $idarticle)->delete('article_universite');
                $rep['status'] = true;
                $rep['message'] = 'Article supprimé.';
            } else {
                $rep['status'] = false;
                $rep['message'] = 'Erreur de suppression.';
            }
        }

        echo json_encode($rep ?? []);
    }

    function annonce_u()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $idannonce = $this->input->post('idannonce', true);
        $titre = $this->input->post('titre', true);
        $rep['status'] = false;
        if (strlen($titre) > 128) {
            $rep['message'] = 'Le titre doit avoir moins de 128 caractères.';
            echo json_encode($rep);
            exit;
        }

        if ($type == 'admin') {
            $this->db->update('annonce', ['titre' => $titre], ['idannonce' => $idannonce, 'type' => 'admin']);
            $rep['status'] = true;
            $rep['message'] = "Annonce mise à jour.";
        } else if ($type == 'ecole') {
            $idecole = $this->session->ecole_session;
            $this->db->update('annonce', ['titre' => $titre], ['idannonce' => $idannonce, 'type' => 'ecole', 'id' => $idecole]);
            $rep['status'] = true;
            $rep['message'] = "Annonce mise à jour.";
        } else if ($type == 'univ') {
            $iduniv = $this->session->universite_session;
            $this->db->update('annonce', ['titre' => $titre], ['idannonce' => $idannonce, 'type' => 'universite', 'id' => $iduniv]);
            $rep['status'] = true;
            $rep['message'] = "Annonce mise à jour.";
        } else if ($type == 'banque') {
            $idbank = $this->session->bank_session;
            $this->db->update('annonce', ['titre' => $titre], ['idannonce' => $idannonce, 'type' => 'banque', 'id' => $idbank]);
            $rep['status'] = true;
            $rep['message'] = "Annonce mise à jour.";
        }

        echo json_encode($rep);
    }
}
