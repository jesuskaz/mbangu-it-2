<?php
class Manager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('AdminCredential/adminConnexion');
        };
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("BanqueModel");
        $this->load->model("Modele");
    }
    public function index()
    {
        $this->load->model("EtudiantModel");
        // $data["etudiants"] = $this->EtudiantModel->getAllStudent();
        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["devises"] = $this->db->get('devise')->result();
        $data["universites"] = $this->db->get('universite')->result();

        $this->load->view("adm-index", $data);
    }
    public function devise()
    {
        $this->load->view('devise');
    }
    public function adddevise()
    {
        $devise = $this->input->post("devise");
        $data = array(
            "nomDevise" => $devise
        );
        $query = $this->db->insert('devise', $data);
        if ($query) {
            $message = array("success" => "Devise $devise ajoutee avec succes");
            $this->load->view('devise', $message);
        } else {
            $message = array('error' => 'La sauvegarde a echoue');
            $this->load->view('devise', $message);
        }
    }
    public function checkdata()
    {
        $heureDebut = strtotime('04-09-21 00:00:00');
        echo $heureDebut;
        // $heureFin = strtotime('04/09/21 23:59:59');
        // $data = $this->BanqueModel->getDate($heureDebut, $heureFin);
        // print_r($data);
    }
    public function connectBanque()
    {

        if (!$this->session->bank_session) {
            redirect('AdminCredential/adminConnexion');
        };

        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone, universite.nomUniversite");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');

        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["devises"] = $this->db->get('devise')->result();

        $this->load->view("banque/bk-index", $data);
    }
    public function etudiantListe()
    {
        $login = $this->session->userdata('loginBanque');
        $denom = $this->BanqueModel->banqueName($login);

        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, 
        etudiant.email, etudiant.telephone, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, 
        etudiant.telephone");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $this->load->view("banque/bk-etudiant", $data);
    }
    public function paiement()
    {
        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, 
        etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, 
        frais.designation, frais.numeroCompte, banque.denomination, paiement.montant, devise.nomDevise");

        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');

        $data["paies"] = $r = $this->db->get('paiement')->result();

        $this->load->view('banque/bk-listepay', $data);
    }
    public function codingTest()
    {
        $this->load->view("coding");
    }
    public function universiteListe()
    {
        if (!$this->session->bank_session) {
            redirect('AdminCredential/adminConnexion');
        };

        // $login = $this->session->userdata('loginBanque');
        // $denom = $this->BanqueModel->banqueName($login);
        // if ($denom) {
        //     $listeStudent = $this->BanqueModel->listSchool($denom);
        //     if ($listeStudent) {
        //         $data["ecoles"] = $listeStudent;
        //         $this->load->view("banque/bk-univ", $data);
        //     } else {
        //         $data["error"] = "Cela lave";
        //         $this->load->view("banque/bk-univ", $data);
        //     }
        // }
        $data["ecoles"] = $this->db->get('universite')->result();
        $this->load->view("banque/bk-univ", $data);
    }
    public function accueil()
    {
        $login = $this->session->userdata("login");
        $this->load->view("banque/bk-index");
    }
}
