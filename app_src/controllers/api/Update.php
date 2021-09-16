<?php defined('BASEPATH') or exit('No direct script access allowed');

class Update extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Modele");
    }

    function index()
    {
        $this->db->select('version, active, note, required');
        $r = $this->Modele->select('release', ['active' => 1]);
        $folder = $this->input->get('f');
        if (empty($folder) or !count($f = $this->Modele->select('release', ['directory' => $folder]))) {
            http_response_code(403);
            // echo json_encode(['message' => "MDR ..."]);
            exit;
        }
        $f = $f[0];

        var_dump($f);

        $res['active'] = 0;
        if (count($r)) {
            $res = $r[0];
        }
        echo json_encode($res);
    }
}
