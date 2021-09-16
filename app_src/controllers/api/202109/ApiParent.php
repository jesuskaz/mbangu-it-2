<?php defined('BASEPATH') or exit('No direct script access allowed');

class ApiParent extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("ApiParentModel");
        $this->load->model("UserModel");
        $this->load->library("Ciqrcode");
        $this->load->model("Modele");
        $this->Modele->checkToken();
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
            // "email" => $numero,
            "login" => $login,
            "password" => $pwd,
            "idpiece" => $piece,
        ];

        $result = $this->ApiParentModel->create("parent", $data);

        if ($result) {
            echo json_encode("true");
        } else {
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

        if ($eleveId) {
            $parentId = $this->db->get_where("parent", ["login" => $loginParent])->row("idparent");
            $checking = $this->db->get_where("parent_has_eleve", ["idparent" => $parentId, "ideleve" => $eleveId])->result_array();

            if (count($checking)) {
                echo json_encode("exist");
            } else {
                $data = [
                    "idparent" => $parentId,
                    "ideleve" => $eleveId
                ];

                $insert = $this->db->insert("parent_has_eleve", $data);
                if ($insert) {
                    echo json_encode("true");
                } else {
                    echo json_encode("false");
                }
            }
        } else {
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

        if ($iddevise) {
            $idOperateur = $this->db->get_where("operateur", ["nomOperateur" => $operateur])->row("idoperateur");

            if ($idOperateur) {
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
        $el = $this->db->where('ideleve', $ideleve)->get('eleve')->result();
        if (!count($el)) {
            echo json_encode([]);
            exit;
        }
        $el = $el[0];

        $iddevise = $this->db->get_where('devise', ["nomDevise" => $devise])->row('iddevise');
        $this->db->select('*');
        $this->db->from('frais_ecole');
        $this->db->join('annee_scolaire_ecole', 'frais_ecole.idannee_scolaire_ecole=annee_scolaire_ecole.idannee_scolaire_ecole');
        $this->db->join('classe', 'annee_scolaire_ecole.idannee_scolaire_ecole=classe.idannee_scolaire_ecole');

        if (!empty($el->idoptionecole)) {
            $this->db->join("optionecole", "classe.idclasse = optionecole.idclasse");
            $this->db->join('eleve', 'optionecole.idoptionecole = eleve.idoptionecole');
        } else {
            $this->db->join('section_has_classe', 'section_has_classe.idclasse = classe.idclasse');
            $this->db->join('eleve', 'eleve.idsection_has_classe=section_has_classe.idsection_has_classe');
        }

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

        if ($approSolde > 0.0 && $paieSolde > 0.0) {
            $convertAppro = (float)$approSolde;
            $convertPaie = (float)$paieSolde;

            if ($convertAppro > $convertPaie) {
                $soldeApproPaie = $convertAppro - $convertPaie;
                return $soldeApproPaie;
            } else {
                return 0;
            }
        } else if ($approSolde && $paieSolde == null) {
            $soldeApproPaie = (float)$approSolde;
            return $soldeApproPaie;
        } else if ($paieSolde) {
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

        if ($soldeParent > $montantInitial) {
            if ($approvisionnement > 0.0 && $paiement > 0.0) {
                if ($approvisionnement > $paiement) {
                    $soldeApproPaie = $approvisionnement - $paiement;
                }
            } else if ($approvisionnement > 0.0 && $paiement <= 0.0) {
                $soldeApproPaie = $approvisionnement;
            }
            if ($paiement > 0.0) {
                if ($paiement <= $montantFrais && $approvisionnement != 0.0) {
                    echo json_encode("tranche");
                } else if ($approvisionnement <= 0.0 || $soldeParent < $montantInitial) {
                    echo json_encode('inferieur');
                }
            } else if ($paiement < $montantInitial && $paiement != 0.0) {
                echo json_encode("superieur");
            } else if ($paiement == 0.0 && $montantInitial < $soldeParent) {
                echo json_encode("insert");
            } else if ($soldeParent < $montantInitial) {
                echo json_encode('inferieur');
            } else if ($paiement > $soldeParent || $soldeParent <= 0.0) {
                echo json_encode("inferieur");
            } else if ($paiement == $montantFrais) {
                echo json_encode("complet");
            }
        } else {
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

        $frais = $this->db->where('idfrais_ecole', $idfrais)->get('frais_ecole')->result()[0]->intitulefrais;


        $dateQr = date('m-d-y-H-i-s');
        $scale = 4;
        $size = 100;
        $qr_image = 'qrcode-' . $dateQr . '.png';
        // $params['data'] = $ideleve;
        $params['level'] = $scale;
        $params['size'] = $size;
        $params['savename'] = FCPATH . 'upload/qrcode/' . $qr_image;
        $collection = $this->db->get_where('eleve', ['ideleve' => $ideleve])->result_array()[0];
        $params['data'] = 'MbanguPay | ' . $collection["matricule"] . ' | ' . $collection["nom"] . '-' . $collection["prenom"] . " | FRAIS $frais" .  " | MONTANT : " . $montant . ' ' . $devise;

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
    public function paieOperation($login, $limit = null)
    {
        $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
        $data = $this->ApiParentModel->getPaieOperation($idparent, $limit);
        echo json_encode($data);
    }
    public function getAlldataAppro($login, $limit = null)
    {
        $idparent = $this->db->get_where('parent', ['login' => $login])->row('idparent');
        $data = $this->ApiParentModel->getAlldataAppro($idparent, $limit);
        echo json_encode($data);
    }

    function achatMagasin($login = null, $limit = null)
    {
        if (is_null($login)) {
            echo json_encode([]);
            exit;
        }
        if (!count($p = $this->db->where('login', $login)->get('parent')->result())) {
            echo json_encode([]);
            exit;
        }

        $idparent = $p[0]->idparent;
        $this->db->select("nomDevise devise, titre, qte, article_ecole.image, date, prix_total, 
        prenom eleve, achat_article_ecole.idachat num, eleve.ideleve");
        $this->db->where('parent_has_eleve.idparent', $idparent);
        $this->db->join('eleve', 'eleve.ideleve=achat_article_ecole.ideleve');
        $this->db->join('parent_has_eleve', 'parent_has_eleve.ideleve=eleve.ideleve');
        $this->db->join('article_ecole', 'article_ecole.idarticle=achat_article_ecole.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $limit = (int) $limit;
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->group_by('idachat');
        $this->db->order_by('idachat', 'desc');

        $r = $this->db->get('achat_article_ecole')->result();
        echo json_encode($r);
    }

    function detailAchat()
    {
        $ideleve = (int) $this->input->post('eleve');
        $idachat = (int) $this->input->post('achat');
        $matricule = $this->input->post('parent');

        $this->db->select("nomDevise devise, titre, description, qte, article_ecole.image, date, prix_total, prix,
        eleve.prenom eleve, achat_article_ecole.idachat num, eleve.ideleve");
        $this->db->where('parent.login', $matricule);
        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->where('achat_article_ecole.idachat', $idachat);
        $this->db->join('eleve', 'eleve.ideleve=achat_article_ecole.ideleve');
        $this->db->join('parent_has_eleve', 'parent_has_eleve.ideleve=eleve.ideleve');
        $this->db->join('parent', 'parent_has_eleve.idparent=parent.idparent');
        $this->db->join('article_ecole', 'article_ecole.idarticle=achat_article_ecole.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $this->db->group_by('idachat');
        $this->db->order_by('idachat', 'desc');

        $r = $this->db->get('achat_article_ecole')->result();
        echo json_encode($r);
    }

    function facturette()
    {
        $ideleve = (int) $this->input->post('eleve');
        $idpaiement = (int) $this->input->post('paiement');

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
        $query = $this->db->get('paiement_ecole')->result_array();

        echo json_encode($query);
    }


    public function getAllHistoriquePaiement($matricule_parent = null, $ideleve = null)
    {
        if (is_null($matricule_parent) or is_null($ideleve)) {
            echo json_encode([]);
            exit;
        }
        $this->db->join('parent_has_eleve', 'parent_has_eleve.idparent=parent.idparent');
        $this->db->join('eleve', 'eleve.ideleve=parent_has_eleve.ideleve');
        $this->db->where('parent.login', $matricule_parent);
        $this->db->where('eleve.ideleve', $ideleve);
        if (!count($p = $this->db->get('parent')->result())) {
            echo json_encode([]);
            exit;
        }

        $idparent = $p[0]->idparent;
        $this->db->select("nomDevise devise, titre, qte, article_ecole.image, date, prix_total, 
        prenom eleve, achat_article_ecole.idachat num, eleve.ideleve");
        $this->db->where('parent_has_eleve.idparent', $idparent);
        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->join('eleve', 'eleve.ideleve=achat_article_ecole.ideleve');
        $this->db->join('parent_has_eleve', 'parent_has_eleve.ideleve=eleve.ideleve');
        $this->db->join('article_ecole', 'article_ecole.idarticle=achat_article_ecole.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');
        $this->db->group_by('idachat');
        $this->db->order_by('idachat', 'desc');

        $query['achat'] = $this->db->get('achat_article_ecole')->result();

        $this->db->select("
            eleve.ideleve,
            frais_ecole.montant as fraisMontant,
            frais_ecole.idfrais_ecole idfrais,
            paiement_ecole.idpaiement_ecole as paiement,
            paiement_ecole.montant as montant, date, 
            paiement_ecole.typeOperation,
            paiement_ecole.commission,
            intitulefrais frais,
            nomDevise devise,
            paiement_ecole.ideleve 
            ");
        $this->db->from("paiement_ecole");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole = paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'frais_ecole.iddevise = devise.iddevise');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->where('eleve.ideleve', $ideleve);
        $this->db->order_by("paiement", "desc");
        $this->db->group_by('paiement');
        $query['paiement'] = $this->db->get()->result_array();

        // $data = $this->ApiParentModel->getAllHistoriquePaiement($ideleve);
        echo json_encode($query);
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
            devise.nomDevise, intitulefrais, compte, eleve.nom, eleve.prenom');
        $this->db->from("paiement_ecole");
        $this->db->join('eleve', 'eleve.ideleve=paiement_ecole.ideleve');
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'devise.iddevise = paiement_ecole.iddevise');
        $this->db->where('paiement_ecole.ideleve', $ideleve);
        $this->db->group_by('paiement_ecole.iddevise');
        $this->db->group_by('paiement_ecole.idfrais_ecole');
        $this->db->order_by('paiement_ecole.idpaiement_ecole', 'desc');
        $query = $this->db->get()->result_array();

        // if ($query) 
        // {
        //     $frais = array();
        //     foreach ($query as $key => $value) {
        //         $idfrais = $value['idfrais_ecole'];

        //         $this->db->select('idfrais_ecole, montant');
        //         $this->db->from('frais_ecole');
        //         $this->db->where('idfrais_ecole', $idfrais);
        //         $data = $this->db->get()->result_array();

        //         $frais[$key] = $data;
        //     }
        //     foreach ($query as $key => $value) {
        //         foreach ($frais as $f => $v) {
        //             if ($value["idfrais_ecole"] == $v[0]["idfrais_ecole"]) {
        //                 $tab[$value["idfrais_ecole"]] = $v[0]["montant"] - $value["montant"];
        //             }
        //         }
        //     }

        //     $d = $query;
        //     $i = 0;
        //     foreach ($tab as $ke => $va) {

        //         foreach ($d as $k => $val) {
        //             if ($ke == $val["idfrais_ecole"]) {
        //                 $query[$i]["montant"] = $va;
        //             }
        //         }
        //         $i += 1;
        //     }
        // }
        echo json_encode($query);
    }
    public function getAllStatistique($login)
    {
        $idparent = $this->db->get_where("parent", ["login" => $login])->row("idparent");

        $this->db->select('sum(paiement_ecole.montant) as montant, 
            frais_ecole.montant as montantTotal, paiement_ecole.idfrais_ecole, 
            devise.nomDevise, intitulefrais, compte, parent_has_eleve.ideleve, eleve.nom, eleve.prenom');
        $this->db->from('paiement_ecole');
        $this->db->join('eleve', 'paiement_ecole.ideleve = eleve.ideleve');
        $this->db->join('parent_has_eleve', 'eleve.ideleve = parent_has_eleve.ideleve');
        $this->db->join('parent', 'parent.idparent = parent_has_eleve.idparent');
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'devise.iddevise = paiement_ecole.iddevise');
        $this->db->where('parent.idparent', $idparent);
        $this->db->group_by('paiement_ecole.iddevise');
        $this->db->group_by('paiement_ecole.ideleve');
        $this->db->group_by('paiement_ecole.idfrais_ecole');
        $this->db->order_by('paiement_ecole.idpaiement_ecole', 'desc');
        $query = $this->db->get()->result_array();
        // var_dump($query); die;
        // if ($query) 
        // {
        //     $frais = array();
        //     foreach ($query as $key => $value) {
        //         $idfrais = $value['idfrais_ecole'];

        //         $this->db->select('idfrais_ecole, montant');
        //         $this->db->from('frais_ecole');
        //         $this->db->where('idfrais_ecole', $idfrais);
        //         $data = $this->db->get()->result_array();

        //         $frais[$key] = $data;
        //     }
        //     foreach ($query as $key => $value) {
        //         foreach ($frais as $f => $v) {
        //             if ($value["idfrais_ecole"] == $v[0]["idfrais_ecole"]) {
        //                 $tab[$value["idfrais_ecole"]] = $v[0]["montant"] - $value["montant"];
        //             }
        //         }
        //     }

        //     $d = $query;
        //     $i = 0;
        //     foreach ($tab as $ke => $va) {

        //         foreach ($d as $k => $val) {
        //             if ($ke == $val["idfrais_ecole"]) {
        //                 $query[$i]["montant"] = $va;
        //             }
        //         }
        //         $i += 1;
        //     }
        // }
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
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $id = $data[$i]["id"];
                $this->db->select(" * ");
                $this->db->from('annonce');
                $this->db->where('id', $id);
                $this->db->where('type', 'ecole');
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
        foreach ($data as $d) {
            for ($i = 0; $i < count($d); $i++) {
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
        $pt = $this->input->post("prix_total");
        $qte = $this->input->post("quantite");

        $data = [
            "idarticle" => $idarticle,
            "ideleve" => $ideleve,
            "qte" => $qte,
            "prix_total" => $pt,
        ];
        $solde = $this->solde($login, $devise);
        if ($solde >= $montant) {
            $insertAchat = $this->db->insert('achat_article_ecole', $data);
            if ($insertAchat) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else {
            echo json_encode("false");
        }
    }

    public function getProduct($login)
    {
        $this->db->select('idarticle, titre, description, image, prix, nomDevise');
        $this->db->from('parent');
        $this->db->join('parent_has_eleve', 'parent.idparent = parent_has_eleve.idparent');
        $this->db->join('eleve', 'parent_has_eleve.ideleve = eleve.ideleve');
        $this->db->join('ecole', 'eleve.idecole = ecole.idecole');
        $this->db->join('article_ecole', 'ecole.idecole = article_ecole.idecole');
        $this->db->join('devise', 'article_ecole.iddevise = devise.iddevise');
        $this->db->where('parent.login', $login);
        $this->db->group_by('idarticle');
        $this->db->order_by('idarticle', 'desc');
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

        if ($index == '1') {
            $data = [
                "email" => $inputData,
            ];

            $this->db->where("login", $login);
            $update = $this->db->update("parent", $data);

            if ($update) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else if ($index == '2') {
            $data = [
                "adresse" => $inputData,
            ];

            $this->db->where("login", $login);
            $update = $this->db->update("parent", $data);

            if ($update) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else if ($index == '3') {
            $data = [
                "tel" => $inputData,
            ];

            $this->db->where("login", $login);
            $update = $this->db->update("etudiant", $data);

            if ($update) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
    }

    function sendDataApi()
    {
        $montant = $this->input->post("montant");
        $devise = $this->input->post("devise");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://test.new.rawbankillico.com:4003/RAWAPIGateway/ecommerce/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "mobilenumber": "00243907763838",
                "trancurrency":"' . $devise . '",
                "amounttransaction": "' . $montant . '",
                "merchantid": "merch0000000000000203",
                "invoiceid":"123456715",
                "terminalid":"123456789012",
                "encryptkey": "NozZSGL660ZZM8u4kUTV4CfgSy3G7wpFDQ0vCOhLWLpmnkNLkGia6mn7J2j2f4CJ/RDKF0ICxN7mBD9ciURYWj97KT2LYBoaPJVJs3hv5s5SGYoOw4fcAigt7+0nQiza",
                "securityparams":{
                    "gpslatitude": "24.864190",
                    "gpslongitude": "67.090420"
                }
            }',

            CURLOPT_HTTPHEADER => array(
                'LogInName: 74dad6242e434de80c417a617e43371d42cf242a788961d0a508e076dab48e61',
                'Content-Type: application/json',
                'LoginPass: a8d5ef97340a1399f4c901669e9b6e8a30a4908f89e5b1e1c0da73f16413de26',
                'Authorization: Basic ZGVsdGE6MTIzNDU2'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $reference = json_decode($response, true);
        echo json_encode($reference);
    }

    public function getDataApi($refnumber, $otpmsg)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://test.new.rawbankillico.com:4003/RAWAPIGateway/ecommerce/payment/' . $otpmsg . '/' . $refnumber . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'LogInName: 74dad6242e434de80c417a617e43371d42cf242a788961d0a508e076dab48e61',
                'Content-Type: application/json',
                'LogInPass: a8d5ef97340a1399f4c901669e9b6e8a30a4908f89e5b1e1c0da73f16413de26',
                'Authorization: Basic ZGVsdGE6MTIzNDU2'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $gettingData = json_decode($response, true);
        echo json_encode($gettingData);
    }
}
