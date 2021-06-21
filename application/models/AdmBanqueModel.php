<?php
class AdmBanqueModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function checkBanque($nom)
    {
        $data = $this->db->get_where("banque", ["denomination" => $nom])->result_array();
        return $data;
    }
    public function checkLogin($login)
    {
        $data = $this->db->get_where("banque", ["login" => $login])->result_array();
        return $data;
    }
    public function createBanque($data)
    {
        $data = $this->db->insert("banque", $data);
        return $data;
    }
    public function getAllBanque()
    {
        $data = $this->db->get("banque")->result_array();
        return $data;
    }
}
