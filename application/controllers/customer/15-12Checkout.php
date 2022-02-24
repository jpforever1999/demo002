<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Checkout extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
		$this->load->model('Product_model');
        $this->load->helper('text');		
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

	## checkout page		
	public function index($arg=null) 
    {
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
		$crumbs = array("Home" => "/$this->TYPE/product/", "cart" => "/cart", "checkout" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
		
		if ($this->uri->segment(2) === FALSE)
		{
			$slug = 0;
		}
		else
		{
			$slug = $this->uri->segment(2);
		}
		
		$args = array('post_slug' => $slug,'enabled' => '1');		
		$data['detail'] = $this->Query_model->get_data_obj('ec_page',$args);	
        $this->load->template("$this->TYPE/checkout", $data);
    }
	public function ajaxCheckout()
    {
		$this->validation();		
		$data       	= array();
		$data_new		= array();				
        $data['TYPE'] 	= $this->TYPE;
        $data['csrf'] 	= csrf_token();
		$session_id = $_SESSION['__ci_last_regenerate'];
		$data = $this->input->post();
		$n = 2; 
		$otp = bin2hex(random_bytes($n)); 
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
		
        if ($this->form_validation->run() == FALSE){
			echo json_encode(array('msg' => validation_errors(), 'success' => 0));
        }else{
				
			$data_new = array(
				'email' 		=> $data['email_id'],					
				'otp'			=> $otp,
				'customer_uid'	=>$session_id.'_'.$otp,
				'user_id'	=>$session_id.'_'.$otp,
				);						
			$data_new = $this->security->xss_clean($data_new);
			$this->checkout(array('DATA' => $data_new));		
		
		}		
    }  
    
    public function validation()
    {
        $this->load->helper(array('form', 'url'));		
        $this->load->library('form_validation');		
        $this->form_validation->set_error_delimiters('<div>', '</div>');  
		$this->form_validation->set_rules('email','email', 'trim|xss_clean|is_unique[ec_customer.email]');                  
    }
 
    public function checkout($args)
    {	
		$data['error'] = false;
		$newdata = array();
        if(isset($args['DATA']) && $args['DATA'])
        {	
			//$emailid ='';
			//$email = $this->input->post('email_id');
			//if(isset($last_inserted_id+)){
				//$emailid = $this->Query_model->Does_email_exists($email);
			//}

			$email = $this->input->post('email_id');
			$otp = $this->input->post('otp');
		    $email_obj = $this->Query_model->get_data_obj('ec_customer', array('email' => $email));	
            #print_r($email_obj);
            if($otp)
            {
                if($otp == $email_obj->otp)
                {
                    echo json_encode(array('success'=>1, 'msg'=>'Successfully Login'));

                }
                else
                {
                    echo json_encode(array('success'=>1, 'msg'=>'OTP not matched'));
                }
                die();
            }
            if($email_obj)
            {
                echo json_encode(array('success'=>1, 'msg'=>'OTP Send to your emailid'));
                $otp = '1234';
                $update_status = $this->Query_model->update_data('ec_customer', array('otp' => $otp), array('customer_id' => $email_obj->customer_id));
                #if($update_status)
                #{
                #}
                
            }
            else
            {
                $last_inserted_id  =  $this->Query_model->insert_data('ec_customer',$args['DATA']);
            }
            
			
			$n = 2; 
			$otp = bin2hex(random_bytes($n));  
		
			$this->load->library('mailer');			
			$email = 'jpforever1999@gmail.com';
			$useremail = 'jpforever1999@gmail.com';
			$admin_email = 'jay@move2inbox.in';//admin@viralbake.com			
			$msg = '<p style="text-align:center;">Thanks you.opt='.$otp.'</p>';			
			$admin_msg = '<div style="text-align:center;"><p>'.$useremail.' has purchase product on klentano. <br ><br >Here is the submitted form data</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"><tr><td>Email</td><td>'.$email.'</td></tr><tr><td>Otp</td><td>'.$otp.'</td></tr></table></div>';
			
			#$this->mailer->smtp(array('SUBJECT' => 'Thank You purchase', 'EMAIL' => $useremail, 'CONTENT' => $msg));
			$this->mailer->smtp(array('SUBJECT' => 'Klentano purchase', 'EMAIL' => $admin_email, 'CONTENT' => $admin_msg));
		   
		  if(isset($last_inserted_id) && $last_inserted_id!='' )
            {
				$cart_item = cart_item_count();
                echo json_encode(array('msg' => 'Data added successfully', 'success' => 1, 'data' => array('cart_count' => $cart_item)));
            }
     
			
        }

    }
	
	/////otp check
	
	public function ajaxOtp()
    { 
		
		$this->otp_validation();		
		$data       	= array();
		$data_new		= array();				
        $data['TYPE'] 	= $this->TYPE;
        $data['csrf'] 	= csrf_token();		
		$data = $this->input->post();		
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
		
        if ($this->form_validation->run() == FALSE){
			echo json_encode(array('msg' => validation_errors(), 'success' => 0));
        }else{
			
			if($this->Product_model->Does_note_otp_exists($data['otp'])){
                echo json_encode(array('success' =>0, 'msg' => 'Otp Not match'));
                die();
            
			}else {						
			
			$data_new = array(						
					'mobile'=> 222						
				);					
			$data_new = $this->security->xss_clean($data_new);			
			$this->otpcheck(array('DATA' => $data_new));		
			} 
		}		
    }  
    
    public function otp_validation()
    {
        $this->load->helper(array('form', 'url'));		
        $this->load->library('form_validation');		
        $this->form_validation->set_error_delimiters('<div>', '</div>');  	             
        $this->form_validation->set_rules('otp',' OTP', 'trim|xss_clean');      
			
    }
 
    public function otpcheck($args)
    {	
		$data['error'] = false;
		$newdata = array();
        if(isset($args['DATA']) && $args['DATA'])
        {					
			$otp = $this->input->post('otp');			
			$update = $this->Query_model->update_data('ec_customer',$args['DATA'],array('otp' => $otp));
				echo $update;
				if($update){
					$cart_item = cart_item_count();
					echo json_encode(array('msg' => 'Product update successfully', 'success' => 1, 'data' => array('cart_count' => $cart_item)));
				}

			
			$n = 2; 
			$otp = bin2hex(random_bytes($n)); 
		
			$this->load->library('mailer');
			//$useremail = $email;
			$email = 'jpforever1999@gmail.com';
			$useremail = 'jpforever1999@gmail.com';
			$admin_email = 'jay@move2inbox.in';//admin@viralbake.com
			
			$msg = '<p style="text-align:center;">Thanks you.opt='.$otp.'</p>';
			
			$admin_msg = '<div style="text-align:center;"><p>'.$useremail.' has purchase product on klentano. <br ><br >Here is the submitted form data</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"><tr><td>Email</td><td>'.$email.'</td></tr><tr><td>Otp</td><td>'.$otp.'</td></tr></table></div>';
			
			#$this->mailer->smtp(array('SUBJECT' => 'Thank You purchase', 'EMAIL' => $useremail, 'CONTENT' => $msg));
			#$this->mailer->smtp(array('SUBJECT' => 'Klentano purchase', 'EMAIL' => $admin_email, 'CONTENT' => $admin_msg));
		   
		  if(isset($last_inserted_id) && $last_inserted_id!='' )
            {
				$cart_item = cart_item_count();
                echo json_encode(array('msg' => 'Product added successfully', 'success' => 1, 'data' => array('cart_count' => $cart_item)));
            }
     
			
        }

    }
 
	
 
	public function del()
    {
		$data['csrf'] = csrf_token();
	    $order_item_id = $this->input->post('id');		
		$data['csrf'] = csrf_token();
        $data = array();
        $delete = $this->Product_model->delete_cart($order_item_id);
		
		$cart_iterm = $this->session->userdata('cart');
		unset($cart_iterm[$order_item_id]);		
		$this->session->set_userdata('cart',$cart_iterm);			
        echo json_encode(array('success' => $delete));
		
		
		
    }
	    
}





















