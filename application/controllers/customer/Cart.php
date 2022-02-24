<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
        $this->load->helper('text');		
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

    public function index($arg=null) 
    {
		$currency = get_currency();
			//print '<pre>';print_r($currency);exit;
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
		$crumbs = array("Home" => "/$this->TYPE/cart/", "cart" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
		
		if ($this->uri->segment(2) === FALSE)
		{
			$slug = 0;
		}
		else
		{
			$slug = $this->uri->segment(2);
		}
		//echo 'cc'.$slug;
		$args = array('post_slug' => $slug,'enabled' => '1');		
		$data['detail'] = $this->Query_model->get_data_obj('ec_page',$args);	
        $this->load->template("$this->TYPE/cart_detail", $data); 
    }

    
}
