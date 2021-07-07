<?php
class Ecole extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$ide = $this->session->ecole_session) {
            redirect();
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->idecole = $ide;
        $this->idannee = $this->session->annee_scolaire;
    }


    function index()
    {
        $data["devises"] = $this->db->get('devise')->result();
        $data["sections"] = $this->db->where('idecole', $this->idecole)->get('section')->result();

        $this->db->join('classe', 'classe.idclasse=eleve.idclasse');
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=classe.idannee_scolaire_ecole');
        $this->db->where('annee_scolaire_ecole.idannee_scolaire_ecole', $this->idannee);
        $data["tot_eleve"] = $te = count($this->db->get('eleve')->result());

        $sql = "SELECT * from eleve where ideleve 
            in (select paiement_ecole.ideleve from paiement_ecole join eleve ON paiement_ecole.ideleve=eleve.ideleve join classe on classe.idclasse=eleve.idclasse 
            join annee_scolaire_ecole on classe.idannee_scolaire_ecole = annee_scolaire_ecole.idannee_scolaire_ecole
            where annee_scolaire_ecole.idannee_scolaire_ecole=$this->idannee)";
        $data["eleve_paie"] = $ep = count($this->db->query($sql)->result());

        $data["eleve_pas_paie"] = $te - $ep;

        $this->load->view("ecole/index", $data);
    }

    function solde()
    {

        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'ecole.idecole=annee_scolaire_ecole.idecole');
        $data['frais'] = $this->db->where(['ecole.idecole' =>  $this->idecole, 'frais_ecole.idannee_scolaire_ecole' => $this->idannee])->get('frais_ecole')->result();

        $this->db->select("sum(paiement_ecole.montant) total, nomDevise devise, frais_ecole.intitulefrais frais");
        $this->db->join('frais_ecole', 'frais_ecole.idfrais_ecole=paiement_ecole.idfrais_ecole');
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        $this->db->join('ecole', 'ecole.idecole=annee_scolaire_ecole.idecole');
        $this->db->where(['ecole.idecole' =>  $this->idecole, 'frais_ecole.idannee_scolaire_ecole' => $this->idannee]);

        $this->db->group_by('paiement_ecole.iddevise');

        $data['solde'] = $this->db->get('paiement_ecole')->result();

        $this->load->view("ecole/solde", $data);
    }

    public function frais()
    {

        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        $this->db->join('devise', 'devise.iddevise = frais_ecole.iddevise');
        $data["frais"] = $this->db->where(['idannee_scolaire_ecole' => $this->idannee])->get('frais_ecole')->result_array();
        $data["anneescolaires"] = $this->db->get_where('annee_scolaire_ecole', ['idecole' => $this->idecole])->result_array();
        $data['devise'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $this->load->view("ecole/frais", $data);
    }

    function delete_f($idfrais = null)
    {
        $idfrais = (int) $idfrais;
        $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
        if (!count($this->db->where(['idfrais_ecole' => $idfrais, 'idecole' => $this->idecole])->get('frais_ecole')->result())) {
            redirect();
        }
        if (count($this->db->where(['paiement_ecole.idfrais_ecole' => $idfrais])->get('paiement_ecole')->result())) {
            $this->session->set_flashdata(['message2' => "Vous ne pouvez plus supprimer ce frais, car il existe déjà un paiement lié à ce frais.", 'classe2' => 'danger']);
        } else {
            $this->db->delete('frais_ecole', ['idfrais_ecole' => $idfrais]);
            $this->session->set_flashdata(['message2' => "Le frais a été supprimé.", 'classe2' => 'success']);
        }
        redirect('ecole/frais');
    }

    function edit_f($id_frais = null)
    {
        $id_frais = (int) $id_frais;
        $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
        $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
        if (!count($et = $this->db->where('idfrais_ecole', $id_frais)->get('frais_ecole')->result())) {
            redirect('ecole/frais');
        }
        $et = $et[0];
        $data['frais'] = "$et->intitulefrais : $et->montant $et->nomDevise";
        $data["anneescolaires"] = $this->db->get_where('annee_scolaire_ecole', ['idecole' => $this->idecole])->result_array();
        $data['devises'] = $this->db->get('devise')->result();
        $data['banques'] = $this->db->get('banque')->result();

        $data['idfrais'] = $id_frais;
        $data['nom_f'] = $et->intitulefrais;
        $data['compte'] = $et->compte;
        $data['idbanque'] = $et->idbanque;
        $data['montant'] = $et->montant;
        $data['devise'] = $et->iddevise;
        $data['annee'] = $et->idannee_scolaire_ecole;
        $this->load->view("ecole/edit_frais", $data);
    }

    function update_f()
    {
        $this->load->library('form_validation');
        $validation = new CI_Form_validation();

        $validation->set_rules('idfrais', '', 'required');
        $validation->set_rules('annee', '', 'required');
        $validation->set_rules('banque', '', 'required');
        $validation->set_rules('compte', '', 'required');
        $validation->set_rules('frais', '', 'required');
        $validation->set_rules('montant', '', 'required');
        $validation->set_rules('devise', '', 'required');

        if ($validation->run()) {
            $fr = $this->input->post('idfrais');
            $this->db->join('devise', 'devise.iddevise=frais_ecole.iddevise');
            $this->db->join('banque', 'banque.idbanque=frais_ecole.idbanque');
            $this->db->join('annee_scolaire_ecole', 'annee_scolaire_ecole.idannee_scolaire_ecole=frais_ecole.idannee_scolaire_ecole');
            if (!count($this->db->where(['idfrais_ecole' => $fr, 'idecole' => $this->idecole])->get('frais_ecole')->result())) {
                redirect();
            }

            if (count($this->db->where(['paiement_ecole.idfrais_ecole' => $fr])->get('paiement_ecole')->result())) {
                $this->session->set_flashdata(['message' => "Vous ne pouvez plus modifier ce frais, car il existe déjà un paiement lié à ce frais.", 'classe' => 'danger']);
            } else {
                $this->db->update('frais_ecole', [
                    'idannee_scolaire_ecole' => $this->input->post('annee'),
                    'iddevise' => $this->input->post('devise'),
                    'compte' => $this->input->post('compte'),
                    'idbanque' => $this->input->post('banque'),
                    'intitulefrais' => $this->input->post('frais'),
                    'montant' => $this->input->post('montant'),
                ], ['idfrais_ecole' => $fr]);
                $this->session->set_flashdata(['message' => "Le frais a été mis à jour.", 'classe' => 'success']);
            }
            redirect('ecole/edit_f/' . $fr);
        } else {
            redirect('ecole/edit_f');
        }
    }

    public function frais_a()
    {

        $banque = $this->input->post("banque");
        $compte = $this->input->post("compte");
        $frais = $this->input->post("frais");
        $montant = $this->input->post("montant");
        $devise = $this->input->post("devise");
        $anne = $this->input->post('annee');

        $data = [
            "intitulefrais" => $frais,
            "compte" => $compte,
            "idbanque" => $banque,
            "montant" => $montant,
            "iddevise" => $devise,
            "idannee_scolaire_ecole" => $anne,
        ];

        $this->db->insert('frais_ecole', $data);

        $id = $this->session->universite_session;
        $data["anneeAcademiques"] = $this->db->get_where('anneeAcademique', ['iduniversite' => $id])->result_array();

        $this->session->set_flashdata(['message' => "Frais ajouté avec succès", 'classe' => 'success']);

        redirect('ecole/frais');
    }

    function anneescolaire()
    {
        $this->db->order_by('actif', 'desc');
        $data["anneescolaires"] = $this->db->get_where('annee_scolaire_ecole', ['idecole' => $this->idecole])->result();
        $this->load->view("ecole/anneescolaire", $data);
    }

    public function annee_a()
    {

        $to = $this->input->post("to");
        $from = $this->input->post("from");

        $data = array(
            "date_debut" => $from,
            "date_fin" => $to,
            "idecole" => $this->idecole,
        );

        $this->db->insert('annee_scolaire_ecole', $data);
        $message["message"] = "L'année ajoutée avec succès ";
        $message["classe"] = "success";
        $this->session->set_flashdata($message);
        redirect('ecole/anneescolaire');
    }

    function active_a($idann = null)
    {
        if (is_null($idann)) redirect('ecole/anneescolaire');
        if (!count($a = $this->db->where(['idecole' => $this->idecole, 'idannee_scolaire_ecole' => $idann])->get('annee_scolaire_ecole')->result()))  redirect('ecole/anneescolaire');

        $a = $a[0];
        $a = "$a->date_debut $a->date_fin";

        $this->db->trans_start();
        $this->db->update('annee_scolaire_ecole', ['actif' => 0], ['idecole' => $this->idecole]);
        $this->db->update('annee_scolaire_ecole', ['actif' => 1], ['idannee_scolaire_ecole' => $idann]);
        $this->db->trans_complete();
        $this->session->set_flashdata(['message2' => "Année '$a' activée avec succès.",]);
        $this->session->set_flashdata(['classe2' => "success",]);
        redirect('ecole/anneescolaire');
    }
}
