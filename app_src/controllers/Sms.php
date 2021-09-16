<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            http_response_code(405);
            die('Not allowed');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('Modele');
    }

    function checktype($type)
    {
        if (!in_array($type, ['ecole', 'univ', 'admin'])) {
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

        if ($type == 'ecole' and empty($i = $this->session->userdata("ecole_session"))) {
            echo json_encode(['ERROR NOT CONNECTED']);
            die;
        }

        return $i;
    }

    function notification()
    {
        $type = $this->input->post('type');
        $id = $this->checktype($type);

        $rep['status'] = false;
        if ($type == 'ecole') {
            $this->db->where('eleve.idecole', $id);
            $r = $this->db->get('eleve')->result();
            if (!count($r)) {
                $rep['message'] = "Veuillez ajouter d'abord les eleves.";
                echo json_encode($rep);
                exit;
            }

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
                        if ($sms) {
                            $this->db->insert('sms_ecole', ['ideleve' => $el->ideleve, 'nb' => 1]);
                            $n++;
                        } else {
                            $rep['message'] = "Erreur lors de l'envoi du message";
                        }
                    }
                }
                if ($n > 0) {
                    $rep['message'] = "Vous avez envoyé un SMS à $n parent(s).";
                    $rep['status'] = true;
                } else {
                    $rep['message'] = "Aucun SMS n'a été envoyé, vérifiez que vous avez déjà ajouté le numéro de téléphone.";
                }
            } else {
                $rep['message'] = "Vous avez déjà envoyé un SMS à tous les parents.";
            }
        } else if ($type == 'univ') {
            $this->db->where('universite.iduniversite', $id);
            $this->db->join('options', 'options.idoptions=etudiant.idoptions');
            $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
            $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
            $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
            $this->db->group_by('etudiant.idetudiant');
            $r = $this->db->get('etudiant')->result();
            if (!count($r)) {
                $rep['message'] = "Veuillez ajouter d'abord les etudiants.";
                echo json_encode($rep);
                exit;
            }

            $this->db->select('etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.telephone, 
            etudiant.matricule, etudiant.password, universite.nomUniversite
            ');

            $sql = "SELECT sms_universite.idetudiant FROM sms_universite JOIN etudiant ON etudiant.idetudiant=sms_universite.idetudiant 
            JOIN options ON options.idoptions=etudiant.idoptions 
            JOIN promotion ON promotion.idpromotion=options.idpromotion 
            JOIN faculte ON faculte.idfaculte=options.idfaculte 
            JOIN universite ON universite.iduniversite=faculte.iduniversite 
            WHERE universite.iduniversite=$id group by etudiant.idetudiant";

            $this->db->where('universite.iduniversite', $id);
            $this->db->where("`etudiant`.`idetudiant` NOT IN ($sql)", NULL, FALSE);
            $this->db->join('etudiant', 'etudiant.idetudiant=sms_universite.idetudiant', 'right');
            $this->db->join('options', 'options.idoptions=etudiant.idoptions');
            $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
            $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
            $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
            $r = $this->db->get('sms_universite')->result();

            if (count($r)) {
                $n = 0;
                foreach ($r as $el) {
                    $tel = $el->telephone;
                    if (!empty($tel)) {
                        $universite = $el->nomUniversite;
                        $msg = "Cher(e) " . ucwords("$el->nom $el->postnom $el->prenom") . "., voici le numero matricule et le code de connexion. Matricule : $el->matricule  Code : $el->password. Universite : $universite";
                        $sms = $this->Modele->sms($tel, $msg);
                        if ($sms) {
                            $this->db->insert('sms_universite', ['idetudiant' => $el->idetudiant, 'nb' => 1]);
                            $n++;
                        } else {
                            $rep['message'] = "Erreur lors de l'envoi du message";
                        }
                    }
                }

                if ($n > 0) {
                    $rep['message'] = "Vous avez envoyé un SMS à $n étudiant(s).";
                    $rep['status'] = true;
                } else {
                    $rep['message'] = "Aucun SMS n'a été envoyé, vérifiez que vous avez déjà ajouté le numéro de téléphone.";
                }
            } else {
                $rep['message'] = "Vous avez déjà envoyé un SMS à tous les étudiants.";
            }
        } else if ($type == 'admin') {
            $source = $this->input->post('source');
            if ($source == 'univ') {
            }
        }
        echo json_encode($rep);
    }

    function resend()
    {
        $type = $this->input->post('type');
        $id = $this->checktype($type);

        $rep['status'] = false;
        if ($type == 'ecole') {
            $ideleve = $this->input->post('eleve');
            $this->db->select('eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, eleve.telephoneparent, 
            eleve.matricule, eleve.password, ecole.nomecole, sms_ecole.nb
            ');
            $this->db->where(['eleve.idecole' => $id, 'eleve.ideleve' => $ideleve]);
            $this->db->join('sms_ecole', 'sms_ecole.ideleve=eleve.ideleve', 'left');
            $this->db->join('ecole', 'ecole.idecole=eleve.idecole');
            $r = $this->db->get('eleve')->result();
            // var_dump($r);
            if (count($r)) {
                $r = $r[0];
                $nb = (int) $r->nb;
                if ($nb >= 2) {
                    $rep['message'] = "Vous avez déjà envoyé $nb SMS ($r->telephoneparent) aux parents de l'eleve $r->nom $r->prenom.";
                } else {
                    $tel = $r->telephoneparent;
                    if (!empty($tel)) {
                        $ecole = $r->nomecole;
                        $msg = "Chers parents voici le numero matricule et le code de l'eleve " . ucwords("$r->nom $r->postnom $r->prenom") . ". Matricule : $r->matricule  Code : $r->password. Ecole : $ecole";
                        $sms = $this->Modele->sms($tel, $msg);
                        if ($sms) {
                            if (count($t = $this->db->where(['ideleve' => $ideleve])->get('sms_ecole')->result())) {
                                $this->db->update('sms_ecole', ['nb' => (int) $t[0]->nb + 1], ['ideleve' => $r->ideleve,]);
                            } else {
                                $this->db->insert('sms_ecole', ['ideleve' => $ideleve, 'nb' => 1]);
                            }
                            $rep['message'] = "Vous venez d'envoyer un SMS ($r->telephoneparent) aux parents de l'eleve $r->nom $r->prenom.";
                            $rep['status'] = true;
                        } else {
                            $rep['message'] = "Erreur lors de l'envoi du message";
                        }
                    } else {
                        $rep['message'] = "Vous devez ajouter un numero de telephone du parent de l'eleve avant d'envoyer le SMS.";
                    }
                }
            } else {
                $rep['message'] = 'Erreur';
            }
        } else if ($type == 'univ') {
            $idetudiant = $this->input->post('etudiant');
            $this->db->select('etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.telephone, 
                etudiant.matricule, etudiant.password, universite.nomUniversite, sms_universite.nb
            ');
            $this->db->where(['universite.iduniversite' => $id, 'etudiant.idetudiant' => $idetudiant]);
            $this->db->join('sms_universite', 'sms_universite.idetudiant=etudiant.idetudiant', 'left');
            $this->db->join('options', 'options.idoptions=etudiant.idoptions');
            $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
            $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
            $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
            $r = $this->db->get('etudiant')->result();

            if (count($r)) {
                $r = $r[0];
                $nb = (int) $r->nb;
                if ($nb >= 2) {
                    $rep['message'] = "Vous avez déjà envoyé $nb SMS ($r->telephone) à l'etudiant $r->nom $r->prenom.";
                } else {
                    $tel = $r->telephone;
                    if (!empty($tel)) {
                        $universite = $r->nomUniversite;
                        $msg = "Cher(e) " . ucwords("$r->nom $r->postnom $r->prenom") . "., voici le numero matricule et le code de connexion. Matricule : $r->matricule  Code : $r->password. Universite : $universite";
                        $sms = $this->Modele->sms($tel, $msg);
                        if ($sms) {
                            if (count($t = $this->db->where(['idetudiant' => $idetudiant])->get('sms_universite')->result())) {
                                $this->db->update('sms_universite', ['nb' => (int) $t[0]->nb + 1], ['idetudiant' => $r->idetudiant,]);
                            } else {
                                $this->db->insert('sms_universite', ['idetudiant' => $idetudiant, 'nb' => 1]);
                            }
                            $rep['message'] = "Vous venez d'envoyer un SMS ($r->telephone) à l'etudiant $r->nom $r->prenom.";
                            $rep['status'] = true;
                        } else {
                            $rep['message'] = "Erreur lors de l'envoi du message";
                        }
                    } else {
                        $rep['message'] = "Vous devez ajouter un numero de telephone de l'etudiant avant d'envoyer le SMS.";
                    }
                }
            } else {
                $rep['message'] = 'Erreur';
            }
        } else if ($type == 'admin') {
            $source = $this->input->post('source');
            if ($source == 'univ') {
                $idetudiant = $this->input->post('etudiant');
                $this->db->select('etudiant.idetudiant, etudiant.nom, etudiant.postnom, etudiant.prenom, etudiant.telephone, 
                    etudiant.matricule, etudiant.password, universite.nomUniversite, sms_universite.nb
                ');
                $this->db->where(['etudiant.idetudiant' => $idetudiant]);
                $this->db->join('sms_universite', 'sms_universite.idetudiant=etudiant.idetudiant', 'left');
                $this->db->join('options', 'options.idoptions=etudiant.idoptions');
                $this->db->join('promotion', 'promotion.idpromotion=options.idpromotion');
                $this->db->join('faculte', 'faculte.idfaculte=options.idfaculte');
                $this->db->join('universite', 'universite.iduniversite=faculte.iduniversite');
                $r = $this->db->get('etudiant')->result();

                if (count($r)) {
                    $r = $r[0];
                    $nb = (int) $r->nb;

                    $tel = $r->telephone;
                    if (!empty($tel)) {
                        $universite = $r->nomUniversite;
                        $msg = "Cher(e) " . ucwords("$r->nom $r->postnom $r->prenom") . "., voici le numero matricule et le code de connexion. Matricule : $r->matricule  Code : $r->password. Universite : $universite";
                        $sms = $this->Modele->sms($tel, $msg);
                        if ($sms) {
                            if (count($t = $this->db->where(['idetudiant' => $idetudiant])->get('sms_universite')->result())) {
                                $this->db->update('sms_universite', ['nb' => (int) $t[0]->nb + 1], ['idetudiant' => $r->idetudiant,]);
                            } else {
                                $this->db->insert('sms_universite', ['idetudiant' => $idetudiant, 'nb' => 1]);
                            }
                            $rep['message'] = "Vous venez d'envoyer un SMS ($r->telephone) à l'etudiant $r->nom $r->prenom. (SMS envoyé " . ($nb + 1) . ")";
                            $rep['status'] = true;
                        } else {
                            $rep['message'] = "Erreur lors de l'envoi du message";
                        }
                    } else {
                        $rep['message'] = "Aucun numéro de téléphone enregistré pour l'étudiant.";
                    }
                }
            } else if ($source == 'ecole') {
                $ideleve = $this->input->post('eleve');
                $this->db->select('eleve.ideleve, eleve.nom, eleve.postnom, eleve.prenom, eleve.telephoneparent, 
                eleve.matricule, eleve.password, ecole.nomecole, sms_ecole.nb
                ');
                $this->db->where(['eleve.ideleve' => $ideleve]);
                $this->db->join('sms_ecole', 'sms_ecole.ideleve=eleve.ideleve', 'left');
                $this->db->join('ecole', 'ecole.idecole=eleve.idecole');
                $r = $this->db->get('eleve')->result();

                if (count($r)) {
                    $r = $r[0];
                    $nb = (int) $r->nb;

                    $tel = $r->telephoneparent;
                    if (!empty($tel)) {
                        $ecole = $r->nomecole;
                        $msg = "Chers parents voici le numero matricule et le code de l'eleve " . ucwords("$r->nom $r->postnom $r->prenom") . ". Matricule : $r->matricule  Code : $r->password. Ecole : $ecole";
                        $sms = $this->Modele->sms($tel, $msg);
                        if ($sms) {
                            if (count($t = $this->db->where(['ideleve' => $ideleve])->get('sms_ecole')->result())) {
                                $this->db->update('sms_ecole', ['nb' => (int) $t[0]->nb + 1], ['ideleve' => $r->ideleve,]);
                            } else {
                                $this->db->insert('sms_ecole', ['ideleve' => $ideleve, 'nb' => 1]);
                            }
                            $rep['message'] = "Vous venez d'envoyer un SMS ($r->telephoneparent) aux parents de l'eleve $r->nom $r->prenom. (SMS envoyé " . ($nb + 1) . ")";
                            $rep['status'] = true;
                        } else {
                            $rep['message'] = "Erreur lors de l'envoi du message";
                        }
                    } else {
                        $rep['message'] = "Aucun numéro de téléphone enregistré pour l'eleve.";
                    }
                }
            }
        }

        echo json_encode($rep);
    }

    function token()
    {
        $type = $this->input->post_get('type');
        $this->checktype($type);
        $token = $this->input->post('token');
        $id = "ACe53f2cb9eca5a7240beee2cf58a006a5";
        $r = $this->Modele->select('twilio');

        if (empty($token)) {
            $t = @(json_decode(@$r[0]->setting))->auth_token;
            $rep = ['status' => false, 'token' => $t, 'date' => @$r[0]->date, "message" => "Entrer le token"];
        } else {
            if (!count($r)) {
                $data = ['account_sid' => $id, 'auth_token' => $token];
                $this->Modele->add('twilio', ['setting' => json_encode($data)]);
                $rep = ['status' => true, 'token' => $token, 'date' => date('Y-m-d H:i:s'),  "message" => "Token mis à jour."];
            } else {
                $data = ['account_sid' => $id, 'auth_token' => $token];
                $this->db->update('twilio', ['setting' => json_encode($data), 'date' => date('Y-m-d H:i:s')]);
                $rep = ['status' => true, 'token' => $token, 'date' => $r[0]->date, "message" => "Token mis à jour."];
            }
        }
        echo json_encode($rep);
    }
}
