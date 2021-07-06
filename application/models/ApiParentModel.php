<?php
    class ApiParentModel extends CI_Model
    {
        public function create($table, $data)
        {
            $query = $this->db->insert($table, $data);
            return $query;
        }
        public function read($table, $data)
        {
            $query = $this->db->get_where($table, $data)->result_array();
            return $query;
        }
        public function updateData($collection, $login)
        {
            $this->db->where("login", $login);
            $query = $this->db->update("parent", $collection);
            return $query;
        }
    }
?>