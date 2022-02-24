<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
        $this->TYPE = $this->session->userdata('type');
	}
	
	public function index()  
    {
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Dashboard" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $data['csrf'] = csrf_token();
		
		$args = array('enabled' => '1');
		$data['count_all_product'] = $this->Query_model->count_all('ec_product',$args);
		$data['count_all_post'] = $this->Query_model->count_all('ec_posts',$args);
		
		$args1 = array('custype' => 'subscribe');
		$data['count_all_subscribe'] = $this->Query_model->count_all('ec_enquiry',$args1);
		
		$args2 = array('status' => '1');
		$data['count_all_visiter'] = $this->Query_model->count_all('ec_customer',$args2);
		
		
        $this->load->template("$this->TYPE/dashboard",$data);

	}
}
