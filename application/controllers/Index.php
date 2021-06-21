<?php
class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model("Manager");
    }

    public function index()
    {
        $this->load->view('first/index');
    }

    public function contact()
    {
        $this->load->view('first/contact');
    }

    public function about()
    {
        $this->load->view('first/about');
    }

    public function process()
    {
        $this->load->view('first/process');
    }

    public function login()
    {

        if ($this->session->userdata("login")) 
        {

            $data["promotions"] = $this->Manager->getPromotion($this->session->universite_session);

            // // get Faculte data
            $data["faculte"] = count($this->db->get_where('faculte', ["iduniversite" => $this->session->universite_session])->result() );

            
            // $data["faculte"] = count($faculte);
            $data["selectFaculte"] = $this->db->get_where('faculte', ["iduniversite" => $this->session->universite_session])->result_array();

            // // get Student
            $data["etudiant"] = count([]);
            // $data["etudiant"] = count($this->Manager->getStudent($denomination));

            // // get Option
            $data["options"] = $this->Manager->getOption($this->session->universite_session);
            $data["devises"] = $this->db->get('devise')->result();
            // $data["options"] = $this->Manager->getOption($denomination);
         
            // $data["rapports"] = $this->Manager->getAllRapport(['universite' => $denomination]);
            // $data["rapports"] = $this->Manager->getAllRapport($denomination);
            $this->load->view("universite/index", $data);
        } 
        else 
        {
            redirect("AdminCredential");
        }
    }

    function getallrapport()
    {
        $faculte = $this->input->get('faculte', true);
        $promotion = $this->input->get('promotion', true);
        $option = $this->input->get('option', true);
        $d = $this->input->get('date', true);
        $d = explode('-', $d);
        $date_debut = trim(@$d[0]);
        $date_fin = trim(@$d[1]);
        $devise = $this->input->get('devise', true);

        $login = $this->session->userdata("login");
        $denomination = $this->Manager->rapportPayement($login);
        $where = ['universite' => $denomination];
        if(!empty($faculte)){
            $where['faculte'] = $faculte;
        }
        if(!empty($promotion)){
            $where['promotion'] = $promotion;
        }
        if(!empty($option)){
            $where['options'] = $option;
        }
        $r = $this->Manager->getAllRapport($where);
        // $r = $this->Manager->getAllRapport($denomination);
        // var_dump($denomination);
        // die;
        // var_dump(empty($faculte), $where,$faculte, $promotion, $option, $date_debut, $date_fin, $devise);
        // die;
        echo json_encode([
            'data' => $r
        ]);
    }

    public function getSchoolChart($devise)
    {
        $login = $this->session->userdata("login");
        $idEcole = $this->Manager->getIdSchool($login);

        $query = $this->Manager->getDataGraphe($idEcole, $devise);
        if ($query) {
            foreach ($query[0] as $value => $key) {
                $mois[] = $value;
                $somme[] = $key;
            }
            $maxValue = max($somme);
            $excedent = (int)($maxValue / 4);

            $resultat = $maxValue + $excedent;

            $all[] = $somme;
            $all[] = $mois;
            $all[] = array($resultat);

            echo json_encode($all);
        }
    }
}
