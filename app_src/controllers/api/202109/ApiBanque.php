<?php defined('BASEPATH') or exit('No direct script access allowed');
class ApiBanque extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Ciqrcode");
    }
    public function signin()
    {
        $matricule = $this->input->post("matricule");
        $code = $this->input->post("code");

        $data = $this->db->get_where(
            "checker_banque",
            [
                "matricule" => $matricule,
                "mdp" => $code
            ]
        )->result_array();

        if (count($data) > 0) {
            $resarr = array();
            array_push($resarr, array(
                "id" => $data[0]["idchecker_banque"],
                "matricule" => $data[0]["matricule"],
                "password" => $data[0]["mdp"],
                "status" => "banque"
            ));
            echo json_encode($resarr);
        } else {
            $constraint = [
                "login" => $matricule,
                "password" => $code
            ];

            $result = $this->db->get_where(
                "checker_ecole",
                [
                    "matricule" => $matricule,
                    "mdp" => $code
                ]
            )->result_array();

            if ($result) {
                $arr = array();
                array_push(
                    $arr,
                    array(
                        "id" => $result[0]["idchecker_ecole"],
                        "matricule" => $result[0]["matricule"],
                        "status" => "ecole"
                    )
                );
                echo json_encode($arr);
            } else {
                echo json_encode("false");
            }
        }
    }
    function getData($matricule)
    {

        if ($el = $this->db->where('matricule', $matricule)->get('eleve')->result()) {

            if (empty($el[0]->idoptionecole)) {
                $this->db->select('*');
                $this->db->from('eleve');
                $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
                $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe = eleve.idsection_has_classe');
                $this->db->join('classe', 'section_has_classe.idclasse = classe.idclasse');
                $this->db->join('section', 'section.idsection = section_has_classe.idsection');
                $this->db->group_by('eleve.ideleve');
                $this->db->where('eleve.matricule', $matricule);
            } else {
                $this->db->select('*');
                $this->db->from('eleve');
                $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
                $this->db->join('section', 'ecole.idecole = section.idecole');
                $this->db->join('optionecole', 'section.idsection = optionecole.idsection');
                $this->db->join('classe', 'optionecole.idclasse = classe.idclasse');
                $this->db->group_by('eleve.ideleve');
                $this->db->where('eleve.matricule', $matricule);
            }

            $query = $this->db->get()->result_array();
            echo json_encode($query);
        } else if ($el = $this->db->where('matricule', $matricule)->get('etudiant')->result()) {
            $this->db->select('*');
            $this->db->from('etudiant');
            $this->db->join('options', 'etudiant.idoptions = options.idoptions');
            $this->db->join('faculte', 'faculte.idfaculte = options.idfaculte');
            $this->db->join('universite', 'universite.iduniversite = faculte.iduniversite');
            $this->db->join('promotion', 'promotion.idpromotion = options.idpromotion');
            $this->db->group_by('etudiant.idetudiant');
            $this->db->where('etudiant.matricule', $matricule);
            $query = $this->db->get()->result_array();
            echo json_encode($query);
        } else {
            $msg[] = array("msg" => "no exist");
            echo json_encode($msg);
        }
    }

    public function insertPayment()
    {
        $devise = $this->input->post("devise");
        $ideleve = $this->input->post("ideleve");
        $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');

        $montant = $this->input->post("montant");
        $idfrais = $this->input->post("idfrais");
        $totMontant = $this->input->post("montantTot");
        $commissionMontant = $this->input->post("commission");

        //Get Student personnel data
        $collection = $this->db->get_where('eleve', ['ideleve' => $ideleve])->result_array()[0];

        $dateQr = date('m-d-y-H-i-s');
        $scale = 4;
        $size = 100;
        $qr_image = 'qrcode-' . $dateQr . '-' . $ideleve . '.png';
        $params['data'] = 'MbanguPay ' . $collection["matricule"] . ' ' . $collection["nom"] . '-' . $collection["prenom"] . " MONTANT : " . $montant . ' ' . $devise;
        $params['level'] = $scale;
        $params['size'] = $size;
        $params['savename'] = FCPATH . "upload\qrcode\\" . $qr_image;

        $save = $this->ciqrcode->generate($params);

        $insertOperation = [
            "montant" => $montant,
            "ideleve" => $ideleve,
            "idfrais_ecole" => $idfrais,
            'codeQr' => $qr_image,
            // "operateur" => "assets/images/bangulogo.png",
            "commission" => $commissionMontant,
            "montant" => $montant,
            "montantTot" => $totMontant,
            // "nomOperateur" => "mbangu",
            "iddevise" => $iddevise,
            "typeOperation" => "Paiement effectue"
        ];

        $query = $this->db->insert('paiement_ecole', $insertOperation);
        $id = $this->db->insert_id();

        if ($query) {
            echo json_encode($id);
        } else {
            echo json_encode("false");
        }
    }
    function facturette($idetudiant,  $idpaiement)
    {
        // $idetudiant = (int) $this->input->post('etudiant');
        // $idfrais = (int) $this->input->post('paiement');

        $this->db->select("
            paiement.idpaiement,
            frais.montant as montantfrais,
            (frais.montant - sum(paiement.montant)) as reste,
            paiement.montant as montantPaye, date, frais.designation frais,
            numeroCompte compte, nomDevise devise,codeQr, etudiant.nom, etudiant.prenom, 
            etudiant.postnom, etudiant.matricule, nomFaculte faculte, 
            intituleOptions option, intitulePromotion promotion, nomUniversite universite
            ");
        $this->db->join('frais', 'frais.idfrais = paiement.idfrais');
        $this->db->join('devise', 'frais.iddevise = devise.iddevise');
        $this->db->join('etudiant', 'paiement.idetudiant = etudiant.idetudiant');
        $this->db->join('options', 'etudiant.idoptions = options.idoptions');
        $this->db->join('promotion', 'options.idpromotion = promotion.idpromotion');
        $this->db->join('faculte', 'faculte.idfaculte = options.idfaculte');
        $this->db->join('universite', 'faculte.iduniversite = universite.iduniversite');

        $this->db->where('etudiant.idetudiant', $idetudiant);
        $this->db->where('paiement.idpaiement', $idpaiement);
        $query = $this->db->get('paiement')->result_array();

        echo json_encode($query);
    }
    public function paieOperation($matricule)
    {
        $ideleve = $this->db->get_where('eleve', ["matricule" => $matricule])->row("ideleve");

        $this->db->select("
            frais_ecole.idfrais_ecole idfrais,
            frais_ecole.montant as fraisMontant,
            (frais_ecole.montant - sum(paiement_ecole.montant)) as reste,
            paiement_ecole.idpaiement_ecole as idpaiement,
            sum(paiement_ecole.montant) as montant, date, paiement_ecole.typeOperation,
            paiement_ecole.commission, intitulefrais,
            compte, nomDevise,codeQr, paiement_ecole.ideleve,
            eleve.nom, eleve.prenom, eleve.postnom, eleve.matricule
            ");
        $this->db->from("paiement_ecole");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->where("paiement_ecole.ideleve", $ideleve);

        $this->db->order_by("idpaiement", "desc");
        $this->db->group_by('idpaiement');
        $query = $this->db->get()->result_array();
        echo json_encode($query);
    }
    function facturetteEleve($ideleve, $idpaiement)
    {

        if (!count($el = $this->db->where('ideleve', $ideleve)->get('eleve')->result())) {
            echo json_encode([]);
            die;
        }

        if (empty($el[0]->idoptionecole)) {
            $this->db->select("
            paiement_ecole.idpaiement_ecole paiement,
            frais_ecole.montant as montantfrais,
            (frais_ecole.montant - sum(paiement_ecole.montant)) as reste,
            paiement_ecole.montant as montantPaye, date, intitulefrais frais,
            compte, nomDevise devise,codeQr, eleve.nom, eleve.prenom, 
            eleve.postnom, eleve.matricule, intitulesection section, intituleclasse classe, nomecole
            ");
            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
            $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
            $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
            $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe = eleve.idsection_has_classe');
            $this->db->join('classe', 'section_has_classe.idclasse = classe.idclasse');
            $this->db->join('section', 'section.idsection = section_has_classe.idsection');
            $this->db->join('ecole', 'section.idecole = ecole.idecole');
        } else {
            $this->db->select("
            paiement_ecole.idpaiement_ecole paiement,
            frais_ecole.montant as montantfrais,
            (frais_ecole.montant - sum(paiement_ecole.montant)) as reste,
            paiement_ecole.montant as montantPaye, date, intitulefrais frais,
            compte, nomDevise devise,codeQr, eleve.nom, eleve.prenom, 
            eleve.postnom, eleve.matricule, intitulesection section, intituleOption option,intituleclasse classe, nomecole
            ");
            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
            $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
            $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
            $this->db->join('optionecole', 'eleve.idoptionecole = optionecole.idoptionecole');
            $this->db->join('classe', 'optionecole.idclasse = classe.idclasse');
            $this->db->join('section', 'section.idsection = optionecole.idsection');
            $this->db->join('ecole', 'section.idecole = ecole.idecole');
        }

        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->where('paiement_ecole.idpaiement_ecole', $idpaiement);
        // $this->db->where('paiement_ecole.idpaiement_ecole', $idfrais);
        $query = $this->db->get('paiement_ecole')->result_array();

        echo json_encode($query);
    }
    public function insertPaymentEtudiant()
    {
        $devise = $this->input->post("devise");
        $matricule = $this->input->post("matricule");
        $montant = $this->input->post("montant");
        $idfrais = $this->input->post("idfrais");
        $rep['status'] = false;

        if (!isset($devise, $matricule, $montant, $idfrais)) {
            $rep['message'] = "Missing params.";
            echo json_encode($rep);
            exit;
        }

        $montant = (float) $montant;

        if ($montant <= 0) {
            $rep['message'] = "Montant non valide : $montant";
            echo json_encode($rep);
            exit;
        }

        $iddevise = (int) $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
        if (!$iddevise) {
            $rep['message'] = "Devise non valide : $devise";
            echo json_encode($rep);
            exit;
        }

        $frais = $this->db->get_where("frais", ["idfrais" => $idfrais])->result_array();
        if (!count($frais)) {
            $rep['message'] = "Frais non valide.";
            echo json_encode($rep);
            exit;
        }
        $collection = $this->db->get_where('etudiant', ['matricule' => $matricule])->result_array();
        if (!count($collection)) {
            $rep['message'] = "Etudiant non valide.";
            echo json_encode($rep);
            exit;
        }
        $collection = $collection[0];

        $montantFrais = (float)($frais[0]["montant"]);
        $nomFrais = $frais[0]["designation"];

        $idet = $collection['idetudiant'];
        $query = $this->db->query("select sum(montant) as montant from paiement where idfrais = $idfrais and idetudiant = $idet and iddevise = $iddevise");
        $paiement = (float) $query->row('montant');

        $reste = $montantFrais - $paiement;
        if ($paiement == $montantFrais) {
            $rep['message'] = "Ce frais est déjà totalement payé.";
        } else if ($montant > $reste) {
            $rep['message'] = "Le montant restant pour ce frais est de $reste $devise.";
        } else if ($montant + $paiement <= $montantFrais) {

            $commissionMontant = $montant * TAUX_COMMISSION;
            $totMontant = $montant + $commissionMontant;

            $dateQr = date('m-d-y-H-i-s');
            $scale = 4;
            $size = 100;
            $qr_image = 'qrcode-' . $dateQr . '.png';
            $params['level'] = $scale;
            $params['size'] = $size;
            $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;

            $params['data'] = 'MbanguPay | ' . $collection["matricule"] . ' | ' . $collection["nom"] . '-' . $collection["prenom"] . " | FRAIS $nomFrais" .  " | MONTANT : " . $montant . ' ' . $devise;

            $this->ciqrcode->generate($params);

            $this->db->where(['etudiant.idetudiant' => $collection['idetudiant'], 'anneeAcademique.actif' => 1]);
            $this->db->join('etudiant', 'etudiant.idanneeAcademique=anneeAcademique.idanneeAcademique');
            $annee = $this->db->get('anneeAcademique')->result();

            if (!count($annee)) {
                $rep['message'] = "Année académique non trouvée.";
                echo json_encode($rep);
                exit;
            }

            $insertOperation = [
                "montant" => $montant,
                "idetudiant" => $collection['idetudiant'],
                "idfrais" => $idfrais,
                'codeQr' => $qr_image,
                "commission" => $commissionMontant,
                "montant" => $montant,
                "montantTotal" => $totMontant,
                "iddevise" => $iddevise,
                "idanneeAcademique" => $annee[0]->idanneeAcademique,
                "typeOperation" => "Paiement effectue"
            ];
            $this->db->insert('paiement', $insertOperation);

            $rep['message'] = "Paiement effectué.";
            $rep['idpaiement'] = $this->db->insert_id();
            $rep['status'] = true;
            echo json_encode($rep);
            exit;
        } else {
            $rep['message'] = "Erreur de paiement...";
            echo json_encode($rep);
            exit;
        }

        // ////
        // $devise = $this->input->post("devise");
        // $matricule = $this->input->post("matricule");
        // $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');

        // $collection = $this->db->get_where('etudiant', ['matricule' => $matricule])->result_array()[0];

        // $this->db->select('*');
        // $this->db->from("etudiant");
        // $this->db->join('anneeAcademique', 'anneeAcademique.idanneeAcademique = etudiant.idanneeAcademique');
        // $this->db->where('etudiant.matricule', $matricule);
        // $query = $this->db->get()->result_array();

        // $idetudiant = $query[0]["idetudiant"];
        // $idanneeAcademique = $query[0]['idanneeAcademique'];

        // $montant = $this->input->post("montant");
        // $idfrais = $this->input->post("idfrais");

        // //Commission
        // $totMontant = $this->input->post("montantTot");
        // $commissionMontant = $this->input->post("commission");

        // $dateQr = date('m-d-y-H-i-s');
        // // QrCode generator
        // $scale = 4;
        // $size = 100;
        // $qr_image = 'qrcode-' . $dateQr . '.png';
        // $params['data'] = 'MbanguPay ' . $collection["matricule"] . ' ' . $collection["nom"] . '-' . $collection["prenom"] . " MONTANT : " . $montant . ' ' . $devise;
        // $params['level'] = $scale;
        // $params['size'] = $size;
        // $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
        // //print_r($params["savename"]);
        // $this->ciqrcode->generate($params);

        // $insertOperation = [
        //     "montant" => $montant,
        //     "idetudiant" => $idetudiant,
        //     "idfrais" => $idfrais,
        //     'idanneeAcademique' => $idanneeAcademique,
        //     'codeQr' => $qr_image,
        //     "operateur" => "assets/images/bangulogo.png",
        //     "commission" => $commissionMontant,
        //     "montantTotal" => $totMontant,
        //     "nomOperateur" => "mbangu",
        //     "iddevise" => $iddevise,
        //     "typeOperation" => "Paiement effectue"
        // ];

        // $query = $this->db->insert('paiement', $insertOperation);
        // $id = $this->db->insert_id();
        // if ($query) {
        //     echo json_encode($id);
        // } else {
        //     echo json_encode("false");
        // }
    }
    public function paiementFrais($fraisId, $ideleve, $devise, $montantInitial)
    {
        $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');
        $paiement = $this->db->query("select sum(montant) as montant from paiement_ecole where idfrais_ecole = $fraisId and ideleve = $ideleve and iddevise = $iddevise");

        return $paiement->row("montant");
    }
    public function verifyEleve($fraisId, $ideleve, $devise, $montantInitial)
    {

        $frais = $this->db->get_where("frais_ecole", ["idfrais_ecole" => $fraisId])->result_array();
        $montantFrais = $frais[0]["montant"];

        $paiement = $this->paiementFrais($fraisId, $ideleve, $devise, $montantInitial);
        //Appro

        if ($paiement > 0.0) {
            if ($paiement <= $montantFrais) {
                echo json_encode("tranche");
            }
        } else if ($paiement < $montantInitial && $paiement != 0.0) {
            echo json_encode("superieur");
        } else if ($paiement == 0.0 && $montantInitial) {
            echo json_encode("insert");
        } else if ($paiement == $montantFrais) {
            echo json_encode("complet");
        }
    }
}
