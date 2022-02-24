<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
		$this->load->model('Page_model'); 
        $this->TYPE = $this->session->userdata('type');
		
	}
	
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
	   $crumbs = array("Home" => "/$this->TYPE/dashboard", "Page" => ""); 
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();
		//echo "<pre>"; print_r($data); echo "</pre>";die;
        $this->load->template("$this->TYPE/page/index_post",$data);
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
        $list = $this->Page_model->get_datatable();
		
        $data = array();
        foreach ($list as $obj) {
            $row = array();
			$author = $this->Query_model->get_author($obj->user_id);
			$autho_name = !empty($author->fname) ? $author->fname : $author->admin_uid;
			$row['page_id']   = $obj->page_id;
			//$row['post_title']   = $obj->post_title;
			$row['post_title']   = '<a href="/page/'.$obj->post_slug.'">'.$obj->post_title.'</a>';
			$row['user_id']      = $autho_name;
			$row['comment']      = '-';
			$row['date']     	 = $obj->modified;
			$row['status']       = $obj->enabled;			
            $data[] = $row;
        }
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Page_model->count_all(),
                "recordsFiltered" => $this->Page_model->count_filtered(),
                "data" => $data,
                );		
        echo json_encode($output);
    }
		
	public function add()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");       
	   $this->post();
    }

	public function update($page_id)
    {
        if(!logged_in()) redirect("$this->TYPE/auth/login");
		$this->post($page_id);
    }

	function post($page_id = NULL)
    {
		$data =array();	
		$data = $this->input->post();
		$user = $this->session->userdata();	
		//echo "<pre>"; print_r( $_FILE);	echo "</pre>"; die;		
		$current_id =$user['admin']['login_id'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('post_title', 'Post Title', 'trim|required');        
		
        if(isset($page_id)){
			
            $page_obj = $this->Query_model->get_data_obj('ec_page',array('page_id' => $page_id, 'enabled' => '1')); 
			
            if(!$page_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/page");
            }
			
			if($_POST) {
					
				$db_data =  array(
						'post_title'        => $this->input->post('post_title'),
						'post_slug'         => $this->input->post('post_slug'),
						'post_content'  	=> $this->input->post('post_content'),
						//'featured_image' 	=> $this->input->post('featured_image'),
						'enabled'   		=> $this->input->post('enabled')
					);					
					
				}else{
					
					if(isset($page_obj)){
						$data =  array(
							'post_title'          => $page_obj->post_title,
							'post_slug'           => $page_obj->post_slug,
							'post_content'  	  => $page_obj->post_content,
							'featured_image'   	  => $page_obj->featured_image,
							'enabled'  			  => $page_obj->enabled
						);
					}
				}
		
			
		
        }
		
		
        if ($this->form_validation->run() == FALSE){

            $action_bc = isset($page_id) ? 'Update' : 'Add';	
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "Page" => "/$this->TYPE/page/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($page_id) ? 'update' : 'add';
            $data['page_id'] = isset($page_id) ? $page_id : NULL;			
			//echo $this->TYPE;die;			
            $this->load->template("$this->TYPE/page/post_form",$data);
			
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
				'post_type'        => 'page',
				'enabled'          => $data['enabled'],
				'user_id'          => $current_id
            );
			
		}
			
            if(isset($page_id)){						
                $this->Query_model->update_data('ec_page',$db_data,array('page_id' => $page_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');			
				
            }else{
				
                $this->Query_model->insert_data('ec_page',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');
            }
            redirect("$this->TYPE/page");
        }
	}
	
	public function del()
    {

		$data['csrf'] = csrf_token();
	    $id = $this->input->post('id');
		$data['csrf'] = csrf_token();
        $data = array();
        $delete = $this->Page_model->delete_post($id);
        echo json_encode(array('success' => $delete));
		
    }

}
