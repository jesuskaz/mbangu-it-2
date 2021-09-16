<?php
class EtudiantModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getAllStudent()
    {
        $data = $this->db->get("eleve")->result_array();
        return $data;
    }
    public function gelAllPaie()
    {
        $data = $this->db->get("paiement")->result_array();
        return $data;
    }
}
