<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function page_count()
{
    $page_count = 10;
    return $page_count;
}

function csrf_token()
{
    $CI =& get_instance();
    $csrf = (object) array(
    'name' => $CI->security->get_csrf_token_name(),
    'hash' => $CI->security->get_csrf_hash()
    );
    return $csrf;
}

function insert_data_utils($table_name,$data)
{
    $CI =& get_instance();
    $CI->master = $CI->load->database('master', TRUE);
    $CI->master->insert($table_name,$data);
    return $CI->master->insert_id();
}

function update_data_utils($table_name,$data,$condition)
{
    $CI =& get_instance();
    $CI->master = $CI->load->database('master', TRUE);
    foreach($condition as $column => $value){
        $CI->master->where($column, $value);
    }
    $CI->master->update($table_name,$data);
    return ($CI->master->affected_rows() > 0) ? TRUE : FALSE;
}

function get_data_utils($table_name,$condition)
{
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->select('*');
    $CI->slave->from($table_name);
    foreach($condition as $column => $value){
        $CI->slave->where($column, $value);
    }
    $obj = $CI->slave->get()->result();
    if($obj && count($obj) == 1){
        $obj = $obj[0];
    }
    return $obj;
}

function get_country($country_id = NULL)
{
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->cache_on();
    $CI->slave->select('country_id, name');
    $CI->slave->from('ec_country');
    $CI->slave->order_by("name", "asc");
    $CI->slave->where('country_id', $country_id);
    $obj = $CI->slave->get()->row();
    $CI->slave->cache_off();
    return $obj;
}

function get_language($language_id = NULL)
{
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->cache_on();
    $CI->slave->select('language_id, name');
    $CI->slave->from('ec_language');
    if($language_id){
        $CI->slave->where('language_id',$language_id);
    }
    $CI->slave->where('status','1');
    $CI->slave->order_by("basic", "desc");
    $CI->slave->order_by("name", "asc");
    if($language_id){
        $obj = $CI->slave->get()->row();
    }else{
        $obj = $CI->slave->get()->result();
    }
    $CI->slave->cache_off();
    return $obj;
}

function get_currency($currency_id = NULL)
{
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->cache_on();
    $CI->slave->select('currency_id, name, iso_code, symbol, rate, basic');
    $CI->slave->from('ec_currency');
    if($currency_id){
        $CI->slave->where('currency_id',$currency_id);
    }
    $CI->slave->where('status','1');
    $CI->slave->order_by("basic", "desc");
    $CI->slave->order_by("name", "asc");
    if($currency_id){
        $obj = $CI->slave->get()->row();
    }else{
        $obj = $CI->slave->get()->result();
    }
    $CI->slave->cache_off();
    return $obj;
}

function default_currency()
{
    $CI =& get_instance();
    if($CI->session->userdata('cur')){
        $cur = $CI->session->userdata('cur');
    }else{
        $CI->slave = $CI->load->database('slave', TRUE);
        $CI->slave->cache_on();
        $CI->slave->select('currency_id');
        $CI->slave->from('ec_currency');
        $CI->slave->where('status','1');
        $CI->slave->where('basic',1);
        $obj = $CI->slave->get()->row();
        $CI->slave->cache_off();
        $cur = $obj->currency_id;
    }
    return $cur;
}

function default_language()
{
    $CI =& get_instance();
    if($CI->session->userdata('ln')){
        $ln = $CI->session->userdata('ln');
    }else{
        $CI->slave = $CI->load->database('slave', TRUE);
        $CI->slave->cache_on();
        $CI->slave->select('language_id');
        $CI->slave->from('ec_language');
        $CI->slave->where('status','1');
        $CI->slave->where('basic',1);
        $obj = $CI->slave->get()->row();
        $CI->slave->cache_off();
        $ln = $obj->language_id;
    }
    return $ln;
}

function get_product($product_id = NULL)
{
     if(!$product_id){return false;}
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->select('post_title, sale_price, post_content, post_slug');
    $CI->slave->from('ec_product');
    $CI->slave->where('product_id', $product_id);
    $CI->slave->limit('1');
    $obj = $CI->slave->get()->row();
    //echo $CI->slave->last_Query(); exit;
    return $obj;  
}

function get_product_image($product_id = NULL)
{
     if(!$product_id){return false;}
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->select('file_name');
    $CI->slave->from('ec_gallery');
    $CI->slave->where('product_id', $product_id);
    $CI->slave->order_by("id", "DESC");
    $CI->slave->limit('1');
    $obj = $CI->slave->get()->row();
    return $obj;  
}

function format_date_limadi_type($date)
{
    $date = date_create($date);
    $date = date_format($date,"d-m-Y H:i");
    return $date;
}

function format_date_mysql_type($date,$date_only = NULL)
{
    $date = date_create($date);
    if($date_only){
        $date = date_format($date,"Y-m-d");
    }else{
        $date = date_format($date,"Y-m-d H:i:s");
    }
    return $date;
}

function random_string( $length = 8 )
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function valid_email($email){
    $success = 0;
    if (preg_match("/^[a-zA-Z0-9\'\.\-_\+]+@[a-zA-Z0-9\-]+\.([a-zA-Z0-9\-]+\.)*?[a-zA-Z]+$/i",$email)) {
        $success = 1;
    }
    return $success;
}

function is_api()
{
    if(isset($_POST['api']) && $_POST['api'] == 1)
    {
        return 1;
    }
    return 0;
}

function logged_in()
{
    $CI =& get_instance();
    $TYPE = $CI->session->userdata('type');
    if($CI->session->userdata($TYPE) && isset($CI->session->userdata($TYPE)['logged_in'])){
        return true;
    }else{
        return false;
    }
}

