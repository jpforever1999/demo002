<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_prod extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Query_model');
        $this->load->model('Category_prod_model');
        $this->TYPE = $this->session->userdata('type');		
    }

    public function index(){
        if(!logged_in()) redirect("$this->TYPE/auth/login");
        $data = array();
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "category" => ""); 
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();		
        $this->load->template("$this->TYPE/categories_prod/index",$data); 	
    }

    public function index_ajax_cat()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
        $list = $this->Category_prod_model->get_datatable();

        $data = array();
        foreach ($list as $obj) {
            $row = array();
            $row['id']   	= $obj->id;
            $row['name']   	= $obj->name;
            $row['slug']   	= $obj->slug;						
            $row['status']  = ($obj->status) ? 'Active' : 'InActive';
            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Category_prod_model->count_all(),
                "recordsFiltered" => $this->Category_prod_model->count_filtered(),
                "data" => $data,
                );		
        echo json_encode($output);
    }

    public function add(){
        if(!logged_in()) redirect("$this->TYPE/auth/login");
        $data = array();
        $data['admin'] = 1;

        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Category" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        #$this->form_validation->set_rules('slug', 'Slug', 'trim|required|is_unique[ec_categories_prod.slug]');
        $this->form_validation->set_rules('status', 'status', 'required');

        if($this->form_validation->run() == true){
            $t=time();
            if($_FILES['thumbnail_image']['name']){				
                $file_name = $_FILES['thumbnail_image']['name'];
                $fileSize = $_FILES["thumbnail_image"]["size"]/1024;
                $fileType = $_FILES["thumbnail_image"]["type"];
                $new_file = '';
                $new_file =  $t.'_'.preg_replace( "/[^a-z0-9\._]+/", "-", strtolower($file_name) );
                $config = array(
                        'file_name' => $new_file,
                        'upload_path' => "./assets/categories",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => False,
                        //'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        //'max_height' => "600",
                        //'max_width' => "600"
                        );
                $this->load->library('Upload', $config);
                $this->upload->initialize($config);     
                if (!$this->upload->do_upload('thumbnail_image')) {
                    echo $this->upload->display_errors();
                }
                $thumbnail = $this->upload->data();
                $thumbnail_img = $thumbnail['file_name'];
            }

            if($_FILES['icon']['name']){				
                $icon_name = $_FILES['icon']['name'];
                $fileSize = $_FILES["icon"]["size"]/1024;
                $fileType = $_FILES["icon"]["type"];
                $new_file = '';
                $new_file =  $t.'_'.preg_replace( "/[^a-z0-9\._]+/", "-", strtolower($icon_name) );	
                $config = array(
                        'file_name' => $new_file,
                        'upload_path' => "./assets/categories",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => False,
                        //'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        //'max_height' => "600",
                        //'max_width' => "600"
                        );
                $this->load->library('Upload', $config);

                $this->upload->initialize($config);     
                if (!$this->upload->do_upload('icon')) {
                    echo $this->upload->display_errors();
                }
                $icon_img = $this->upload->data();
                $icon = $icon_img['file_name'];
            }
    
            $parent_id = ($this->input->post('parent_id')) ? $this->input->post('parent_id') : 0;
            $category = array(
                    'name' => $this->input->post('name'),
                    'status' => $this->input->post('status'),
                    'parent_id' => $parent_id,
                    );

            if(isset($_FILES['thumbnail_image']['name']) && $_FILES['thumbnail_image']['name']!=''){
                $category['thumbnail'] = isset($thumbnail_img)?$thumbnail_img:'';
            }
            if(isset($_FILES['icon']['name'])  && $_FILES['icon']['name']!='' ){
                $category['icon'] = isset($icon)? $icon:'';
            }

            $this->Category_prod_model->create($category);

            $this->session->set_flashdata('message',message_box('Category has been saved','success'));
            redirect("$this->TYPE/categories_prod");
        }

        $cat_array = array();
        $cat_obj = $this->Query_model->get_data('ec_categories_prod', array('status' => 1));
        if($cat_obj){
            foreach($cat_obj as $row){
                $cat_array[$row->id] = $row->name;
            }
        }
        $data['cat_array'] = $cat_array;
        $this->load->template("$this->TYPE/categories_prod/add",$data); 	
    }

    public function update($id = null){
        if(!logged_in()) redirect("$this->TYPE/auth/login");

        $data = array();
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Category" => ""); 
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;

        $data['admin'] = 1;                
        if($id == null){
            $id = $this->input->post('id');
        }
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if($this->form_validation->run() == true){
            $t=time();
            if($_FILES['thumbnail_image']['name']){				
                $file_name = $_FILES['thumbnail_image']['name'];
                $fileSize = $_FILES["thumbnail_image"]["size"]/1024;
                $fileType = $_FILES["thumbnail_image"]["type"];
                $thumbnail_file = '';
                $thumbnail_file =  $t.'_'.preg_replace( "/[^a-z0-9\._]+/", "-", strtolower($file_name) );
                $config = array(
                        'file_name' => $thumbnail_file,
                        'upload_path' => "./assets/categories",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => False,
                        //'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        //'max_height' => "600",
                        //'max_width' => "600"
                        );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);  								
                if (!$this->upload->do_upload('thumbnail_image')) {
                    echo $this->upload->display_errors();					
                }				
                $thumbnail = $this->upload->data();
                $thumbnail_img = $thumbnail['file_name'];
            }

            if($_FILES['icon']['name']){				
                $icon_name = $_FILES['icon']['name'];
                $fileSize = $_FILES["icon"]["size"]/1024;
                $fileType = $_FILES["icon"]["type"];
                $icon_file = '';
                $icon_file =  $t.'_'.preg_replace( "/[^a-z0-9\._]+/", "-", strtolower($icon_name) );	
                $config = array(
                        'file_name' => $icon_file,
                        'upload_path' => "./assets/categories",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => False,
                        //'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        //'max_height' => "600",
                        //'max_width' => "600"
                        );
                $this->load->library('Upload', $config);				
                $this->upload->initialize($config);     
                if (!$this->upload->do_upload('icon')) {
                    echo $this->upload->display_errors();
                }
                $icon_img = $this->upload->data();
                $icon = $icon_img['file_name'];
            }

            $parent_id = ($this->input->post('parent_id')) ? $this->input->post('parent_id') : 0;
            $category = array(
                    'name' => $this->input->post('name'),
                    'status' => $this->input->post('status'),
                    'parent_id' => $parent_id,
                    );

            if(isset($_FILES['thumbnail_image']['name']) && $_FILES['thumbnail_image']['name']!=''){
                $category['thumbnail'] = isset($thumbnail_img)?$thumbnail_img:'';
            }
            if(isset($_FILES['icon']['name'])  && $_FILES['icon']['name']!='' ){
                $category['icon'] = isset($icon)? $icon:'';
            }

            $this->Category_prod_model->update($category, $id);
            $this->session->set_flashdata('message',message_box('Category has been saved','success'));
            redirect("$this->TYPE/categories_prod");
        }

        $data['category'] = $this->Category_prod_model->find_by_id($id);
        $cat_array = array();
        $cat_obj = $this->Query_model->get_data('ec_categories_prod', array('status' => 1));
        if($cat_obj){
            foreach($cat_obj as $row){
                $cat_array[$row->id] = $row->name;
            }
        }
        $data['cat_array'] = $cat_array;
        $this->load->template("$this->TYPE/categories_prod/edit", $data);

    }

    public function delete($id = null){
        if(!logged_in()) redirect("$this->TYPE/auth/login");
        if(!empty($id)){
            $this->Category_prod_model->delete($id);
            $this->session->set_flashdata('message',message_box('Category has been deleted','success'));
            redirect("$this->TYPE/categories_prod");
        }else{
            $this->session->set_flashdata('message',message_box('Invalid id','danger'));
            redirect("$this->TYPE/categories_prod");
        }
    }
}
