<?php defined('BASEPATH') OR exit('No direct script access allowed');
    class Etudiant extends CI_Controller
    {
        public function etudiant()
        {
            $this->load->view("etuidant");
        }

        public function listeEtudiant()
        {
            $this->load->view("admn-listeetudiant");
        }

        public function listePaiement()
        {
            $this->load->view("admn-listepay");
        }
        public function listeUniv()
        {
            $this->load->view("admn-listuniv");
        }
        public function listBanque()
        {
            $this->load->view("adm-voirbanque");
        }

    }
?>