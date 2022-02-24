<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
		//$this->load->model('Page_model'); 
		$this->load->model('User_model'); 
        $this->TYPE = $this->session->userdata('type');
		
	}
	
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
	   $crumbs = array("Home" => "/$this->TYPE/dashboard", "Contact" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();		

        $this->load->template("$this->TYPE/contact/index",$data);
	}

    public function index_ajax_post()
    {
        $contact = $this->Query_model->get_contact();

        $data = array();
        $sno = 0;
        foreach ($contact as $obj) {
            $sno++;
            $row = array();
            $row['sno']         = $sno;
            $lname = (($obj->lname) ? " " . $obj->lname : '');
            $row['fullname']       = $obj->fname . $lname;
            $row['email']       = $obj->email;
            $row['message']     = $obj->message;
            $row['ip_address']  = $obj->ip_address;
            $row['created']     = $obj->created;
        
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw'])?$_POST['draw']:'',
            "recordsTotal" => $this->Query_model->count_all('ec_enquiry'),
            "recordsFiltered" => $this->Query_model->count_filtered('ec_enquiry'),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
