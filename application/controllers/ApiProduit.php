<?php
    class ApiProduit extends CI_Controller
    {
        public function ApiGetImage()
        {
            $this->load->model("ProduitModel");
            $data = $this->ProduitModel->getImage();

            echo json_encode($data);
        }
    }
?>