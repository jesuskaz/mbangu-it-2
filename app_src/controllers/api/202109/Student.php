<?php defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("UserModel");
        $this->load->library('Ciqrcode');
        $this->load->model("Modele");
        // $this->Modele->checkToken();
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
    public function getOption($idpromotion, $ecole)
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
            "commission" => $commission,
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
                        "montant" => $solde,
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
                            "devise" => "USD",
                        ];

                        $commission = [
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
        $this->db->order_by('paiement.idpaiement', 'desc');
        $query = $this->db->get()->result_array();

        // if ($query) {
        //     $frais = array();
        //     foreach ($query as $key => $value) {
        //         $idfrais = $value['idfrais'];

        //         $this->db->select('idfrais, montant');
        //         $this->db->from('frais');
        //         $this->db->where('idfrais', $idfrais);
        //         $data = $this->db->get()->result_array();

        //         $frais[$key] = $data;
        //     }
        //     // print_r($frais[0]);
        //     // exit();
        //     foreach ($query as $key => $value) {
        //         foreach ($frais as $f => $v) {
        //             if ($value["idfrais"] == $v[0]["idfrais"]) {
        //                 $tab[$value["idfrais"]] = $v[0]["montant"] - $value["montant"];
        //             }
        //         }
        //     }

        //     $d = $query;

        //     $i = 0;
        //     foreach ($tab as $ke => $va) {

        //         foreach ($d as $k => $val) {
        //             if ($ke == $val["idfrais"]) {
        //                 $query[$i]["montant"] = $va;
        //             }
        //         }
        //         $i += 1;
        //     }
        // }
        echo json_encode($query);
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";

        // $query = $this->UserModel->getStatistic($matricule);
        // echo json_encode($query);
    }

    public function soldeCdf($matricule, $devise = "CDF")
    {
        $data = array(["solde" => $this->solde($matricule, $devise)]);
        echo json_encode($data);
    }

    public function soldeUsd($matricule, $devise = "USD")
    {
        $data = array(["solde" => $this->solde($matricule, $devise)]);
        echo json_encode($data);
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
                    //"typeOperation" => "Depot effectue",
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
                "state" => 'null',
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
            "message" => $message,
        ];

        //$checking = $this->UserModel->checkMatricule($matricule);

        $data = $this->UserModel->updateTemp($matricule, $data);
    }

    public function getFrais($devise, $matricule)
    {
        $this->db->select('*');
        $this->db->from('etudiant');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->join('options', 'options.idoptions = etudiant.idoptions');
        $this->db->join('faculte', 'faculte.idfaculte = options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite = faculte.iduniversite');

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

        $paiement = (float) $this->paiementFrais($idfrais, $collection['idetudiant'], $iddevise);

        $reste = $montantFrais - $paiement;
        if ($paiement == $montantFrais) {
            $rep['message'] = "Ce frais est déjà totalement payé.";
            echo json_encode($rep);
            exit;
        } else if ($montant > $reste) {
            $rep['message'] = "Le montant restant pour ce frais est de $reste $devise.";
            echo json_encode($rep);
            exit;
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
            $rep['status'] = true;
            echo json_encode($rep);
        } else {
            $rep['message'] = "Erreur de paiement...";
            echo json_encode($rep);
            exit;
        }

        // exit;

        // $devise = $this->input->post("devise");
        // $matricule = $this->input->post("matricule");
        // $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');

        // $this->db->select('*');
        // $this->db->from("etudiant");
        // $this->db->join('anneeAcademique', 'anneeAcademique.idanneeAcademique = etudiant.idanneeAcademique');
        // $this->db->where('etudiant.matricule', $matricule);
        // $query = $this->db->get()->result_array();

        // $idetudiant = $query[0]["idetudiant"];
        // $idanneeAcademique = $query[0]['idanneeAcademique'];

        // $montant = $this->input->post("montant");
        // $idfrais = $this->input->post("idfrais");
        // $frais = $this->db->where('idfrais', $idfrais)->get('frais')->result()[0]->designation;

        // //Commission
        // $totMontant = $this->input->post("montantTot");
        // $commissionMontant = $this->input->post("commission");

        // $dateQr = date('m-d-y-H-i-s');
        // // QrCode generator
        // $scale = 4;
        // $size = 100;
        // $qr_image = 'qrcode-' . $dateQr . '.png';
        // // $params['data'] = $matricule;
        // $params['level'] = $scale;
        // $params['size'] = $size;
        // $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
        // //print_r($params["savename"]);
        // $collection = $this->db->get_where('etudiant', ['idetudiant' => $idetudiant])->result_array()[0];
        // $params['data'] = 'MbanguPay | ' . $collection["matricule"] . ' | ' . $collection["nom"] . '-' . $collection["prenom"] . " | FRAIS $frais" . " | MONTANT PAYE : " . $montant . ' ' . $devise;

        // ///

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
        //     "typeOperation" => "Paiement effectue",
        // ];

        // $query = $this->db->insert('paiement', $insertOperation);
        // if ($query) {
        //     echo json_encode("true");
        // } else {
        //     echo json_encode("false");
        // }
    }

    public function paiementFrais($fraisId, $idetudiant, $devise)
    {
        $query = $this->db->query("select sum(montant) as montant from paiement where idfrais = $fraisId and idetudiant = $idetudiant and iddevise = $devise");
        return $query->row('montant');
    }

    // public function verifyFrais($montant, $fraisId, $matricule, $devise, $montantInitial)
    // {
    //     $this->db->select('*');
    //     $this->db->from('etudiant');
    //     $this->db->where('matricule', $matricule);
    //     $this->db->join('options', 'etudiant.idoptions = options.idoptions');
    //     $this->db->join('faculte', 'options.idfaculte = faculte.idfaculte');
    //     $this->db->join('universite', 'universite.iduniversite = faculte.iduniversite');
    //     $etudiant = $this->db->get()->result_array();

    //     $idetudiant = $etudiant[0]['idetudiant'];
    //     $iduniversite = $etudiant[0]['iduniversite'];

    //     $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');
    //     // Frais
    //     $frais = $this->db->get_where('frais', ['idfrais' => $fraisId, 'iddevise' => $iddevise, "iduniversite" => $iduniversite])->result_array();
    //     $montantFrais = $frais[0]["montant"];

    //     $paiement = $this->paiementFrais($montant, $fraisId, $matricule, $devise, $montantInitial);
    //     //Appro
    //     $approvisionnement = $this->UserModel->fraisApproSolde($idetudiant, $iddevise);

    //     //Calcul Solde Appro

    //     $this->db->select("sum(montant) as montant");
    //     $this->db->from("appro");
    //     $this->db->join("devise", "devise.iddevise = appro.iddevise");
    //     $this->db->where('devise.nomDevise', $devise);
    //     $approSolde = $this->db->get()->row('montant');

    //     // Calcul Solde Paiement

    //     $this->db->select("sum(montant) as montant");
    //     $this->db->from("paiement");
    //     $this->db->join("devise", "devise.iddevise = paiement.iddevise");
    //     $this->db->where('devise.nomDevise', $devise);
    //     $paieSolde = $this->db->get()->row('montant');

    //     $soldeEtudiant = $this->solde($matricule, $devise);

    //     if ($soldeEtudiant > $montantInitial) {
    //         if ($approSolde && $paieSolde) {
    //             if ($approSolde > $paieSolde) {
    //                 $soldeApproPaie = $approSolde - $paieSolde;
    //             }
    //         } else if ($approSolde) {
    //             $soldeApproPaie = $approSolde;
    //         }

    //         if ($paiement) {
    //             if ($paiement <= $montantFrais && $approvisionnement != null) {
    //                 echo json_encode("tranche");
    //             } else if ($approvisionnement == null || $soldeApproPaie < $montantInitial) {
    //                 echo json_encode('inferieur');
    //             }
    //         } else if ($paiement < $montantInitial && $paiement != null) {
    //             echo json_encode("superieur");
    //         } else if ($paiement == null && $montantInitial < $soldeApproPaie) {
    //             echo json_encode("insert");
    //         } else if ($soldeApproPaie < $montantInitial) {
    //             echo json_encode('inferieur');
    //         } else if ($paiement > $soldeApproPaie || $soldeApproPaie == null) {
    //             echo json_encode("inferieur");
    //         } else if ($paiement == $montantFrais) {
    //             echo json_encode("complet");
    //         }
    //     } else {
    //         echo json_encode("critique");
    //     }
    // }

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
        $paie = $this->db->get()->row('montant');

        $this->db->select("sum(prix) as montant");
        $this->db->from('etudiant');
        $this->db->join('options', 'options.idoptions = etudiant.idoptions');
        $this->db->join('promotion', 'options.idpromotion = promotion.idpromotion');
        $this->db->join('universite', 'universite.iduniversite = promotion.iduniversite');
        $this->db->join('article_universite', 'universite.iduniversite = article_universite.iduniversite');
        $this->db->join('achat_article_universite', 'article_universite.idarticle = achat_article_universite.idarticle');
        $this->db->join('devise', 'article_universite.iddevise = devise.iddevise');
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->where('nomDevise', $devise);
        $achat = $this->db->get()->row('montant');

        $paieSolde = $paie + $achat;

        if ($approSolde && $paieSolde) {
            $convertAppro = (int) $approSolde;
            $convertPaie = (int) $paieSolde;

            if ($convertAppro > $convertPaie) {
                $soldeApproPaie = $convertAppro - $convertPaie;
                return $soldeApproPaie;
            } else {
                return 0;
            }
        } else if ($approSolde) {
            $soldeApproPaie = (int) $approSolde;
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
        $this->db->join('options', 'options.idoptions = etudiant.idoptions');
        $this->db->join('faculte', 'faculte.idfaculte = options.idfaculte');
        $this->db->join('universite', 'faculte.iduniversite = universite.iduniversite');
        $iduniversite = $this->db->get()->row('iduniversite');

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
                        $query[0]["montant"] = (string) $reste;
                    }
                }
                echo json_encode($query);
            } else {
                $query = [["montant" => (string) 0, "nomDevise" => $devise]];
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
    public function getAlldataAppro($matricule, $limit = null)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $matricule])->row('idetudiant');
        $data = $this->UserModel->getAlldataAppro($idetudiant, $limit);
        echo json_encode($data);
    }

    public function paieOperation($login, $limit = null)
    {
        $idetudiant = $this->db->get_where('etudiant', ['matricule' => $login])->row('idetudiant');
        $data = $this->UserModel->getPaieOperation($idetudiant, $limit);
        echo json_encode($data);
    }

    public function achatMagasin($login = null, $limit = null)
    {
        if (is_null($login)) {
            echo json_encode([]);
            exit;
        }
        if (!count($p = $this->db->where('matricule', $login)->get('etudiant')->result())) {
            echo json_encode([]);
            exit;
        }
        $idetudiant = $p[0]->idetudiant;
        $this->db->select("nomDevise devise, titre, qte, article_universite.image, date, prix_total,
        achat_article_universite.idachat num");
        $this->db->where('etudiant.idetudiant', $idetudiant);
        $this->db->join('etudiant', 'etudiant.idetudiant=achat_article_universite.idetudiant');
        $this->db->join('article_universite', 'article_universite.idarticle=achat_article_universite.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $limit = (int) $limit;
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->group_by('idachat');
        $this->db->order_by('idachat', 'desc');

        $r = $this->db->get('achat_article_universite')->result();
        echo json_encode($r);
    }

    public function detailAchat()
    {
        $idachat = (int) $this->input->post('achat');
        $matricule = $this->input->post('matricule');
        if (!count($p = $this->db->where('matricule', $matricule)->get('etudiant')->result())) {
            echo json_encode([]);
            exit;
        }

        $this->db->select("nomDevise devise, titre, description, qte, article_universite.image, date, prix_total, prix,
       achat_article_universite.idachat num");
        $this->db->where('etudiant.matricule', $matricule);
        $this->db->where('achat_article_universite.idachat', $idachat);
        $this->db->join('etudiant', 'etudiant.idetudiant=achat_article_universite.idetudiant');
        $this->db->join('article_universite', 'article_universite.idarticle=achat_article_universite.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $this->db->group_by('idachat');
        $this->db->order_by('idachat', 'desc');

        $r = $this->db->get('achat_article_universite')->result();
        echo json_encode($r);
    }

    public function facturette()
    {
        $idetudiant = (int) $this->input->post('etudiant');
        $idpaiement = (int) $this->input->post('paiement');

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

    public function allData()
    {
        $data = $this->UserModel->getReverseData("12kk12");
    }

    public function getproduct($matricule = null)
    {
        if (is_null($matricule)) {
            echo json_encode(['status' => false, 'message' => "missing param"]);
            exit;
        }
        $this->db->join('options', 'options.idoptions=etudiant.idoptions');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
        $this->db->where('matricule', $matricule);
        $r = $this->db->get('etudiant')->result();

        if (!count($r)) {
            echo json_encode(['status' => false, 'message' => "$matricule is not valid"]);
            exit;
        }
        $univ = $r[0]->iduniversite;

        $this->db->select('idarticle, titre, description, image, prix, nomDevise');
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $this->db->where('iduniversite', $univ);
        $this->db->order_by('idarticle', 'desc');
        $data = $this->db->get('article_universite')->result();
        echo json_encode(['status' => (bool) count($data), 'data' => $data]);
    }

    public function paiementMagasin()
    {
        $login = $this->input->post("login");
        $montant = $this->input->post("montant");
        $devise = $this->input->post("devise");
        $matricule = $this->input->post("matricule");
        // $idetudiant = $this->input->post("idetudiant");
        $idarticle = $this->input->post("idarticle");
        $pt = $this->input->post("prix_total");
        $qte = $this->input->post("quantite");

        $idetudiant = $this->db->select('idetudiant')->where('matricule', $matricule)->get('etudiant')->result()[0]->idetudiant;

        $data = [
            "idarticle" => $idarticle,
            "idetudiant" => $idetudiant,
            "qte" => $qte,
            "prix_total" => $pt,
        ];
        $insertAchat = $this->db->insert('achat_article_universite', $data);
        if ($insertAchat) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
    }
}
