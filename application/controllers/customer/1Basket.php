<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Basket extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
		$this->load->model('Product_model');
        $this->load->helper('text');		
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

	## add to cart 		
	 public function ajaxaddtocart()
    {
		$this->validation();		
		$data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
		
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
		
        if ($this->form_validation->run() == FALSE)
        {
			echo json_encode(array('msg' => validation_errors(), 'success' => 0));
        }
        else{
            $data = $this->input->post();	
            $data = $this->security->xss_clean($data);
			$this->addtocart(array('DATA' => $data));		
        }   
    }  
    
    public function validation()
    {
        $this->load->helper(array('form', 'url'));		
        $this->load->library('form_validation');		
        $this->form_validation->set_error_delimiters('<div>', '</div>');          
        $this->form_validation->set_rules('quantity',' quantity', 'numeric|xss_clean');      
    }
 
    public function addtocart($args)
    {	
		$data['error'] = false;
		$newdata = array();
        if(isset($args['DATA']) && $args['DATA'])
        {
			$session_id = $_SESSION['__ci_last_regenerate'];
			$date = date("Y-m-d h:i:s"); //2021-01-05 10:06:16 
			$product_id = $this->input->post('product_id');
			$product_n = trim($this->input->post('product_name'));
			$product_name = trim($product_n);
			$product_qty = $this->input->post('product_qty');
			$product_net_revenue = $this->input->post('product_net_revenue');
			$var_name_json = $this->input->post('product_name');
			$var_id_jason = $this->input->post('variation_id');	 	
			
			$order_items['DATA']['order_item_name'] 	= $var_name_json;			
			$order_items['DATA']['order_item_type']	  	= "line_item";
			$order_items['DATA']['customer_id'] 		= $this->LOGIN_ID;
			$order_items['DATA']['session_id'] 			= $session_id;			
			//echo $var_id_jason;
			//die;
			
		## if user loging
		 if($this->LOGIN_ID){
			
			$item_obj = $this->Query_model->get_data_obj('ec_order_items',array('customer_id' => $this->LOGIN_ID, 'order_item_name' => $product_name,'order_id' => 0));
							
			if(!empty($item_obj) && $item_obj->order_item_name==$product_name){
				
				#ec_order_product tables update
					
				$item_arr = $this->Query_model->get_data_obj('ec_order_product',array('customer_id' => $this->LOGIN_ID, 'order_item_id' => $item_obj->order_item_id,'order_id' => 0));
				
				$qty = $item_arr->product_qty + $product_qty;
				$db_data1 = array(
					'product_qty'       		=> $qty,
					'product_net_revenue'       => $product_net_revenue,
					#'post_title'       => $data['post_title'],
				);
				
				$get_cart[$item_obj->order_item_id]['product_qty'] = $qty;               			
				#$get_cart[$item_obj->product_net_revenue]['product_net_revenue'] = $product_net_revenue;
                $this->session->set_userdata('cart', $get_cart);
				
				$this->Query_model->update_data('ec_order_product',$db_data1,array('order_item_id' => $item_obj->order_item_id));
               
				#ec_order_itemmeta tables update
				$db_data2 = array(
					'_qty'       => $qty,
					#'post_title'       => $data['post_title'],
				);
				
				$update = $this->Query_model->update_data('ec_order_itemmeta',$db_data2,array('order_item_id' => $item_obj->order_item_id,'order_id' => $item_obj->order_item_id));
				
				if($update){
					$cart_item = cart_item_count();
					echo json_encode(array('msg' => 'Product update successfully', 'success' => 1, 'data' => array('cart_count' => $cart_item)));
				}
				
				
			}else{
				
				$last_inserted_id  =  $this->Query_model->insert_data('ec_order_items',$order_items['DATA']);
				
				#order insert on ec_order_product
				$order_product['DATA']['order_item_id'] 		= $last_inserted_id;
				$order_product['DATA']['product_id'] 			= $product_id;
				$order_product['DATA']['product_qty'] 			= $product_qty;
				$order_product['DATA']['product_net_revenue'] 	= $product_net_revenue;
				$order_product['DATA']['variation_id'] 			= $var_id_jason;
				$order_product['DATA']['customer_id'] 			= $this->LOGIN_ID;
				$order_product['DATA']['date_created'] 			= $date;
				#$variation_id_arr 								= $var_id_jason;				
				#$order_product['DATA']['product_id'] 		= $product_id;
				$cart_details = $this->session->userdata('cart');
				$cart_details[$order_product['DATA']['order_item_id']] = $order_product['DATA'];
				$this->session->set_userdata('cart', $cart_details);	
				
				//echo "<pre>";
				$order_product  =  $this->Query_model->insert_data('ec_order_product',$order_product['DATA']);
				
				
				#order insert on meta data				
				$order_itemmeta['DATA']['order_item_id'] 	= $last_inserted_id;
				$order_itemmeta['DATA']['product_id'] 		= $product_id;
				$order_itemmeta['DATA']['_qty'] 			= $product_qty;			
				$order_itemmeta['DATA']['_variation_id'] 	= $var_id_jason;	
				#$order_itemmeta['DATA']['product_net_revenue'] = $order_items['DATA']['product_net_revenue'];				
				$order_item_meta  =  $this->Query_model->insert_data('ec_order_itemmeta',$order_itemmeta['DATA']);
			}
			
		}else{
			 
			#session case 
			$item_obj = $this->Query_model->get_data_obj('ec_order_items',array('session_id' => $session_id, 'order_item_name' => $product_name,'order_id' => 0));
							
			if(!empty($item_obj) && $item_obj->order_item_name==$product_name){
				$get_cart = get_cart();
				
				#ec_order_product tables update				
				$item_arr = $this->Query_model->get_data_obj('ec_order_product',array('session_id' => $session_id, 'order_item_id' => $item_obj->order_item_id,'order_id' => 0));
				
				$qty = $item_arr->product_qty + $product_qty;
				$db_data1 = array(
					'product_qty'       => $qty,
					#'post_title'       => $data['post_title'],
				);
			
                $get_cart[$item_obj->order_item_id]['product_qty'] = $qty;
                $this->session->set_userdata('cart', $get_cart);
				$this->Query_model->update_data('ec_order_product',$db_data1,array('order_item_id' => $item_obj->order_item_id));
               
				#ec_order_itemmeta tables update
				$db_data2 = array(
					'_qty'       => $qty,
					#'post_title'       => $data['post_title'],
				);
				
				$update = $this->Query_model->update_data('ec_order_itemmeta',$db_data2,array('order_item_id' => $item_obj->order_item_id));
				
				if($update){
					$cart_item = cart_item_count();
					echo json_encode(array('msg' => 'Product update successfully', 'success' => 1, 'data' => array('cart_count' => $cart_item)));
				}
			}else{
				#echo "<pre>";print_r($order_items['DATA']); echo "</pre>";die;
				$last_inserted_id  =  $this->Query_model->insert_data('ec_order_items',$order_items['DATA']);	
				#order insert on ec_order_product
				$order_product['DATA']['order_item_id'] 		= $last_inserted_id;
				$order_product['DATA']['order_item_name']   	= $var_name_json;
				$order_product['DATA']['session_id'] 			= $session_id;
				$order_product['DATA']['product_id'] 			= $product_id;
				$order_product['DATA']['product_qty'] 			= $product_qty;
				$order_product['DATA']['product_net_revenue'] 	= $product_net_revenue;				
				$order_product['DATA']['date_created'] 			= $date;	
				$order_product['DATA']['variation_id'] 			= $var_id_jason;
				$order_product['DATA']['order_id']   			= 0;	
				$order_product['DATA']['product_gross_revenue'] = 0;
				$order_product['DATA']['coupon_amount'] 		= 0;				
				$order_product['DATA']['tax_amount'] 			= 0;
				$order_product['DATA']['shipping_amount']		= 0;
				
				$cart_details = $this->session->userdata('cart');	
				
				$cart_details[$order_product['DATA']['order_item_id']] = $order_product['DATA'];															
				$this->session->set_userdata('cart', $cart_details);
				
				#echo "<pre>"; print_r($cart_details); echo "</pre>";
				unset($order_product['DATA']['order_item_name']);
				unset($order_product['DATA']['order_id']);
				unset($order_product['DATA']['product_gross_revenue']);
				unset($order_product['DATA']['coupon_amount']);
				unset($order_product['DATA']['tax_amount']);
				unset($order_product['DATA']['shipping_amount']);
				
				$order_product  =  $this->Query_model->insert_data('ec_order_product',$order_product['DATA']);
				#order insert on meta data				
				$order_itemmeta['DATA']['order_item_id'] 	= $last_inserted_id;
				$order_itemmeta['DATA']['product_id'] 		= $product_id;
				$order_itemmeta['DATA']['_qty'] 			= $product_qty;	
				$order_itemmeta['DATA']['_variation_id'] 	= $var_id_jason;	
				
				
				
				$order_item_meta  =  $this->Query_model->insert_data('ec_order_itemmeta',$order_itemmeta['DATA']);
			}
			
				
		} //end logoout
			 
			//echo '--'.$last_inserted_id;
			/*$details = array(
					'email'         => $email,
					'fname'         => $email_name,						
					'current_id'    => $last_inserted_id					
			);
			*/
			
			#$this->session->set_userdata($this->TYPE, $details);	
			
			$this->load->library('mailer');
			//$useremail = $email;
			$email = 'jpforever1999@gmail.com';
			$useremail = 'jpforever1999@gmail.com';
			$admin_email = 'jay@move2inbox.in';//admin@viralbake.com
			
			$msg = '<p style="text-align:center;">Thanks for purchase this product! We will be in touch with you shortly.</p>';
			
			$admin_msg = '<div style="text-align:center;"><p>'.$useremail.' has purchase product on klentano. <br ><br >Here is the submitted form data</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"><tr><td>Email</td><td>'.$email.'</td> </tr> </table></div>';
			
			$this->mailer->smtp(array('SUBJECT' => 'Thank You purchase', 'EMAIL' => $useremail, 'CONTENT' => $msg));
			$this->mailer->smtp(array('SUBJECT' => 'Klentano purchase', 'EMAIL' => $admin_email, 'CONTENT' => $admin_msg));
		   
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





















