<?php
class ApiEleve extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("ApiModel");
    }

    public function getFaculte()
    {
        $data = $this->ApiModel->getDataFaculte();
        echo json_encode($data);
    }

    public function getUniversite()
    {
        $data = $this->ApiModel->getDataUniversite();
        echo json_encode($data);
    }

    public function getCompte($idUniversite)
    {
        $univ = $this->ApiModel->getUnivByIDSchool($idUniversite);
        if ($univ) {
            echo json_encode($univ);
        }
    }

    public function option($idEcole)
    {
        $data = $this->ApiModel->getOption($idEcole);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode("false");
        }
    }

    public function promotion($idEcole)
    {
        $data = $this->ApiModel->getPromotion($idEcole);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode("false");
        }
    }
}
