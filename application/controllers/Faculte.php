<?php
class Faculte extends CI_Controller
{
    public $id;
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("FaculteModel");
        $this->load->database();

        $this->id = $this->session->universite_session;
    }
    public function addFaculte()
    {
        $this->load->view("ajouter-faculte");
    }

    public function addAnne()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $id = $this->session->universite_session;

        $to = $this->input->post("to");
        $from = $this->input->post("from");


        $annee = $to . " " . $from;
        $data = array(
            "iduniversite" => $id,
            "annee" => $annee
        );

        $query = $this->db->insert('anneeAcademique', $data);
        if ($query) {
            $message["message"] = "L'année ajoutée avec succès ";
            $message["classe"] = "success";
        } else {
            $message["message"] = "erreur ";
            $message["classe"] = "danger";
        }
        $this->session->set_flashdata($message);
        redirect('faculte/anneeacademique');
    }
    public function anneeAcademique()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $this->load->view("universite/anneAcademique");
    }
    public function listeFaculte()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $login = $this->session->userdata("universite_session");

        $data["facultes"] = $this->FaculteModel->getData($login);
        $this->load->view("universite/liste-faculte", $data);
    }


    public function options($idfaculte = null)
    {

        if (!$login = $this->session->universite_session) {
            redirect('index/login');
        }
        $idfaculte = (int) $idfaculte;

        if (!count($fac = $this->db->where(['idfaculte' => $idfaculte, 'iduniversite' => $login])->get('faculte')->result())) {
            redirect('faculte/listefaculte');
        }

        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $data["options"] = $this->db->where(['idfaculte' => $idfaculte])->get('options')->result();
        $data["faculte"] = $fac[0]->nomFaculte;

        $this->load->view("universite/liste-options", $data);
    }

    public function promotion()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $this->load->view("universite/promotion");
    }
    public function option()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $id = $this->session->userdata('universite_session');

        $faculte = $this->FaculteModel->getFaculte($id);
        $promotion = $this->FaculteModel->getPromotion($id);
        if ($faculte || $promotion) {
            $data["facultes"] = $faculte;
            $data["promotions"] = $promotion;
            $this->load->view("universite/ajouter-promotion", $data);
        } else {
            $data["error"] = "Vide";
            $this->load->view("universite/ajouter-promotion", $data);
        }
    }

    public function addPromo()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $listePromo = $this->input->post("addmore");
        $state = "error";

        if (!empty($listePromo)) {
            foreach ($listePromo as $key => $value) {
                $value["iduniversite"] = $this->id;
                $query = $this->db->insert("promotion", $value);

                if ($query) {
                    $state = "succes";
                } else {
                    $state = "echec";
                }
            }

            if ($state == "succes") {
                $faculte = $this->FaculteModel->getFaculte($this->id);
                if ($faculte) {
                    $data["success"] = "Promotions ajoutees avec succes";
                    $data["facultes"] = $faculte;
                    $this->load->view("universite/promotion", $data);
                } else {
                    $data["facultes"] = $faculte;
                    $data["error"] = "Erreur";
                    $this->load->view("universite/promotion", $data);
                }
            }
        }
    }

    public function addPromotion()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $listeOption = $this->input->post("addmore");
        $idFaculte = $this->input->post("faculte");

        //Getting Promotion data

        $promotionChooses = $this->input->post("promotionChose");
        $state = "error";

        if (!is_array($listeOption)) {
            $message["message"] = "Aucune option sélectionnée. ";
            $message["classe"] = "danger";
            $this->session->set_flashdata($message);
            redirect('faculte/option');
        }
        if (!is_array($promotionChooses)) {
            $message["message"] = "Aucune promotion sélectionnée. ";
            $message["classe"] = "danger";
            $this->session->set_flashdata($message);
            redirect('faculte/option');
        }

        $message = [];
        if (!empty($listeOption) && !empty($idFaculte)) {
            foreach ($listeOption as $key => $value) {
                foreach ($promotionChooses as $choose) {
                    $checkData = $this->FaculteModel->checkData($this->id, $choose);

                    if ($checkData) {

                        $value["idfaculte"] = $idFaculte;
                        $value["idpromotion"] = $checkData;

                        $query = $this->db->insert("options", $value);
                        if ($query) {
                            $state = "succes";
                        } else {
                            $state = "echec";
                        }
                    } else {
                        redirect("Faculte/option");
                    }
                }
            }
            if ($state == "succes") {
                $faculte = $this->FaculteModel->getFaculte($this->id);
                if ($faculte) {
                    $promotion = $this->FaculteModel->getPromotion($this->id);
                    if ($faculte || $promotion) {
                        $message["message"] = "Option ajoutée avec succès ";
                        $message["classe"] = "success";

                        // $data["success"] = "Options ajoutees avec succes";
                        // $data["facultes"] = $faculte;
                        // $data["promotions"] = $promotion;
                        // $this->load->view("universite/ajouter-promotion", $data);
                    } else {
                        // Options
                        // $data["error"] = "Vide";
                        // $this->load->view("universite/ajouter-promotion", $data);
                        $message["message"] = "champ vide ";
                        $message["classe"] = "danger";
                    }
                } else {
                    $message["message"] = "champ vide ";
                    $message["classe"] = "danger";

                    // $data["facultes"] = $faculte;
                    // $data["error"] = "Erreur";
                    // $this->load->view("universite/ajouter-promotion", $data);
                }
            }
        }

        $this->session->set_flashdata($message);
        redirect('faculte/option');
    }

    public function addOption()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $listePromotion = $this->input->post("addmore");
        $idOption = $this->input->post("option");
        $nomOption = $this->FaculteModel->getOption($idOption);

        //School
        $school = $nomOption[0]["ecole"];
        $option = $nomOption[0]["intituleOption"];
        $faculte = $nomOption[0]["intituleFaculte"];
        $idEcole = $nomOption[0]["idEcole"];

        if (!empty($listePromotion) && !empty($idOption) && $nomOption) {
            foreach ($listePromotion as $key => $value) {
                $value["nomEcole"] = $school;
                $value["intituleFaculte"] = $faculte;
                $value["option"] = $option;
                $value["idOption"] = $idOption;
                $value["idEcole"] = $idEcole;

                $data = $this->db->insert('promotion', $value);
                if ($data) {
                    $state = "succes";
                } else {
                    $state = "echec";
                }
            }
            if ($state == "succes") {
                $login = $this->session->userdata("login");
                $getEcoleData = $this->FaculteModel->getAllUniv($login);
                $denom = $getEcoleData[0]["denomination"];

                $selectOption = $this->FaculteModel->getAllOption($denom);
                if ($selectOption) {
                    $collection["success"] = "Promotion ajoutee avec succes";
                    $collection["options"] = $selectOption;
                    $this->load->view("universite/ajouter-promotion", $collection);
                } else {
                    $collection["error"] = "Erreur";
                    $collection["options"] = $selectOption;
                    $this->load->view("universite/ajouter-promotion");
                }
            }
        }
    }

    public function createFaculte()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $faculte = $this->input->post("faculte");
        $logEcole = $this->session->userdata("login");

        $checkFaculte = $this->FaculteModel->faculteCheck($faculte);

        if (!$checkFaculte) {
            $data = [
                "nomFaculte" => $faculte,
                "idUniversite" => $this->id,
            ];

            $insert = $this->FaculteModel->faculteCreate($data);
            if ($insert) {
                $message["message"] = "La faculté a été créée avec succès";
                $message["classe"] = "success";
            } else {
                $message["message"] = "La faculté n'a pas été créée, vérifiez vos données";
                $message["classe"] = "danger";
            }
        } else {
            $message["message"] = "La faculté " . strtoupper($faculte) . " existe déjà";
            $message["classe"] = "danger";
        }

        $this->session->set_flashdata($message);
        redirect('faculte/listefaculte');
    }

    function annonces()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $this->load->view('universite/annonces');
    }

    function annonce_e($idannonce = null)
    {
        $idannonce  = (int) $idannonce;
        if (!count($annonce = $this->db->where(['idannonce' => $idannonce, 'type' => 'universite', 'id' => $this->id])->get('annonce')->result())) {
            redirect('faculte/annonces');
        }
        $this->load->view('universite/annonce-e', ['annonce' => $annonce[0]]);
    }

    function magasin()
    {
        if (!$this->session->universite_session) {
            redirect('index/login');
        }
        $this->load->view('universite/magasin', ['devises' => $this->db->get('devise')->result()]);
    }

    function achat()
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect('index/login');
        }
        $this->db->select('devise.nomDevise devise, sum(prix) total');
        $this->db->join('article_universite', 'article_universite.idarticle=achat_article_universite.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $this->db->group_by('devise.iddevise');
        $this->db->where('article_universite.iduniversite', $iduniv);
        $data['solde'] = $this->db->get('achat_article_universite')->result();

        $this->db->select('article_universite.idarticle, devise.nomDevise devise, sum(prix) total, article_universite.prix, article_universite.description article');
        $this->db->join('article_universite', 'article_universite.idarticle=achat_article_universite.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $this->db->group_by('article_universite.idarticle');
        $this->db->order_by('achat_article_universite.idachat', 'desc');
        $this->db->where('article_universite.iduniversite', $iduniv);
        $data['achats'] = $this->db->get('achat_article_universite')->result();

        $this->load->view('universite/achat', $data);
    }

    function detail_achat($idarticle = null)
    {
        $idarticle = (int) $idarticle;
        if (!$iduniv = $this->session->universite_session) {
            redirect('index/login');
        }

        $this->db->where('article_universite.idarticle', $idarticle);
        $this->db->where('article_universite.iduniversite', $iduniv);
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $article = $this->db->get('article_universite')->result();
        if (!count($article)) {
            redirect('faculte/achat');
        }

        $this->db->select('etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.matricule, devise.nomDevise devise,
         article_universite.prix, article_universite.description article, achat_article_universite.date');
        $this->db->join('etudiant', 'etudiant.idetudiant=achat_article_universite.idetudiant');
        $this->db->join('article_universite', 'article_universite.idarticle=achat_article_universite.idarticle');
        $this->db->join('devise', 'devise.iddevise=article_universite.iddevise');
        $this->db->order_by('achat_article_universite.idachat', 'desc');
        $this->db->where('article_universite.idarticle', $idarticle);
        $this->db->where('article_universite.iduniversite', $iduniv);
        $data['achats']  = $ar = $this->db->get('achat_article_universite')->result();

        $data['article'] = $article[0];

        $tot = 0;
        foreach ($ar as $aaa) {
            $tot += $aaa->prix;
        }
        $data['total'] = $tot;

        $this->load->view('universite/detail-achat', $data);
    }

    public function faculte_d($idfaculte = null)
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect('index/login');
        }
        $idfaculte = (int) $idfaculte;

        $this->db->where(['faculte.idfaculte' => $idfaculte, 'iduniversite' => $iduniv]);
        if (!count($this->db->get('faculte')->result())) {
            $this->session->set_flashdata(['classe' => 'danger', 'message2' => 'Ereur.']);
            redirect('faculte/listefaculte');
        }

        $this->db->join('options', 'options.idoptions=etudiant.idoptions');
        $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
        $this->db->where(['faculte.idfaculte' => $idfaculte, 'iduniversite' => $iduniv]);
        if (count($this->db->get('etudiant')->result())) {
            $this->session->set_flashdata(['classe' => 'warning', 'message2' => 'Vous devez supprimer tous les étudiants dans cette faculté avant la suppression.']);
            redirect('faculte/listefaculte');
        }

        $this->db->trans_start();
        $this->db->delete('options', ['idfaculte' => $idfaculte]);
        $this->db->delete('faculte', ['idfaculte' => $idfaculte]);
        $this->db->trans_complete();
        $this->session->set_flashdata(['classe' => 'success', 'message2' => 'Faculté supprimée.']);
        redirect('faculte/listefaculte');
    }

    public function faculte_e($idfaculte = null)
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect('index/login');
        }

        $this->db->where(['faculte.idfaculte' => $idfaculte, 'iduniversite' => $iduniv]);
        if (!count($fac =  $this->db->get('faculte')->result())) {
            $this->session->set_flashdata(['classe' => 'danger', 'message2' => 'Ereur.']);
            redirect('faculte/listefaculte');
        }
        $this->load->view('universite/faculte-e', ['faculte' => $fac[0]]);
    }

    public function faculte_u()
    {
        if (!$iduniv = $this->session->universite_session) {
            redirect('index/login');
        }

        $id = $this->input->post('idfaculte');
        $faculte = $this->input->post('faculte');

        $this->db->where(['faculte.idfaculte' => $id, 'iduniversite' => $iduniv]);
        if (!count($this->db->get('faculte')->result())) {
            $this->session->set_flashdata(['classe' => 'danger', 'message2' => 'Ereur.']);
            redirect('faculte/listefaculte');
        }


        if (!empty($faculte)) {
            $this->db->update('faculte', ['nomFaculte' => $faculte], ['idfaculte' => $id]);
            $this->session->set_flashdata(['classe' => 'success', 'message2' => 'Faculté mise a jour.']);
        }
        redirect('faculte/listefaculte');
    }
}
