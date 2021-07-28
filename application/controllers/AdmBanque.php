<?php
class AdmBanque extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isadmin) {
            redirect('index/login');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("AdmBanqueModel");
    }
    public function loadBanque()
    {
        $this->db->order_by('idbanque', 'desc');
        $data["banques"] = $this->db->get('banque')->result();
        $this->load->view("admin/liste-banque", $data);
    }
    public function addBanque()
    {
        $this->load->view("admin/adm-creerbanque");
    }
    public function banqueCreate()
    {
        $banque = $this->input->post("banque");
        $login = $this->input->post("login");
        $password = $this->input->post("password");

        $data = [
            "denomination" => $banque,
            "login" => $login,
            "password" => $password
        ];

        $checkLogin = $this->AdmBanqueModel->checkLogin($login);
        $checkBanque = $this->AdmBanqueModel->checkBanque($banque);
        if ($checkLogin || $checkBanque) {
            if ($checkBanque) {
                $data["message"] = "La banque " . strtoupper($banque) . " existe déjà";
                $data["classe"] = "danger";
            } else if ($checkLogin) {
                $data["message"] = "Le nom d'utilisateur " . strtoupper($login) . " existe déjà";
                $data["classe"] = "danger";
            }
        } else {
            $insert = $this->AdmBanqueModel->createBanque($data);
            if ($insert) {
                $data["message"] = "La banque " . strtoupper($banque) . " a été créée avec succès";
                $data["classe"] = "success";
            } else {
                $data["message"] = "erreur";
                $data["classe"] = "danger";
            }
        }

        $this->session->set_flashdata($data);
        redirect('admbanque/addbanque');
    }

    function listeeleve()
    {
        $this->db->order_by('eleve.ideleve', 'desc');
        $this->db->select(
            "eleve.ideleve,
        eleve.nom, eleve.postnom, eleve.prenom, 
        eleve.matricule, section.intitulesection section, 
        classe.intituleclasse classe, eleve.adresse, 
        eleve.telephoneparent telephone, nomecole ecole"
        );
        $this->db->join('optionecole', 'eleve.idoptionecole=optionecole.idoptionecole');
        $this->db->join('classe', 'classe.idclasse=optionecole.idclasse');
        $this->db->join('section', 'section.idsection=optionecole.idsection');
        $this->db->join('ecole', 'ecole.idecole=section.idecole');
        $this->db->group_by('eleve.ideleve');

        $r =  $this->db->get('eleve')->result();
        $ide = '';
        foreach ($r as $el) {
            $ide .= "$el->ideleve, ";
        }
        $ide = substr($ide, 0, -2);

        //////////
        $r2 = [];
        $this->db->order_by('eleve.ideleve', 'desc');
        $this->db->select(
            "eleve.ideleve,
        eleve.nom, eleve.postnom, eleve.prenom, 
        eleve.matricule, section.intitulesection section, 
        classe.intituleclasse classe, eleve.adresse, 
        eleve.telephoneparent telephone, nomecole ecole"
        );
        $this->db->join('section_has_classe', 'section_has_classe.idsection_has_classe=eleve.idsection_has_classe');
        $this->db->join('section', 'section.idsection=section_has_classe.idsection');
        $this->db->join('classe', 'classe.idclasse=section_has_classe.idclasse');

        $this->db->join('ecole', 'ecole.idecole=section.idecole');
        if (!empty($ide)) {
            $this->db->where("`ideleve` NOT IN ($ide)", NULL, FALSE);
        }
        $this->db->group_by('eleve.ideleve');

        $r2 =  $this->db->get('eleve')->result();      

        foreach ($r2 as $ele) {
            $e = $ele;
            array_push($r, $e);
        }
        $data["eleves"] = $r;
        $this->load->view("admin/liste-eleve", $data);
    }
}
