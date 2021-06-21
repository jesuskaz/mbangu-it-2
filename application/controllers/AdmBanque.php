<?php
class AdmBanque extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("AdmBanqueModel");
    }
    public function loadBanque()
    {
        $data["banques"] = $this->db->get('banque')->result();
        // $data["banques"] = $this->AdmBanqueModel->getAllBanque();

        // if($data)
        // {
        //     $this->load->view("admin/liste-banque", $data);   
        // }
        // else
        // {
        //     $data["error"] = "Vide";
        //     $this->load->view("admin/liste-banque", $data);   
        // }
        $this->load->view("admin/liste-banque", $data);
    }
    public function addBanque()
    {
        $this->load->view("adm-creerbanque");
    }
    public function banqueCreate()
    {
        $banque = $this->input->post("banque");
        $login = $this->input->post("login");
        $password = $this->input->post("password");

        $data = [
            "denomination" => $banque,
            "login" => $login,
            "password" => $password
        ];

        $checkLogin = $this->AdmBanqueModel->checkLogin($login);
        $checkBanque = $this->AdmBanqueModel->checkBanque($banque);
        if ($checkLogin || $checkBanque) {
            if ($checkBanque) {
                $data["error"] = "La banque " . strtoupper($banque) . " existe déjà";
                $this->load->view("adm-creerbanque", $data);
            } else if ($checkLogin) {
                $data["error"] = "Le nom d'utilisateur " . strtoupper($login) . " existe déjà";
                $this->load->view("adm-creerbanque", $data);
            }
        } else {
            $insert = $this->AdmBanqueModel->createBanque($data);
            if ($insert) {
                $data["success"] = "La banque " . strtoupper($banque) . " a été créée avec succès";
                $this->load->view("adm-creerbanque", $data);
            }
        }
    }
}
