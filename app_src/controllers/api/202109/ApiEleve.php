<?php defined('BASEPATH') or exit('No direct script access allowed');
class ApiEleve extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ApiModel");
        $this->load->model("Modele");
        // $this->Modele->checkToken();
    }

    public function getFaculte()
    {
        $data = $this->ApiModel->getDataFaculte();
        echo json_encode($data);
    }
    public function getProvince()
    {
        $province = $this->db->get('province')->result_array();
        echo json_encode($province);
    }
    public function updateInfo()
    {
        $inputData = $this->input->post("data");
        $index = $this->input->post("index");
        $matricule = $this->input->post("matricule");

        if ($index == '1') {
            $data = [
                "email" => $inputData,
            ];

            $this->db->where("matricule", $matricule);
            $update = $this->db->update("etudiant", $data);

            if ($update) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else if ($index == '2') {
            $data = [
                "adresse" => $inputData,
            ];

            $this->db->where("matricule", $matricule);
            $update = $this->db->update("etudiant", $data);

            if ($update) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else if ($index == '3') {
            $data = [
                "tel" => $inputData,
            ];

            $this->db->where("matricule", $matricule);
            $update = $this->db->update("etudiant", $data);

            if ($update) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
    }
    public function picture()
    {
        $matricule = $this->input->post("matricule");
        $name = $this->input->post("name");
        $path = $this->input->post("picture");

        $tempo = "upload/profile/" . $name;
        $decodeImage = base64_decode($path);

        file_put_contents($tempo, $decodeImage);

        $data = [
            "picture" => $tempo
        ];

        $isMatricule = $this->db->get_where(
            "etudiant",
            ["matricule" => $matricule]
        )->result_array();

        if ($isMatricule) {
            $this->db->where("matricule", $matricule);
            $insert = $this->db->update("etudiant", $data);
            if ($insert) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
    }
    public function carte()
    {
        $matricule = $this->input->post("matricule");
        $name = $this->input->post("name");
        $path = $this->input->post("carte");

        $tempo = "upload/carte/" . $name;
        $decodeImage = base64_decode($path);

        file_put_contents($tempo, $decodeImage);

        $data = [
            -+"carte" => $tempo
        ];

        $isMatricule = $this->db->get_where(
            "etudiant",
            ["matricule" => $matricule]
        )->result_array();

        if ($isMatricule) {
            $this->db->where("matricule", $matricule);
            $insert = $this->db->update("etudiant", $data);
            if ($insert) {
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        }
    }
    public function updateStudent()
    {
        // $province = $this->input->post("province");
        $ville = $this->input->post('ville');
        $sexe = $this->input->post("sexe");
        $adresse = $this->input->post("adresse");
        $email = $this->input->post("email");
        $nationalite = $this->input->post("nationalite");
        $matricule = $this->input->post("matricule");

        $idetudiant = $this->db->get_where("etudiant", ["matricule" => $matricule])->row("idetudiant");

        $data = [
            "idville" => $ville,
            "sexe" => $sexe,
            "adresse" => $adresse,
            "email" => $email,
            "nationnalite" => $nationalite
        ];

        $this->db->where("idetudiant", $idetudiant);
        $query = $this->db->update("etudiant", $data);

        if ($query) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
    }
    public function getVille($idprovince)
    {
        $ville = $this->db->get_where('ville', ['idprovince' => $idprovince])->result_array();
        echo json_encode($ville);
    }

    public function getUniversite()
    {
        $data = $this->ApiModel->getDataUniversite();
        echo json_encode($data);
    }

    public function getCompte($idUniversite)
    {
        $univ = $this->ApiModel->getUnivByIDSchool($idUniversite);
        if ($univ) {
            echo json_encode($univ);
        }
    }
    public function getevery($matricule)
    {
        $this->db->select('universite.iduniversite as id');
        $this->db->from('etudiant');
        $this->db->join('options', 'etudiant.idoptions = options.idoptions');
        $this->db->join('faculte', 'options.idfaculte = faculte.idfaculte');
        $this->db->join('universite', 'faculte.iduniversite = universite.iduniversite');
        $this->db->group_by('etudiant.matricule', $matricule);
        $this->db->where('etudiant.matricule', $matricule);
        $data = $this->db->get()->result_array();

        $r = array();
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $id = $data[$i]["id"];
                $this->db->select(" * ");
                $this->db->from('annonce');
                $this->db->where('id', $id);
                $this->db->where('type', 'universite');
                $query = $this->db->limit(4)->get()->result_array();
                array_push($r, $query);
            }
        }
        return $r;
    }
    public function operatingAnnonce($matricule)
    {
        $banque = $this->db->get_where('annonce', ['type' => 'banque'])->result_array();
        $admin = $this->db->get_where('annonce', ['type' => 'admin'])->result_array();
        $merge1 = array_merge($banque, $admin);

        $data = $this->getevery($matricule);
        foreach ($data as $d) {
            for ($i = 0; $i < count($d); $i++) {
                array_push($merge1, $d[$i]);
            }
        }
        echo json_encode($merge1);
    }
    public function option($idEcole)
    {
        $data = $this->ApiModel->getOption($idEcole);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode("false");
        }
    }

    public function promotion($idEcole)
    {
        $data = $this->ApiModel->getPromotion($idEcole);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode("false");
        }
    }
}
