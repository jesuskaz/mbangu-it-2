<?php
class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("Manager");
    }
    public function index()
    {
        if ($this->session->userdata("nomEcole")) {
            $this->load->view("index");
        } else {
            redirect("AdminCredential");
        }
    }
    // Banque controller
    public function loadUniversite()
    {
        $data["ecoles"] = $this->Manager->getAllEcole();
        if ($data) {
            $fac = $this->Manager->getAllFaculte();
            $this->load->view("bk-universites", $data);
        } else {
            $data["error"] = "Aucune ecole enregistree";
            $this->load->view("bk-universites", $data);
        }
    }
    public function loadImpression()
    {
        $this->load->view("bk-universites");
    }
    public function loadEtudiant()
    {
        $this->load->view("bk-universites");
    }
}
