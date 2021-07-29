<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

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
		$mat .= substr($nom[0], 0, 1) . substr($nom[1], 0, 1) . substr($nom[2], 0, 1);
		$i = '';
		if ($type == 'eleve') {

			$this->db->where('idecole', $this->session->ecole_session);
			$i = count($this->db->get('eleve')->result()) + 1;
		} else if ($type == 'etudiant') {

			$this->db->join('anneeAcademique', 'anneeAcademique.idanneeAcademique=etudiant.idanneeAcademique');
			$this->db->where('anneeAcademique.iduniversite', $this->session->universite_session);
			$i = count($this->db->get('etudiant')->result()) + 1;
		}
		if ($i <= 9) {
			$i = "00$i";
		} else if ($i >= 10 and $i <= 99) {
			$i = "0$i";
		}

		$mat .= "$i";
		return strtoupper($mat);
	}

	function code()
	{
		return uniqid();
	}

	function is_connected()
	{
		$adm = $this->session->isadmin;
		$adm_url = site_url('manager');
		$bank = $this->session->bank_session;
		$bank_url  = site_url('banquee');
		$ecole =  $this->session->ecole_session;
		$ecole_url = site_url('ecole');
		$univ =  $this->session->universite_session;
		$univ_url = site_url('index/home');
		if (!empty($adm)) {
			redirect($adm_url);
		} else if (!empty($bank)) {
			redirect($bank_url);
		} else if (!empty($ecole)) {
			redirect($ecole_url);
		} else if (!empty($univ)) {
			redirect($univ_url);
		}
	}

	function sms($to = '', $msg = '')
	{
		if (empty($to) or empty($msg)) {
			return false;
		}

		$account_sid = 'ACe53f2cb9eca5a7240beee2cf58a006a5';
		$auth_token = '422ed09d1f5db6a74fc26d41ba731e7e';
		$twilio_number = "+15082839672";

		$client = new Client($account_sid, $auth_token);
		$a = $client->messages->create(
			$to,
			array(
				'from' => 'MbanguPay',
				'body' => $msg
			)
		);
		// return TRUE;
		// var_dump($a);
	}
}
