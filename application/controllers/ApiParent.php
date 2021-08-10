<?php

use function Complex\rho;

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
            $iddevise = $this->db->get_where("devise", ["nomDevise" => $devise])->row("iddevise");

            if ($iddevise) 
            {
                $idOperateur = $this->db->get_where("operateur", ["nomOperateur" => $operateur])->row("idoperateur");

                if ($idOperateur) 
                {
                    $data = array(
                        "idoperateur" => $idOperateur,
                        "iddevise" => $iddevise,
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
            $solde = array(["solde" => round($this->solde($login, $devise), 2)]);
            echo json_encode($solde);
        }
        
        public function soldeCdf($login, $devise = "CDF")
        {
            $solde =  $solde = array(["solde" => round($this->solde($login, $devise), 2)]);
            echo json_encode($solde);
        }
        public function getEleve($login, $idarticle)
        {
            $idparent = $this->db->get_where("parent", ["login" => $login])->row("idparent");
            $this->db->select('*');
            $this->db->from('eleve');
            $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
            $this->db->join('parent', 'parent.idparent = parent_has_eleve.idparent');
            $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
            $this->db->join('article_ecole', 'article_ecole.idecole = ecole.idecole');
            $this->db->where('parent.login', $login);
            $this->db->where('article_ecole.idarticle', $idarticle);
            $data = $this->db->get()->result_array();

            // $data = $this->db->query("select * from eleve where ideleve in (select ideleve from parent_has_eleve where idparent = $idparent)")->result_array();
            echo json_encode($data);
        }
        public function getFrais($devise, $ideleve)
        {
            $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
            $this->db->select('*');
            $this->db->from('frais_ecole')  ;
            $this->db->join('annee_scolaire_ecole', 'frais_ecole.idannee_scolaire_ecole=annee_scolaire_ecole.idannee_scolaire_ecole');
            $this->db->join('classe', 'annee_scolaire_ecole.idannee_scolaire_ecole=classe.idannee_scolaire_ecole');
            $this->db->join("optionecole", "classe.idclasse = optionecole.idclasse");
            $this->db->join('eleve', 'optionecole.idoptionecole = eleve.idoptionecole');
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
            $paie = $this->db->get()->row('montant');

            // Calcul of paiement article

            $this->db->select("sum(prix) as montant");
            $this->db->from('parent');
            $this->db->join('parent_has_eleve', 'parent.idparent = parent_has_eleve.idparent');
            $this->db->join('eleve', 'parent_has_eleve.ideleve = eleve.ideleve');
            $this->db->join('achat_article_ecole', 'eleve.ideleve = achat_article_ecole.ideleve');
            $this->db->join('article_ecole', 'achat_article_ecole.idarticle = article_ecole.idarticle');
            $this->db->join('devise', 'article_ecole.iddevise = devise.iddevise');
            $this->db->where('nomDevise', $devise);
            $achat = $this->db->get()->row('montant');

            $paieSolde = $paie + $achat;

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
            $ideleve = $this->input->post("ideleve");
            $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
            
            $montant = $this->input->post("montant");
            $idfrais = $this->input->post("idfrais");
            $totMontant = $this->input->post("montantTot");
            $commissionMontant = $this->input->post("commission");

            $dateQr = date('m-d-y-H-i-s');
            $scale = 4;
            $size = 100;
            $qr_image = 'qrcode-' . $dateQr . '.png';
            $params['data'] = $ideleve;
            $params['level'] = $scale;
            $params['size'] = $size;
            $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
        
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
        public function getAllChild($login)
        {
            $idparent = $this->db->get_where('parent', ['login' => $login])->row("idparent");
            $data = $this->ApiParentModel->getAllChild($idparent);
            echo json_encode($data);
        }
        public function getAllTarif($ideleve)
        {
            $data = $this->ApiParentModel->getTarif($ideleve);
            echo json_encode($data);
        }
        public function getEleveData($ideleve)
        {
            $data = $this->ApiParentModel->getEleveData($ideleve);
            echo json_encode($data);
        }
        public function getAllTarifChild($login)
        {
            $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
            $data = $this->ApiParentModel->getAllTarifChild($idparent);
            echo json_encode($data);
        }
        public function getStatistic($ideleve)
        {
            $this->db->select('sum(paiement_ecole.montant) as montant, 
            frais_ecole.montant as montantTotal, paiement_ecole.idfrais_ecole, 
            devise.nomDevise, intitulefrais, compte');
            $this->db->from("paiement_ecole");
            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');           
            $this->db->join('devise', 'devise.iddevise = paiement_ecole.iddevise');
            $this->db->where('paiement_ecole.ideleve', $ideleve);
            $this->db->group_by('paiement_ecole.iddevise');
            $this->db->group_by('paiement_ecole.idfrais_ecole');
            $query = $this->db->get()->result_array();

            if ($query) 
            {
                $frais = array();
                foreach ($query as $key => $value) {
                    $idfrais = $value['idfrais_ecole'];

                    $this->db->select('idfrais_ecole, montant');
                    $this->db->from('frais_ecole');
                    $this->db->where('idfrais_ecole', $idfrais);
                    $data = $this->db->get()->result_array();

                    $frais[$key] = $data;
                }
                foreach ($query as $key => $value) {
                    foreach ($frais as $f => $v) {
                        if ($value["idfrais_ecole"] == $v[0]["idfrais_ecole"]) {
                            $tab[$value["idfrais_ecole"]] = $v[0]["montant"] - $value["montant"];
                        }
                    }
                }

                $d = $query;
                $i = 0;
                foreach ($tab as $ke => $va) {

                    foreach ($d as $k => $val) {
                        if ($ke == $val["idfrais_ecole"]) {
                            $query[$i]["montant"] = $va;
                        }
                    }
                    $i += 1;
                }
            }
            echo json_encode($query);
        }
        public function getAllStatistique($login)
        {
            $idparent = $this->db->get_where("parent", ["login" => $login])->row("idparent");
        
            $this->db->select('sum(paiement_ecole.montant) as montant, 
            frais_ecole.montant as montantTotal, paiement_ecole.idfrais_ecole, 
            devise.nomDevise, intitulefrais, compte, parent_has_eleve.ideleve');
            $this->db->from('paiement_ecole');
            $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
            $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
            $this->db->join('parent', 'parent.idparent = parent_has_eleve.idparent');
            $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');           
            $this->db->join('devise', 'devise.iddevise = paiement_ecole.iddevise');
            $this->db->where('parent.idparent', $idparent);
            $this->db->group_by('paiement_ecole.iddevise');
            $this->db->group_by('paiement_ecole.idfrais_ecole');
            $query = $this->db->get()->result_array();
            if ($query) 
            {
                $frais = array();
                foreach ($query as $key => $value) {
                    $idfrais = $value['idfrais_ecole'];

                    $this->db->select('idfrais_ecole, montant');
                    $this->db->from('frais_ecole');
                    $this->db->where('idfrais_ecole', $idfrais);
                    $data = $this->db->get()->result_array();

                    $frais[$key] = $data;
                }
                foreach ($query as $key => $value) {
                    foreach ($frais as $f => $v) {
                        if ($value["idfrais_ecole"] == $v[0]["idfrais_ecole"]) {
                            $tab[$value["idfrais_ecole"]] = $v[0]["montant"] - $value["montant"];
                        }
                    }
                }

                $d = $query;
                $i = 0;
                foreach ($tab as $ke => $va) {

                    foreach ($d as $k => $val) {
                        if ($ke == $val["idfrais_ecole"]) {
                            $query[$i]["montant"] = $va;
                        }
                    }
                    $i += 1;
                }
            }
            echo json_encode($query);
        }
        public function getInfoNav($login)
        {
            $query = $this->ApiParentModel->getInfoNav($login);
            echo json_encode($query);
        }
        public function getevery($login)
        {
            $this->db->select('ecole.idecole as id');
            $this->db->from('parent');
            $this->db->join('parent_has_eleve', 'parent.idparent = parent_has_eleve.idparent');
            $this->db->join('eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
            $this->db->join('ecole', 'ecole.idecole = eleve.idecole');
            $this->db->group_by('ecole.idecole');
            $this->db->where('parent.login', $login);
            $data = $this->db->get()->result_array();

            $r = array();
            if(count($data) > 0)
            {
                for($i = 0; $i < count($data); $i++)
                {
                    $id = $data[$i]["id"];
                    $this->db->select(" * ");
                    $this->db->from('annonce');
                    $this->db->where('id',$id);
                    $this->db->where('type','ecole');
                    $query = $this->db->limit(4)->get()->result_array();
                    array_push($r, $query);
                }     

            }
            return $r;
        }
        public function operatingAnnonce($login)
        {
            $banque = $this->db->get_where('annonce', ['type' => 'banque'])->result_array();
            $admin = $this->db->get_where('annonce', ['type' => 'admin'])->result_array();
            $merge1 = array_merge($banque, $admin);

            $data = $this->getevery($login);
            foreach($data as $d)
            {
                for($i = 0; $i < count($d); $i++)
                {
                    array_push($merge1, $d[$i]);
                }
            }
           echo json_encode($merge1);
        }
        public function paiementMagasin()
        {
            $login = $this->input->post("login");
            $montant = $this->input->post("montant");
            $devise = $this->input->post("devise");
            $ideleve = $this->input->post("ideleve");
            $idarticle = $this->input->post("idarticle");
            
            $data = [
                "idarticle" => $idarticle,
                "ideleve" =>$ideleve
            ];
            $solde = $this->solde($login, $devise);
            if($solde >= $montant)
            {
                $insertAchat = $this->db->insert('achat_article_ecole', $data);
                if($insertAchat)
                {
                    echo json_encode("true");
                }
                else
                {
                    echo json_encode("false");
                }
            }
            else
            {
                echo json_encode("false");
            }
        }
        public function getProductCarousel($login)
        {
            $this->db->select('*');
            $this->db->from('parent');
            $this->db->join('parent_has_eleve', 'parent.idparent = parent_has_eleve.idparent');
            $this->db->join('eleve', 'parent_has_eleve.ideleve = eleve.ideleve');
            $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
            $this->db->join('article_ecole', 'ecole.idecole = article_ecole.idecole');
            $this->db->where('parent.login', $login);
            $this->db->limit(3);
            $data = $this->db->get()->result_array();

            echo json_encode($data);
        }
        
        public function getProduct($login)
        {
            $this->db->select('*');
            $this->db->from('parent');
            $this->db->join('parent_has_eleve', 'parent.idparent = parent_has_eleve.idparent');
            $this->db->join('eleve', 'parent_has_eleve.ideleve = eleve.ideleve');
            $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
            $this->db->join('article_ecole', 'ecole.idecole = article_ecole.idecole');
            $this->db->join('devise', 'article_ecole.iddevise = devise.iddevise');
            $this->db->where('parent.login', $login);
            $data = $this->db->get()->result_array();
            
            echo json_encode($data);
        }
        public function getAnnonceSchool($login)
        {
            $idecole = $this->db->get_where('ecole')->row('idecole');
            $this->db->select('*');
            $this->db->from('annonce');
            $this->db->where('id', $idecole);
            $this->db->where('type', 'ecole');
            $this->db->limit(3);
            $annonceecole = $this->db->get()->result_array();
            echo json_encode($annonceecole);
        }
        public function getAdminAnnonce()
        {
             // Annonce Admin
            $this->db->select('*');
            $this->db->from('annonce');
            $this->db->where('type', 'admin');
            $this->db->limit(3);
            $adminannonce = $this->db->get()->result_array();
             echo json_encode($adminannonce);
        }
        public function getBanqueAnnonce()
        {
            // banque Annonce
            $this->db->get_where('annonce', ['type' => 'banque'])->result_array();
            $this->db->select('*');
            $this->db->from('annonce');
            $this->db->where('type', 'banque');
            $banqueannonce = $this->db->get()->result_array();
            echo json_encode($banqueannonce);
        }

        public function updateInfo()
        {
            $inputData = $this->input->post("data");
            $index = $this->input->post("index");
            $login = $this->input->post("matricule");

            if($index == '1')
            {
                $data = [
                    "email" => $inputData,
                ];

                $this->db->where("login", $login);
                $update = $this->db->update("parent", $data);

                if($update)
                {
                    echo json_encode("true");
                }
                else
                {
                    echo json_encode("false");
                }
            }
            else if($index == '2')
            {
                $data = [
                    "adresse" => $inputData,
                ];

                $this->db->where("login", $login);
                $update = $this->db->update("parent", $data);

                if($update)
                {
                    echo json_encode("true");
                }
                else
                {
                    echo json_encode("false");
                }
            }
            else if($index == '3')
            {
                $data = [
                    "tel" => $inputData,
                ];

                $this->db->where("login", $login);
                $update = $this->db->update("etudiant", $data);

                if($update)
                {
                    echo json_encode("true");
                }
                else
                {
                    echo json_encode("false");
                }
            }
        }
    }