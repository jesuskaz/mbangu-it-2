<?php
class FaculteModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getIdUniv($logEcole)
    {
        $data = $this->db->get_where("universite", ["login" => $logEcole])->row("idEcole");
        return $data;
    }
    public function getAllUniv($logEcole)
    {
        $data = $this->db->get_where("universite", ["login" => $logEcole])->result_array();
        return $data;
    }
    public function faculteCreate($data)
    {
        $data = $this->db->insert("faculte", $data);
        return $data;
    }
    public function getFaculte($idUniversite)
    {
        $query = $this->db->get_where("faculte", ["iduniversite" => $idUniversite])->result_array();
        return $query;
    }
    public function getPromotion($id)
    {
        $query = $this->db->get_where("promotion", ["iduniversite" => $id])->result_array();
        return $query;
    }
    public function checkData($idUniversite, $promotion)
    {
        $query = $this->db->get_where("promotion", ["intitulePromotion" => $promotion, "iduniversite" => $idUniversite])->row('idpromotion');
        return $query;
    }
    public function getNameFaculte($idFaculte)
    {
        $query = $this->db->get_where("faculte", ["idFaculte" => $idFaculte])->result_array();
        return $query;
    }
    public function getAllOption($denom)
    {
        $query = $this->db->get_where("option", ["ecole" => $denom])->result_array();
        return $query;
    }

    public function getOption($idOption)
    {
        $query = $this->db->get_where("option", ["idOption" => $idOption])->result_array();
        return $query;
    }
    public function faculteCheck($faculte)
    {
        $data = $this->db->get_where("faculte", ["nomFaculte" => $faculte])->result_array();
        return $data;
    }

    public function getData($idUniversite)
    {
        $data = $this->db->get_where("faculte", ["idUniversite" => $idUniversite])->result_array();
        return $data;
    }
    public function getUniv($idUniversite)
    {
        $query = $this->db->get_where("universite", ["idUniversite" => $idUniversite])->result_array();
        return $query;
    }
}
