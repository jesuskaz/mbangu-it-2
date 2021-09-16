<?php
class AdminCredentialModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function connexionAdmin($login, $password)
    {
        return $this->db->where(["login" => $login, "password" => $password])->get("admin")->result();
    }
    public function connexionSchool($login, $code)
    {
        return $this->db->where(["login" => $login, "code" => $code])->get("universite")->result();
        // $query = $this->db->get_where("universite", ["login" => $login, "code" => $code])->row("idEcole");
        // return $query;
    }
    public function connexionBank($login, $password)
    {
        return $this->db->where(["login" => $login, "password" => $password])->get("banque")->result();

        // $query = $this->db->get_where("banque", ["login" => $login, "password" => $password])->row("idBanque");
        // return $query;
    }
}
