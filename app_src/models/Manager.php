<?php
    class Manager extends CI_Model
    {
        public function rapportPayement($idUversite)
        {
            $query = $this->db->get_where("universite", ["login" => $idUversite])->row("nomUniversite");
            return $query;
        }

        public function getAllRapport($clauses)
        {
            $this->db->select('*');
            $this->db->from('paiement');
            $this->db->where($clauses);
            $this->db->order_by('idpaiement', 'desc');
            $query = $this->db->get()->result_array();

            // $query = $this->db->get_where("paiement", ["universite" => $id])->result_array();
            return $query;
        }
        public function getPromotion($denomination)
        {
            $this->db->select('*');
            $this->db->from('promotion');
            $query = $this->db->get()->result_array();
            //$query = $this->db->get_where('promotion', ["ecole" => $denomination])->result_array();
            return $query;
        }
        public function getOption($iduniversite)
        {
            $this->db->select('*');
            $this->db->from('faculte');
            $this->db->where('faculte.iduniversite', $iduniversite);
            $this->db->join("options", "faculte.idfaculte = options.idfaculte");
            $this->db->group_by('intituleOptions');
            $query = $this->db->get()->result_array();
            return $query;
        }

        public function getFac($denomination)
        {
            $query = $this->db->get_where("faculte", ["nomFaculte" => $denomination])->result_array();
            return $query;
        }
        public function getStudent($denomination)
        {
            $query = $this->db->get_where("etudiant", ["nomEcole" => $denomination])->result_array();
            return $query;
        }
        public function getPaiement($denomination)
        {
            $query = $this->db->get_where("paiement", ["universite" => $denomination])->result_array();
            return $query;
        }
        // Banque Administration
        public function getAllEcole($banque)
        {
            $query = $this->db->get("frais", ["nomBanque" => $banque])->result_array();
            return $query();
        }
        
        public function getAllFaculte()
        {
            $query = $this->db->get("faculte")->result_array();
            return $query();
        }
        public function getDataGraphe($idEcole, $devise)
        {
            $data = $this->db->query("select SUM(janvier) as janvier,SUM(fevrier) as fevrier, SUM(mars) as mars, SUM(avril) as avril, SUM(mais) as mais, SUM(juin) as juin, SUM(juillet) as juillet, SUM(aout) as aout, SUM(septembre) as septembre, SUM(octobre) as octobre, SUM(novembre) as novembre, SUM(decembre) as decembre from graphique where idUniversite='$idEcole' and devise='$devise'");
            return $data->result_array(); 
        }

        public function getIdSchool($login)
        {
            $query = $this->db->get_where("universite", ["login" => $login]);
            return $query->row('idEcole');
        }
    }
?>