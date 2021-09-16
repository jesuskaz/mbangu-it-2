<?php
class ProduitModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getImage()
    {
        $query = $this->db->get("film")->result_array();
        return $query;
    }
}
