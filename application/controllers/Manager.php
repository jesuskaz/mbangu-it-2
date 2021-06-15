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
        $this->db->select("etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["devises"] = $this->db->get('devise')->result();
        $data["universites"] = $this->db->get('universite')->result();

        $this->load->view("admin/adm-index", $data);
    }
    public function devise()
    {
        $this->load->view('admin/devise');
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

    public function codingTest()
    {
        $this->load->view("coding");
    }

    public function accueil()
    {
        $login = $this->session->userdata("login");
        $this->load->view("banque/bk-index");
    }

    function detail_etudiant($idetudiant = null)
    {

        $idetudiant = (int) $idetudiant;
        if (!count($et = $this->db->where('idetudiant', $idetudiant)->get('etudiant')->result())) {
            redirect('manager');
        }


        $this->load->view("admin/detail_etudiant", $data = []);
    }
}
