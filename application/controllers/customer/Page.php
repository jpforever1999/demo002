<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {

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
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
		if ($this->uri->segment(2) === FALSE)
		{
			$slug = 0;
		}
		else
		{
			$slug = $this->uri->segment(2);
		}
		
		if(is_api()){
			$slug=$this->input->post('slug');
		}
		
		$args = array('post_slug' => $slug,'enabled' => '1');		
		$data['detail'] = $this->Query_model->get_data_obj('ec_page',$args);
		
		$crumbs = array("Home" => "/", "$slug" => '');
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
		
		
		
		if(is_api()){
			 
            unset($data['csrf']);
            unset($data['breadcrumbs']);
            unset($data['TYPE']);
			$data['detail']->post_content = strip_tags($data['detail']->post_content);
            $response = array(
                'status' => '1',
                'message' => 'success',
                'data' => [$data['detail']],
             );
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
		}else{
			$this->load->template("$this->TYPE/page_detail", $data);
		}
		
		
		
    }

    
}
