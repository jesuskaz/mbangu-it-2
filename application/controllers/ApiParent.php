<?php
    class ApiParent extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->model("ApiParentModel");
            $this->load->model("UserModel");
            $this->load->library("Ciqrcode");

        }
        public function signup()
        {
            $nom = $this->input->post("nom");
            $prenom = $this->input->post("prenom");
            $email = $this->input->post("email");
            $numero = $this->input->post("telephone");

            $login = $this->input->post("login");
            $pwd = $this->input->post("password");
            
            $piece = $this->db->get("pieceidentite")->row("idpiece");
              
            $data = [
                "nomcomplet" => $nom,
                "prenom" => $prenom,
                "adresse" => $numero,
                "login" => $login,
                "password" => $pwd,
                "idpiece" => $piece,
            ];

            $result = $this->ApiParentModel->create("parent", $data);

            if($result)
            {
                echo json_encode("true");
            }
            else
            {
                echo json_encode("false");
            }
        }
        public function getHeadData($login)
        {
            $constainst = [
                "login" => $login
            ];
            $query = $this->ApiParentModel->read("parent", $constainst);
            echo json_encode($query);
        }
        public function getSchool()
        {
            $query = $this->db->get('ecole')->result_array();
            echo json_encode($query);
        }
        public function parentHasStudent($matricule, $password, $loginParent)
        {
            $eleveId = $this->db->get_where("eleve", ["matricule" => $matricule, "password" => $password])->row("ideleve");
            
            if($eleveId)
            {
                $parentId = $this->db->get_where("parent", ["login" => $loginParent])->row("idparent");
                $checking = $this->db->get_where("parent_has_eleve", ["idparent" => $parentId, "ideleve" => $eleveId])->result_array();
                
                if(count($checking))
                {
                    echo json_encode("exist");
                }
                else
                {
                    $data = [
                        "idparent" => $parentId,
                        "ideleve" => $eleveId
                    ];
                
                    $insert = $this->db->insert("parent_has_eleve", $data);
                    if($insert)
                    {
                        echo json_encode("true");
                    }
                    else
                    {
                        echo json_encode("false");
                    }
                }
            }
            else
            {
                echo json_encode("no exist");
            }
        }
        
        public function appro()
        {
            $login = $this->input->post("login");
            $devise = $this->input->post("devise");
            $operateur = $this->input->post("nomOperateur");
            $montant = $this->input->post("montant");
    
            $idparent = $this->db->get_where("parent", ["login" => $login])->row("idparent");
            $idDevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");
            if ($idDevise) {
                $idOperateur = $this->db->get_where("operateur", ["nomOperateur" => $operateur])->row("idoperateur");
                if ($idOperateur) {
                    $data = array(
                        "idoperateur" => $idOperateur,
                        "iddevise" => $idDevise,
                        "idparent" => $idparent,
                        "montant" => $montant,
                        // "typeOperation" => "Depot effectue",
                    );
                    $query = $this->db->insert('appro_parent', $data);
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
        public function soldeUsd($login, $devise = "USD")
        {
            $idDevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");
    
            $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
            $soldeAppro = $this->ApiParentModel->solde($idparent, $idDevise);
            $soldePaie = $this->ApiParentModel->soldePaie($idparent, $idDevise);
    
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
        
        public function soldeCdf($login, $devise = "CDF")
        {
            
            $idDevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");
    
            $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
            $soldeAppro = $this->ApiParentModel->solde($idparent, $idDevise);
            $soldePaie = $this->ApiParentModel->soldePaie($idparent, $idDevise);
            
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
        public function getEleve($login)
        {
            $idparent = $this->db->get_where("parent", ["login" => $login])->row("idparent");
            $data = $this->db->query("select * from eleve where ideleve in (select ideleve from parent_has_eleve where idparent = $idparent)")->result_array();
            echo json_encode($data);
        }
        public function getFrais($devise, $ideleve)
        {
            $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
            $this->db->select('*');
            $this->db->from('frais_ecole')  ;
            $this->db->join('annee_scolaire_ecole', 'frais_ecole.idannee_scolaire_ecole=annee_scolaire_ecole.idannee_scolaire_ecole');
            $this->db->join('classe', 'annee_scolaire_ecole.idannee_scolaire_ecole=classe.idannee_scolaire_ecole');
            $this->db->join("eleve", "classe.idclasse = eleve.idclasse");
            $this->db->where('ideleve', $ideleve);
            $this->db->where('frais_ecole.iddevise', $iddevise);
            
            $query = $this->db->get()->result_array();
            echo json_encode($query);
        }
        public function solde($login, $devise)
        {
            $this->db->select('sum(montant) as montant');
            $this->db->from('appro_parent');
            $this->db->join('parent', 'parent.idparent = appro_parent.idparent');
            $this->db->join('devise', 'devise.iddevise = appro_parent.iddevise');
            $this->db->where('devise.nomDevise', $devise);
            $this->db->where('parent.login', $login);
            $approSolde = $this->db->get()->row('montant');
        
            // Calcul Solde Paiement
    
            $this->db->select("sum(montantTot) as montant");
            $this->db->from("paiement_ecole");
            $this->db->join("devise", "devise.iddevise = paiement_ecole.iddevise");
            $this->db->join('eleve', 'eleve.ideleve = paiement_ecole.ideleve');
            $this->db->join('parent_has_eleve', 'parent_has_eleve.ideleve = eleve.ideleve');
            $this->db->join('parent', 'parent_has_eleve.idparent = parent.idparent');
            $this->db->where('parent.login', $login);
            $this->db->where('devise.nomDevise', $devise);
            $paieSolde = $this->db->get()->row('montant');

            if ($approSolde > 0.0 && $paieSolde > 0.0) 
            {
                $convertAppro = (double)$approSolde;
                $convertPaie = (double)$paieSolde;
    
                if ($convertAppro > $convertPaie) {
                    $soldeApproPaie = $convertAppro - $convertPaie;
                    return $soldeApproPaie;
                } else {
                    return 0;
                }
            }
            else if ($approSolde && $paieSolde == null) 
            {
                $soldeApproPaie = (double)$approSolde;
                return $soldeApproPaie;
            } 
            else if ($paieSolde) 
            {
                return 0;
            }
        }
        public function paiementFrais($fraisId, $ideleve, $devise, $montantInitial)
        {
            $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');
            $paiement = $this->db->query("select sum(montant) as montant from paiement_ecole where idfrais_ecole = $fraisId and ideleve = $ideleve and iddevise = $iddevise");
            
            return $paiement->row("montant");
        }
        public function verifyFrais($fraisId, $ideleve, $login, $devise, $montantInitial)
        {

            $iddevise = $this->db->get_where('devise', ['nomDevise' => $devise])->row('iddevise');
            // Frais 
            $frais = $this->db->get_where("frais_ecole", ["idfrais_ecole" => $fraisId])->result_array();
            $montantFrais = $frais[0]["montant"];

            $paiement = $this->paiementFrais($fraisId, $ideleve, $devise, $montantInitial);
            //Appro
            $approvisionnement = $this->db->query("
            select sum(montant) as montant from appro_parent where idparent in 
            (select idparent from parent where login='$login') and iddevise=$iddevise")->row("montant");

            $soldeParent = $this->solde($login, $devise);
            
            if ($soldeParent > $montantInitial) 
            {
                if ($approvisionnement > 0.0 && $paiement > 0.0) 
                {
                    if ($approvisionnement > $paiement) 
                    {
                        $soldeApproPaie = $approvisionnement - $paiement;
                    }
                }
                else if ($approvisionnement > 0.0 && $paiement <= 0.0)
                {
                    $soldeApproPaie = $approvisionnement;
                }
                if ($paiement > 0.0) 
                {
                    if ($paiement <= $montantFrais && $approvisionnement != 0.0) 
                    {
                        echo json_encode("tranche");
                    } 
                    else if ($approvisionnement <= 0.0 || $soldeParent < $montantInitial) 
                    {
                        echo json_encode('inferieur');
                    }
                } 
                else if ($paiement < $montantInitial && $paiement != 0.0) 
                {
                    echo json_encode("superieur");
                }
                else if ($paiement == 0.0 && $montantInitial < $soldeParent) 
                {
                    echo json_encode("insert");
                } 
                else if ($soldeParent < $montantInitial) 
                {
                    echo json_encode('inferieur');
                }
                else if ($paiement > $soldeParent || $soldeParent <= 0.0) 
                {
                    echo json_encode("inferieur");
                }
                else if ($paiement == $montantFrais) 
                {
                    echo json_encode("complet");
                }
            } 
            else 
            {
                echo json_encode("critique");
            }
        }
        public function getReste($idfrais, $ideleve, $devise)
        {
            $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
            $this->db->select("sum(montant) as montant");
            $this->db->from('paiement_ecole');
            $this->db->join('devise', 'devise.iddevise=paiement_ecole.iddevise');
            $this->db->where('devise.iddevise', $iddevise);
            $this->db->where('paiement_ecole.idfrais_ecole', $idfrais);
            $this->db->where('paiement_ecole.ideleve', $ideleve);
            $query = $this->db->get()->result_array();
            // Frais 
            $frais = $this->db->get_where("frais_ecole", ["idfrais_ecole" => $idfrais])->result_array();
            $montantFrais = $frais[0]["montant"];
            // $soldeMatDevise = $this->solde($login, $devise);

            if($query) 
            {
                $montantFraisPayer = $query[0]["montant"];

                if ($montantFrais > $montantFraisPayer)
                 {
                    $reste = $montantFrais - $montantFraisPayer;

                    foreach ($query[0] as $value => $key) 
                    {
                        if ($value == "montant") 
                        {
                            $query[0]["montant"] = (string)$reste;
                        }
                    }
                    echo json_encode($query);
                } 
                else 
                {
                    $query = [["montant" => (string)0, "nomDevise" => $devise]];
                    echo json_encode($query);
                }
            } 
            else 
            {
                $query = [["montant" => (string)$montantFrais, "nomDevise" => $devise]];
                echo json_encode($query);
            }
        }
        public function insertPayment()
        {
            $devise = $this->input->post("devise");
            $ideleve = 1; $this->input->post("ideleve");
            $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
            
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
            $params['data'] = $ideleve;
            $params['level'] = $scale;
            $params['size'] = $size;
            $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
            //print_r($params["savename"]);
            $this->ciqrcode->generate($params);

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
            if ($query) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
        public function paieOperation($login)
        {
            $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
    
            $data = $this->ApiParentModel->getPaieOperation($idparent);
            echo json_encode($data);
        }
        public function getAlldataAppro($login)
        {
            $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
            $data = $this->ApiParentModel->getAlldataAppro($idparent);
            echo json_encode($data);
        }
        public function getAllHistoriquePaiement($ideleve)
        {
            $data = $this->ApiParentModel->getAllHistoriquePaiement($ideleve);
            echo json_encode($data);
        }
        public function getAllTarif($ideleve)
        {
            $data = $this->ApiParentModel->getTarif($ideleve);
            echo json_encode($data);
        }
    }