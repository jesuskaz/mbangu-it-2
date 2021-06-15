<?php
class AdmUniversiteModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function checkUniv($nom)
    {
        $query = $this->db->get_where("universite", ["nomUniversite" => $nom])->result_array();
        return $query;
    }
    public function addUniv($data)
    {
        $query = $this->db->insert("universite", $data);
        return $query;
    }
    public function getAllSchool()
    {
        $query = $this->db->get("universite")->result_array();
        return $query;
    }
    public function getAllFaculte()
    {
        $query = $this->db->get("faculte")->result_array();
        return $query;
    }
}