function is_auth()
{
    $CI =& get_instance();
    $TYPE = $CI->session->userdata('type');
    if($CI->session->userdata($TYPE) && isset($CI->session->userdata($TYPE)['logged_in'])){
        if(isset($_POST['api']) && $_POST['api'] == 1){
            $ret_data = array('status' => '1', 'message' => 'Already Login.', 'data' => array());
            header('Content-Type: application/json');
            echo json_encode($ret_data);
            die();
        }else{
            redirect("$TYPE/dashboard");
        }
    }
}

function remove_extra_for_api($msg)
{
	$msg = preg_replace('/\n/', '', $msg);
	//$msg = str_replace(",", "", $msg);  
	$msg = strip_tags($msg);
	return $msg;
}

function uniq_uid ()
{
    $uniqid = uniqid();
    return $uniqid;
}

function message_box($msg, $status = 'success'){
	$response = '';
	$class = 'danger';
	if($status == 'success'){
		$class = 'success';
	}
	if(!empty($msg)){
		$response = '<div class="alert alert-'.$class.' no-margin" style="margin-bottom:15px!important;">'.$msg.'</div>';
	}
	return $response;
}

function banner_type($type = NULL)
{
    $array = array(1=>"Home Page Banner",2=>"Featured Categories Banner", 3=>"Featured Banner", 4=>"New Arrivals Banner", 5=>"Best Selling Banner");
    if(isset($type) && $array[$type]){
        return $array[$type];
    }
    return $array;
}
function get_permalink($product_slug=null) {       
         
	if ( $product_slug ) {
	   return base_url().'product/detail/'.$product_slug;
	}else{
	   return null;
	}		
}
function get_thumb_link($product_id=null) {       
         
	if ( $product_id ) {
		$img = get_product_image($product_id);
	   return base_url().'assets/uploads/files/'.$img->file_name;
	}else{
	   return null;
	}		
}

function get_cart()
{
    $CI =& get_instance();
	$cart_details_session = ($CI->session->userdata('cart')) ? $CI->session->userdata('cart') : array();
	//echo "<pre>"; print_r($cart_details_session);
    $TYPE = $CI->session->userdata('type');
	$cart_details_db = array();
    if($CI->session->userdata($TYPE) && isset($CI->session->userdata($TYPE)['logged_in'])){
        $customer_id = $CI->session->userdata($TYPE)['login_id'];
        $CI->db->select('*');
        $CI->db->from('ec_order_items as ot');
        $CI->db->join('ec_order_product as op', 'ot.order_item_id=op.order_item_id');
        $CI->db->join('ec_order_itemmeta as oi', 'ot.order_item_id=oi.order_item_id');
        $CI->db->where("ot.customer_id", $customer_id);
        $CI->db->where("ot.order_id", NULL);
        $cart_array = $CI->db->get()->result();
		//echo  $CI->db->last_query();
        
        if($cart_array){
            foreach($cart_array as $row){
                $cart_details_db[$row->order_item_id] = (array) $row;
            }
        }
    }
	$cart_details = array();
	if($cart_details_session){
		foreach($cart_details_session as $row => $val){
			$cart_details[$row] = $val;
		}
	}
	if($cart_details_db){
		foreach($cart_details_db as $row => $val){
			$cart_details[$row] = $val;
		}
	}	
	//echo "<pre>"; print_r($cart_details);exit;
    return $cart_details;
}

function cart_item_count()
{
	$get_cart = get_cart();
	//echo "<pre>";print_r($get_cart); echo "</pre>";die;
    $product_qty = 0;
    if($get_cart){
        foreach($get_cart as $key => $val){
            $product_qty+=isset($val['product_qty']) ? $val['product_qty'] : 0;
        }
    }
	return $product_qty;
}

function get_slug($string){
$string = trim($string);
$string = strtolower($string);
$string = str_replace(' ', '-', $string);
$slug=preg_replace('/[^A-Za-z0-9-]+/', '', $string);
return $slug;
}   


#This function add by maharaj

function order_status($type = NULL)
{
    //$array = array(1=>"Pending", 2=> "Approved", 3=>"Cancelled", 4=>"Completed", 5=>"Awaiting Payment", 6=>"Disputed");

    $array = array(0=>"Incomplete",1=>"Pending",2=>"Shipped",3=>"Partially Shipped",4=>"Refunded",5=>"Cancelled",6=>"Declined",7=>"Awaiting Payment",8=>"Awaiting Pickup",9=>"Awaiting Shipment",10=>"Completed",11=>"Awaiting Fulfillment",12=>"Manual Verification Required",13=>"Disputed",14=>"Partially Refunded", 15=> "Approved");

    if(isset($type) && $array[$type]){
        return $array[$type];
    }
    
    return $array;
}


function order_item_status($type = NULL)
{
    $array = array(1=>"Pending", 2=> "Shipped", 3=>"Cancelled", 4=>"Delivered", 5=>"Refunded", 6=>"Payment", 7=>"Disputed", 8=>"Refunded", 9=>"Dispatched", 10=>"Shipped", 10=>"Completed");

    if(isset($type) && $array[$type]){
        return $array[$type];
    }
    
    return $array;
}


function get_customer($customer_id = NULL)
{
    if(!$customer_id){return false;}
    $CI =& get_instance();
    $CI->slave = $CI->load->database('slave', TRUE);
    $CI->slave->select('customer_uid, fname, lname');
    $CI->slave->from('ec_customer');
    $CI->slave->where('customer_id', $customer_id);
    $obj = $CI->slave->get()->row();
    return $obj;  
}



?>
