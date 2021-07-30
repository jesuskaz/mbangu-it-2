<?php
    class ApiParentModel extends CI_Model
    {
        public function create($table, $data)
        {
            $query = $this->db->insert($table, $data);
            return $query;
        }
        public function read($table, $data)
        {
            $query = $this->db->get_where($table, $data)->result_array();
            return $query;
        }
        // New arrea
        public function insertUser($data)
    {
        $data = $this->db->insert("etudiant", $data);
        return $data;
    }
    public function getPromo($idEcole)
    {
        $query = $this->db->get_where("promotion", ["idEcole" => $idEcole])->result_array();
        return $query;
    }
    public function getOneUser($id)
    {
        $this->db->select("*");
        $this->db->from("client");
        $this->db->where("id", $id);
    }
    public function getFacSelected($idFaculte, $iduniversite)
    {
        $this->db->select('*');
        $this->db->from('faculte');
        $this->db->join("options", "faculte.idfaculte = options.idfaculte");
        $this->db->join("promotion", "promotion.idpromotion = options.idpromotion");
        $this->db->where("options.idfaculte", $idFaculte);
        $this->db->where("faculte.iduniversite", $iduniversite);
        $this->db->group_by("intitulePromotion");
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getOption($idpromotion, $iduniversite)
    {
        $this->db->select("*");
        $this->db->from("options");
        $this->db->where("options.idpromotion", $idpromotion);
        $this->db->join("promotion", "promotion.idpromotion = options.idpromotion");
        $this->db->join("universite", "universite.iduniversite = promotion.iduniversite");
        $this->db->where("universite.iduniversite", $iduniversite);
        $this->db->group_by("intituleOptions");
        $query = $this->db->get()->result_array();
        //  = $this->db->get_where("option", ["idPromotion" => $$idpromotion, "iduniversite" => $iduniversite])->result_array();
        return $query;
    }
    public function getPasswordChecking($matricule, $code)
    {
        $query = $this->db->get_where("etudiant", ["matricule" => $matricule, "password" => $code])->result_array();
        return $query;
    }
    public function getUserChecking($matricule)
    {
        $query = $this->db->get_where("etudiant", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function getSomeStudent($matricule)
    {
        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->join('promotion', 'promotion.idpromotion = etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion = promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte = options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite = faculte.iduniversite');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->group_by('idetudiant');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getStudent($id)
    {
        $query = $this->db->get_where("etudiant", ['idetudiant' => $id])->result_array();
        return $query;
    }
    public function other()
    {
        $query = $this->db->get("etudiant")->result_array();
        return $query;
    }
    public function addOperation($data)
    {
        $query = $this->db->insert("operation", $data);
        return $query;
    }
    public function getIdUser($login)
    {
        $query = $this->db->get_where("eleve", ["login" => $login])->result_array();
        return $query;
    }
    public function addCode($data)
    {
        $query = $this->db->insert("password", $data);
        return $query;
    }
    public function addAppro($data)
    {
        $query = $this->db->insert("appro", $data);
        return $query;
    }
    public function addApprocdf($data)
    {
        $query = $this->db->insert("approcdf", $data);
        return $query;
    }
    public function saveTempo($data)
    {
        $query = $this->db->insert("tempo", $data);
        return $query;
    }

    public function fraisPaiSolde($fraisId, $idetudiant, $iddevise)
    {
        $query = $this->db->query("select sum(montant) as montant from paiement where idfrais = $fraisId and idetudiant = $idetudiant and iddevise = $iddevise");
        return $query->row('montant');
    }
    public function fraisApproSolde($idetudiant, $iddevise)
    {
        $query = $this->db->query("select sum(montant) as montant from appro where idetudiant=$idetudiant and iddevise=$iddevise");
        return $query->row('montant');
    }
    public function solde($idparent, $iddevise)
    {
        $query = $this->db->query("select SUM(montant) as montant from appro_parent where idparent=$idparent and iddevise=$iddevise");
        return $query->result_array();
    }
    public function soldePaie($idparent, $iddevise)
    {
        $this->db->select("SUM(montantTot) as montant")->from("paiement_ecole");
        $query = $this->db->where("ideleve in (select ideleve from parent_has_eleve where idparent=$idparent) and iddevise=$iddevise");
        // $query = $this->db->query("select SUM(montantTot) as montant from paiement_ecole where ideleve in (select ideleve from parent_has_eleve where idparent=$idparent) and iddevis=$iddevise");
        return $query->get()->result_array();
    }
    public function getCheckSolde($matricule)
    {
        $query = $this->db->get_where("solde", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function getDataUniv($matricule)
    {
        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->where('matricule', $matricule);
        $this->db->join('promotion', 'promotion.idpromotion = etudiant.idpromotion');
        $this->db->join('options', 'options.idpromotion = promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte = options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite = faculte.iduniversite');
        $this->db->group_by('etudiant.idetudiant');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getCheckSoldeCdf($matricule)
    {
        $query = $this->db->get_where("soldeCdf", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function getUsername($matricule)
    {
        $query = $this->db->get_where("eleve", ["matricule" => $matricule])->result_array();
        return $query;
    }
    // For toDay
    public function prixFrais($idFrais)
    {
        $query = $this->db->get_where("frais", ["idFrais" => $idFrais])->row("montant");
        return $query;
    }
    public function getPrixFrais($idFrais, $iduniversite, $iddevise)
    {
        $this->db->select('*');
        $this->db->from('frais');
        $this->db->join('devise', 'devise.iddevise = frais.iddevise');
        $this->db->where('frais.idfrais', $idFrais);
        $this->db->where('frais.iduniversite', $iduniversite);
        $this->db->where('frais.iddevise', $iddevise);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getReste($idfrais, $idetudiant, $iddevise)
    {
        $this->db->select('sum(montant) as montant, nomDevise');
        $this->db->from('paiement');
        $this->db->where('paiement.idfrais_ecole', $idfrais);
        $this->db->where('paiement.idetudiant', $idetudiant);
        $this->db->where('paiement.iddevise', $iddevise);
        $this->db->join('devise', 'devise.iddevise = paiement.iddevise');
        $this->db->group_by('idetudiant');

        $query = $this->db->get()->result_array();
        return $query;

        // $this->db->where('paiement.iddevise', $iddevise);
        // $query = $this->db->query("select sum(montant) as montant from paiement where idfrais = $idfrais and idetudiant = $idetudiant and iddevise=$iddevise");
        // return $query->row('montant');
    }
    public function dataUptoDate($contraint, $data)
    {
        $query = $this->db->where($contraint);
        $query = $this->db->update("reste", $data);
        return $query;
    }
    public function insertGraph($table, $data)
    {
        $query = $this->db->insert($table, $data);
        return $query;
    }

    public function checkFrais($frais, $matricule)
    {

        $query = $this->db->get_where("paiement", ["matricule" => $matricule, "idFrais" => $frais])->result_array();
        return $query;
    }
    public function getInfoNav($login)
    {
        $query = $this->db->get_where("parent", ["login" => $login])->result_array();
        return $query;
    }
    public function insertionReste($data)
    {
        $query = $this->db->insert("reste", $data);
        return $query;
    }
    public function verifyReste($matricule, $idFrais, $devise)
    {
        $query = $this->db->get_where("reste", ["matricule" => $matricule, "idFrais" => $idFrais, "devise" => $devise])->result_array();
        return $query;
    }
    //For To Day
    public function insertSolde($data)
    {
        $query = $this->db->insert("solde", $data);
        return $query;
    }
    public function insertSoldecdf($data)
    {
        $query = $this->db->insert("soldeCdf", $data);
        return $query;
    }
    public function updateSolde($matricule, $collection)
    {
        $query = $this->db->where("matricule", $matricule);
        $query = $this->db->update("solde", $collection);
        return $query;
    }
    public function updateSoldeCdf($matricule, $collection)
    {
        $query = $this->db->where("matricule", $matricule);
        $query = $this->db->update("soldeCdf", $collection);
        return $query;
    }
    public function addCommission($commission)
    {
        $query = $this->db->insert("commission", $commission);
        return $query;
    }

    public function updateEntry($matricule, $data)
    {
        $query = $this->db->where("matricule", $matricule);
        $query = $this->db->update("tempo", $data);
        return $query;
    }
    public function checkState($matricule)
    {
        $query = $this->db->get_where("tempo", ["matricule" => $matricule])->row('state');
        return $query;
    }

    public function checkMatricule($matricule)
    {
        $query = $this->db->get_where("tempo", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function updateTemp($matricule, $data)
    {
        $query = $this->db->where("matricule", $matricule);
        $query = $this->db->update("tempo", $data);
        return $query;
    }

    public function getFrais($iddevise, $idetudiant)
    {
        $query = $this->db->get_where("frais", ["iddevise" => $iddevise, "iduniversite" => $idetudiant])->result_array();
        return $query;
    }
    public function allStudent()
    {
        $query = $this->db->get('eleve')->result_array();
        return $query;
    }
    public function getStudentAll()
    {
        $query = $this->db->get("universite")->result_array();
        return $query;
    }
    public function getStatistic($matricule)
    {
        $query = $this->db->get_where("reste", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function payment($data)
    {
        $query = $this->db->insert("paiement", $data);
        return $query;
    }
    public function paymentSyllabus($data)
    {
        $query = $this->db->insert("paymentsyllabus", $data);
        return $query;
    }
    public function paymentCdf($data)
    {
        $query = $this->db->insert("paiementcdf", $data);
        return $query;
    }
    public function getAllSoldeCdf()
    {
        $query = $this->db->get("soldeCdf")->result_array();
        return $query;
    }
    public function getASolde($matricule)
    {
        $query = $this->db->get_where("solde", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function getIntituleFaculte($faculte, $idEcole)
    {
        $query = $this->db->get_where("faculte", ["idFaculte" => $faculte, "idEcole" => $idEcole])->row("nomFaculte");
        return $query;
    }
    public function getASoldeCdf($matricule)
    {
        $query = $this->db->get_where("soldeCdf", ["matricule" => $matricule])->result_array();
        return $query;
    }
    public function getLastPay()
    {
        $query = $this->db->limit(5);
        $query = $this->db->get('paiement')->result_array();
        return $query;
    }
    public function getAllAppro()
    {
        $query = $this->db->limit(5);
        $query = $this->db->get("appro")->result_array();
        return $query;
    }
    public function getPaieOperation($idparent)
    {
        $this->db->select("
            frais_ecole.montant as fraisMontant,
            (frais_ecole.montant - paiement_ecole.montant) as reste,
            paiement_ecole.idpaiement_ecole as idpaiement,
            paiement_ecole.montant as montant, date, paiement_ecole.typeOperation,
            paiement_ecole.commission, intitulefrais,
            compte, nomDevise,codeQr, paiement_ecole.ideleve,
            eleve.nom, eleve.prenom, eleve.postnom, eleve.matricule,
            intitulesection, intituleOption, intituleclasse, nomecole, idparent
            ");
        $this->db->from("paiement_ecole");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->join('optionecole', 'optionecole.idoptionecole = eleve.idoptionecole');
        $this->db->join('classe', 'optionecole.idclasse = classe.idclasse');
        $this->db->join('section', 'optionecole.idsection = section.idsection');
        $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
        $this->db->join('annee_scolaire_ecole', 'classe.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'annee_scolaire_ecole.idecole = annee_scolaire_ecole.idecole');
        // $this->db->where('parent_has_eleve.idparent', $idparent);
        $this->db->limit(3);
        $this->db->order_by("idpaiement", "desc");
        $this->db->group_by('idpaiement');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAlldataAppro($idparent)
    {
        $this->db->select("*");
        $this->db->from("appro_parent");
        $this->db->join('operateur', 'operateur.idoperateur = appro_parent.idoperateur');
        $this->db->join('devise', 'devise.iddevise = appro_parent.iddevise');
        $this->db->where('appro_parent.idparent', $idparent);
        $this->db->limit(3);
        $this->db->order_by("idappro_parent", "desc");
        $this->db->group_by('idappro_parent');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getHistorique($matricule)
    {
        $this->db->select("*");
        $this->db->from("operation");
        $this->db->order_by("idOperation", "desc");
        $this->db->where("idEtudiant", $matricule);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAllHistoriquePaiement($ideleve)
    {
        $this->db->select("
            frais_ecole.montant as fraisMontant,
            (frais_ecole.montant - paiement_ecole.montant) as reste,
            paiement_ecole.idpaiement_ecole as idpaiement,
            paiement_ecole.montant as montant, date, paiement_ecole.typeOperation,
            paiement_ecole.commission, intitulefrais,
            compte, nomDevise,codeQr, paiement_ecole.ideleve,
            eleve.nom, eleve.prenom, eleve.postnom, eleve.matricule,
            intitulesection, intituleOption, intituleclasse, nomecole,
            ");
        $this->db->from("paiement_ecole");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
        $this->db->join('optionecole', 'eleve.idoptionecole = optionecole.idoptionecole');
        $this->db->join('classe', 'optionecole.idclasse = classe.idclasse');
        $this->db->join('section', 'section.idsection = optionecole.idsection');
        $this->db->join('annee_scolaire_ecole', 'classe.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'annee_scolaire_ecole.idecole = annee_scolaire_ecole.idecole');
        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->order_by("idpaiement", "desc");
        $this->db->group_by('idpaiement');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAllChild($idparent)
    {
        $this->db->select("
            frais_ecole.montant as fraisMontant,
            (frais_ecole.montant - paiement_ecole.montant) as reste,
            paiement_ecole.idpaiement_ecole as idpaiement,
            paiement_ecole.montant as montant, date, paiement_ecole.typeOperation,
            paiement_ecole.commission, intitulefrais,
            compte, nomDevise,codeQr, paiement_ecole.ideleve,
            eleve.nom, eleve.prenom, eleve.postnom, eleve.matricule,
            intitulesection, intituleOption, intituleclasse, nomecole, idparent
            ");
        $this->db->from("paiement_ecole");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
        $this->db->join('optionecole', 'eleve.idoptionecole = optionecole.idoptionecole');
        $this->db->join('classe', 'optionecole.idclasse = classe.idclasse');
        $this->db->join('section', 'section.idsection = optionecole.idsection');
        $this->db->join('annee_scolaire_ecole', 'classe.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'annee_scolaire_ecole.idecole = annee_scolaire_ecole.idecole');
        $this->db->where('parent_has_eleve.idparent', $idparent);
        $this->db->order_by("idpaiement", "desc");
        $this->db->group_by('idpaiement');
        $query = $this->db->get()->result_array();
        return $query;
        
        $this->db->select("
            frais_ecole.montant as fraisMontant,
            (frais_ecole.montant - paiement_ecole.montant) as reste,
            paiement_ecole.idpaiement_ecole as idpaiement,
            paiement_ecole.montant as montant, date, paiement_ecole.typeOperation,
            paiement_ecole.commission, intitulefrais,
            compte, nomDevise,codeQr, paiement_ecole.ideleve,
            eleve.nom, eleve.prenom, eleve.postnom, eleve.matricule,
            intitulesection, intituleOption, intituleclasse, nomecole,
            ");
        $this->db->from("paiement_ecole");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
        $this->db->join('classe', 'eleve.idclasse = classe.idclasse');
        $this->db->join('section_has_classe', 'classe.idclasse = section_has_classe.idclasse');
        $this->db->join('section', 'section_has_classe.idsection = section.idsection');
        $this->db->join('optionecole', 'section.idsection = optionecole.idsection');
        $this->db->join('annee_scolaire_ecole', 'classe.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'annee_scolaire_ecole.idecole = annee_scolaire_ecole.idecole');
        $this->db->where('parent_has_eleve.idparent', $idparent);
        $this->db->order_by("idpaiement", "desc");
        $this->db->group_by('idpaiement');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAllHistoriqueAppro($idetudiant)
    {
        $this->db->select("*");
        $this->db->from("appro");
        $this->db->join('operateur', 'operateur.idoperateur = appro.idoperateur');
        $this->db->join('devise', 'devise.iddevise = appro.iddevise');
        $this->db->where('appro.idetudiant', $idetudiant);
        $this->db->order_by("idappro", "desc");
        $this->db->group_by('idappro');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getTarif($ideleve)
    {
        $this->db->select('*');
        $this->db->from('eleve');
        $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
        $this->db->join('annee_scolaire_ecole', 'ecole.idecole = annee_scolaire_ecole.idecole');
        $this->db->join('frais_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole = frais_ecole.idannee_scolaire_ecole');
        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->join('devise', 'devise.iddevise = frais_ecole.iddevise');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getEleveData($ideleve)
    {
        $this->db->select('*');
        $this->db->from('eleve');
        $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
        $this->db->join('section', 'ecole.idecole = section.idecole');
        $this->db->join('optionecole', 'section.idsection = optionecole.idsection');
        $this->db->join('classe', 'optionecole.idclasse = classe.idclasse');
        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->group_by('eleve.ideleve');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAllTarifChild($idparent)
    {
        $this->db->select('*');
        $this->db->from('frais_ecole');
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole = frais_ecole.idannee_scolaire_ecole');
        $this->db->join('classe', 'annee_scolaire_ecole.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole');
        $this->db->join('optionecole', 'optionecole.idclasse = classe.idclasse');
        $this->db->join('eleve', 'optionecole.idoptionecole = eleve.idoptionecole');
        $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
        $this->db->where("idparent", $idparent);
        $this->db->group_by('idfrais_ecole');
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getNameSchool($matricule)
    {
        $query = $this->db->get_where("eleve", ["matricule" => $matricule])->row("nomEcole");
        return $query;
    }
    public function getReverseData($idOperation)
    {
        //not use
        $this->db->from("operation");
        $this->db->order_by("idOperation", "desc");
        $this->db->where("idEtudiant", $idOperation);
        $query = $this->db->get()->result_array();
        return $query;
    }
    }
