<?php
class AdmEtudiant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("EtudiantModel");
    }
    
    public function listePaiement()
    {

        $data["universites"] = $this->db->get('universite')->result();
        $this->load->view("admin/adm-listepay", $data);
    }
    
    public function listeEtudiant()
    {
        $this->db->order_by('etudiant.idetudiant', 'desc');
        $this->db->select(
            "etudiant.idetudiant,
        etudiant.nom, etudiant.postnom, etudiant.prenom, 
        etudiant.matricule, etudiant.email, faculte.nomFaculte, 
        promotion.intitulePromotion, etudiant.adresse, 
        etudiant.telephone, nomUniversite universite"
        );
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->group_by('etudiant.idetudiant');
        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $this->load->view("admin/liste-etudiant", $data);
    }
}
