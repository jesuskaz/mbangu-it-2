<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

class Modele extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->default_data();
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
		return (int) substr(rand(time(), time() * time()), 0, 4);
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

		$r = $this->select('twilio');
		if (!count($r)) {
			return false;
		}

		$r = $r[0]->setting;
		$r = json_decode($r);

		$account_sid = 'ACe53f2cb9eca5a7240beee2cf58a006a5';
		$auth_token = $r->auth_token;

		$client = new Client($account_sid, $auth_token);
		try {
			$a = $client->messages->create(
				$to,
				array(
					'from' => 'MbanguPay',
					'body' => $msg
				)
			);
			return true;
		} catch (\Throwable $th) {
			$m = $th->getMessage();
			return false;
		}
	}

	function default_data()
	{
		foreach (['admin'] as $el) {
			if (!count($this->select('admin', ['login' => $el]))) {
				$this->add('admin', ['login' => $el, 'password' => '0000', 'nomComplet' => 'Admin']);
			}
		}
		foreach (['CDF', 'USD'] as $el) {
			if (!count($this->select('devise', ['nomDevise' => $el]))) {
				$this->add('devise', ['nomDevise' => $el]);
			}
		}

		foreach (['RAWBANK', 'TMB', 'EQUITY', 'UBA'] as $el) {
			if (!count($this->select('banque', ['denomination' => $el]))) {
				$this->add('banque', ['denomination' => $el, 'login' => strtolower($el), 'password' => '1234']);
			}
		}

		foreach (['RAWBANK' => "assets/img/operateurs/rawbank.png", 'VISA' => "assets/img/operateurs/visa.png", 'MASTERCARD' => "assets/img/operateurs/mastercard.png", 'VODACOM' => "assets/img/operateurs/vodacom.png", 'AIRTEL' => "assets/img/operateurs/airtel.png", 'ORANGE' => "assets/img/operateurs/orange.png"] as $el => $va) {
			if (!count($this->select('operateur', ['nomOperateur' => $el]))) {
				$this->add('operateur', ['nomOperateur' => $el, 'image' => $va]);
			}
		}

		$tab = [
			'Haut Katanga' => ['Lubumbashi'],
			'Lualaba' => ['Kolwezi'],
			'Kinshasa' => ['Kinshasa']
		];

		$this->db->trans_start();
		foreach ($tab as $el => $v) {
			if (!count($this->select('province', ['nomProvince' => $el]))) {
				$this->add('province', ['nomProvince' => $el]);
				$id = $this->db->insert_id();
				foreach ($v as $e) {
					if (!count($this->select('ville', ['nomVille' => $e, 'idprovince' => $id]))) {
						$this->add('ville', ['nomVille' => $e, 'idprovince' => $id]);
					}
				}
			}
		}
		$this->db->trans_complete();
	}

	function makeToken($type = '', $id = '')
	{
		$id = (int) $id;
		if (!$id or empty($type) or !in_array($type, ['etudiant', 'parent'])) {
			return false;
		}

		if ($type == 'etudiant' and count($et = $this->select('etudiant', ['idetudiant' => $id]))) {
			if (count($e = $this->db->where(['id' => $id, 'source' => $type])->get('token')->result())) {
				$token =  $this->hashToken($et[0]->idetudiant, $et[0]->matricule, $type);
				$this->update('token', ['idtoken' => $e[0]->idtoken], ['token' => $token]);
			} else {
				$token =  $this->hashToken($et[0]->idetudiant, $et[0]->matricule, $type);
				$this->add('token', ['id' => $id, 'source' => $type, 'token' => $token]);
			}
			return $token;
		} else if ($type == 'parent' and count($et = $this->select('parent', ['idparent' => $id]))) {
			if (count($e = $this->db->where(['id' => $id, 'source' => $type])->get('token')->result())) {
				$token =  $this->hashToken($et[0]->idparent, $et[0]->login, $type);
				$this->update('token', ['idtoken' => $e[0]->idtoken], ['token' => $token]);
			} else {
				$token =  $this->hashToken($et[0]->idparent, $et[0]->login, $type);
				$this->add('token', ['id' => $id, 'source' => $type, 'token' => $token]);
			}
			return $token;
		} else {
			return false;
		}
	}

	function hashToken(int $id, string $matricule, $type)
	{
		$code = md5(781227);
		$_type = $this->encrypt_decrypt('encrypt', $type);
		$_id = $this->encrypt_decrypt('encrypt', $id * pi());

		$type = md5($type);
		$id = md5($id * 2048);
		$matricule = md5($matricule);

		$separator1 = md5(128);
		$separator2 = md5(256);
		$separator3 = md5(512);
		$separator4 = md5(1024);
		$_ = md5('_');
		$rand = sha1(time() *  rand(1, 1000));

		$token = "$rand$rand$matricule$separator1$type$_$_id$_$separator2$id$separator3$code$separator4$_$_type$_";
		return $token;
	}

	function valideToken($token)
	{
		$_ = md5('_');
		$tab = explode($_, $token);
		if (count($tab) != 5) {
			return false;
		}

		$_id = (int) ($this->encrypt_decrypt('decrypt', $tab[1]) / pi());
		$_type = $this->encrypt_decrypt('decrypt', $tab[3]);

		$this->db->join('token', 'token.id=etudiant.idetudiant');
		$this->db->where(['token' => $token, 'source' => $_type]);
		$r =  $this->select('etudiant', ['idetudiant' => $_id]);

		$this->db->join('token', 'token.id=parent.idparent');
		$this->db->where(['token' => $token, 'source' => $_type]);
		$r2 = $this->select('parent', ['idparent' => $_id]);
		if ($_type == 'etudiant' and count($r)) {
			return true; //$r;
		} else if ($_type == 'parent' and count($r2)) {
			return true; // $r2;
		} else {
			return false;
		}
	}

	function encrypt_decrypt($action, $string)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = '1001';
		$secret_iv = '2002';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'encrypt') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($action == 'decrypt') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	function checkToken()
	{
		$token = $this->input->request_headers()['token'] ?? '';
		if (empty($token)) {
			http_response_code(401);
			exit;
		}

		if (!$this->valideToken($token)) {
			http_response_code(401);
			exit;
		}
		// var_dump(($token));
	}
}
