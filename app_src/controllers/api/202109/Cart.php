<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Modele");
    }

    function checkType(String $type = '')
    {
        if (!in_array($type, ['p', 'e'])) {
            echo json_encode(['status' => false, 'message' => "Invalid type : $type"]);
            exit;
        }
    }

    function get()
    {
        $rep['status'] = false;
        $type = $this->input->get('type');
        $matricule =  $this->input->get('matricule');

        if (empty($type) or empty($matricule)) {
            $rep['message'] = "Missing params.";
            echo json_encode($rep);
            exit;
        }
        $this->checkType($type);

        if ($type == 'p') {
            if (!count($r = $this->db->where('login', $matricule)->get('parent')->result())) {
                $rep['message'] = "Invalid mat : $matricule.";
                echo json_encode($rep);
                exit;
            }
            $r = $r[0];
            $this->db->select("panier_ecole.qte, panier_ecole.prix, panier_ecole.prix_total, devise.nomDevise devise, 
            eleve.ideleve, eleve.nom, eleve.prenom,article_ecole.idarticle, article_ecole.titre article, article_ecole.image");
            $this->db->join('panier_ecole', 'panier_ecole.idcommande=commande_ecole.idcommande');
            $this->db->join('article_ecole', 'article_ecole.idarticle=panier_ecole.idarticle');
            $this->db->join('eleve', 'eleve.ideleve=panier_ecole.ideleve');
            $this->db->join('parent_has_eleve', 'parent_has_eleve.ideleve=eleve.ideleve');
            $this->db->join('parent', 'parent.idparent=parent_has_eleve.idparent');
            $this->db->join('devise', 'devise.iddevise=article_ecole.iddevise');

            $this->db->where(['commande_ecole.idparent' => $r->idparent,]);
            $this->db->group_by('panier_ecole.idpanier');
            $this->db->order_by('commande_ecole.idcommande', 'desc');
            $a = $this->db->get('commande_ecole')->result();

            $rep['data'] = $a;
            if (!count($a)) {
                $rep['message'] = "Aucun article dans le panier.";
            } else {
                $rep['status'] = true;
            }
        } else if ($type == 'e') {
        }
        echo json_encode($rep);
    }

    function add()
    {
        $rep['status'] = false;
        $type = $this->input->post('type');
        $matricule =  $this->input->post('matricule');
        $idarticle =  $this->input->post('article');
        $ideleve =  $this->input->post('eleve');
        $qte = (int) $this->input->post('qte');
        $increment =  $this->input->post('increment');



        if (empty($type) or empty($matricule) or empty($idarticle) or empty($ideleve) or empty($qte)) {
            $rep['message'] = "Missing params.";
            echo json_encode($rep);
            exit;
        }
        $this->checkType($type);

        if ($type == 'p') {
            if (!count($rp = $this->db->where('login', $matricule)->get('parent')->result())) {
                $rep['message'] = "Invalid mat : $matricule.";
                echo json_encode($rep);
                exit;
            }

            $this->db->join('parent_has_eleve', 'parent_has_eleve.ideleve=eleve.ideleve');
            $this->db->join('parent', 'parent.idparent=parent_has_eleve.idparent');
            if (!count($this->db->where(['eleve.ideleve' => $ideleve, 'parent.login' => $matricule])->get('eleve')->result())) {
                $rep['message'] = "Eleve non valide.";
                echo json_encode($rep);
                exit;
            }

            if (!count($ra = $this->db->where('idarticle', $idarticle)->get('article_ecole')->result())) {
                $rep['message'] = "Article non valide.";
                echo json_encode($rep);
                exit;
            }

            if ($qte < 0) {
                $rep['message'] = "Qte non valide.";
                echo json_encode($rep);
                exit;
            }

            // commande 0 : non livree
            // commande 1 : livree partiellement
            // commande 2 : livree

            if (count($cmd = $this->db->where(['commande_ecole.livree' => 0, 'commande_ecole.idparent' => $rp[0]->idparent])->get('commande_ecole')->result())) {
                if (count($pe = $this->db->where(['panier_ecole.ideleve' => $ideleve, 'panier_ecole.idarticle' => $idarticle, 'panier_ecole.idcommande' => $cmd[0]->idcommande])->get('panier_ecole')->result())) {
                    $pe = $pe[0];
                    if ($increment == 'no') {
                        $q = $qte ?? 1;
                    } else {
                        $q = $pe->qte + ($qte ?? 1);
                    }

                    if ($q > 10) {
                        $q = 10;
                        $rep['message'] = "La quantité maximale par aricle  est de 10. L'article a été mis à jour. Qte : $q";
                    } else {
                        $rep['message'] = "L'article a été mis à jour. Qte : $q";
                    }

                    $mt = $ra[0]->prix * $q;
                    $this->Modele->update('panier_ecole', ['idpanier' => $pe->idpanier], [
                        'iddevise' => $ra[0]->iddevise,
                        'qte' => $q,
                        'prix' => $ra[0]->prix,
                        'prix_total' => $mt,
                    ]);
                } else {
                    $this->Modele->add('panier_ecole', [
                        'idarticle' => $idarticle,
                        'ideleve' => $ideleve,
                        'iddevise' => $ra[0]->iddevise,
                        'idcommande' => $cmd[0]->idcommande,
                        'qte' => $qte ?? 1,
                        'prix' => $ra[0]->prix,
                        'prix_total' => $ra[0]->prix  * ($qte ?? 1),
                        'code' => md5($ra[0]->idarticle . uniqid('', true))
                    ]);
                    $rep['message'] = "L'article a été ajouté au panier.";
                }
            } else {
                $this->db->trans_start();
                $this->Modele->add('commande_ecole', [
                    'idparent' => $rp[0]->idparent,
                    'numero_commande' => uniqid("CMD-"),
                    'livree' => 0,
                ]);
                $idcmd = $this->db->insert_id();
                $this->Modele->add('panier_ecole', [
                    'idarticle' => $idarticle,
                    'ideleve' => $ideleve,
                    'iddevise' => $ra[0]->iddevise,
                    'idcommande' => $idcmd,
                    'qte' => $qte ?? 1,
                    'prix' => $ra[0]->prix,
                    'prix_total' => $ra[0]->prix  * ($qte ?? 1),
                    'code' => md5($ra[0]->idarticle . uniqid('', true))
                ]);
                $this->db->trans_complete();
                $rep['message'] = "L'article a été ajouté au panier.";
            }

            $rep['status'] = true;
        } else if ($type == 'e') {
        }

        echo json_encode($rep);
    }
}
