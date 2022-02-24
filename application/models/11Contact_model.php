<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model{

	 function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }   
    public function insert_data($table_name,$data)
    {
        unset($data['save']);
        $this->master->insert($table_name,$data);
        return  $this->master->insert_id();
    }
	
	
}