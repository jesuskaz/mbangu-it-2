<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Banquee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->bank_session) {
            $this->session->sess_destroy();
            redirect();
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("BanqueModel");
        $this->load->model("Manager");
        $this->idbanque = $this->session->bank_session;
    }


    function index()
    {

        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, etudiant.telephone, universite.nomUniversite");
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $data["nb_univ"] =  count($this->db->get('universite')->result());
        $data["nb_ecole"] =  count($this->db->get('ecole')->result());
        $data["devises"] = $this->db->get('devise')->result();

        ///////////////
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
        //////////////////

        $idbank = (int) $this->session->bank_session;

        $sql = "SELECT sum(paiement.montant) montant, sum(commission) commission, nomDevise devise, paiement.iddevise from paiement
        join devise on devise.iddevise=paiement.iddevise join frais on frais.idfrais=paiement.idfrais
        where cast(date as date)  >= curdate() AND frais.idbanque=$idbank group by paiement.iddevise ";
        $cajour_univ = $this->db->query($sql)->result();

        $sql = "SELECT sum(paiement.montant) montant, sum(commission) commission, nomDevise devise, paiement.iddevise from paiement
        join devise on devise.iddevise=paiement.iddevise join frais on frais.idfrais=paiement.idfrais
        where MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE) AND frais.idbanque=$idbank group by paiement.iddevise ";
        $camoi_univ = $this->db->query($sql)->result();

        $sql = "SELECT sum(paiement_ecole.montant) montant, sum(commission) commission, nomDevise devise, paiement_ecole.iddevise from paiement_ecole
        join devise on devise.iddevise=paiement_ecole.iddevise join frais_ecole on frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole
        where cast(date as date)  >= curdate() AND frais_ecole.idbanque=$idbank group by paiement_ecole.iddevise ";
        $cajour_ecole = $this->db->query($sql)->result();

        $sql = "SELECT sum(paiement_ecole.montant) montant, sum(commission) commission, nomDevise devise, paiement_ecole.iddevise from paiement_ecole
        join devise on devise.iddevise=paiement_ecole.iddevise join frais_ecole on frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole
        where MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE) AND frais_ecole.idbanque=$idbank group by paiement_ecole.iddevise ";
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

        $this->load->view("banque/bk-index", $data);
    }

    public function universite()
    {
        $this->db->select('nomUniversite, count(idetudiant) nb');
        $this->db->join('faculte', 'faculte.iduniversite=universite.iduniversite', 'left');
        $this->db->join('options', 'faculte.idfaculte=options.idfaculte', 'left');
        $this->db->join('etudiant', 'etudiant.idoptions=options.idoptions', 'left');
        $this->db->group_by('universite.iduniversite');
        $data["ecoles"] = $this->db->get('universite')->result();
        $this->load->view("banque/bk-univ", $data);
    }

    public function ecole()
    {
        $this->db->select('ecole.nomEcole ecole, count(ideleve) nb');
        $this->db->join('eleve', 'eleve.idecole=ecole.idecole', 'left');
        $this->db->group_by('ecole.idecole');
        $data["ecoles"] = $this->db->get('ecole')->result();
        $this->load->view("banque/bk-ecole", $data);
    }

    public function paiement()
    {
        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, 
        etudiant.matricule, etudiant.email, faculte.nomFaculte, promotion.intitulePromotion, 
        frais.designation, frais.numeroCompte, banque.denomination, paiement.montant, devise.nomDevise, nomUniversite, date");

        $this->db->join('etudiant', 'etudiant.idetudiant=paiement.idetudiant');
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');

        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('banque', 'banque.idbanque=frais.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais.iddevise');
        $this->db->where('banque.idbanque', $this->idbanque);

        $this->db->group_by('paiement.idpaiement');
        $this->db->order_by('paiement.idpaiement', 'desc');

        $data["paies"] = $this->db->get('paiement')->result();

        #################################################################
        $this->db->select("paiement_ecole.*, eleve.ideleve, eleve.nom, eleve.postnom,
        eleve.prenom, eleve.matricule, section.intitulesection section, 
        optionecole.intituleOption option, frais_ecole.intitulefrais frais, frais_ecole.compte, banque.denomination banque, 
        paiement_ecole.montant, devise.nomDevise devise, classe.intituleclasse classe, ecole.nomecole, date ");

        $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
        $this->db->join('optionecole', 'optionecole.idoptionecole=eleve.idoptionecole');
        $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
        $this->db->join('section', 'section.idsection=optionecole.idsection');
        $this->db->join('ecole', 'ecole.idecole=section.idecole');

        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->where('banque.idbanque', $this->idbanque);

        $this->db->group_by('paiement_ecole.idpaiement_ecole');
        $this->db->order_by('paiement_ecole.idpaiement_ecole', 'desc');

        $r = $this->db->get('paiement_ecole')->result();

        $ide = '';
        foreach ($r as $el) {
            $ide .= $el->ideleve . ", ";
        }
        $ide = substr($ide, 0, -2);
        /////
        $this->db->select("paiement_ecole.*, eleve.nom, eleve.postnom,
        eleve.prenom, eleve.matricule, section.intitulesection section, 
        frais_ecole.intitulefrais frais, frais_ecole.compte, banque.denomination banque, 
        paiement_ecole.montant, devise.nomDevise devise, classe.intituleclasse classe, ecole.nomecole, date ");

        $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
        $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe=eleve.idsection_has_classe');
        $this->db->join('classe', 'classe.idclasse=section_has_classe.idclasse');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->join('ecole', 'ecole.idecole=section.idecole');

        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->where('banque.idbanque', $this->idbanque);

        if (!empty($ide)) {
            $this->db->where("`eleve`.`ideleve` NOT IN ($ide)", NULL, FALSE);
        }

        $this->db->group_by('paiement_ecole.idpaiement_ecole');
        $this->db->order_by('paiement_ecole.idpaiement_ecole', 'desc');
        $r2 = $this->db->get('paiement_ecole')->result();

        foreach ($r2 as $ele) {
            $e = $ele;
            array_push($r, $e);
        }

        $data["paies2"] = $r;

        $this->load->view('banque/bk-listepay', $data);
    }

    public function etudiantListe()
    {
        $this->db->select("etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, 
        etudiant.email, etudiant.telephone, faculte.nomFaculte, promotion.intitulePromotion, etudiant.adresse, 
        etudiant.telephone, nomUniversite universite");
        $this->db->join('options', 'etudiant.idoptions=options.idoptions');
        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->group_by('etudiant.idetudiant');

        $data["etudiants"] =  $this->db->get('etudiant')->result();
        $this->load->view("banque/bk-etudiant", $data);
    }

    public function eleve()
    {
        ///////////////
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

        $this->load->view("banque/bk-eleve", $data);
    }

    function profil()
    {
        $idbank = $this->session->bank_session;
        $u = $this->db->where('idbanque', $idbank)->get('banque')->result()[0];
        $this->load->view("banque/profil", ['bank' => $u]);
    }

    function annonces()
    {
        $this->load->view('banque/annonces');
    }

    function annonce_e($idannonce = null)
    {
        $idannonce  = (int) $idannonce;
        if (!count($annonce = $this->db->where(['idannonce' => $idannonce, 'type' => 'banque', 'id' => $this->idbanque])->get('annonce')->result())) {
            redirect('banquee/annonces');
        }
        $this->load->view('banque/annonce-e', ['annonce' => $annonce[0]]);
    }
}
