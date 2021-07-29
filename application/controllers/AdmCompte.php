<?php
class AdmCompte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            $this->session->sess_destroy();
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("CompteModel");
    }
    public function listeCompte()
    {
        $this->db->order_by('idfrais', 'desc');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');

        $data["comptes"] = $this->db->get('frais')->result();
        $this->load->view("admin/liste-compte", $data);
    }
    
}
