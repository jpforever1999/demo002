<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
	    $this->load->model('Tax_model');
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
        $this->FNAME = $this->session->userdata($this->TYPE)['fname'];
	}
	
	public function index()
    {
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Tax" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
        $this->load->template("$this->TYPE/tax/index_tax",$data);
	}

    public function index_ajax_tax()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
        $list = $this->Tax_model->get_datatable();
        $data = array();
        foreach ($list as $obj) {
            $row = array();
            $row['tax_id']      = $obj->tax_id;
            $row['name']        = $obj->name;
            $row['rate']        = $obj->rate;
            $row['type']        = $type_array[$obj->type];
            $row['status']      = ($obj->status) ? 'Active' : 'InActive';

            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Tax_model->count_all(),
                "recordsFiltered" => $this->Tax_model->count_filtered(),
                "data" => $data,
                );
    
        echo json_encode($output);
    }

	public function add()
    {
        $this->post();
    }

	public function update($tax_id)
    {
        $this->post($tax_id);
    }

	function post($tax_id = NULL)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('rate', 'Tax', 'trim|required');
        $this->form_validation->set_rules('type', 'Tax Type', 'trim|required');

        if(isset($tax_id)){
            $tax_obj = $this->Query_model->get_data_obj('ec_tax',array('tax_id' => $tax_id, 'login_id' => $this->LOGIN_ID));
            if(!$tax_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/tax");
            }
        }

        if($_POST) {
            $data =  array(
                    'name'          => $this->input->post('name'),
                    'description'   => $this->input->post('description'),
                    'rate'          => $this->input->post('rate'),
                    'type'          => $this->input->post('type'),
                    'status'        => $this->input->post('status'),
                );
        }else{
            if(isset($tax_id)){
                $data =  array(
                    'name'          => $tax_obj->name,
                    'description'   => $tax_obj->description,
                    'rate'          => $tax_obj->rate,
                    'type'          => $tax_obj->type,
                    'status'        => $tax_obj->status,
                );
            }
        }

        if ($this->form_validation->run() == FALSE){
            $action_bc = isset($tax_id) ? 'Update' : 'Add';
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Tax" => "/$this->TYPE/tax/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($tax_id) ? 'update' : 'add';
            $data['tax_id'] = isset($tax_id) ? $tax_id : NULL;
            $this->load->template("$this->TYPE/tax/tax",$data);
        }else{
            $data['status'] = ($data['status']) ? $data['status'] : '0';
            $db_data =  array(
                'name'          => $data['name'],
                'description'   => $data['description'],
                'rate'          => $data['rate'],
                'type'          => $data['type'],
                'status'        => $data['status'],
                'login_id'      => $this->LOGIN_ID,
            );
            if(isset($tax_id)){
                $this->Query_model->update_data('ec_tax',$db_data,array('tax_id' => $tax_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');
            }else{
                $this->Query_model->insert_data('ec_tax',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/tax");
        }
	}
}
