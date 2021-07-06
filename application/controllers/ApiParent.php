<?php
    class ApiParent extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->model("ApiParentModel");
        }
        public function signup()
        {
            $nom = $this->input->post("nom");
            $prenom = $this->input->post("prenom");
            $email = $this->input->post("email");
            $numero = $this->input->post("telephone");

            $login = $this->input->post("login");
            $pwd = $this->input->post("password");

            $data = [
                "nomcomplet" => $nom,
                "prenom" => $prenom,
                "adresse" => $numero,
                "login" => $login,
                "password" => $pwd,
                "idpiece" => 1,
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
    }
?>