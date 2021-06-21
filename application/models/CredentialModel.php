<?php
class CredentialModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getAdmin($denomination, $code)
    {
        //$arra["login"] = 
        $query = $this->db->get_where('universite', ["denomination" => $denomination, "code" => $code])->row("idEcole");
        return $query;
    }
    public function getAdminEspace($login, $password)
    {
        //$arra["login"] = 
        $query = $this->db->get_where('admin', ["login" => $login, "password" => $password])->row("id");
        return $query;
    }
}
