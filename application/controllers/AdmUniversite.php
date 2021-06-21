<?php
class AdmUniversite extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("AdmUniversiteModel");
    }
    public function loadUniversite()
    {
        // $data["ecoles"] = $this->AdmUniversiteModel->getAllSchool();
        $data["ecoles"] = $this->db->get('universite')->result();
        if ($data) {
            $this->load->view("adm-listeuniv", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("adm-listeuniv", $data);
        }
    }
    public function addUniversite()
    {
        $this->load->view("adm-creeruniv");
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
            $data["error"] = "L'université " . strtoupper($nom) . "  existe déjà";
            $this->load->view("adm-creeruniv", $data);
        } else {
            $insert = $this->AdmUniversiteModel->addUniv($data);
            if ($insert) {
                $data["success"] = "L'université " . strtoupper($nom) . " a été créée avec succès";
                $this->load->view("adm-creeruniv", $data);
            }
        }
    }
}
