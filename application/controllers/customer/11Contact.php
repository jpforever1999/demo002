<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('Contact_model');
        $this->load->library('session');
        $this->master = $this->load->database('master', TRUE);
		$this->TYPE = $this->session->userdata('type');
    }
	
}

