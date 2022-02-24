<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Profile extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
		$this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->helper('text');		
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

    public function index($arg=null) 
    { 
		$cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "My Account" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['account_detail'] = $this->Query_model->get_data_obj('ec_customer', array('customer_id' => $this->LOGIN_ID));
        //$data['country'] = get_country();

        $data['country']  =  isset($data['account_detail']->country) ? get_country($data['account_detail']->country)->name : '';
        $this->load->template("$this->TYPE/my_account", $data);
    }

    
    public function customer_order()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Orders" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $customer_id  = $this->LOGIN_ID;
        $data['order_count']    = $this->Product_model->get_order_count($customer_id);
        $data['breadcrumbs']    = $breadcrumbs;
        $this->load->template("$this->TYPE/my_order", $data);
    }



    public function ajax_get_customer_order()
    {
        $data = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $customer_id = $this->LOGIN_ID;
        $orderlist = $this->Product_model->get_order_data($customer_id);
        //print_r($orderlist); exit;
        $data = array();

        $order_id_arr = $order_id_arr1 = array();
        foreach ($orderlist as $row) {

            //$productname        = json_decode($row->order_item_name);
            $row->order_id      = $row->order_id;
            $row->order_uid     = $row->order_uid;
            $row->product_id    = $row->product_id;
            $row->num_items     = $row->num_items_sold;
            $row->productname   = get_product($row->product_id)->post_title;
            $row->quantity      = $row->product_qty;
            $row->totalprice    = $row->net_total;
            $row->proprice      = get_product($row->product_id)->sale_price;
            $row->image         = base_url()."assets/uploads/files/".get_product_image($row->product_id)->file_name;
            $row->orderstatus   = $row->status;
            $row->delivery_date = date("d-M-Y", strtotime($row->date_created."+7 day"));
            $row->order_date    = date("d-M-Y", strtotime($row->date_created));
            $row->product_link  = get_permalink(get_product($row->product_id)->post_slug);
            $order_id_arr[$row->order_id][] = $row;
        }

        if(is_api())
        {
            $order_id_arr1[] = $order_id_arr;
        }else{
            $order_id_arr1 =  $order_id_arr;
        }

        $response = array(
        'status' => '1',
        'message' => 'success',
        'data' => $order_id_arr1
        );

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));

    }



     public function customer_order_tracking()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Orders" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $this->load->template("$this->TYPE/my_order_track", $data);
    }


    public function customer_voucher()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Voucher" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $this->load->template("$this->TYPE/my_voucher", $data);
    }


    public function ajax_get_customer_voucher()
    {
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $customer_id  = $this->LOGIN_ID;
        $condition    = array('type' => '2', 'end_date >=' => date('Y-m-d 00:00:00'));
        $couponlist = $this->Query_model->get_data('ec_coupon', $condition);
        $data = array();

        foreach ($couponlist as $couponlistdata) {

            $row['coupon_id']   =  $couponlistdata->coupon_id;
            $row['name']        =  $couponlistdata->name;
            $row['description'] =  $couponlistdata->description;
            $row['discount']    =  $couponlistdata->discount;
            $row['couponstatus']=  ($couponlistdata->type == '2') ? 'Active' : 'Expired';
            $row['start_date']  =  date("d-M-Y", strtotime($couponlistdata->start_date));
            $row['end_date']    =  date("d-M-Y", strtotime($couponlistdata->end_date));
            $row['date_added']  =  $couponlistdata->date_added;
            $data[] = $row;
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }



    public function customer_wishlist()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Wishlist" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $this->load->template("$this->TYPE/wishlist", $data);

    }


    public function ajax_get_wishlist_product()
    {
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $customer_id  =  $this->LOGIN_ID;
        $condition = array('customer_id' => $customer_id);
        $productlist = $this->Query_model->get_data('ec_wishlist', $condition);

        $data = array();
        foreach ($productlist as $orderlistdata) {

            $row['wishlist_id'] =  $orderlistdata->wishlist_id;
            $row['customer_id'] =  $orderlistdata->customer_id;
            $row['productimg']  =  get_product_image($orderlistdata->product_id)->file_name;
            $row['productname'] =  get_product($orderlistdata->product_id)->post_title;
            $row['price']       =  get_product($orderlistdata->product_id)->sale_price;
            $row['product_description'] = get_product($orderlistdata->product_id)->post_content;
            $row['product_id']  =  $orderlistdata->product_id;
            $row['date_added']  =  $orderlistdata->date_added;
            $data[] = $row;
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }


    public function ajax_remove_wishlist_product()
    {
        $wishlist_id = $this->input->post('id');
        $condition   = array('customer_id'=> $this->LOGIN_ID, 'wishlist_id' => $wishlist_id);
        $status      = $this->Query_model->delete_query('ec_wishlist', $condition);
        $response = array(
           'status'    => '1',
           'message'   => 'Wishlist product removed successfully',
           'data'      => (array)$status
        );

        echo json_encode($response);
        die();
    }


    public function customer_address()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Address" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $this->load->template("$this->TYPE/my_address", $data);
    }


    public function customer_change_password()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Change Passowrd" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $data['customer_id']    = $this->LOGIN_ID;
        $this->load->template("$this->TYPE/my_change_password", $data);
    }



    public function add_address($customer_id = NULL)
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs       = array("Home" => "/$this->TYPE/profile/", "Add Address" => "");
        $breadcrumbs  = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $data['error'] = false;
        $data['type'] = '';
        $data['country_list'] = $this->Query_model->get_data('ec_country');
        $data['address']      = $this->Query_model->find_by_id('ec_customer', array('customer_id' => $customer_id));
        
        $data['customer_id'] = $customer_id;
        $data['message']['error'] = ''; 
        $customer_id = $this->input->post('customer_id');
        
        $this->address_validation();

        if($_POST) {
            $data['street']            = $this->input->post('street');
            $data['city']              = $this->input->post('city');
            $data['zip_code']          = $this->input->post('zip_code');
            $data['country']           = $this->input->post('country');
            $data['address']           = $this->input->post('address');
        }else{
            if(isset($customer_id)){
                $address_obj = $this->Query_model->find_by_id('ec_customer', array('customer_id' => $customer_id));
                if(isset($address_obj)){
                    $data['street']           = $address_obj->street;
                    $data['city']             = $address_obj->city ;
                    $data['zip_code']         = $address_obj->zip_code;
                    $data['country']          = $address_obj->id;
                    $data['address']          = $address_obj->address;
                }else{
                    redirect("$this->TYPE/address", $data);
                }
            }
        }
        if ($this->form_validation->run())
        {
            $post_data = array(
                    'street'        => $data['street'],
                    'city'          => $data['city'],
                    'zip_code'      => $data['zip_code'],
                    'country'       => $data['country'],
                    'address'       => $data['address'],
            );

            if(isset($customer_id)){

                $condition = array('customer_id' => $customer_id);
                $this->Query_model->update_data('ec_customer', $post_data, $condition);
                $this->session->set_flashdata('message', 'Address updated sucessfully.');
                redirect("$this->TYPE/profile");
            }
        }else{
            $data['TYPE']       = $this->TYPE;
            $data['csrf']       = csrf_token();
            $this->load->template("$this->TYPE/address", $data);  
        }  
    }

	    

    public function address_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('street', 'Street Name', 'trim|required');
        $this->form_validation->set_rules('city', 'City Name', 'trim|required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
        $this->form_validation->set_rules('country', 'Country Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Address Detail', 'trim|required');
    }


    public function shipping_address($cmeta_id = NULL)
    {   
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Shipping Address" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']     = $breadcrumbs;
        $data['cmeta_id']        = $cmeta_id;
        $data['country_list']    = $this->Query_model->get_data('ec_country'); 
        $data['shippingaddress'] = $this->Query_model->get_data_obj('ec_customermeta', array('cmeta_id' => $cmeta_id));
        $this->load->template("$this->TYPE/shipping_address", $data);
    }

    public function ajax_get_country()
    {
        $data = $this->Query_model->get_data('ec_country');

        $response = array(
                        'status'  => '1',
                        'message' => "success",
                        'data'    => (array)$data,
                    );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }

    public function add_shipping_address($cmeta_id = NULL)
    {
        $data['csrf'] = csrf_token();
        $data['error'] = false;
        $data['type'] = '';
        $data['message']['error'] = ''; 
        $cmeta_id = $this->input->post('cmeta_id');
        $data = array();
        $this->shipping_address_validation();   

        if ($this->form_validation->run() == false) {
            $response = array(
                'status'  => '0',
                'message' => remove_extra_for_api(validation_errors()),
                'data'    => (array)$data,
            );

        }else{
            if($_POST) {
                $data['cust_id']                = $this->LOGIN_ID;
                $data['shipping_first_name']    = $this->input->post('shipping_first_name');
                $data['shipping_last_name']     = $this->input->post('shipping_last_name');
                $data['shipping_mobile']        = $this->input->post('shipping_mobile');
                $data['shipping_street']        = $this->input->post('shipping_street');
                $data['shipping_city']          = $this->input->post('shipping_city');
                $data['shipping_postcode']      = $this->input->post('shipping_postcode');
                $data['shipping_country']       = $this->input->post('shipping_country');
                $data['shipping_address_1']     = $this->input->post('shipping_address_1');
            }else{
            if($cmeta_id!=''){
                $customermeta_obj = $this->Query_model->get_data_obj('ec_customermeta', array('cmeta_id' => $cmeta_id));
                if(isset($customermeta_obj)){
                    $data['shipping_first_name']    = $customermeta_obj->shipping_first_name;
                    $data['shipping_last_name']     = $customermeta_obj->shipping_last_name;
                    $data['shipping_mobile']        = $customermeta_obj->shipping_mobile;
                    $data['cust_id']                = $customermeta_obj->cust_id;
                    $data['shipping_street']        = $customermeta_obj->shipping_street;
                    $data['shipping_city']          = $customermeta_obj->shipping_city;
                    $data['shipping_postcode']      = $customermeta_obj->shipping_postcode;
                    $data['shipping_country']       = $customermeta_obj->shipping_country;
                    $data['shipping_address_1']     = $customermeta_obj->shipping_address_1;
                }else{
                    redirect("$this->TYPE/shipping-address", $data);
                }
            }
        }

         $post_data = array(
                    'shipping_first_name'   => $data['shipping_first_name'],
                    'shipping_last_name'    => $data['shipping_last_name'],  
                    'shipping_mobile'       => $data['shipping_mobile'],     
                    'cust_id'               => $this->LOGIN_ID,             
                    'shipping_street'       => $data['shipping_street'],     
                    'shipping_city'         => $data['shipping_city'],       
                    'shipping_postcode'     => $data['shipping_postcode'],  
                    'shipping_country'      => $data['shipping_country'],    
                    'shipping_address_1'    => $data['shipping_address_1'],
                );

            if($cmeta_id!=''){
                    $condition = array('cmeta_id' => $cmeta_id);
                    $status   = $this->Query_model->update_data('ec_customermeta',$post_data, $condition);
                    $this->session->set_flashdata('message', 'Shipping address update sucessfully.');
                    
    
                    $response = array(
                        'status'  => '1',
                        'message' => "Shipping address update sucessfully.",
                        'data'    => (array)$status,
                    );

                    
            }else{

                    $lats_id = $this->Query_model->insert_data('ec_customermeta', $post_data);
                    $this->session->set_flashdata('message', 'Shipping address add sucessfully.');
                    $response = array(
                        'status'  => '1',
                        'message' => "Shipping address add sucessfully.",
                        'data'    => (array)$lats_id,
                    );
            }

        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }



    public function shipping_address_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('shipping_first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('shipping_last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('shipping_mobile', 'Mobile No', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('shipping_street', 'Street Name', 'trim|required');
        $this->form_validation->set_rules('shipping_city', 'City Name', 'trim|required');
        $this->form_validation->set_rules('shipping_postcode', 'Zip Code', 'trim|required');
        $this->form_validation->set_rules('shipping_country', 'Country Name', 'trim|required');
        //$this->form_validation->set_rules('shipping_address_1', 'Address Detail', 'trim|required');
    }


    public function ajax_shipping_address()
    {
        $data = array();
        $condition = array('cust_id' => $this->LOGIN_ID);
        $addresslist = $this->Query_model->get_data('ec_customermeta', $condition);
        foreach ($addresslist as $addresslistdata) 
        {
            $row = array();
            $row['cmeta_id']            = $addresslistdata->cmeta_id;
            $row['cust_id']             = $addresslistdata->cust_id;
            $row['shipping_first_name'] = $addresslistdata->shipping_first_name;
            $row['shipping_last_name']  = $addresslistdata->shipping_last_name;
            $row['shipping_mobile']     = $addresslistdata->shipping_mobile;
            $row['shipping_address_1']  = $addresslistdata->shipping_address_1;
            $row['shipping_city']       = $addresslistdata->shipping_city;
            $row['shipping_street']     = $addresslistdata->shipping_street;
            $row['shipping_postcode']   = $addresslistdata->shipping_postcode;
            $row['status']              = $addresslistdata->status;
            $row['shipping_country']    = get_country($addresslistdata->shipping_country)->name;
            $data[] = $row;
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



    public function change_password($customer_id = NULL)
    {
        $data['csrf'] = csrf_token();
        $customer_id = $this->LOGIN_ID;
        $data = array();
        $this->password_validation(); 

        if($this->form_validation->run() == false) {

            $response = array(
                'status'  => '0',
                'message' => remove_extra_for_api(validation_errors()),
                'data'    => (array)$data,
            );

        }else{

         if($_POST) {

                $data['cust_id']     = $customer_id;
                $data['password']    = $this->input->post('password');

            }

            $post_data = array('password'   => MD5($data['password']));
            $condition = array('customer_id' => $customer_id);
            $status    = $this->Query_model->update_data('ec_customer', $post_data, $condition);
            
            $response = array(
                'status'  => '1',
                'message' => "Password update sucessfully.",
                'data'    => (array)$status,
            );

        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }


    public function password_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'New Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');  
    }



    public function customer_profile()
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Change Passowrd" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;
        $data['customer_id']    = $this->LOGIN_ID;
        $data['country_list'] = $this->Query_model->get_data('ec_country');
        $data['userdetail']     = $this->Query_model->get_data_obj('ec_customer', array('customer_id' => $this->LOGIN_ID));
        $this->load->template("$this->TYPE/edit_profile", $data);
    }


    public function update_customer_profile()
    {
        
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $data['error'] = false;
        $data['type'] = '';
        $data['message']['error'] = '';
        $customer_id = $this->LOGIN_ID;
        $userdetail = $this->Query_model->get_data('ec_customer', array('customer_id' => $this->LOGIN_ID));
        if($this->input->post('request_type') == 'get')
            {
                $response = array(
                   'status'    => '1',
                   'message'   => 'success',
                   'data'      => $userdetail
                );

            }else{

                $this->customer_profile_validation();

                if ($this->form_validation->run() == false) {
                    $response = array(
                        'status'  => '0',
                        'message' => remove_extra_for_api(validation_errors()),
                        'data'    => (array)$userdetail,
                    );
           
                }else{

                    if($_POST) {
                        
                         $data =  array(
                                'fname'            => $this->input->post('fname'),
                                'lname'            => $this->input->post('lname'),
                                'email'            => $this->input->post('email'),
                                'mobile'           => $this->input->post('mobile'),
                                'street'           => $this->input->post('street'),
                                'city'             => $this->input->post('city'),
                                'country'          => $this->input->post('country'),
                                'zip_code'         => $this->input->post('zip_code'),
                                'address'          => $this->input->post('address'),
                            );
                     }else{
                            $data['customer_id']    = $userdetail->customer_id;
                            $data['fname']          = $userdetail->fname;
                            $data['lname']          = $userdetail->lname;
                            $data['email']          = $userdetail->email;
                            $data['mobile']         = $userdetail->mobile;
                            $data['street']         = $userdetail->street;
                            $data['city']           = $userdetail->city;
                            $data['country']        = $userdetail->country;
                            $data['zip_code']       = $userdetail->zip_code;
                            $data['address']        = $userdetail->address;
                            $data['country_name']   = get_country($userdetail->country)->name;
                    }

                    $condition = array('customer_id' => $customer_id);
                    $status    = $this->Query_model->update_data('ec_customer',$data, $condition);
                        $response = array(
                        'status'  => '1',
                        'message' => "Profile Update Successfully",
                        'data'    => (array)$status,
                    );
                }
            }   

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));

    }


    public function customer_profile_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
       // $this->form_validation->set_rules('lname', 'Last Name',  'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('street', 'Street', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
    }



    public function track_package($order_id = NULL)
    {
        $cart_details = $this->session->userdata('cart');
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/profile/", "Track Package" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['order_id']   = $order_id;
        $data['breadcrumbs']    = $breadcrumbs;
        $this->load->template("$this->TYPE/my_order_track", $data);
    }


    public function ajax_get_track_package()
    {
        $data = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $customer_id  = $this->LOGIN_ID;
        $order_id    = $this->input->post('order_id');
        $orderlist    = $this->Order_model->get_order_track_data($customer_id, $order_id);
        $data = array();

        foreach ($orderlist as $orderlistdata) {

            $row['order_id']    = $orderlistdata->order_id;
            $row['customer_id'] = $orderlistdata->customer_id;
            $row['totalprice']  = $orderlistdata->net_total;
            $row['productimg']  = base_url()."assets/uploads/files/".get_product_image($orderlistdata->product_id)->file_name;
            $row['productname'] = get_product($orderlistdata->product_id)->post_title;
            $row['price']       = get_product($orderlistdata->product_id)->sale_price;
            $row['orderstatus'] = order_status($orderlistdata->orderstatus);
            $row['product_description'] = get_product($orderlistdata->product_id)->post_content;
            $row['product_id']  = $orderlistdata->product_id;
            $row['order_date']  = date("d-M-Y", strtotime($orderlistdata->date_created));
            $row['delivery_date']= date("d-M-Y", strtotime($orderlistdata->date_created."+7 day"));
            $data[] = $row;
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
       
    }


}





















