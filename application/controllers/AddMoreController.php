<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
class AddMoreController extends CI_Controller {
   
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
       $this->load->database();
    }
   
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index()
    {
        $this->load->view('addMore');
    }
   
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function storePost()
    {
        if(!empty($this->input->post('addmore'))){
   
            foreach ($this->input->post('addmore') as $key => $value) {
                $this->db->insert('admin',$value);
            }
               
        }
   
        print_r('Record Added Successfully.');
    }
       
}