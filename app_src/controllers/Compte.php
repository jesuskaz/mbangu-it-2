<?php defined('BASEPATH') OR exit('No direct script access allowed');
    class Compte extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
            $this->load->model("CompteModel");
        }
        
        public function addCompte()
        {
            $this->load->view("ajouter-compte");
        }
        public function listeCompte()
        {
            $this->load->view("liste-compte");
        }
        public function getBanque()
        {
            $data["banques"] = $this->CompteModel->banqueGet();
            if($data)
            {
                $this->load->view("ajouter-compte", $data);
            }
            else
            {
                $data["vide"] = "Vous n'avez aucune banque pour le moment";
                $this->load->view("ajouter-compte", $data);
            }
        }
        public function compte()
        {
            $banque = $this->input->post("banque");
            $compte = $this->input->post("compte");
            $frais = $this->input->post("frais");
            //Getting School id
            $nomUniv = $this->session->userdata("nomEcole");
            $idEcole = $this->CompteModel->getIdEcole($nomUniv);

            // Getting Banque name
            $nomBanque = $this->CompteModel->getNameBanque($banque);

            if($idEcole)
            {
                $data = [
                    "designation" => $frais,
                    "numeroCompte" => $compte,
                    "idBanque" => $banque,
                    "idUniv" => $idEcole,
                    "nomEcole" => $nomUniv
                ];
                $insert = $this->CompteModel->compteAdd($data);
                if($insert)
                {
                    if($nomBanque)
                    {
                        //Data of banqueUniv
                        $collection = [
                            "idBanque" => $banque,
                            "idEcole" => $idEcole,
                            "nomBanque" => $nomBanque,
                            "nomEcole" => $nomUniv
                        ];
                        $insertBankUniv = $this->CompteModel->banckUnivAdd($collection);

                        if($insertBankUniv)
                        {
                            // Getting data for printing in addCOmppte ListeScroll
                            $data["banques"] = $this->CompteModel->banqueGet();
                            if($data)
                            {
                                $data["success"] = "Le compte et frais ont été ajouté avec succès à la Banque".strtoupper($nomBanque);
                                $this->load->view("ajouter-compte", $data);
                            }
                            else
                            {
                                $data["vide"] = "Vous n'avez aucune banque pour le moment";
                                $this->load->view("ajouter-compte", $data);
                            }
                        }   
                    }
                }
    
            }
        }
    }
?>