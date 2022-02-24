<?php

class Register_model extends MY_Model {
	
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
