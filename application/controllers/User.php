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
    }
    public function index()
    {
        $this->load->view("a");
    }

    public function signInUser()
    {
        $matricule = "bonjour"; //$this->input->post("matricule");
        $code = "Bonjour"; //$this->input->post("code");

        $data = $this->UserModel->getPasswordChecking($matricule, $code);
       
        if (count($data) > 0) 
        {
            $resarr = array();
            array_push($resarr, array(
                "id" => $data[0]["idetudiant"],
                "matricule" => $data[0]["matricule"],
                "password" => $data[0]["password"],
                "status" => "etudiant"
            ));
            echo json_encode(array("result" => $resarr));
        } 
        else 
        {
            $constraint = [
                "login" => $matricule,
                "password" => $code
            ];

            $result = $this->ApiParentModel->read("parent", $constraint);

            if($result)
            {
                $arr = array();
                array_push(
                    $arr, array(
                        "id" => $result[0]["idparent"],
                        "login" => $result[0]["login"],
                        "status" => "parent"
                    )
                    );
                echo json_encode($arr);
            }
            else
            {
                echo json_encode("false");
            }
        }
    }

    public function addUser()
    {
        $name = $this->input->post("nom");
        $firstname = $this->input->post("postnom");
        $lastname = $this->input->post("prenom");
        $matricule = $this->input->post("matricule");
        $idpromotion = $this->input->post("idpromotion");
        $password = $this->input->post("password");
        $iduniversite = $this->input->post("iduniversite");
        $telephone = $this->input->post("telephone");

        $anneeAcademique = $this->db->get_where("anneeAcademique", ["iduniversite" => $iduniversite])->row("idanneeAcademique");

        $checkData = $this->UserModel->getUserChecking($matricule);

        if ($checkData != array()) {
            echo json_encode("An Account already exits");
        } else {
            $data = array(
                "nom" => $name,
                "postnom" => $lastname,
                "prenom" => $firstname,
                "matricule" => $matricule,
                "idpromotion" => $idpromotion,
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
