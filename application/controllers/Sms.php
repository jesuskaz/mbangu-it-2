<?php


class Sms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (!$this->input->is_ajax_request()) {
        //     http_response_code(403);
        //     die('Not allowed');
        // }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('Modele');
    }

    function checktype($type)
    {
        if (!in_array($type, ['ecole'])) {
            echo json_encode(['TYPE ERROR']);
            die;
        }

        if ($type == 'univ' and empty($i = $this->session->userdata("universite_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'admin' and empty($i = $this->session->userdata("isadmin"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'banque' and empty($i = $this->session->userdata("bank_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'ecole' and empty($i = $this->session->userdata("ecole_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        return $i;
    }

    function index()
    {
    }



    function notification()
    {
        $type = $this->input->post('type');
        $id = $this->checktype($type);

        $rep['status'] = false;
        if ($type == 'ecole') {
            $this->db->select('eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, eleve.telephoneparent, 
            eleve.matricule, eleve.password, ecole.nomecole
            ');
            $this->db->where('eleve.idecole', $id);
            $this->db->where("`eleve`.`ideleve` NOT IN (SELECT sms_ecole.ideleve FROM sms_ecole JOIN eleve ON eleve.ideleve=sms_ecole.ideleve WHERE eleve.idecole=$id group by eleve.ideleve )", NULL, FALSE);
            $this->db->join('eleve', 'eleve.ideleve=sms_ecole.ideleve', 'right');
            $this->db->join('ecole', 'ecole.idecole=eleve.idecole');
            $r = $this->db->get('sms_ecole')->result();

            if (count($r)) {
                $n = 0;
                foreach ($r as $el) {
                    $tel = $el->telephoneparent;
                    if (!empty($tel)) {
                        $ecole = $el->nomecole;

                        $msg = "Chers parents voici le numero matricule et le code de l'eleve " . ucwords("$el->nom $el->postnom $el->prenom") . ". Matricule : $el->matricule  Code : $el->password. Ecole : $ecole";
                        $sms = $this->Modele->sms($tel, $msg);
                        $this->db->insert('sms_ecole', ['ideleve' => $el->ideleve, 'nb' => 1]);
                        $n++;
                    }
                }
                $rep['message'] = "Vous avez envoyé un SMS à $n parent(s).";
                $rep['status'] = true;
            } else {
                $rep['message'] = "Vous avez déjà envoyé un SMS à tous les parents.";
            }
        }

        echo json_encode($rep);
    }
}
