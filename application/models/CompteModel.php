<?php
class CompteModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function bankGet()
    {
        $query = $this->db->get("banque")->result_array();
        return $query;
    }
    public function addCompte($data)
    {
        $query = $this->db->insert("frais", $data);
        return $query;
    }
    public function getIdEcole($nomUniv)
    {
        $query = $this->db->get_where("universite", ["denomination" => $nomUniv])->row("idEcole");
        return $query;
    }

    public function getNameBanque($idBanque)
    {
        $query = $this->db->get_where("banque", ["idBanque" => $idBanque])->row("denomination");
        return $query;
    }
    public function getAllCompte()
    {
        $query = $this->db->get("frais")->result_array();
        return $query;
    }
}
