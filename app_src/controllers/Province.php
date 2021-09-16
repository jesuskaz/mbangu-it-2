<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Province extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("Manager");
    }
    public function index()
    {
        $this->load->view('admin/province');
    }
    public function ville()
    {
        $data["provinces"] = $this->db->get("province")->result_array();

        $this->load->view("admin/ville", $data);
    }
    public function addVille()
    {
        $idProvince = $this->input->post('province');
        $ville = $this->input->post('ville');

        foreach ($ville as $v) {
            $v["idprovince"] = $idProvince;
            $data = $this->db->insert('ville', $v);
        }

        if ($data) {
            $data = array("message" => "Ville ajoutee avec success", 'classe' => 'success');
        } else {
            $data = array("message" => "erreur", 'classe' => 'danger');
        }
        $this->session->set_flashdata($data);
        redirect('province/ville');
    }

    public function addProvince()
    {
        $province = $this->input->post("province");

        foreach ($province as $p) {
            $data = $this->db->insert('province', $p);
        }
        if ($data) {
            $data = array("message" => "Province ajoutee avec succes", 'classe' => "success");
        } else {
            $data = array("message" => "erreur", 'classe' => "danger");
        }
        $this->session->set_flashdata($data);
        redirect('province');
    }
}
