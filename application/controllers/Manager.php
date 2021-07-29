<?php
class Manager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            $this->session->sess_destroy();
            redirect('index/login');
        };
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("BanqueModel");
        $this->load->model("Modele");
    }
    public function index()
    {
        $this->db->select("etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone");
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["devises"] = $this->db->get('devise')->result();
        $data["universites"] = $this->db->get('universite')->result();

        $data['nb_faculte'] = count($this->db->get('faculte')->result());
        $data['nb_etudiant'] = count($this->db->get('etudiant')->result());

        $data['nb_eleve'] = count($this->db->get('eleve')->result());
        $data['ecoles'] = $this->db->get('ecole')->result();

        $sql = "SELECT sum(montant) montant, sum(commission) commission, nomDevise devise, paiement.iddevise from paiement
        join devise on devise.iddevise=paiement.iddevise 
        where cast(date as date)  >= curdate() group by paiement.iddevise ";
        $cajour_univ = $this->db->query($sql)->result();

        $sql = "SELECT sum(montant) montant, sum(commission) commission, nomDevise devise, paiement.iddevise from paiement
        join devise on devise.iddevise=paiement.iddevise 
        where MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE) group by paiement.iddevise ";
        $camoi_univ = $this->db->query($sql)->result();

        // var_dump($camoi_univ);
        // die;
        ///
        $sql = "SELECT sum(montant) montant, sum(commission) commission, nomDevise devise, paiement_ecole.iddevise from paiement_ecole
        join devise on devise.iddevise=paiement_ecole.iddevise 
        where cast(date as date)  >= curdate() group by paiement_ecole.iddevise ";
        $cajour_ecole = $this->db->query($sql)->result();

        $sql = "SELECT sum(montant) montant, sum(commission) commission, nomDevise devise, paiement_ecole.iddevise from paiement_ecole
        join devise on devise.iddevise=paiement_ecole.iddevise 
        where MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE) group by paiement_ecole.iddevise ";
        $camoi_ecole = $this->db->query($sql)->result();

        $cajour = $camoi = [];

        foreach ($cajour_univ as $cau) {
            foreach ($cajour_ecole as $cae) {
                if ($cau->iddevise == $cae->iddevise) {
                    $o = new stdClass();
                    $o->iddevise = $cau->iddevise;
                    $o->devise = $cau->devise;
                    $o->montant = $cau->montant + $cae->montant;
                    $o->commission = $cau->commission + $cae->commission;
                    array_push($cajour, $o);
                    break;
                }
            }
        }

        foreach ($camoi_univ as $cmu) {
            foreach ($camoi_ecole as $cme) {
                if ($cmu->iddevise == $cme->iddevise) {
                    $o = new stdClass();
                    $o->iddevise = $cmu->iddevise;
                    $o->devise = $cmu->devise;
                    $o->montant = $cmu->montant + $cme->montant;
                    $o->commission = $cmu->commission + $cme->commission;
                    array_push($camoi, $o);
                    break;
                }
            }
        }

        $data['nb_ca_mensuel'] = $camoi;
        $data['nb_ca_jour'] = $cajour;

        // var_dump($camoi_univ, $camoi_ecole, $camoi);
        // die;

        $this->db->order_by('eleve.ideleve', 'desc');
        $this->db->select(
            "eleve.ideleve,
        eleve.nom, eleve.postnom, eleve.prenom, 
        eleve.matricule, section.intitulesection section, 
        classe.intituleclasse classe, eleve.adresse, 
        eleve.telephoneparent telephone, nomecole ecole"
        );
        $this->db->join('optionecole', 'eleve.idoptionecole=optionecole.idoptionecole');
        $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
        $this->db->join('section', 'section.idsection=optionecole.idsection');
        $this->db->join('ecole', 'ecole.idecole=section.idecole');
        $this->db->group_by('eleve.ideleve');

        $r =  $this->db->get('eleve')->result();
        $ide = '';
        foreach ($r as $el) {
            $ide .= "$el->ideleve, ";
        }
        $ide = substr($ide, 0, -2);

        //////////
        $r2 = [];
        $this->db->order_by('eleve.ideleve', 'desc');
        $this->db->select(
            "eleve.ideleve,
        eleve.nom, eleve.postnom, eleve.prenom, 
        eleve.matricule, section.intitulesection section, 
        classe.intituleclasse classe, eleve.adresse, 
        eleve.telephoneparent telephone, nomecole ecole"
        );
        $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe=eleve.idsection_has_classe');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->join('classe', 'classe.idclasse=section_has_classe.idclasse');

        $this->db->join('ecole', 'ecole.idecole=section.idecole');
        if (!empty($ide)) {
            $this->db->where("`ideleve` NOT IN ($ide)", NULL, FALSE);
        }
        $this->db->group_by('eleve.ideleve');

        $r2 =  $this->db->get('eleve')->result();

        foreach ($r2 as $ele) {
            $e = $ele;
            array_push($r, $e);
        }
        $data["eleves"] = $r;

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
        $this->load->view("banque/bk-index");
    }

    function detail_etudiant($idetudiant = null)
    {

        $idetudiant = (int) $idetudiant;
        $this->db->join('anneeAcademique', 'etudiant.idanneeAcademique=anneeAcademique.idanneeAcademique');
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
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

    function detail_eleve($ideleve = null)
    {

        $ideleve = (int) $ideleve;
        $this->db->join('optionecole', 'optionecole.idoptionecole=eleve.idoptionecole');
        $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
        $this->db->join('section', 'section.idsection=optionecole.idsection');
        $this->db->where(['eleve.ideleve' => $ideleve]);
        $a = $this->db->get('eleve')->result();

        $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe=eleve.idsection_has_classe');
        $this->db->join('classe', 'classe.idclasse=section_has_classe.idclasse');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->where(['eleve.ideleve' => $ideleve]);
        $b = $this->db->get('eleve')->result();

        if (!count($a) && !count($b)) {
            redirect('manager');
        }

        $data['eleve'] = count($a) > 0 ? $a[0] : $b[0];

        $this->db->select('frais_ecole.montant montant_frais, paiement_ecole.montant montant_paye, frais_ecole.intitulefrais frais, devise.nomDevise devise, commission, date');
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'devise.iddevise=paiement_ecole.iddevise');
        $this->db->where('paiement_ecole.ideleve', $ideleve);
        $data['paiements'] = $this->db->get('paiement_ecole')->result();
        $this->load->view("admin/detail_eleve", $data);
    }

    function annonces()
    {
        $this->load->view('admin/annonces');
    }


    function annonce_e($idannonce = null)
    {
        $idannonce  = (int) $idannonce;
        if (!count($annonce = $this->db->where(['idannonce'=> $idannonce, 'type' => 'admin'])->get('annonce')->result())) {
            redirect('manager/annonces');
        }
        $this->load->view('admin/annonce-e', ['annonce' => $annonce[0]]);
    }
}
