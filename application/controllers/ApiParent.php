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

        public function updateData()
        {
            $login = "bonjour";//$this->input->post("login");
            $index = 2; //$this->input->post("index");
            $data = "cool"; //$this->input->post("data");

            if($index == 1)
            {
                $collection = ["adresse" => $data];
                $query = $this->apiParentModel->updateData($collection, $login);

            }
            else if($index == 2)
            {
                $collection = ["telephone" => $data];
                $query = $this->apiParentModel->updateData($collection, $login);
            }
            else if($index == 3)
            {
                $collection = ["email" => $data];
                $query = $this->apiParentModel->updateData($collection, $login);
            }
        }
    }
?>