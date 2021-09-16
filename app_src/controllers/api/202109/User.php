<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("UserModel");
        $this->load->model("ApiParentModel");
        $this->load->model("Modele");
        $this->Modele->checkToken();
    }
    
    public function signInUser()
    {
        $matricule = $this->input->post("matricule");
        $code = $this->input->post("code");

        if (!isset($matricule) or !isset($code)) {
            http_response_code(204);
            exit;
        }

        if (count($data = $this->db->where(['matricule' => $matricule, 'password' => $code])->get('etudiant')->result())) {
            $data = $data[0];
            $d['id'] = $data->idetudiant;
            $d['matricule'] = $data->matricule;
            $d['status'] = "etudiant";
            $d['token'] = $this->Modele->makeToken("etudiant", $data->idetudiant);
            $d = [$d];
            echo json_encode($d);
        } else if (count($data = $this->db->where(['login' => $matricule, 'password' => $code])->get('parent')->result())) {
            $data = $data[0];
            $d['id'] = $data->idparent;
            $d['login'] = $data->login;
            $d['status'] = "parent";
            $d['token'] = $this->Modele->makeToken("parent", $data->idparent);
            $d = [$d];
            echo json_encode($d);
        } else {
            echo json_encode("false");
        }
    }

    public function addUser()
    {
        $name = $this->input->post("nom");
        $firstname = $this->input->post("postnom");
        $lastname = $this->input->post("prenom");
        $matricule = $this->input->post("matricule");
        $idoption = $this->input->post("idoptions");
        $password = $this->input->post("password");
        $iduniversite = $this->input->post("iduniversite");
        $telephone = $this->input->post("telephone");

        $anneeAcademique = $this->db->get_where("anneeAcademique", ["iduniversite" => $iduniversite, 'actif' => 1])->row("idanneeAcademique");

        $checkData = $this->UserModel->getUserChecking($matricule);

        if ($checkData != array()) {
            echo json_encode("An Account already exits");
        } else {
            $data = array(
                "nom" => $name,
                "postnom" => $lastname,
                "prenom" => $firstname,
                "matricule" => $matricule,
                "idoptions" => $idoption,
                "password" => $password,
                "idville" => 1,
                "idanneeAcademique " => $anneeAcademique,
                "telephone" => $telephone
            );

            $insertion = $this->UserModel->insertUser($data);

            if ($insertion) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
    }
}
