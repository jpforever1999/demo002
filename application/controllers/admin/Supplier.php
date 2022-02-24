<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');	
		$this->load->model('User_model'); 
        $this->TYPE = $this->session->userdata('type');		
	}
	
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
	    $crumbs = array("Home" => "/$this->TYPE/dashboard", "Supplier" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
		$data['page_count'] = page_count();			
		$this->load->template("$this->TYPE/supplier/index_post",$data);
		
	}
	
	public function index_ajax_post()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
		$type_status = array(1 => 'active', 0 => 'inactive');		
        $list = $this->User_model->get_supplier();		
		
		$last_order_date ='-';
        $data = array();
        foreach ($list as $obj) {					
			$supplier_id = $obj->supplier_id;							
			$address = isset($obj->address) ? $obj->address :'-';	
			$mobile = isset($obj->mobile) ? $obj->mobile :'-';
			$email = isset($obj->email) ? $obj->email :'-';	
			$city = isset($obj->city) ? $obj->city :'-';
			$cname = isset($obj->cname) ? $obj->cname :'-';						
			if (array_key_exists($obj->status, $type_status)) {
			  $st = $type_status[$obj->status];
			}						
            $row = array();
			$row['supplier_id']   		= $obj->supplier_id;
			$row['cname']   			= $cname;
			$row['city']   				= $city;
            $row['address']      		= $address;
			$row['email']    			= $email;
			$row['mobile']     			= $mobile;			
			$row['status']       		= $st;			
            $data[] 					= $row;
        }
		
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->User_model->supplier_count_all(),
                "recordsFiltered" => $this->User_model->supplier_count_filtered(),
                "data" => $data,
                );		
        echo json_encode($output);
    }
		
	public function add()
    {
        if(!logged_in()) redirect("$this->TYPE/auth/login");
		$this->post();
		
	}

	public function update($supplier_id)
    {
        if(!logged_in()) redirect("$this->TYPE/auth/login");
		$this->post($supplier_id);
    }

	function post($supplier_id = NULL)
    {
		$data =array();	
		$db_data =array();	
		$data = $this->input->post();	
		//echo "<pre>"; print_r($data);echo "</pre>";
		$user = $this->session->userdata();				
		$current_id =$user['admin']['login_id'];
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('cname', 'Company name', 'required|trim|xss_clean|is_unique[ec_supplier.cname]');$this->form_validation->set_rules('email', 'Email name', 'required|trim|xss_clean|is_unique[ec_supplier.email]');        
		//update
        if(isset($supplier_id)){
			
			$user_obj = $this->Query_model->get_data_obj('ec_supplier',array('supplier_id' => $supplier_id, 'status' => '1')); 			
			if(!$user_obj){
				$this->session->set_flashdata('error', 'Invalid Error.');
				redirect("$this->TYPE/supplier");
			}else{
				
				if($_POST) {
					 
					$data =  array(					
						
						'cname'     	  			=> $data['cname'],
						'description'      	  		=> $data['description'],
						'address'    		  		=> $data['address'],
						'city'     					=> $data['city'],
						'state'						=> $data['state'],				
						'zip_code'          		=> $data['zip_code'],
						'company_registration_no' 	=> $data['company_registration_no'],
						'fname'      				=> $data['fname'],
						'lname'     		  		=> $data['lname'],
						'email'     		  		=> $data['email'],
						'mobile'     		  		=> $data['mobile'],	
						'password'  			 	=> $data['password'],	
						'status'  			 		=> $data['status'],						
					
					);
					
				 }else{
					 
					$data =  array(	
						'cname'         	 		=> $user_obj->cname,
						'description'          	 	=> $user_obj->description,
						'address'  	 				=> $user_obj->address,
						'city'   					=> $user_obj->city,
						'state'   					=> $user_obj->state,
						'zip_code'         	 		=>$user_obj->zip_code,
						'company_registration_no'   => $user_obj->company_registration_no,
						'fname'   		 			=> $user_obj->fname,
						'lname'   			 		=> $user_obj->lname,
						'mobile'   			 		=> $user_obj->mobile,
						'email'   			 		=> $user_obj->email,
						'password'  			 		=> $user_obj->password,
						'status'  			 		=> $user_obj->status,
					);
				}
			}	
		}
		
		
		if ($this->form_validation->run() == FALSE){

            $action_bc = isset($supplier_id) ? 'Update' : 'Add';	
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "supplier" => "/$this->TYPE/supplier/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($supplier_id) ? 'update' : 'add';
            $data['supplier_id'] = isset($supplier_id) ? $supplier_id : NULL;	
            $this->load->template("$this->TYPE/supplier/post_form",$data);
			
        }else{		
		
			if($_FILES['logo']['name']){			
			
				$file_name = $_FILES['logo']['name'];
				$fileSize = $_FILES["logo"]["size"]/1024;
				$fileType = $_FILES["logo"]["type"];
				$new_file_name='';
				$new_file_name .= substr($data['fname'],0,3).time(); 

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
				if (!$this->upload->do_upload('logo')) {               
					$this->session->set_flashdata('formdata','Filetype is not allowed or uplaod file size 2MB');				
					 redirect("$this->TYPE/user",'refresh');				
				}
			
				$path = $this->upload->data();
				$img_url = $path['file_name'];				
				$data =  array(
					'logo'     	 		 	=> $img_url,
					'cname'     	  		=> $data['cname'],
					'description'      	  	=> $data['description'],
					'address'    		  	=> $data['address'],
					'city'     				=> $data['city'],
					'state'					=> $data['state'],				
					'zip_code'          	=> $data['zip_code'],
					'company_registration_no' => $data['company_registration_no'],
					'fname'      			=> $data['fname'],
					'lname'     		  	=> $data['lname'],
					'email'     		  	=> $data['email'],
					'mobile'     		  	=> $data['mobile'],				
					'password'     	  		=> md5($data['password']),
					'supplier_uid'			=> uniq_uid(),
				);		

			}else{ 
				 
				$data =  array(
					'cname'     	  					=> $data['cname'],
					'description'      	  				=> $data['description'],
					'address'    		  				=> $data['address'],
					'city'     							=> $data['city'],
					'state'								=> $data['state'],				
					'zip_code'         				 	=> $data['zip_code'],
					'company_registration_no'          	=> $data['company_registration_no'],
					'fname'      						=> $data['fname'],
					'lname'     		 				=> $data['lname'],
					'email'     		 				 => $data['email'],
					'mobile'     					  	=> $data['mobile'],				
					'password'     	  					=> md5($data['password']),
					'supplier_uid'						=>uniq_uid(),
				);
				
			}	
			
            if(isset($supplier_id)){	
				//echo "<pre>"; print_r($data); echo "<pre>";die;			
                $this->Query_model->update_data('ec_supplier',$data,array('supplier_id' => $supplier_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');			
				
            }else{			
				
                $insert_db = $this->Query_model->insert_data('ec_supplier',$data);
				if($insert_db){
					$this->session->set_flashdata('success', 'Inserted Successfully.');	
				}
                
            }
            redirect("$this->TYPE/supplier");
        }  
	}
	public function view()
    {
		$data = array();
		if ($this->uri->segment(4) === FALSE){
			$id = 0;
		}else{
			$id = $this->uri->segment(4);
		}		
		if(!logged_in()) redirect("$this->TYPE/auth/login");		
		$shipping_addr = array();$billing_addr = array();
		$crumbs = array("Home" => "/$this->TYPE/dashboard", "supplier" => "/$this->TYPE/supplier/");
		$breadcrumbs = $this->breadcrumbs->show($crumbs);
		$data['breadcrumbs']    = $breadcrumbs;

		$data['csrf'] = csrf_token();
		$data['TYPE'] = $this->TYPE;			
		$data['basic'] = $this->User_model->get_profile_supplier($id); 	
		$update = $this->load->template("$this->TYPE/supplier/view_profile",$data); 	
    }
	
	public function status_change(){

		$data['csrf'] = csrf_token();
	    $id = $this->input->post('id');
		$status = $this->input->post('status');
		if($status == 'active'){
			$status_val = 0;
		}elseif($status == 'inactive'){
			$status_val = 1;
		}		
		$data['csrf'] = csrf_token();
        $data = array();
        $update = $this->User_model->supplier_status_change($id,$status_val);
        echo json_encode(array('success' => $update));
		
    }
	
	public function del(){
		$data['csrf'] = csrf_token();
	    $id = $this->input->post('id');
		$data['csrf'] = csrf_token();
        $data = array();
        $delete = $this->User_model->delete_post($id);
        echo json_encode(array('success' => $delete));		
    }
	

}
