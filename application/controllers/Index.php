<?php
class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("Manager");
    }

    public function index()
    {
        $this->load->view('first/index');
    }

    function deconnexion()
    {
        $this->session->sess_destroy();
        redirect('index/login');
    }

    public function contact()
    {
        $this->load->view('first/contact');
    }

    public function about()
    {
        $this->load->view('first/about');
    }

    public function process()
    {
        $this->load->view('first/process');
    }

    public function login()
    {
        $this->load->view('first/login');
    }

    function home()
    {
        if ($iduniv = (int) $this->session->userdata("universite_session")) {

            $data["promotions"] = $this->db->where('iduniversite', $this->session->universite_session)->get('promotion')->result_array();
            $data["faculte"] = count($this->db->get_where('faculte', ["iduniversite" => $this->session->universite_session])->result());
            $data["selectFaculte"] = $this->db->get_where('faculte', ["iduniversite" => $this->session->universite_session])->result_array();

            $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
            $this->db->where('promotion.iduniversite', $iduniv);
            $data["tot_etudiant"] = $te = count($this->db->get('etudiant')->result());

            $sql = "SELECT * from etudiant where idetudiant 
            in (select paiement.idetudiant from paiement join etudiant ON paiement.idetudiant=etudiant.idetudiant join promotion on promotion.idpromotion=etudiant.idpromotion 
            where promotion.iduniversite=$iduniv)";
            $data["etudiant_paie"] = $ep = count($this->db->query($sql)->result());

            $data["etudiant_pas_paie"] = $te - $ep;

            $data["options"] = $this->Manager->getOption($this->session->universite_session);
            $data["devises"] = $this->db->get('devise')->result();
            $this->load->view("universite/index", $data);
        } else {
            redirect("index/login");
        }
    }

    function solde()
    {
        if ($iduniv = (int) $this->session->userdata("universite_session")) {
            $ann = $this->session->annee_academique;
            $data['frais'] = $this->db->where(['iduniversite' => $iduniv, 'idanneeAcademique' => $ann])->get('frais')->result();

            $annee = $this->session->annee_academique;

            $this->db->where(['frais.iduniversite' => $iduniv, 'frais.idanneeAcademique' => $annee]);
            $this->db->select("sum(paiement.montant) total, nomDevise devise, frais.designation frais");
            $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
            $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
            $this->db->group_by('paiement.iddevise');

            $data['solde'] = $this->db->get('paiement')->result();

            $this->load->view("universite/solde", $data);
        } else {
            redirect("index/login");
        }
    }

    function detail_solde($idfrais = null)
    {
        if ($iduniv = (int) $this->session->userdata("universite_session")) {
            if (is_null(($idfrais))) {
                redirect('index/solde');
            }

            if (!count($fr =  $this->db->where(['idfrais' => $idfrais, 'iduniversite' => $iduniv])->get('frais')->result())) {
                redirect('index/solde');
            }
            $fr = $fr[0];
            $ann = $this->session->annee_academique;
            $data['frais'] = $fr->designation;

            $this->db->select('etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule ,numeroCompte compte, promotion.intitulePromotion promotion, nomFaculte faculte, date, paiement.montant, nomDevise devise ');

            $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
            $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
            $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
            $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
            $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
            $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
            $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
            $this->db->group_by('paiement.idpaiement');

            $this->db->where('frais.idfrais', $idfrais);

            $data['paiement'] = $this->db->where(['frais.iduniversite' => $iduniv, 'frais.idanneeAcademique' => $ann])->get('paiement')->result();

            $this->load->view("universite/detail_solde", $data);
        } else {
            redirect("index/login");
        }
    }
}
