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
		$this->current_id = $this->session->userdata($this->TYPE)['login_id'];
		
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
		
		if ($this->uri->segment(2) === FALSE){
			$slug = 0;
		}else{
			$slug = $this->uri->segment(2);
		}	
		//echo "".$this->current_id;die;
		if(isset($this->current_id)){	
			$args = array('cust_id' => $this->current_id);			
			$data['current_user_info'] = $this->Query_model->get_data_obj('ec_customermeta',$args);		
		}
		
		#$pp = $this->session->userdata($this->TYPE);
		//echo "<pre>"; print_r($data['current_user_info'] ); echo "</pre>";die;
		$data['country_list'] = $this->Query_model->get_data('ec_country');
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
		//echo "<pre>"; print_r($data); echo "</pre>";
		//exit;
		$n = 2; 
		$otp = bin2hex(random_bytes($n)); 
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
		
        if ($this->form_validation->run() == FALSE){
			echo json_encode(array('msg' => validation_errors(), 'success' => 0));
        }else{
			$customer_uid = uniq_uid();	
			$data_new = array(
				'email' 		=> $data['email_id'],					
				'otp'			=> $otp,
				'password'		=> md5($otp),
				'customer_uid'	=>$customer_uid,
				//'user_id'	=>$customer_uid,
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
		$response = array();
        if(isset($args['DATA']) && $args['DATA'])
        {	
			$email = $this->input->post('email_id');
			$otp = $this->input->post('otp');
			
		    $email_obj = $this->Query_model->get_data_obj('ec_customer', array('email' => $email));	
           
            if($otp)
            {
                if($otp == $email_obj->otp)
                {
					if($email_obj->fname == ''){
						$tmp = explode('@',$email_obj->email);
						$email_obj->fname = $tmp[0];
					}
				$details = array(
				   'email'         => $email_obj->email,
				   'fname'         => $email_obj->fname,
				   'lname'         => $email_obj->lname,
				   'login_id'      => $email_obj->customer_id,
				   'logged_in'     => TRUE
				);
                $this->session->set_userdata($this->TYPE, $details);
				unset($details['login_id']);

                echo json_encode(array('success'=>1, 'login' => 'true', 'msg'=>'Successfully Login', 'userdata' => $details));
				
				/*$cart_item = cart_item_count();
                echo json_encode(array('msg' => 'Product added successfully', 'success' => 1, 'data' => array('cart_count' => $cart_item)));*/


                }
                else
                {
                    echo json_encode(array('success'=>1, 'msg'=>'OTP not matched'));
                }
                die();
            }
            if($email_obj)
            {
                echo json_encode(array('success'=>1, 'msg'=>'OTP Send to your Email id'));
                $n = 2;
                $otp = bin2hex(random_bytes($n));
                //$otp = '1234';
                $update_status = $this->Query_model->update_data('ec_customer', array('otp' => $otp), array('customer_id' => $email_obj->customer_id)); 

				
                if($update_status)
                {
                    //Send mail
                    //$this->mail_send(array('otp' => $otp));
					$this->mail_send(array('email' => $email_obj->email, 'otp' => $otp));
                }             
            }
            else
            {
			 	//echo "<pre>"; print_r($args['DATA']); echo "</pre>";die;
				$last_inserted_id  =  $this->Query_model->insert_data('ec_customer',$args['DATA']);
            }
            	
				
			if(isset($last_inserted_id))
            {
				$this->mail_send(array( 'email' => $args['DATA']['email'], 'otp' =>$args['DATA']['otp']));	
				$cart_item = cart_item_count();
				
                echo json_encode(array(	'msg' => 'OTP Send On Your Email Id', 'success' => 1, 'data' => array(		'cart_count' => $cart_item )
				));
				
				#redirect($_SERVER['REQUEST_URI'], 'refresh'); 
            }
     
			
        }

    }
	
	/////otp check
	/*
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
					'mobile'=> 9934141842						
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
 */
	
 
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

    public function mail_send($args) 
    {
        $otp = $args['otp'];
		$useremail = $args['email'];
        $this->load->library('mailer');
		//$useremail = $email;
		$email = 'jay@move2inbox.in';
		//$useremail = 'jpforever1999@gmail.com'; //'jpforever1999@gmail.com';
		$admin_email = 'jay@move2inbox.in';//admin@viralbake.com

		$msg = '<p style="text-align:center;">OTP For login opt='.$otp.'</p>';

		$admin_msg = '<div style="text-align:center;"><p>'.$useremail.' has purchase product on klentano. <br ><br >Here is the submitted form data</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"><tr><td>Email</td><td>'.$email.'</td></tr><tr><td>Otp</td><td>'.$otp.'</td></tr></table></div>';

		$this->mailer->smtp(array('SUBJECT' => 'OTP For login', 'EMAIL' => $useremail, 'CONTENT' => $msg));
    
    }

    public function ajax_order_delivery_address()
    {
        $response = array(
                'status' => '0',
                'message' => 'Error.',
            );

        $cmeta_id = $this->input->post('cmeta_id');
        if($this->LOGIN_ID && $cmeta_id){
            $update = $this->Query_model->update_data('ec_customermeta', array('status' => 0), array('cust_id' => $this->LOGIN_ID));
            $update = $this->Query_model->update_data('ec_customermeta', array('status' => 1), array('cust_id' => $this->LOGIN_ID, 'cmeta_id' => $cmeta_id));
            $response = array(
                'status' => '1',
                'message' => 'Shipping address updated.',
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
	
	public function ajax_bill_address_update(){
		
	if(isset($this->current_id)) { 
		$data = array();		
		$fname = $this->input->post('fname');
		$cmeta_id = $this->input->post('item_id');
		$lname = $this->input->post('lname');	
		$street = $this->input->post('street');	
		$shipping_country = $this->input->post('shipping_country');	
		$address = $this->input->post('address');	
		//$state = $this->input->post('state');	
		$city = $this->input->post('city');	
		$zip_code = $this->input->post('zip_code');			
		//validation
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('fname', 'first name', 'trim|required|min_length[2]|max_length[200]|xss_clean');
		$this->form_validation->set_rules('street', 'street address', 'trim|required|min_length[2]|max_length[200]|xss_clean');
		$this->form_validation->set_rules('city', 'city name', 'trim|required|min_length[2]|max_length[200]|xss_clean');
		$this->form_validation->set_rules('zip_code', 'zip code', 'trim|required|min_length[2]|max_length[200]|xss_clean');
		#$this->form_validation->set_rules('fname', 'first name', 'trim|required|min_length[2]|max_length[200]|xss_clean');

		if ($this->form_validation->run() == FALSE) {            
				echo json_encode(array('msg' => validation_errors(), 'success' => 0));			
			}else{				
				$data = array(					
					'fname'				=> $fname,
					'lname' 			=> $lname,
					'street' 	=> $street,
					'address' 			=> $address,
					'country' 	=> $shipping_country,
					'city' 				=> $city,
					'zip_code' 			=> $zip_code				
                );
				//update customer table billing address
				$update = $this->Query_model->update_data('ec_customer', $data, array('customer_id' => $this->current_id));  
							
				if($update){
					//echo json_encode( array('msg' => 'Address updated!', 'success' => 1 ));
				}
				
				//update customer table Shipping address
				$data = array(					
					'shipping_first_name'		=> $fname,
					'shipping_last_name' 		=> $lname,
					'shipping_street' 			=> $street,
					'shipping_address_1' 		=> $address,
					'shipping_country' 			=> $shipping_country,
					'shipping_city' 			=> $city,
					'shipping_postcode' 		=> $zip_code				
                );
				//update customer table Shipping address
				$update = $this->Query_model->update_data('ec_customermeta', $data, array('cmeta_id'=> $cmeta_id, 'cust_id' => $this->current_id));  
							
				if($update){
					echo json_encode( array('msg' => 'Address updated!', 'success' => 1 ));
				}else{
				$data = array(	
					'cust_id'					=> $this->LOGIN_ID,				
					'shipping_first_name'		=> $fname,
					'shipping_last_name' 		=> $lname,
					'shipping_street' 			=> $street,
					'shipping_address_1' 		=> $address,
					'shipping_country' 			=> $shipping_country,
					'shipping_city' 			=> $city,
					'shipping_postcode' 		=> $zip_code				
                );
				$last_inserted_id  =  $this->Query_model->insert_data('ec_customermeta',$data);
				echo json_encode( array('msg' => 'Address Added!', 'success' => 1 ));
				}
				
			}


		}
		
	}
	
	public function ajax_order_confirm(){
		
	if(isset($this->current_id)) {
        //print_r($_POST);
        //print_r($_SESSION); 
		$data = array();		
		$cart_item = $this->input->post('cart_item');
		$rate = $this->input->post('rate');
		$cmeta_id = $this->input->post('cmeta_id');
		$currency_id = $this->input->post('currency_id');
		$cart_arr = explode(",",$cart_item);
		
		$session_itemid = $this->session->userdata('proceed_checkout');
		$item_id = explode(",",$session_itemid);
		$cart_details = get_cart();
		$proceed_amt = 0; $proceed_amount = 0; $cart_item = 0;
		if(isset($cart_details)){
			foreach($cart_details as $row => $val){
				//$val['order_item_id'];
				if (in_array($val['order_item_id'], $item_id )){
					$proceed_amt+=$val['product_net_revenue'] * $val['product_qty'];
					$proceed_amount =$rate*$proceed_amt;
					$cart_item += $val['product_qty'];
				}
			}
		}
		//echo "<pre>"; print_r($item_id); echo "</pre>";die;

		//$total_sales = $this->input->post('total_sales'); 
		$customer_id = $this->current_id;
		//$cart_item_count =count($cart_item);		
		//validation
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('cart_item', 'Cart item', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {            
				echo json_encode(array('msg' => validation_errors(), 'success' => 0));			
			}else{				
				$data = array(		
					//'parent_id'			=> $customer_id,				
					'num_items_sold'	=> $cart_item,
					'total_sales'		=> $proceed_amount,					
					'tax_total'			=> 10,
					'shipping_total'	=> 11,
					'net_total'			=> $proceed_amount,
					'returning_customer'=> $cmeta_id,
					'customer_id'=> $customer_id,
					'cmeta_id'=> $cmeta_id,
					'currency_id'=> $currency_id,
					'status'			=> 1
					
					
                );				
				//echo "<pre>"; print_r($data); echo "</pre>";
				$last_inserted_id  =  $this->Query_model->insert_data('ec_order_stats',$data);
				if($last_inserted_id){	
					$update_data = array(					
						'order_id'=> $last_inserted_id					
						
					);				
					foreach($item_id as $k=>$val){
						//echo $val;
						$update = $this->Query_model->update_data('ec_order_items', $update_data, array('order_item_id'=> $val, 'customer_id' => $customer_id)); 
					}
					foreach($item_id as $k=>$val){
						//echo $val;
						$update = $this->Query_model->update_data('ec_order_itemmeta', $update_data, array('order_item_id'=> $val)); 
					}
					foreach($item_id as $k=>$val){
						//echo $val;
						$update = $this->Query_model->update_data('ec_order_product', $update_data, array('order_item_id'=> $val, 'customer_id' => $customer_id)); 
					}
					if($update){	
                        $this->session_checkout_reset($cart_details);
						echo json_encode( array('msg' => 'order update!', 'success' => 1 ));
					}
				}				
			
				
				
			}
		
		}
		
	}
	//end order confirm	

    public function session_checkout_reset($cart_details)
    {
        $sess_proceed_checkout = $this->session->userdata('proceed_checkout');
        $sess_proceed_checkout_arr = preg_split('/,/', $sess_proceed_checkout);
        if(count($sess_proceed_checkout_arr))
        {
            foreach($sess_proceed_checkout_arr as $row)
            {
                unset($cart_details[$row]); 
            }
            $this->session->set_userdata('cart', $cart_details); 
            $this->session->unset_userdata('proceed_checkout');      
        }
    }
	 
}





















