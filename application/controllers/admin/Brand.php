<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
	    $this->load->model('Brand_model');
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
        $this->FNAME = $this->session->userdata($this->TYPE)['fname'];
	}
	
	public function index()
    {
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Brand" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
        $this->load->template("$this->TYPE/brand/index_brand",$data);
	}

    public function index_ajax_brand()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
        $list = $this->Brand_model->get_datatable();
        $data = array();
        foreach ($list as $obj) {
            $row = array();
            $row['brand_id']   = $obj->brand_id;
            $row['name']        = $obj->name;
            $row['discount']    = $obj->discount;
            $row['image']       = $obj->image;
            $row['type']        = $type_array[$obj->type];
            $row['start_date']  = date("d-M-Y", strtotime($obj->start_date));
            $row['end_date']    = date("d-M-Y", strtotime($obj->end_date));
            $row['status']      = ($obj->status) ? 'Active' : 'InActive';

            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Brand_model->count_all(),
                "recordsFiltered" => $this->Brand_model->count_filtered(),
                "data" => $data,
                );
    
        echo json_encode($output);
    }

	public function add()
    {
        $this->post();
    }

	public function update($brand_id)
    {
        $this->post($brand_id);
    }

	function post($brand_id = NULL)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        #$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
        #$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        #$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
        #$this->form_validation->set_rules('type', 'Discount Type', 'trim|required');

        if(isset($brand_id)){
            $brand_obj = $this->Query_model->get_data_obj('ec_brand',array('brand_id' => $brand_id));
            if(!$brand_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/brand");
            }
        }

        if($_POST) {
            $data =  array(
                    'name'          => $this->input->post('name'),
                    'description'   => $this->input->post('description'),
                    'image'         => $this->input->post('image'),
                    'status'        => $this->input->post('status'),
                );
        }else{
            if(isset($brand_id)){
                $data =  array(
                    'name'          => $brand_obj->name,
                    'description'   => $brand_obj->description,
                    'image'         => $brand_obj->image,
                    'status'        => $brand_obj->status,
                );
            }
        }

        if ($this->form_validation->run() == FALSE){
            $action_bc = isset($brand_id) ? 'Update' : 'Add';
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Brand" => "/$this->TYPE/brand/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($brand_id) ? 'update' : 'add';
            $data['brand_id'] = isset($brand_id) ? $brand_id : NULL;
            $this->load->template("$this->TYPE/brand/brand",$data);
        }else{
            $data['status'] = ($data['status']) ? $data['status'] : '0';
            $image = NULL;
            if($_FILES['image']['name']){
                $image_name = $_FILES['image']['name'];
                $fileSize = $_FILES["image"]["size"]/1024;
                $fileType = $_FILES["image"]["type"];
                $new_file = '';
                $t=time();
                $new_file =  $t.'_'.preg_replace( "/[^a-z0-9\._]+/", "-", strtolower($image_name) );
                $config = array(
                        'file_name' => $new_file,
                        'upload_path' => "./assets/brand",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => False,
                        //'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        //'max_height' => "600",
                        //'max_width' => "600"
                        );
                $this->load->library('Upload', $config);

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('image')) {
                    echo $this->upload->display_errors();
                }
                $image_img = $this->upload->data();
                $image = $image_img['file_name'];
            }
            $db_data =  array(
                'name'          => $data['name'],
                'description'   => $data['description'],
                'image'         => $image,
                'status'        => $data['status'],
                'login_id'      => $this->LOGIN_ID,
            );
            if(isset($brand_id)){
                $this->Query_model->update_data('ec_brand',$db_data,array('brand_id' => $brand_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');
            }else{
                $this->Query_model->insert_data('ec_brand',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/brand");
        }
	}
}
