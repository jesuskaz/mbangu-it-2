<?php
class Manager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('index/login');
        };
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("BanqueModel");
        $this->load->model("Modele");
    }
    public function index()
    {
        $this->load->model("EtudiantModel");
        $this->db->select("etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone");
        $this->db->join('promotion', 'promotion.idpromotion=etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion=promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["devises"] = $this->db->get('devise')->result();
        $data["universites"] = $this->db->get('universite')->result();

        $data['nb_faculte'] = count($this->db->get('faculte')->result());
        $data['nb_etudiant'] = count($this->db->get('etudiant')->result());

        $sql = "SELECT sum(montant) montant, sum(commission) commission, nomDevise devise from paiement
        join devise on devise.iddevise=paiement.iddevise 
        where cast(date as date)  >= curdate() group by paiement.iddevise ";
        $data['nb_ca_jour'] = $f = $this->db->query($sql)->result();

        $sql = "SELECT sum(montant) montant, sum(commission) commission, nomDevise devise from paiement
        join devise on devise.iddevise=paiement.iddevise 
        where MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE) group by paiement.iddevise ";
        $data['nb_ca_mensuel'] = $f = $this->db->query($sql)->result();
        // var_dump($f);
        // die;
        $this->load->view("admin/adm-index", $data);
    }
    public function devise()
    {
        $this->load->view('admin/devise');
    }
    public function adddevise()
    {
        $devise = $this->input->post("devise");
        $data = array(
            "nomDevise" => $devise
        );
        $query = $this->db->insert('devise', $data);
        if ($query) {
            $message = array("message" => "Devise $devise ajoutee avec succes", 'classe' => 'success');
        } else {
            $message = array('message' => 'La sauvegarde a echoue', 'classe' => 'error');
        }
        $this->session->set_flashdata($message);
        redirect('manager/devise');
    }
    public function checkdata()
    {
        $heureDebut = strtotime('04-09-21 00:00:00');
        echo $heureDebut;
        // $heureFin = strtotime('04/09/21 23:59:59');
        // $data = $this->BanqueModel->getDate($heureDebut, $heureFin);
        // print_r($data);
    }

    public function codingTest()
    {
        $this->load->view("coding");
    }

    public function accueil()
    {
        $login = $this->session->userdata("login");
        $this->load->view("banque/bk-index");
    }

    function detail_etudiant($idetudiant = null)
    {

        $idetudiant = (int) $idetudiant;
        $this->db->join('anneeAcademique', 'etudiant.idanneeAcademique=anneeAcademique.idanneeAcademique');
        $this->db->join('promotion', 'etudiant.idpromotion=promotion.idpromotion');
        $this->db->join('options', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'options.idfaculte=faculte.idfaculte');
        $this->db->group_by('etudiant.idetudiant');
        if (!count($et = $this->db->where('idetudiant', $idetudiant)->get('etudiant')->result())) {
            redirect('manager');
        }
        $data['etudiant'] =  $et[0];

        $this->db->select('frais.montant montant_frais, paiement.montant montant_paye, frais.designation frais, devise.nomDevise devise, commission, date');
        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('devise', 'devise.iddevise=paiement.iddevise');
        $this->db->where('paiement.idetudiant', $idetudiant);
        $data['paiements'] = $this->db->get('paiement')->result();

        $total_appro = $this->db->query("SELECT SUM(montant) total, nomDevise devise, devise.iddevise FROM appro join devise on devise.iddevise=appro.iddevise 
        WHERE appro.idetudiant=$idetudiant GROUP BY appro.iddevise ")->result();

        $total_paiement = $this->db->query("SELECT SUM(montant) total, SUM(commission) commission, nomDevise devise, devise.iddevise FROM paiement join devise on devise.iddevise=paiement.iddevise 
        WHERE paiement.idetudiant=$idetudiant GROUP BY paiement.iddevise ")->result();

        $compte = [];
        foreach ($total_appro as $ta) {
            $find = false;
            $ob = new stdClass();
            foreach ($total_paiement as $tp) {
                if ($ta->iddevise == $tp->iddevise) {
                    $solde = $ta->total - $tp->total - $tp->commission;
                    if ($solde < 0) {
                        die(); // doit toujour etre >= 0 
                    }
                    $ob->montant = $solde;
                    $ob->devise = $ta->devise;
                    $find = true;
                }
            }
            if ($find) {
                array_push($compte, $ob);
            } else {
                $ob = new stdClass();
                $ob->montant = $ta->total;
                $ob->devise = $ta->devise;
                array_push($compte, $ob);
            }
        }
        // var_dump($total_appro, $total_paiement, $compte);
        // die;
        $data['comptes'] = $compte;
        $this->load->view("admin/detail_etudiant", $data);
    }

    function annonces() {
        $this->load->view('admin/annonces');
    }
}
