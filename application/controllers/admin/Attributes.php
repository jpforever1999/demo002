<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributes extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
	    $this->load->model('Attribute_model');
	    $this->load->model('Attribute_item_model');
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
        $this->FNAME = $this->session->userdata($this->TYPE)['fname'];
	}
	
	public function index()
    {
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Attributes" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
        $data['language_array'] = get_language();
        $this->load->template("$this->TYPE/attribute/index_attribute",$data);
	}

    public function index_ajax_attributes()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $list = $this->Attribute_model->get_datatable();
        $data = array();
        foreach ($list as $obj) {
            $row = array();
            #$item_obj = $this->Query_model->get_data('ec_attribute_item',array('attribute_id' => $obj->attribute_id, 'status' => array('0','1'), 'login_id' => $this->LOGIN_ID));
            $item_obj = $this->Query_model->get_data('ec_attribute_item',array('attribute_id' => $obj->attribute_id, 'status' => array('0','1')));
            $item_str = '';
            if($item_obj){
                foreach($item_obj as $it){
                    $item_str.= "<a href=\"/admin/attributes/update_attribute_item/$obj->attribute_id/$it->attribute_item_id\" target=\"_blank\">$it->name</a>&nbsp;&nbsp;";
                }
            }
            $item_str.= "<br><a href=\"/admin/attributes/add_attribute_item/$obj->attribute_id\" target=\"_blank\"  class=\"table_btn_add\">Add</a>";
            $row['attribute_id']= $obj->attribute_id;
            $row['name']        = $obj->name;
            $row['slug']        = $obj->slug;
            $row['item']        = $item_str;
            $row['status']      = ($obj->status) ? 'Active' : 'InActive';

            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Attribute_model->count_all(),
                "recordsFiltered" => $this->Attribute_model->count_filtered(),
                "data" => $data,
                );
    
        echo json_encode($output);
    }

	public function add()
    {
        $this->post();
    }

	public function update($attribute_id)
    {
        $this->post($attribute_id);
    }

	function post($attribute_id = NULL)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required|callback_unique_attribute['.$attribute_id.']');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if(isset($attribute_id)){
            #$attributes_obj = $this->Query_model->get_data_obj('ec_attribute',array('attribute_id' => $attribute_id, 'login_id' => $this->LOGIN_ID));
            $attributes_obj = $this->Query_model->get_data_obj('ec_attribute',array('attribute_id' => $attribute_id));
            if(!$attributes_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/attributes");
            }
        }

        if($_POST) {
            $data =  array(
                    'name'          => $this->input->post('name'),
                    'slug'          => $this->input->post('slug'),
                    'description'   => $this->input->post('description'),
                    'status'        => $this->input->post('status'),
                );
        }else{
            if(isset($attribute_id)){
                $data =  array(
                    'name'          => $attributes_obj->name,
                    'slug'          => $attributes_obj->slug,
                    'description'   => $attributes_obj->description,
                    'status'        => $attributes_obj->status,
                );
            }
        }

        if ($this->form_validation->run() == FALSE){
            $action_bc = isset($attribute_id) ? 'Update' : 'Add';
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Attributes" => "/$this->TYPE/attributes", "$action_bc" => "action");
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['status'] = isset($data['status']) ? $data['status'] : '1';
            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($attribute_id) ? 'update' : 'add';
            $data['attribute_id'] = isset($attribute_id) ? $attribute_id : NULL;
            $data['language_array'] = get_language();
            $this->load->template("$this->TYPE/attribute/attributes",$data);
        }else{
            $db_data =  array(
                'name'          => $data['name'],
                'slug'          => $data['slug'],
                'description'   => $data['description'],
                'status'        => $data['status'],
                'login_id'      => $this->LOGIN_ID,
            );
            $db_data = array_map('trim', $db_data);
            if(isset($attribute_id)){
                $this->Query_model->update_data('ec_attribute',$db_data,array('attribute_id' => $attribute_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');
            }else{
                $this->Query_model->insert_data('ec_attribute',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/attributes");
        }
	}

    function unique_attribute($value, $attribute_id)
    {
        $slug = $this->input->post('slug');
        $slug = trim($slug);

        if($attribute_id){
            $response = $this->Query_model->get_data_obj('ec_attribute', array('attribute_id!=' => $attribute_id, 'slug' => $slug, 'status' => array('0','1')));
        }else{
            $response = $this->Query_model->get_data_obj('ec_attribute', array('slug' => $slug, 'status' => array('0','1')));
        }
        $status   = TRUE;
        $message  = '';

        if($response) {
            $status   = FALSE;
            $message  = 'Attribute already exists <br/>';
        }

        if(!$status) {

            $this->form_validation->set_message('unique_attribute', $message);
        }
        return $status;
    }

	public function index_attribute_item($attribute_id = NULL)
    {
        if(isset($attribute_id)){
            $attributes_obj = $this->Query_model->get_data_obj('ec_attribute',array('attribute_id' => $attribute_id, 'status' => '1'));
            if(!$attributes_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/attributes");
            }
        }else{
            $this->session->set_flashdata('error', 'Invalid Error.');
            redirect("$this->TYPE/attributes");
        }

        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Attributes" => "/$this->TYPE/attributes", 'Items' => '');
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
        $data['attribute_id'] = $attribute_id;
        $this->load->template("$this->TYPE/attribute/index_attribute_item",$data);
	}

    public function index_ajax_attribute_item()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $list = $this->Attribute_item_model->get_datatable();
        $data = array();
        foreach ($list as $obj) {
            $row = array();
            $row['attribute_id']        = $obj->attribute_id;
            $row['attribute_item_id']   = $obj->attribute_item_id;
            $row['name']                = $obj->name;
            $row['slug']                = $obj->slug;

            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Attribute_item_model->count_all(),
                "recordsFiltered" => $this->Attribute_item_model->count_filtered(),
                "data" => $data,
                );
    
        echo json_encode($output);
    }

	public function add_attribute_item($attribute_id = NULL)
    {
        $args = array('attribute_id' => $attribute_id, 'attribute_item_id' => NULL, 'action' => 'add_attribute_item');
        $this->post_attribute_item($args);
    }

	public function update_attribute_item($attribute_id = NULL,$attribute_item_id = NULL)
    {
        $args = array('attribute_id' => $attribute_id, 'attribute_item_id' => $attribute_item_id, 'action' => 'update_attribute_item');
        $this->post_attribute_item($args);
    }

	function post_attribute_item($args)
    {
        $attribute_id = $args['attribute_id'];
        $attribute_item_id = $args['attribute_item_id'];
        $action = $args['action'];
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required|callback_unique_attribute_item['.$attribute_item_id.']');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if($attribute_id){
            #$attributes_obj = $this->Query_model->get_data_obj('ec_attribute',array('attribute_id' => $attribute_id, 'login_id' => $this->LOGIN_ID));
            $attributes_obj = $this->Query_model->get_data_obj('ec_attribute',array('attribute_id' => $attribute_id));
            if(!$attributes_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/attributes");
            }
        }

        if($attribute_item_id){
            #$attribute_item_obj = $this->Query_model->get_data_obj('ec_attribute_item',array('attribute_item_id' => $attribute_item_id, 'login_id' => $this->LOGIN_ID));
            $attribute_item_obj = $this->Query_model->get_data_obj('ec_attribute_item',array('attribute_item_id' => $attribute_item_id));
            if(!$attribute_item_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/attributes");
            }
        }

        if($_POST) {
            $data =  array(
                    'name'          => $this->input->post('name'),
                    'slug'          => $this->input->post('slug'),
                    'description'   => $this->input->post('description'),
                    'status'        => $this->input->post('status'),
                );
        }else{
            if($attribute_item_id){
                $data =  array(
                    'name'          => $attribute_item_obj->name,
                    'slug'          => $attribute_item_obj->slug,
                    'description'   => $attribute_item_obj->description,
                    'status'        => $attribute_item_obj->status,
                );
            }
        }

        if ($this->form_validation->run() == FALSE){
            $action_bc = ($attribute_item_id) ? 'Update' : 'Add';
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Attributes" => "/$this->TYPE/attributes", "$action_bc" => "Add");
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['status'] = isset($data['status']) ? $data['status'] : '1';
            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = $action;
            $data['attribute_id'] = $attribute_id;
            $data['attribute_item_id'] = $attribute_item_id;
            $this->load->template("$this->TYPE/attribute/attribute_item",$data);
        }else{
            $db_data =  array(
                'name'          => $data['name'],
                'slug'          => $data['slug'],
                'description'   => $data['description'],
                'attribute_id'  => $attribute_id,
                'status'        => $data['status'],
                'login_id'      => $this->LOGIN_ID,
            );
            $db_data = array_map('trim', $db_data);
            if($attribute_item_id){
                $this->Query_model->update_data('ec_attribute_item',$db_data,array('attribute_item_id' => $attribute_item_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');
            }else{
                $this->Query_model->insert_data('ec_attribute_item',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/attributes");
        }
	}

    function unique_attribute_item($value, $attribute_item_id)
    {
        $slug = $this->input->post('slug');
        $slug = trim($slug);

        if($attribute_item_id){
            $response = $this->Query_model->get_data_obj('ec_attribute_item', array('attribute_item_id!=' => $attribute_item_id, 'slug' => $slug, 'status' => array('0','1')));
        }else{
            $response = $this->Query_model->get_data_obj('ec_attribute_item', array('slug' => $slug, 'status' => array('0','1')));
        }
        $status   = TRUE;
        $message  = '';

        if($response) {
            $status   = FALSE;
            $message  = 'Attribute Item already exists <br/>';
        }

        if(!$status) {

            $this->form_validation->set_message('unique_attribute_item', $message);
        }
        return $status;
    }
}
