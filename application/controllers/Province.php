<?php
class Province extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('AdminCredential/loginAdmin');
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
            $data = array("provinces" => $this->db->get("province")->result_array());
            $data = array("success" => "Ville ajoutee avec success");
            $this->load->view("admin/ville", $data);
        } else {
            $data = array("provinces" => $this->db->get("province")->result_array());
            $data = array("success" => "Erreur");
            $this->load->view("admin/ville", $data);
        }
    }

    public function addProvince()
    {
        $province = $this->input->post("province");

        foreach ($province as $p) {
            $data = $this->db->insert('province', $p);
        }
        if ($data) {
            $data = array("success" => "Province ajoutee avec succes");
            $this->load->view("admin/province", $data);
        } else {
            $data = array("error" => "Erreur");
            $this->load->view("admin/province", $data);
        }
    }
}
