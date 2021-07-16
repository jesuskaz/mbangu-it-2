<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Json extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            http_response_code(403);
            die('Not allowed');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    function checktype($type)
    {
        if (!in_array($type, ['univ', 'admin', 'banque', 'ecole'])) {
            echo json_encode(['TYPE ERROR']);
            die;
        }

        if ($type == 'univ' and empty($this->session->userdata("universite_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'admin' and empty($this->session->userdata("isadmin"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'banque' and empty($this->session->userdata("bank_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        if ($type == 'ecole' and empty($this->session->userdata("ecole_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }
    }

    function import()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $section = $this->input->post('section');
        $option = $this->input->post('option');
        $classe = $this->input->post('classe');

        if (empty($section)) {
            die(json_encode(['status' => false, 'message' => "Veuillez spécifier la section"]));
        }
        if (empty($option)) {
            die(json_encode(['status' => false, 'message' => "Veuillez spécifier l'option"]));
        }
        if (empty($classe)) {
            die(json_encode(['status' => false, 'message' => "Veuillez spécifier la classe"]));
        }

        $file_mimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        if (isset($_FILES['file']['name'])) {
            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);
            if (!(($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['file']['type'], $file_mimes))) {
                die(json_encode(['status' => false, 'message' => "Veuillez selectionner le fichier correct : .xlsx, .xls"]));
            }
        } else {
            die(json_encode(['status' => false, 'message' => "Veuillez selectionner le fichier à importer"]));
        }

        if (!empty($_FILES['file']['name'])) {
            // get file extension
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }
            // file path
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // array Count
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('NOM', 'POSTNOM', 'PRENOM', 'MATRICULE', 'ADRESSE', 'TELEPHONE_PARENT');
            $makeArray = array('NOM' => "NOM", 'POSTNOM' => 'POSTNOM', 'PRENOM' => 'PRENOM', 'MATRICULE' => 'MATRICULE', 'ADRESSE' => 'ADRESSE', 'TELEPHONE_PARENT' => 'TELEPHONE_PARENT');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    }
                }
            }
            $dataDiff = array_diff_key($makeArray, $SheetDataKey);
            if (empty($dataDiff)) {
                $flag = 1;
            }
            // match excel sheet column
            $this->load->model('Modele');
            if ($flag == 1) {
                $add = $ignore = 0;
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $nom = $SheetDataKey['NOM'];
                    $postnom = $SheetDataKey['POSTNOM'];
                    $prenom = $SheetDataKey['PRENOM'];
                    $matricule = $SheetDataKey['MATRICULE'];
                    $adresse = $SheetDataKey['ADRESSE'];
                    $telephone = $SheetDataKey['TELEPHONE_PARENT'];

                    $nom = filter_var(trim($allDataInSheet[$i][$nom]), FILTER_SANITIZE_STRING);
                    $postnom = filter_var(trim($allDataInSheet[$i][$postnom]), FILTER_SANITIZE_STRING);
                    $prenom = filter_var(trim($allDataInSheet[$i][$prenom]), FILTER_SANITIZE_STRING);
                    $matricule = filter_var(trim($allDataInSheet[$i][$matricule]), FILTER_SANITIZE_STRING);
                    $adresse = filter_var(trim($allDataInSheet[$i][$adresse]), FILTER_SANITIZE_STRING);
                    $telephone = filter_var(trim($allDataInSheet[$i][$telephone]), FILTER_SANITIZE_STRING);

                    if (!empty($nom) and !empty($postnom) and !empty($prenom)) {
                        $matricule = !empty($matricule) ? $matricule : $this->Modele->matricule('eleve', [$nom, $postnom, $prenom]);
                        $code = $this->Modele->code();
                        if (!count($this->db->where(['nom' => $nom, 'postnom' => $postnom, 'prenom' => $prenom, 'idclasse' => $classe])->get('eleve')->result())) {
                            $add++;
                            $this->db->insert('eleve', [
                                'nom' => $nom,
                                'postnom' => $postnom,
                                'prenom' => $prenom,
                                'matricule' => $matricule,
                                'adresse' => $adresse,
                                'idclasse' => $classe,
                                'telephoneparent' => $telephone,
                                'code' => $code
                            ]);
                        } else {
                            $ignore++;
                        }
                    }
                }
                die(json_encode(['status' => (bool) $add, 'message' => $add > 0 ? "Données importées." : "Aucune ligne n'a été importée."]));
            } else {
                die(json_encode(['status' => false, 'message' => "Les colonnes dans le fichier ne sont pas au format requis."]));
            }
        }
        die(json_encode(['status' => false, 'message' => "Veuillez selectionner le fichier à importer."]));
    }

    function import_2()
    {
        $type = $this->input->post('type', true);
        $this->checktype($type);

        $faculte = $this->input->post('faculte');
        $promotion = $this->input->post('promotion');
        $option = $this->input->post('option');

        if (empty($faculte)) {
            die(json_encode(['status' => false, 'message' => "Veuillez spécifier la faculte"]));
        }
        if (empty($promotion)) {
            die(json_encode(['status' => false, 'message' => "Veuillez spécifier l'promotion"]));
        }
        if (empty($option)) {
            die(json_encode(['status' => false, 'message' => "Veuillez spécifier l'option"]));
        }

        $file_mimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        if (isset($_FILES['file']['name'])) {
            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);
            if (!(($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['file']['type'], $file_mimes))) {
                die(json_encode(['status' => false, 'message' => "Veuillez selectionner le fichier correct : .xlsx, .xls"]));
            }
        } else {
            die(json_encode(['status' => false, 'message' => "Veuillez selectionner le fichier à importer"]));
        }

        if (!empty($_FILES['file']['name'])) {
            // get file extension
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }
            // file path
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // array Count
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('NOM', 'POSTNOM', 'PRENOM', 'MATRICULE', 'ADRESSE', 'EMAIL', 'TELEPHONE', 'SEXE');
            $makeArray = array('NOM' => "NOM", 'POSTNOM' => 'POSTNOM', 'PRENOM' => 'PRENOM', 'MATRICULE' => 'MATRICULE', 'ADRESSE' => 'ADRESSE', 'EMAIL' => 'EMAIL', 'TELEPHONE' => 'TELEPHONE', 'SEXE' => 'SEXE');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    }
                }
            }

            $dataDiff = array_diff_key($makeArray, $SheetDataKey);
            if (empty($dataDiff)) {
                $flag = 1;
            }
            // match excel sheet column
            $this->load->model('Modele');
            if ($flag == 1) {
                $add = $ignore = 0;
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $nom = $SheetDataKey['NOM'];
                    $postnom = $SheetDataKey['POSTNOM'];
                    $prenom = $SheetDataKey['PRENOM'];
                    $matricule = $SheetDataKey['MATRICULE'];
                    $adresse = $SheetDataKey['ADRESSE'];
                    $email = $SheetDataKey['EMAIL'];
                    $telephone = $SheetDataKey['TELEPHONE'];
                    $sexe = $SheetDataKey['SEXE'];

                    $nom = filter_var(trim($allDataInSheet[$i][$nom]), FILTER_SANITIZE_STRING);
                    $postnom = filter_var(trim($allDataInSheet[$i][$postnom]), FILTER_SANITIZE_STRING);
                    $prenom = filter_var(trim($allDataInSheet[$i][$prenom]), FILTER_SANITIZE_STRING);
                    $matricule = filter_var(trim($allDataInSheet[$i][$matricule]), FILTER_SANITIZE_STRING);
                    $adresse = filter_var(trim($allDataInSheet[$i][$adresse]), FILTER_SANITIZE_STRING);
                    $email = filter_var(trim($allDataInSheet[$i][$email]), FILTER_SANITIZE_STRING);
                    $telephone = filter_var(trim($allDataInSheet[$i][$telephone]), FILTER_SANITIZE_STRING);
                    $sexe = filter_var(trim($allDataInSheet[$i][$sexe]), FILTER_SANITIZE_STRING);

                    if (!empty($nom) and !empty($postnom) and !empty($prenom)) {
                        $matricule = !empty($matricule) ? $matricule : $this->Modele->matricule('etudiant', [$nom, $postnom, $prenom]);
                        if (!count($this->db->where(['nom' => $nom, 'postnom' => $postnom, 'prenom' => $prenom, 'sexe' => $sexe, 'idpromotion' => $promotion])->get('etudiant')->result())) {
                            $add++;
                            $this->db->insert('etudiant', [
                                'nom' => $nom,
                                'postnom' => $postnom,
                                'prenom' => $prenom,
                                'matricule' => $matricule,
                                'adresse' => $adresse,
                                'idpromotion' => $promotion,
                                'telephone' => $telephone,
                                'sexe' => $sexe,
                                'email' => $email,
                                'idanneeAcademique' => $this->session->annee_academique
                            ]);
                        } else {
                            $ignore++;
                        }
                    }
                }
                die(json_encode(['status' => (bool) $add, 'message' => $add > 0 ? "Données importées." : "Aucune ligne n'a été importée."]));
            } else {
                die(json_encode(['status' => false, 'message' => "Les colonnes dans le fichier ne sont pas au format requis."]));
            }
        }
        die(json_encode(['status' => false, 'message' => "Veuillez selectionner le fichier à importer."]));
    }
}
