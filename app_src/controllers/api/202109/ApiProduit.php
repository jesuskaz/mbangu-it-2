<?php defined('BASEPATH') or exit('No direct script access allowed');
class ApiProduit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("Modele");
        // $this->Modele->checkToken();
    }

    public function ApiGetImage()
    {
        $this->load->model("ProduitModel");
        $data = $this->ProduitModel->getImage();

        echo json_encode($data);
    }
}
