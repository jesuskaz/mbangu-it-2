<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('ProfModel');

        }
        public function check_connexion()
        {
            if(!$this->session->connected)
            {
                redirect('admin/login');
            }
        }

        public function index()
        {
            $this->load->view("prof/login");
        }

        public function postSyllabus()
        {
            $ecole = $this->session->ecole;
            $faculteData["facultes"] = $this->ProfModel->getFaculte($ecole);
            $this->load->view("prof/postSyllabus", $faculteData);
        }
        public function fetch_option()
        {

            if($this->input->post('faculte_id'))
            {
                $idFaculte = $this->input->post('faculte_id');
                echo $this->ProfModel->option($idFaculte);
            }
        }
        public function fetch_promotion()
        {
            if($this->input->post("option_id"))
            {
                echo $this->ProfModel->fetch_promotion($this->input->post("option_id"));
            }
        }
        public function add()
        {
            $idProf = $this->session->id;

            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size'] = 800000;
            $config['max_width'] = 2000;
            $config['max_height'] = 2000;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('fichier')) 
            {
                $error = array('error' => "Veuillez charger un bon fichier PDF ");
                $this->load->view('prof/postSyllabus', $error);

            } 
            else 
            {
                $lastId = $this->ProfModel->getLastElement($idProf)[0];
                if($lastId)
                {
                    $data = array('donnees' => $this->upload->data(), 'message' => 'Votre Syllabus a ete charge avec succes');
                    $path = [
                        "fichier" => 'upload/'.$data['donnees']['file_name']
                        ];
                    $idSyllabus = $lastId["id"];
                    $update = $this->ProfModel->putUpdate($idSyllabus, $path);
                    $this->load->view('prof/postSyllabus', $data);
                }
            } 
        }
        public function allData()
        {
            
            $nom = $this->session->nom;
            $id = $this->session->id;

            $titre = $this->input->post('titre');
            $prix = $this->input->post('prix');
            $promotion = $this->input->post('promotion_id');
            $option = $this->input->post('option_id');
            $faculte = $this->input->post('faculte_id');

            // Intitule Element
            $intPromotion = $this->ProfModel->getPromotionName($promotion);
            $intOption = $this->ProfModel->getOptionName($option);
            $intFaculte = $this->ProfModel->getFacName($faculte);
            
            $data = [
                "prix" => $prix,
                "titre" => $titre,
                "optionSyllabus" => $option,
                "promotionSyllabus" => $promotion,
                "faculteSyllabus" => $faculte, 
                "nomProf" => $nom,
                "idProf" => $id,
                'intituleoption' => $intOption,
                'intitulepromotion' => $intPromotion,
                'intitulefaculte' => $intFaculte
            ];
            echo $this->ProfModel->insertData($data);
        }
        public function login()
        {
            $username = $this->input->post("username");
            $mdp = $this->input->post("mdp");
            $check = $this->ProfModel->check($username, $mdp);
        
            if(count($check) > 0)
            {
                $session = [
                    'id' =>$check[0]->idProfesseur,
                    'connected' => true,
                    'nom' => $check[0]->username,
                    'ecole' => $check[0]->nomEcole,
                ];
                $this->session->set_userdata($session);
                redirect('prof/admin/loadView');
            }
            else
            {
                $error["error"] = "login ou mot de passe incorrect veuillez reesayer svp";
                $this->load->view('prof/login', $error);
            }
        }
        public function loadView()
        {
            $session = $this->session->userdata();
            $login = $this->session->nom;
            $ecole = $this->session->ecole;
            //$getData = $this->ProfModel->getFaculte($ecole);#
            $this->load->view("prof/index");
        }
    }
?>