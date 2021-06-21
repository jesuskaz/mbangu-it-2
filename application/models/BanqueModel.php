<?php
class BanqueModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getIdEcole($nomEcole)
    {
        $query = $this->db->get_where("universite", ["login" => $nomEcole])->row("idEcole");
        return $query;
    }
    public function getAllBanque($nomEcole)
    {
        $query = $this->db->get_where("frais", ["idUniv" => $nomEcole])->result_array();
        return $query;
    }

    public function getIdBanque($idUniv)
    {
        $query = $this->db->get_where("frais", ["idUniv" => $idUniv])->row("idBanque");
        return $query;
    }
    public function getIdBanques($idUniv)
    {
        $query = $this->db->get_where("frais", ["idUniv" => $idUniv])->result_array();
        return $query;
    }
    public function getABanque($idBanque)
    {
        $query = $this->db->get_where("banque", ["idBanque" => $idBanque])->row("denomination");
        return $query;
    }

    public function insertData($data)
    {
        $query = $this->db->insert("frais", $data);
        return $query;
    }
    public function getBanque()
    {
        $query = $this->db->get("banque")->result_array();
        return $query;
    }
    public function getStudent()
    {
        $query = $this->db->get("eleve")->result_array();
        return $query;
    }
    public function banqueName($login)
    {
        $query = $this->db->get_where("banque", ["login" => $login])->row("denomination");
        return $query;
    }
    public function getSchol($idBanque)
    {
        $this->db->distinct();
        $this->db->select("nomEcole");
        $this->db->where("idBanque", $idBanque);
        $query = $this->db->get("frais");
        return $query->result_array();
    }
    public function testJoin($denom)
    {
        // $this->db->distinct();
        $this->db->select("*");
        $this->db->from("eleve");
        $this->db->join("universite", "eleve.idEcole = universite.idEcole", "left outer ");
        $this->db->join("frais", "frais.idUniv = universite.idEcole");
        $this->db->where("nomBanque", $denom);
        $this->db->group_by('matricule');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDataGraphe()
    {
        $data = $this->db->query('select SUM(janvier) as janvier,SUM(fevrier) as fevrier, SUM(mars) as mars, SUM(avril) as avril, SUM(mais) as mais, SUM(juin) as juin, SUM(juillet) as juillet, SUM(aout) as aout, SUM(septembre) as septembre, SUM(octobre) as octobre, SUM(novembre) as novembre, SUM(decembre) as decembre from graphique');
        return $data->result_array();
    }
    public function listSchool($denom)
    {
        $this->db->select("*");
        $this->db->from("frais");
        $this->db->where("nomBanque", $denom);
        $this->db->group_by("idUniv");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getPaiement($denom)
    {
        $this->db->select("*");
        $this->db->from("paiement");
        $this->db->join("frais", "frais.idFrais=paiement.idFrais");
        $this->db->where("nomBanque", $denom);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDate($heureDebut, $heureFin)
    {
        $query = $this->db->query("SELECT * FROM paiement WHERE datePay BETWEEN '$heureDebut' AND '$heureFin'")->result_array();
        return $query;
    }
    public function getCountSchool()
    {
        $this->db->select("*");
        $this->db->from("frais");
        $this->db->join("universite", "universite.idEcole=frais.idUniv");
        $this->db->group_by("idUniv");
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getSchoolName($login)
    {
        $query = $this->db->get_where("universite", ["login" => $login])->result_array();
        return $query;
    }
    public function checkCompte($numero)
    {
        $query = $this->db->get_where("frais", ["numeroCompte" => $numero])->result_array();
        return $query;
    }

    public function getStudentSchool($login)
    {
        $query = $this->db->get_where("universite", ["login" => $login])->row("idEcole");
        return $query;
    }
    public function getBanques()
    {
        $query = $this->db->get("frais")->result_array();
        return $query;
    }
    public function getBanqueFrais($idEcole)
    {
        $query = $this->db->get_where("frais", ["iduniversite" => $idEcole])->result_array();
        return $query;
    }
    public function getAllStudent($idEcole)
    {
        $query = $this->db->get_where("eleve", ["idEcole" => $idEcole])->result_array();
        return $query;
    }
}
