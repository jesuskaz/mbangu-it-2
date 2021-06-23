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
        $idEcole = $this->BanqueModel->getIdEcole($login);
        $iduniv = $this->session->universite_session;

        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise = frais.iddevise');
        $data["frais"] = $this->db->where(['iduniversite' => $iduniv])->get('frais')->result_array();
        $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $iduniv])->result_array();

        $data['devise'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $this->load->view("universite/liste-compte", $data);

        // $login = $this->session->userdata("login");
        // $idEcole = $this->BanqueModel->getIdEcole($login);
        // $idUversite = $this->session->universite_session;

        // $data["frais"] = $this->db->where([])->get('frais');

        // $this->load->view("universite/liste-compte", $data);

    }

    function edit_f($id_frais = null)
    {
        if (!$this->session->universite_session) {
            redirect();
        }

        $id_frais = (int) $id_frais;
        if (!count($et = $this->db->where('idfrais', $id_frais)->get('frais')->result())) {
            redirect('banque/listecompte');
        }

        $data['frais'] = $et[0]->designation;
        $this->load->view("universite/edit_frais", $data);
    }
    // public function listeBanque()
    // {
    //     $login = $this->session->userdata("login");
    //     $nomEcole = $this->BanqueModel->getIdEcole($login);

    //     $data["banques"] = $this->BanqueModel->getAllBanque($nomEcole);
    //     if ($data) {
    //         $this->load->view("universite/liste-banque", $data);
    //     } else {
    //         $data["error"] = "Aucune donnee";
    //         $this->load->view("universite/liste-banque", $data);
    //     }
    // }

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
        $login = $this->session->userdata("universite_session");
        $denomination = $this->Manager->rapportPayement($login);

        $this->db->select("paiement.*, etudiant.nom, etudiant.postnom,
            etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, 
            promotion.intitulePromotion, frais.designation, frais.numeroCompte,banque.denomination, 
            paiement.montant, devise.nomDevise, promotion.idpromotion, options.idoptions");

        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');

        $this->db->group_by('paiement.idpaiement');


        $data["paies"] = $r = $this->db->get('paiement')->result_array();

        $this->db->select('*');
        $this->db->from('promotion');
        $this->db->group_by('intitulePromotion');
        $data["promotion"] = $r = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('faculte');
        $this->db->group_by('nomFaculte');
        $data["faculte"] = $r = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('options');
        $this->db->group_by('intituleOptions');
        $data["option"] = $r = $this->db->get()->result_array();

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
}
