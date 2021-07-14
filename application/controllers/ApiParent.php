<?php
    class ApiParent extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->model("ApiParentModel");
            $this->load->model("UserModel");
            
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

    }
