<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modele extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
	}

	public function select($table, $clause = [], $ordre = null)
	{
		$this->db->order_by($ordre);
		$this->db->where($clause);
		return $this->db->get($table)->result();
	}

	public function add($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function delete($table, $clause)
	{
		$this->db->db_debug = false;
		$this->db->trans_start();
		$this->db->where($clause);
		$this->db->delete($table);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function update($table, $clause, $data)
	{
		$this->db->where($clause);
		$this->db->update($table, $data);
	}

	function matricule($type, $nom)
	{

		$mat = date('y');
		if ($type == 'eleve') {
			$mat .= substr($nom[0], 0, 1) . substr($nom[1], 0, 1) . substr($nom[2], 0, 1);

			$this->db->join('classe', 'classe.idclasse=eleve.idclasse');
			$this->db->join('optionecole', 'optionecole.idoptionecole=classe.idoptionecole');
			$this->db->join('section', 'section.idsection=optionecole.idsection');
			$this->db->where('section.idecole', $this->session->ecole_session);
			$this->db->where('classe.idannee_scolaire_ecole', $this->session->annee_scolaire);
			$i = count($this->db->get('eleve')->result()) + 1;

			if ($i <= 9) {
				$i = "00$i";
			} else if ($i >= 10 and $i <= 99) {
				$i = "0$i";
			}

			$mat .= "$i";
		}

		return strtoupper($mat);
	}
}
