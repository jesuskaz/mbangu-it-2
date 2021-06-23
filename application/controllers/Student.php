<?php
date_default_timezone_set('Africa/Lubumbashi');
class Student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("UserModel");
        $this->load->library('Ciqrcode');
    }
    public function getStudent($matricule)
    {
        $id = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');

        $this->load->model("UserModel");
        $data = $this->UserModel->getStudent($id);

        echo json_encode($data);
    }
    public function other()
    {
        $data = $this->db->get('etudiant')->result_array();
        echo json_encode($data);
    }
    public function  getOption($idpromotion, $ecole)
    {
        $dataPromotion = $this->UserModel->getOption($idpromotion, $ecole);
        if ($dataPromotion) {
            echo json_encode($dataPromotion);
        } else {
            echo json_encode("false");
        }
    }
    public function getPromotion($idFaculte, $iduniversite)
    {
        $dataFaculte = $this->UserModel->getFacSelected($idFaculte, $iduniversite);
        if ($dataFaculte) {
            echo json_encode($dataFaculte);
        } else {
            echo "false";
        }
    }
    public function checkStateTemp($matricule)
    {
        $state = $this->UserModel->checkState($matricule);

        if ($state) {
            if ($state == "succes") {
                echo json_encode($state);
            } else if ($state == "echec") {
                echo json_encode($state);
            } else if ($state == 'null') {
                echo json_encode($state);
            }
        }
    }

    public function paymentSyllabus()
    {
        $matricule = $this->input->post("matricule");
        $montant = $this->input->post("montant");
        $now = date("Y-m-d H:i:s");
        $devise = $this->input->post("devise");
        $cours = $this->input->post("cours");

        $totMontant = $this->input->post("totMontant");
        $commission = $this->input->post("commission");

        $dateQr = date('m-d-y-H-i-s');
        $nomEtudiant = $this->UserModel->getNameStudent($matricule);
        $idUnivEtudiant = $this->UserModel->getIdUnivEtudiant($matricule);
        $nameUniversite = $this->UserModel->getNameUniversite($idUnivEtudiant);
        $postNom = $this->UserModel->getPostNomStudent($matricule);

        $facultesPromo = $this->UserModel->getFacPromo($matricule);

        $fac = $facultesPromo[0]["faculte"];
        $promo = $facultesPromo[0]["promotion"];
        $postNom = $facultesPromo[0]["postNom"];
        $prenom = $facultesPromo[0]["prenom"];

        $data = [
            "matricule" => $matricule,
            "montant" => $totMontant,
            "datePay" => $now,
            "nom" => $nomEtudiant,
            "syllabus" => $cours,
            "prenom" => $prenom,
            "universite" => $nameUniversite,
            "faculte" => $fac,
            "promotion " => $promo,
            "prenom" => $prenom,
            "commission" => $commission
        ];
        // QrCode generator

        $checkSolde = $this->UserModel->getCheckSolde($matricule);
        if ($checkSolde != null) {
            if (($checkSolde[0]["montant"] >= $montant) && ($checkSolde[0]["montant"] != 0 && $totMontant != 0)) {

                $data = $this->UserModel->paymentSyllabus($data);
                if ($data) {
                    $solde = $checkSolde[0]["montant"] - $totMontant;
                    $collection = [
                        "matricule" => $matricule,
                        "montant" => $solde
                    ];

                    $updateSolde = $this->UserModel->updateSolde($matricule, $collection);
                    if ($updateSolde) {
                        $scale = 4;
                        $size = 100;
                        $qr_image = 'qrcode-' . $dateQr . '.png';
                        $params['data'] = $matricule;
                        $params['level'] = $scale;
                        $params['size'] = $size;
                        $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
                        //print_r($params["savename"]);
                        $this->ciqrcode->generate($params);

                        $insertOperation = [
                            "typeOperation" => "Achat Syllabus",
                            "montant" => $totMontant,
                            "idEtudiant" => $matricule,
                            "dateOperation" => $now,
                            'nom' => $nomEtudiant,
                            'postnom' => $postNom,
                            "faculte" => $fac,
                            "promotion" => $promo,
                            'code' => $qr_image,
                            "operateur" => "assets/images/syllabus.webp",
                            "nomOperateur" => $cours,
                            "commission" => $commission,
                            "devise" => "USD"
                        ];

                        $commission  = [
                            "nom" => $nomEtudiant,
                            "matricule" => $matricule,
                            "nomUniversite" => $nameUniversite,
                            "montantCommission" => $commission,
                            "montantTot" => $totMontant,
                            "frais" => "syllabus",
                        ];

                        $operation = $this->UserModel->addOperation($insertOperation);

                        if ($operation) {
                            $commite = $this->UserModel->addCommission($commission);
                            echo json_encode("true");
                        }
                    }
                }
            } else {
                echo json_encode("false");
            }
        } else {
            echo json_encode("vide");
        }
    }

    public function getStatistic($matricule)
    {
        $this->db->select('sum(paiement.montant) as montant, frais.montant as montantTotal, paiement.idfrais, devise.nomDevise, designation, numeroCompte');
        $this->db->from('etudiant');
        $this->db->where('matricule', $matricule);
        $this->db->join('paiement', 'paiement.idetudiant=etudiant.idetudiant');
        $this->db->join('frais', 'frais.idfrais=paiement.idfrais');
        $this->db->join('devise', 'devise.iddevise = paiement.iddevise');
        $this->db->group_by('paiement.iddevise');
        $this->db->group_by('paiement.idfrais');
        $query = $this->db->get()->result_array();

        if ($query) {
            $frais = array();
            foreach ($query as $key => $value) {
                $idfrais = $value['idfrais'];

                $this->db->select('idfrais, montant');
                $this->db->from('frais');
                $this->db->where('idfrais', $idfrais);
                $data = $this->db->get()->result_array();

                $frais[$key] = $data;
            }
            // print_r($frais[0]);
            // exit();
            foreach ($query as $key => $value) {
                foreach ($frais as $f => $v) {
                    if ($value["idfrais"] == $v[0]["idfrais"]) {
                        $tab[$value["idfrais"]] = $v[0]["montant"] - $value["montant"];
                    }
                }
            }

            $d = $query;

            $i = 0;
            foreach ($tab as $ke => $va) {

                foreach ($d as $k => $val) {
                    if ($ke == $val["idfrais"]) {
                        $query[$i]["montant"] = $va;
                    }
                }
                $i += 1;
            }
        }
        echo json_encode($query);
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";

        // $query = $this->UserModel->getStatistic($matricule);
        // echo json_encode($query);
    }

    public function soldeCdf($matricule, $devise = "CDF")
    {
        $idDevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");

        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $soldeAppro = $this->UserModel->solde($idetudiant, $idDevise);

        $soldePaie = $this->UserModel->soldePaie($idetudiant, $idDevise);

        $solde = 0;

        if ($soldeAppro[0]["montant"] && $soldePaie[0]["montant"]) {
            $soldeApp = $soldeAppro[0]["montant"];
            $soldePai = $soldePaie[0]["montant"];

            if ($soldeApp > $soldePai) {
                $nombre = $soldeApp - $soldePai;
                $solde = array(["solde" => (round($nombre, 2))]);
                echo json_encode($solde);
            } else {
                $solde = array(["solde" => 0]);
                echo json_encode($solde);
            }
        } else if ($soldeAppro[0]["montant"] != null && $soldePaie[0]["montant"] == null) {
            $nombre = $soldeAppro[0]["montant"];
            $solde = array(["solde" => round($nombre, 2)]);
            echo json_encode($solde);
        } else {
            $solde = array(["solde" => 0]);
            echo json_encode($solde);
        }
    }

    public function soldeUsd($matricule, $devise = "USD")
    {
        $idDevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");

        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $soldeAppro = $this->UserModel->solde($idetudiant, $idDevise);
        $soldePaie = $this->UserModel->soldePaie($idetudiant, $idDevise);

        $solde = 0;

        if ($soldeAppro[0]["montant"] && $soldePaie[0]["montant"]) {
            $soldeApp = $soldeAppro[0]["montant"];
            $soldePai = $soldePaie[0]["montant"];
            if ($soldeApp > $soldePai) {
                $nombre = $soldeApp - $soldePai;
                $solde = array(["solde" => (round($nombre, 3))]);
                echo json_encode($solde);
            } else {
                $solde = array(["solde" => 0]);
                echo json_encode($solde);
            }
        } else if ($soldeAppro[0]["montant"] != null && $soldePaie[0]["montant"] == null) {
            $nombre = $soldeAppro[0]["montant"];
            $solde = array(["solde" => round($nombre, 2)]);
            echo json_encode($solde);
        } else {
            $solde = array(["solde" => 0]);
            echo json_encode($solde);
        }
    }
    public function appro()
    {
        $matricule = $this->input->post("matricule");
        $devise = $this->input->post("devise");
        $operateur = $this->input->post("nomOperateur");
        $montant = $this->input->post("montant");

        $idetudiant = $this->db->get_where("etudiant", ["matricule" => $matricule])->row("idetudiant");
        $idDevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");
        if ($idDevise) {
            $idOperateur = $this->db->get_where("operateur", ["nomOperateur" => $operateur])->row("idoperateur");
            if ($idOperateur) {
                $data = array(
                    "idoperateur" => $idOperateur,
                    "iddevise" => $idDevise,
                    "idetudiant" => $idetudiant,
                    "montant" => $montant,
                    // "typeOperation" => "Depot effectue",
                );
                $query = $this->db->insert('appro', $data);
                if ($query) {
                    echo json_encode("true");
                } else {
                    echo json_encode("false");
                }
            } else {
                echo json_encode("false");
            }
        } else {
            echo json_encode("false");
        }
    }

    public function temp()
    {
        $matricule = $this->input->post("matricule");
        $montant = $this->input->post("montant");
        $reseau = $this->input->post("reseau");
        $now = date("Y-m-d H:i:s");

        $data = [
            "matricule" => $matricule,
            "montant" => $montant,
            "reseau" => $reseau,
            "dateTemp" => $now,
        ];

        $checking = $this->UserModel->checkMatricule($matricule);
        if (!$checking) {
            $save = $this->UserModel->saveTempo($data);
            if ($save) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else {
            $collection = [
                "matricule" => $matricule,
                "montant" => $montant,
                "reseau" => $reseau,
                "dateTemp" => $now,
                "state" => 'null'
            ];

            $query = $this->UserModel->updateEntry($matricule, $collection);
            if ($query) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
    }

    public function tempo($matricule, $code, $message)
    {
        $data = [
            "matricule" => $matricule,
            "state" => $code,
            "message" => $message
        ];

        //$checking = $this->UserModel->checkMatricule($matricule);

        $data = $this->UserModel->updateTemp($matricule, $data);
    }

    public function getFrais($devise, $matricule)
    {
        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->join('promotion', 'promotion.idpromotion = etudiant.idpromotion');
        $this->db->join('universite', 'universite.iduniversite = promotion.iduniversite');

        $iduniversite = $this->db->get()->row('iduniversite');

        $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');

        $data = $this->UserModel->getFrais($iddevise, $iduniversite);
        echo json_encode($data);
    }
    public function getInfoNav($matricule)
    {
        $query = $this->UserModel->getInfoNav($matricule);
        echo json_encode($query);
    }
    public function insertPayment()
    {
        $devise = $this->input->post("devise");
        $matricule = $this->input->post("matricule");
        $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');

        $this->db->select('*');
        $this->db->from("etudiant");
        $this->db->join('anneeAcademique', 'anneeAcademique.idanneeAcademique = etudiant.idanneeAcademique');
        $this->db->where('etudiant.matricule', $matricule);
        $query = $this->db->get()->result_array();

        $idetudiant = $query[0]["idetudiant"];
        $idanneeAcademique = $query[0]['idanneeAcademique'];

        $montant = $this->input->post("montant");
        $idfrais = $this->input->post("idfrais");

        //Commission
        $totMontant = $this->input->post("montantTot");
        $commissionMontant = $this->input->post("commission");

        $dateQr = date('m-d-y-H-i-s');
        // QrCode generator
        $scale = 4;
        $size = 100;
        $qr_image = 'qrcode-' . $dateQr . '.png';
        $params['data'] = $matricule;
        $params['level'] = $scale;
        $params['size'] = $size;
        $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
        //print_r($params["savename"]);
        $this->ciqrcode->generate($params);

        $insertOperation = [
            "montant" => $montant,
            "idetudiant" => $idetudiant,
            "idfrais" => $idfrais,
            'idanneeAcademique' => $idanneeAcademique,
            'codeQr' => $qr_image,
            "operateur" => "assets/images/bangulogo.png",
            "commission" => $commissionMontant,
            "montantTotal" => $totMontant,
            "nomOperateur" => "mbangu",
            "iddevise" => $iddevise,
            "typeOperation" => "Paiement effectue"
        ];

        $query = $this->db->insert('paiement', $insertOperation);
        if ($query) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
    }
    public function paiementFrais($montant, $fraisId, $matricule, $devise, $montantInitial)
    {
        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->where('matricule', $matricule);
        $this->db->join('promotion', 'promotion.idpromotion = etudiant.idpromotion');
        $this->db->join('universite', 'universite.iduniversite = promotion.iduniversite');
        $etudiant = $this->db->get()->result_array();

        $idetudiant = $etudiant[0]['idetudiant'];

        $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');

        $paiement = $this->UserModel->fraisPaiSolde($fraisId, $idetudiant, $iddevise);

        return $paiement;
    }

    public function verifyFrais($montant, $fraisId, $matricule, $devise, $montantInitial)
    {
        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->where('matricule', $matricule);
        $this->db->join('promotion', 'promotion.idpromotion = etudiant.idpromotion');
        $this->db->join('universite', 'universite.iduniversite = promotion.iduniversite');
        $etudiant = $this->db->get()->result_array();

        $idetudiant = $etudiant[0]['idetudiant'];
        $iduniversite = $etudiant[0]['iduniversite'];

        $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');
        // Frais 
        $frais = $this->db->get_where('frais', ['idfrais' => $fraisId, 'iddevise' => $iddevise, "iduniversite" => $iduniversite])->result_array();
        $montantFrais = $frais[0]["montant"];

        $paiement = $this->paiementFrais($montant, $fraisId, $matricule, $devise, $montantInitial);
        //Appro
        $approvisionnement = $this->UserModel->fraisApproSolde($idetudiant, $iddevise);

        //Calcul Solde Appro

        $this->db->select("sum(montant) as montant");
        $this->db->from("appro");
        $this->db->join("devise", "devise.iddevise = appro.iddevise");
        $this->db->where('devise.nomDevise', $devise);
        $approSolde = $this->db->get()->row('montant');

        // Calcul Solde Paiement

        $this->db->select("sum(montant) as montant");
        $this->db->from("paiement");
        $this->db->join("devise", "devise.iddevise = paiement.iddevise");
        $this->db->where('devise.nomDevise', $devise);
        $paieSolde = $this->db->get()->row('montant');

        $soldeEtudiant = $this->solde($matricule, $devise);

        if ($soldeEtudiant > $montantInitial) {
            if ($approSolde && $paieSolde) {
                if ($approSolde > $paieSolde) {
                    $soldeApproPaie = $approSolde - $paieSolde;
                }
            } else if ($approSolde) {
                $soldeApproPaie = $approSolde;
            }

            if ($paiement) {
                if ($paiement <= $montantFrais && $approvisionnement != null) {
                    echo json_encode("tranche");
                } else if ($approvisionnement == null || $soldeApproPaie < $montantInitial) {
                    echo json_encode('inferieur');
                }
            } else if ($paiement < $montantInitial && $paiement != null) {
                echo json_encode("superieur");
            } else if ($paiement == null && $montantInitial < $soldeApproPaie) {
                echo json_encode("insert");
            } else if ($soldeApproPaie < $montantInitial) {
                echo json_encode('inferieur');
            } else if ($paiement > $soldeApproPaie || $soldeApproPaie == null) {
                echo json_encode("inferieur");
            } else if ($paiement == $montantFrais) {
                echo json_encode("complet");
            }
        } else {
            echo json_encode("critique");
        }
    }

    public function solde($matricule, $devise)
    {
        $this->db->select("sum(montant) as montant");
        $this->db->from("appro");
        $this->db->join('etudiant', 'etudiant.idetudiant = appro.idetudiant');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->join("devise", "devise.iddevise = appro.iddevise");
        $this->db->where('devise.nomDevise', $devise);
        $approSolde = $this->db->get()->row('montant');

        // Calcul Solde Paiement

        $this->db->select("sum(montant) as montant");
        $this->db->from("paiement");
        $this->db->join("devise", "devise.iddevise = paiement.iddevise");
        $this->db->join('etudiant', 'etudiant.idetudiant = paiement.idetudiant');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->where('devise.nomDevise', $devise);
        $paieSolde = $this->db->get()->row('montant');


        if ($approSolde && $paieSolde) {
            $convertAppro = (int)$approSolde;
            $convertPaie = (int)$paieSolde;

            if ($convertAppro > $convertPaie) {
                $soldeApproPaie = $convertAppro - $convertPaie;
                return $soldeApproPaie;
            } else {
                return 0;
            }
        } else if ($approSolde) {
            $soldeApproPaie = (int)$approSolde;
            return $soldeApproPaie;
        } else if ($paieSolde) {
            return 0;
        }
    }
    public function getReste($idfrais, $matricule, $devise)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');

        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->join('promotion', 'promotion.idpromotion = etudiant.idpromotion');
        $this->db->join('universite', 'universite.iduniversite = promotion.iduniversite');
        $iduniversite  = $this->db->get()->row('iduniversite');

        $query = $this->UserModel->getReste($idfrais, $idetudiant, $iddevise);

        // Frais 
        $frais = $this->db->get_where('frais', ['idfrais' => $idfrais, 'iddevise' => $iddevise, "iduniversite" => $iduniversite])->result_array();
        $montantFrais = $frais[0]["montant"];

        $soldeMatDevise = $this->solde($matricule, $devise);

        if ($query) {
            $montantFraisPayer = $query[0]["montant"];

            if ($montantFrais > $montantFraisPayer) {
                $reste = $montantFrais - $montantFraisPayer;
                foreach ($query[0] as $value => $key) {
                    if ($value == "montant") {
                        $query[0]["montant"] = (string)$reste;
                    }
                }
                echo json_encode($query);
            } else {
                $query = [["montant" => (string)0, "nomDevise" => $devise]];
                echo json_encode($query);
            }
        } else {
            $query = $this->UserModel->getPrixFrais($idfrais, $iduniversite, $iddevise);
            if ($query) {
                echo json_encode($query);
            }
        }
    }

    public function student($id)
    {
        $data = $this->UserModel->getSomeStudent($id);
        echo json_encode($data);
    }

    public function lastPay()
    {
        $data = $this->UserModel->getLastPay();
        echo json_encode($data);
    }

    public function getAllStudent()
    {
        $data = $this->UserModel->getStudentAll();
        echo json_encode($data);
    }

    public function lastAppro()
    {
        $data = $this->UserModel->getAllAppro();
        echo json_encode($data);
    }

    public function getAllOperation($matricule)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');

        $data = $this->UserModel->getAlldata($idetudiant);

        echo json_encode($data);
    }
    public function getAlldataAppro($matricule)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $data = $this->UserModel->getAlldataAppro($idetudiant);
        echo json_encode($data);
    }
    public function getAllHistorique($matricule)
    {
        $data = $this->UserModel->getHistorique($matricule);
        echo json_encode($data);
    }
    public function getAllHistoriqueAppro($matricule)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $data = $this->UserModel->getAllHistoriquePaiement($idetudiant);
        echo json_encode($data);
    }
    public function getAllHistoriquePaiement($matricule)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $data = $this->UserModel->getAllHistoriquePaiement($idetudiant);
        echo json_encode($data);
    }
    public function getAllTarif($matricule)
    {

        $data = $this->UserModel->getTarif($matricule);
        echo json_encode($data);
    }
    public function apiSolde($matricule)
    {
        $data = $this->UserModel->getASolde($matricule);
        echo json_encode($data);
    }
    public function apiSoldeCdf($matricule)
    {
        $data = $this->UserModel->getASoldeCdf($matricule);
        echo json_encode($data);
    }
    public function allData()
    {
        $data = $this->UserModel->getReverseData("12kk12");
    }
}
