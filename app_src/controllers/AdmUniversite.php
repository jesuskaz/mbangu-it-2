<?php defined('BASEPATH') OR exit('No direct script access allowed');
class AdmUniversite extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            $this->session->sess_destroy();
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("AdmUniversiteModel");
    }
    public function loadUniversite()
    {
        $this->db->order_by('iduniversite', 'desc');
        $data["ecoles"] = $this->db->get('universite')->result();
        if ($data) {
            $this->load->view("admin/adm-listeuniv", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("admin/adm-listeuniv", $data);
        }
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
            } else {
                $data["message"] = "erreur";
                $data["classe"] = "danger";
            }
        }

        $this->session->set_flashdata($data);
        redirect('admUniversite/loaduniversite');
    }

    public function ecole()
    {
        $this->db->order_by('idecole', 'desc');
        $data["ecoles"] = $this->db->get('ecole')->result();
        $this->load->view("admin/ecole", $data);
    }

    function ecole_a()
    {
        $nom = $this->input->post("nom");
        $login = $this->input->post("login");
        $password = $this->input->post("password");

        if (count($this->db->where('nomecole', $nom)->get('ecole')->result())) {
            $data["message"] = "Le nom $nom existe déjà.";
            $data["classe"] = "danger";
        } else  if (count($this->db->where('login', $login)->get('ecole')->result())) {
            $data["message"] = "Le login $login existe déjà.";
            $data["classe"] = "danger";
        } else {
            $this->db->insert('ecole', ['nomecole' => $nom, 'login' => $login, 'password' => $password]);
            $data["message"] = "Ecole créée avec succès";
            $data["classe"] = "success";
        }

        $this->session->set_flashdata($data);
        redirect('admUniversite/ecole');
    }
}
