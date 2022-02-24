<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Admin_model');
        $this->TYPE = $this->session->userdata('type');
		
	}
	
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
	   $crumbs = array("Home" => "/$this->TYPE/dashboard", "Admin" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();		

        $this->load->template("$this->TYPE/admin/index",$data);
	}

    public function index_ajax_post()
    {
        $admin = $this->Admin_model->get_admin();

        $data = array();
        $sno = 0;
        foreach ($admin as $obj) {
            $sno++;
            $row = array();
            $row['sno']             = $sno;
            $row['fullname']        = $obj->fname;
            $row['email']           = $obj->email;
            $row['mobile']          = $obj->mobile;
            $row['superadmin']      = (($obj->super_admin) ? 'Yes' : 'No');
            $row['status']          = (($obj->status) ? 'Active' : 'InActive');
            $row['date_added']      = $obj->date_added;
            $row['last_updated']    = $obj->last_updated;
        
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw'])?$_POST['draw']:'',
            "recordsTotal" => $this->Admin_model->count_all('ec_admin'),
            "recordsFiltered" => $this->Admin_model->count_filtered('ec_admin'),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
