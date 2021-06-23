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
            $message = array("success" => "L'annee scolare ajoute avec succes");
            $this->load->view("universite/anneAcademique", $message);
        } else {
            $message = array("error" => "La sauvegarde a echouee");
            $this->load->view("universite/anneAcademique", $message);
        }
    }
    public function anneeAcademique()
    {
        if (!$this->session->universite_session) {
            redirect();
        }
        $this->load->view("universite/anneAcademique");
    }
    public function listeFaculte()
    {
        if (!$this->session->universite_session) {
            redirect();
        }
        $login = $this->session->userdata("universite_session");

        $data["facultes"] = $this->FaculteModel->getData($login);
        $this->load->view("universite/liste-faculte", $data);
    }


    public function options($idfaculte = null)
    {

        if (!$login = $this->session->universite_session) {
            redirect();
        }
        $idfaculte = (int) $idfaculte;

        if (!count($fac = $this->db->where(['idfaculte' => $idfaculte, 'iduniversite' => $login])->get('faculte')->result())) {
            redirect('faculte/listefaculte');
        }

        $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
        $this->db->group_by('promotion.idpromotion');
        $data["options"] = $this->db->where(['idfaculte' => $idfaculte])->get('options')->result();
        $data["faculte"] = $fac[0]->nomFaculte;

        $this->load->view("universite/liste-options", $data);
    }
    public function ajouterFaculte()
    {
        if (!$this->session->universite_session) {
            redirect();
        }
        $this->load->view("universite/ajouter-faculte");
    }
    public function promotion()
    {
        if (!$this->session->universite_session) {
            redirect();
        }
        $this->load->view("universite/promotion");
    }
    public function option()
    {
        if (!$this->session->universite_session) {
            redirect();
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
        $listeOption = $this->input->post("addmore");
        $idFaculte = $this->input->post("faculte");

        $now = date("Y-m-d H:i:s");

        //Getting Promotion data

        $promotionChooses = $this->input->post("promotionChose");
        $state = "error";

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
                        $data["success"] = "Options ajoutees avec succes";
                        $data["facultes"] = $faculte;
                        $data["promotions"] = $promotion;
                        $this->load->view("universite/ajouter-promotion", $data);
                    } else {
                        $data["error"] = "Vide";
                        $this->load->view("universite/ajouter-promotion", $data);
                    }
                } else {
                    $data["facultes"] = $faculte;
                    $data["error"] = "Erreur";
                    $this->load->view("universite/ajouter-promotion", $data);
                }
            }
        }
    }

    public function addOption()
    {
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
                $message["success"] = "La faculté a été créée avec succès";
                $this->load->view("universite/ajouter-faculte", $message);
            } else {
                $message["error"] = "La faculté n'a pas été créée, vérifiez vos données";
                $this->load->view("universite/ajouter-faculte", $message);
            }
        } else {
            $message["existe"] = "La faculté " . strtoupper($faculte) . " existe déjà";
            $this->load->view("universite/ajouter-faculte", $message);
        }
    }
}
