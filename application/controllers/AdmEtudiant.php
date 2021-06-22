<?php
class AdmEtudiant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('AdminCredential/loginAdmin');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("EtudiantModel");
    }
    // public function etudiant()
    // {
    //     $this->load->view("etuidant");
    // }

    // public function listeEtudiant()
    // {
    //     $this->load->view("admn-listeetudiant");
    // }

    public function listePaiement()
    {
        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, 
        etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, 
        frais.designation, frais.numeroCompte, banque.denomination, paiement.montant, devise.nomDevise");

        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');


        $data["paies"] = $r = $this->db->get('paiement')->result();
        // $data["paies"] = $this->EtudiantModel->gelAllPaie();

        // var_dump($r);
        // die;

        if ($data) {
            $this->load->view("admin/adm-listepay", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("admin/adm-listepay", $data);
        }
    }
    // public function listeUniv()
    // {
    //     $this->load->view("admn-listuniv");
    // }
    // public function listBanque()
    // {
    //     $this->load->view("adm-voirbanque");
    // }
    public function listeEtudiant()
    {
        $this->db->select("
        etudiant.nom, etudiant.postnom, etudiant.prenom, 
        etudiant.matricule, etudiant.email, faculte.nomFaculte, 
        promotion.intitulePromotion, etudiant.adresse, 
        etudiant.telephone"
        );
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $data["etudiants"] =  $this->db->get('etudiant')->result();
        // $data["etudiants"] = $this->EtudiantModel->getAllStudent();
        if ($data) {
            $this->load->view("admin/liste-etudiant", $data);
        } else {
            $data["error"] = "vide";
            $this->load->view("admin/liste-etudiant", $data);
        }
    }
}
