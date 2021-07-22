<?php
class Banquee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->bank_session) {
            redirect();
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("BanqueModel");
        $this->load->model("Manager");
    }


    function index()
    {

        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone, universite.nomUniversite");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');

        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["nb_univ"] =  count($this->db->get('universite')->result());
        $data["devises"] = $this->db->get('devise')->result();

        $this->load->view("banque/bk-index", $data);
    }

    public function universite()
    {
        $data["ecoles"] = $this->db->get('universite')->result();
        $this->load->view("banque/bk-univ", $data);
    }

    public function paiement()
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
        $this->db->group_by('paiement.idpaiement');

        $data["paies"] = $r = $this->db->get('paiement')->result();

        $this->load->view('banque/bk-listepay', $data);
    }

    public function etudiantListe()
    {
        $login = $this->session->userdata('bank_session');
        $denom = $this->BanqueModel->banqueName($login);

        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, 
        etudiant.email, etudiant.telephone, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, 
        etudiant.telephone");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $this->load->view("banque/bk-etudiant", $data);
    }

    function profil()
    {
        $idbank = $this->session->bank_session;
        $u = $this->db->where('idbanque', $idbank)->get('banque')->result()[0];
        $this->load->view("banque/profil", ['bank' => $u]);
    }

    function annonces() {
        $this->load->view('banque/annonces');
    }
}
