<?php
class AdmCompte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("CompteModel");
    }
    public function listeCompte()
    {
        // $data["comptes"] = $this->CompteModel->getAllCompte();
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');

        $data["comptes"] = $this->db->get('frais')->result();

        // var_dump($data["comptes"] ); die;
        // if($data)
        // {
        //     $this->load->view("admin/liste-compte", $data);
        // }
        // else
        // {
        //     $data["error"] = "Vide";
        //     $this->load->view("liste-compte", $data);
        // }

        $this->load->view("admin/liste-compte", $data);
    }
    // public function getBanque()
    // {
    //     $data["banques"] = $this->CompteModel->banqueGet();
    //     if ($data) {
    //         $this->load->view("ajouter-compte", $data);
    //     } else {
    //         $data["vide"] = "Vous n'avez aucune banque pour le moment";
    //         $this->load->view("admin/ajouter-compte", $data);
    //     }
    // }
}
