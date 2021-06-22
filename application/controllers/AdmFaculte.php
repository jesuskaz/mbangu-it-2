<?php
class AdmFaculte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('AdminCredential/loginAdmin');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("AdmUniversiteModel");
    }
    public function addFaculte()
    {
        $this->load->view("admin/ajouter-faculte");
    }
    public function listeFaculte()
    {
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $data["facultes"] = $this->db->get('faculte')->result();
        // $data["facultes"] = $this->AdmUniversiteModel->getAllFaculte();

        if ($data) {
            $this->load->view("admin/adm-listfaculte", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("admin/liste-faculte", $data);
        }
    }
}
