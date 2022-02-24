<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Thanks extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
		$this->load->model('Product_model');
        $this->load->helper('text');		
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
		$this->current_id = $this->session->userdata($this->TYPE)['login_id'];
		
    }

	## Thank you page		
	public function index($arg=null) 
    {
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
		$crumbs = array("Home" => "/$this->TYPE/product/", "cart" => "/cart", "checkout" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
		
		if ($this->uri->segment(2) === FALSE){
			$slug = 0;
		}else{
			$slug = $this->uri->segment(2);
		}	
		//echo "".$this->current_id;die;
		if(isset($this->current_id)){	
			$args = array('cust_id' => $this->current_id);			
			$data['current_user_info'] = $this->Query_model->get_data_obj('ec_customermeta',$args);		
		}
		
		#$pp = $this->session->userdata($this->TYPE);
		#echo "<pre>"; print_r($data['current_user_info'] ); echo "</pre>";die;
		
        $this->load->template("$this->TYPE/thankyou", $data);
    }
	
}





















