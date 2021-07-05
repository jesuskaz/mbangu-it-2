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
    }
?>