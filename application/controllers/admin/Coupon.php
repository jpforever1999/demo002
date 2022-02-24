<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
	    $this->load->model('Coupon_model');
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
        $this->FNAME = $this->session->userdata($this->TYPE)['fname'];
	}
	
	public function index()
    {
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Coupon" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
        $this->load->template("$this->TYPE/coupon/index_coupon",$data);
	}

    public function index_ajax_coupon()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
        $list = $this->Coupon_model->get_datatable();
        $data = array();
        foreach ($list as $obj) {
            $row = array();
            $row['coupon_id']   = $obj->coupon_id;
            $row['name']        = $obj->name;
            $row['discount']    = $obj->discount;
            $row['type']        = $type_array[$obj->type];
            $row['start_date']  = date("d-M-Y", strtotime($obj->start_date));
            $row['end_date']    = date("d-M-Y", strtotime($obj->end_date));
            $row['status']  = ($obj->status) ? 'Active' : 'InActive';

            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Coupon_model->count_all(),
                "recordsFiltered" => $this->Coupon_model->count_filtered(),
                "data" => $data,
                );
    
        echo json_encode($output);
    }

	public function add()
    {
        $this->post();
    }

	public function update($coupon_id)
    {
        $this->post($coupon_id);
    }

	function post($coupon_id = NULL)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('discount', 'Discount', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
        $this->form_validation->set_rules('type', 'Discount Type', 'trim|required');

        if(isset($coupon_id)){
            $coupon_obj = $this->Query_model->get_data_obj('ec_coupon',array('coupon_id' => $coupon_id, 'login_id' => $this->LOGIN_ID));
            if(!$coupon_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/coupon");
            }
        }

        if($_POST) {
            $data =  array(
                    'name'          => $this->input->post('name'),
                    'description'   => $this->input->post('description'),
                    'discount'      => $this->input->post('discount'),
                    'start_date'    => $this->input->post('start_date'),
                    'end_date'      => $this->input->post('end_date'),
                    'type'          => $this->input->post('type'),
                    'status'        => $this->input->post('status'),
                );
        }else{
            if(isset($coupon_id)){
                $data =  array(
                    'name'          => $coupon_obj->name,
                    'description'   => $coupon_obj->description,
                    'discount'      => $coupon_obj->discount,
                    'start_date'    => $coupon_obj->start_date,
                    'end_date'      => $coupon_obj->end_date,
                    'type'          => $coupon_obj->type,
                    'status'        => $coupon_obj->status,
                );
            }
        }

        if ($this->form_validation->run() == FALSE){
            $action_bc = isset($coupon_id) ? 'Update' : 'Add';
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Coupon" => "/$this->TYPE/coupon/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($coupon_id) ? 'update' : 'add';
            $data['coupon_id'] = isset($coupon_id) ? $coupon_id : NULL;
            $this->load->template("$this->TYPE/coupon/coupon",$data);
        }else{
            $data['status'] = ($data['status']) ? $data['status'] : '0';
            $db_data =  array(
                'name'          => $data['name'],
                'description'   => $data['description'],
                'discount'      => $data['discount'],
                'start_date'    => $data['start_date'],
                'end_date'      => $data['end_date'],
                'type'          => $data['type'],
                'status'        => $data['status'],
                'login_id'      => $this->LOGIN_ID,
            );
            if(isset($coupon_id)){
                $this->Query_model->update_data('ec_coupon',$db_data,array('coupon_id' => $coupon_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');
            }else{
                $this->Query_model->insert_data('ec_coupon',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/coupon");
        }
	}
}
