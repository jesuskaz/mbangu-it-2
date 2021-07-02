<?php
class AdmUniversite extends CI_Controller
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
    public function loadUniversite()
    {
        // $data["ecoles"] = $this->AdmUniversiteModel->getAllSchool();
        $data["ecoles"] = $this->db->get('universite')->result();
        if ($data) {
            $this->load->view("admin/adm-listeuniv", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("admin/adm-listeuniv", $data);
        }
    }
    public function addUniversite()
    {
        $this->load->view("admin/adm-creeruniv");
    }
    public function univCreate()
    {
        $nom = $this->input->post("nom");
        $login = $this->input->post("login");
        $password = $this->input->post("password");

        $data = [
            "nomUniversite" => $nom,
            "login" => $login,
            "code" => $password
        ];
        $insert = $this->AdmUniversiteModel->checkUniv($nom);

        if ($insert) {
            $data["message"] = "L'université " . strtoupper($nom) . "  existe déjà";
            $data["classe"] = "danger";

        } else {
            $insert = $this->AdmUniversiteModel->addUniv($data);
            if ($insert) {
                $data["message"] = "L'université " . strtoupper($nom) . " a été créée avec succès";
                $data["classe"] = "success";
            }else{
                $data["message"] = "erreur";
                $data["classe"] = "danger"; 
            }
        }

        $this->session->set_flashdata($data);
        redirect('admuniversite/adduniversite');
    }
}
