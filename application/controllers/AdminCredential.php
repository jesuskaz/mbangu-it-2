<?php
class AdminCredential extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    //     $this->load->model("AdminCredentialModel");
    // }
    // public function loginAdmin()
    // {
    //     $this->load->view("first/mbangulog/admin1");
    // }
    // public function loadBanque()
    // {
    //     $this->load->view("index");
    // }
    // public function loginBanque()
    // {
    //     $this->load->view("first/mbangulog/admin");
    // }
    // public function ecole()
    // {
    //     $this->load->view('first/mbangulog/ecole');
    // }
    // public function adminConnexion()
    // {
    //     $login = $this->input->post("login");
    //     $password = $this->input->post("code");

    //     $sent = $this->AdminCredentialModel->connexionAdmin($login, $password);
    //     if (count($sent)) {
    //         $this->session->set_userdata(['isadmin' => true]);
    //         redirect("Manager");
    //     } else {
    //         $error["error"] = "Vos données ne sont pas correctes";
    //         $this->load->view("first/mbangulog/admin1", $error);
    //     }
    // }

    // public function index()
    // {
    //     $this->load->view('first/mbangulog/universite');
    //     // $this->load->view('first/footer.php');
    //     // $this->load->view("loginSchool");
    // }

    // public function schoolConnexion()
    // {
    //     $login = $this->input->post("login");
    //     $code = $this->input->post("code");

    //     $sent = $this->AdminCredentialModel->connexionSchool($login, $code);

    //     // var_dump($sent, $login, $code); die;

    //     if (count($sent)) {
    //         $this->session->set_userdata("login", $login);
    //         $this->session->set_userdata(['universite_session' =>  $sent[0]->iduniversite]);
    //         $r = @$this->db->where(['iduniversite' => $sent[0]->iduniversite, 'actif' => 1])->get('anneeAcademique')->result()[0];
    //         $this->session->set_userdata(['annee_academique' =>  $r->idanneeAcademique]);
    //         redirect("Index/login");
    //     } else {
    //         $error["error"] = "Vos données ne sont pas correctes";
    //         $this->load->view("first/mbangulog/universite", $error);
    //     }
    // }
    // public function bankConnexion()
    // {
    //     $login = $this->input->post("login");
    //     $code = $this->input->post("code");

    //     $sent = $this->AdminCredentialModel->connexionBank($login, $code);

    //     if (count($sent)) {
    //         // $this->session->set_userdata("loginBanque", $login);
    //         $this->session->set_userdata(['bank_session' =>  $sent[0]->idbanque]);
    //         redirect("banquee");
    //         // redirect("Manager/connectBanque");
    //     } else {
    //         $error["error"] = "Vos données ne sont pas correctes";
    //         $this->load->view("first/mbangulog/admin", $error);
    //     }
    // }
}
