<?php
class ApiModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getDataFaculte()
    {
        $data = $this->db->get("faculte")->result_array();
        return $data;
    }
    public function getDataUniversite()
    {
        $data = $this->db->get("universite")->result_array();
        return $data;
    }

    public function getUnivByIDSchool($idUniversite)
    {
        $data = $this->db->get_where("faculte", ["iduniversite" => $idUniversite])->result_array();
        return $data;
    }
    public function getOption($idUniversite)
    {
        $data = $this->db->get_where("option", ["idEcole" => $idUniversite])->result_array();
        return $data;
    }
    public function getPromotion($idUniversite)
    {
        $data = $this->db->get_where("promotion", ["idEcole" => $idUniversite])->result_array();
        return $data;
    }
}
