<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
	    //$this->load->model('Vendor_model');
		$this->load->model('Posts_model'); 
        $this->TYPE = $this->session->userdata('type');
		
	}
	
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
		$crumbs = array("Home" => "/$this->TYPE/dashboard", "Posts" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
		//echo "<pre>"; print_r($data); echo "</pre>";die;
        $this->load->template("$this->TYPE/posts/index_post",$data);
	}
	
	public function get_slug($string){
        $string = trim($string);
        $string = strtolower($string);
        $string = str_replace(' ', '-', $string);
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '', $string);
        return $slug;
    }  
	
	public function index_ajax_post()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
        $list = $this->Posts_model->get_datatable();
		
        $data = array();
        foreach ($list as $obj) {
            $row = array();
			$row['post_id']   = $obj->post_id;
			$row['post_title']   = $obj->post_title;
            $row['user_id']      = $obj->user_id;
			$row['comment']      = '-';
			$row['date']     	 = $obj->modified;
			$row['status']       = $obj->enabled;			
            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Posts_model->count_all(),
                "recordsFiltered" => $this->Posts_model->count_filtered(),
                "data" => $data,
                );
		//	echo "<pre>"; print_r( $data); echo "</pre>";die;
        echo json_encode($output);
    }
		
	public function add()
    {	
		if(!logged_in()) redirect("$this->TYPE/auth/login");
        $this->post();
    }

	public function update($post_id)
    {
        if(!logged_in()) redirect("$this->TYPE/auth/login");
		$this->post($post_id);
    }

	function post($post_id = NULL)
    {
		$data =array();	
		$data = $this->input->post();
		$user = $this->session->userdata();		
		$current_id =$user['admin']['login_id'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('post_title', 'Post Title', 'trim|required');        
		
        if(isset($post_id)){
			
            $post_obj = $this->Query_model->get_data_obj('ec_posts',array('post_id' => $post_id, 'enabled' => '1')); 
			
            if(!$post_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/posts");
            }
        }

        if($_POST) {
			
            $data =  array(
				   'post_title'          => $data['post_title'],
				   'post_slug'         	 => $this->get_slug( $data['post_title'] ),
				   'post_content'        => $data['post_content'],
				   //'featured_image' 	=> $this->input->post('featured_image'),
				   'enabled'             => $data['enabled']				   
                );
        }else{
            if(isset($post_id)){
				
                $data =  array(
				   'post_title'         => $post_obj->post_title,
				   'post_slug'          => $this->get_slug($post_obj->post_slug),
				   'post_content'       => $post_obj->post_content,
				   'featured_image'   	=>$post_obj->featured_image,
				   'enabled'         	=> $post_obj->enabled						   
                );				
            }
        }
		
        if ($this->form_validation->run() == FALSE){

            $action_bc = isset($post_id) ? 'Update' : 'Add';	
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Posts" => "/$this->TYPE/posts/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;
            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($post_id) ? 'update' : 'add';
            $data['post_id'] = isset($post_id) ? $post_id : NULL;
            $this->load->template("$this->TYPE/posts/post_form",$data);
        }else{
			
            if($_FILES['featured_image']['name']){
			
			
            $file_name = $_FILES['featured_image']['name'];
			$fileSize = $_FILES["featured_image"]["size"]/1024;
			$fileType = $_FILES["featured_image"]["type"];
			$new_file_name='';
            $new_file_name .= substr($data['post_title'],0,3).time(); 

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "800",
                'max_width' => "800"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);  
            if (!$this->upload->do_upload('featured_image')) {
               // echo $this->upload->display_errors();
				$this->session->set_flashdata('formdata','Filetype is not allowed or uplaod file size 2MB');
				//redirect('payment/add_payment','refresh');
				 redirect("$this->TYPE/page",'refresh');
				
			}
			
			$path = $this->upload->data();
			$img_url = $path['file_name'];
			
			$db_data =  array(
				'post_title'       => $data['post_title'],
				'post_slug'        => $this->get_slug( $data['post_title'] ),
				'post_content'     => $data['post_content'],
				'featured_image'   => $img_url,
				'post_type'        => 'page',
				'enabled'          => $data['enabled'],
				'user_id'          => $current_id
            );		
		
		}else{ 
			$db_data =  array(
				'post_title'       => $data['post_title'],
				'post_slug'        => $this->get_slug( $data['post_title'] ),
				'post_content'     => $data['post_content'],
				'post_type'        => 'posts',
				'enabled'          => $data['enabled'],
				'user_id'          => $current_id
            );
		}	
		//echo "<pre>"; print_r($db_data); echo "</pre>";die;
            if(isset($post_id)){
               $this->Query_model->update_data('ec_posts',$db_data,array('post_id' => $post_id));
               $this->session->set_flashdata('success', 'Updated Successfully.');
            }else{			
               $this->Query_model->insert_data('ec_posts',$db_data);
               $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/posts");
        }
	}
	

}
