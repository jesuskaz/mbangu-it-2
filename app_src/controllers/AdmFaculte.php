<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdmFaculte extends CI_Controller
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
    public function addFaculte()
    {
        $this->load->view("admin/ajouter-faculte");
    }
    public function listeFaculte()
    {
        $data["universites"] = $this->db->get('universite')->result();

        if ($data) {
            $this->load->view("admin/adm-listfaculte", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("admin/liste-faculte", $data);
        }
    }
}
