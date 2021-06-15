<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ProfModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function check($username, $mdp)
    {
        $query = $this->db->get_where("professeur", ["username" => $username, "mdp" => $mdp])->result();
        return $query;
    }
    // public function getFaculte($ecole)
    // {
    //     $this->db->select('*');
    //     $this->db->from('faculte');
    //     $this->db->where('faculte.nomEcole', $ecole);
    //     $this->db->join('option', 'faculte.idFaculte = option.idFaculte');
    //     $this->db->join('promotion', 'option.idOption = promotion.idOption');
    //     $query = $this->db->get()->result_array();
    //     return $query;
    // }
    public function getFaculte($ecole)
    {
        $query = $this->db->get_where("faculte", ["nomEcole" => $ecole])->result_array();
        return $query;
    }
    public function option($idFaculte)
    {
        $query = $this->db->get_where("option", ["idFaculte" => $idFaculte]);

        $output = '<option selected> Choisissez Option</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->idOption . '">' . $row->intituleOption . '</option>';
        }
        return $output;
    }
    public function fetch_promotion($id_option)
    {
        $query = $this->db->get_where("promotion", ["idOption" => $id_option]);
        $output = '<option value=""> Selectionnez Promotion</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->idPromotion . '">' . $row->intitulePromotion . '</option>';
        }
        return $output;
    }
    public function insertData($data)
    {
        $query = $this->db->insert("syllabus", $data);
        return $query;
    }
    public function getPromotionName($promotion)
    {
        $query = $this->db->get_where("promotion", ["idPromotion" => $promotion])->row('intitulePromotion');
        return $query;
    }
    public function getOptionName($option)
    {
        $query = $this->db->get_where("option", ["idOption" => $option])->row('intituleOption');
        return $query;
    }
    public function getFacName($faculte)
    {
        $query = $this->db->get_where("faculte", ["idFaculte" => $faculte])->row('nomFaculte');
        return $query;
    }
    public function getLastElement($idProf)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->where('idProf', $idProf);
        $query = $this->db->get('syllabus')->result_array();
        return $query;
    }
    public function putUpdate($id, $data)
    {
        $this->db->where("id", $id);
        $query = $this->db->update("syllabus", $data);
        return $query;
    }
}
