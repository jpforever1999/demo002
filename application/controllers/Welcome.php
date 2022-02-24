<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
		$this->load->model('Product_model');
		$this->load->model('Widgets_model');
        $this->load->helper('text');
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

    public function index() 
    {
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $data['homepage'] = '1';
		
        $this->load->template("$this->TYPE/index", $data);
    }
	
	 public function ajaxsubscribeform()
    {
		$this->check_validation();
        $data = array();
		
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
		
        if ($this->form_validation->run() == FALSE)
        {
			echo json_encode(array('msg' => validation_errors(), 'success' => 0));
        }
        else{
            $data = $this->input->post();
            $data = $this->security->xss_clean($data);
			$this->insert_subscribe(array('DATA' => $data));
        }
   
    }  
    
    public function check_validation()
    {
        $this->load->helper(array('form', 'url'));		
        $this->load->library('form_validation');		
        $this->form_validation->set_error_delimiters('<div>', '</div>');          
        $this->form_validation->set_rules('email',' Email', 'trim|required|valid_email');      
      
    }
 
    public function insert_subscribe($args)
    {	
		$data['error'] = false;
        if(isset($args['DATA']) && $args['DATA'])
        {
			$url = base_url();
			$args['DATA']['ip_address'] = $_SERVER['REMOTE_ADDR'];	
			$args['DATA']['custype'] = 'subscribe';
			
			$email = $this->input->post('email');
			$email2 = explode( "@", $email);
			$email_name= $email2[0];
			
			$args['DATA']['fname'] = $email_name;					
            $last_inserted_id  =  $this->Query_model->insert_data('ec_enquiry',$args['DATA']);
			/*
			$details = array(
					'email'         => $email,
					'fname'         => $email_name,						
					'current_id'    => $last_inserted_id					
			);
			$this->session->set_userdata($this->TYPE, $details);
            */
		
			
			$this->load->library('mailer');
			$useremail = $email;
			$admin_email = 'jay@move2inbox.in';//admin@viralbake.com
			
			$msg = '<p style="text-align:center;">Thanks for subscription us! We will be in touch with you shortly.</p>';
			
			$admin_msg = '<div style="text-align:center;"><p>'.$useremail.' has subscription on klentano. <br ><br >Here is the submitted form data</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"><tr><td>Email</td><td>'.$email.'</td> </tr> </table></div>';
			
			$this->mailer->smtp(array('SUBJECT' => 'Thank You subscription', 'EMAIL' => $useremail, 'CONTENT' => $msg));
			$this->mailer->smtp(array('SUBJECT' => 'Klentano Subscription', 'EMAIL' => $admin_email, 'CONTENT' => $admin_msg));
		   
		   if($last_inserted_id)
            {
                echo json_encode(array('msg' => 'Form submit Successfully', 'success' => 1));
            }
            else{
                echo json_encode(array('msg' => 'Form is not submitted', 'success' => 0));
            }
			
        }

    }
 
    
 #THIS FUNCTION USE FOR THE HOME PAGE DATA
    public function ajax_home()
    {
            if($this->input->post('api'))
            {
                $data['all_category']       = $this->ajax_get_all_category_list(array('widget' =>1, 'api' =>$this->input->post('api')));
            }
            $data['home_banner']        = $this->ajax_get_home_page_banner(array('widget' =>1));
            $data['top_cat_banner_web'] = $this->ajax_get_top_categories_banner(array('widget' =>1));
            $data['top_category']       = $this->ajax_get_top_category(array('widget' =>1));
            $data['featured_product']   = $this->ajax_get_featured_product(array('widget' =>1));
            $data['banner_strip_one']   = $this->ajax_get_banner_strip_one(array('widget' =>1));
            $data['new_arrivals']       = $this->ajax_get_new_arrivals(array('widget' =>1));
            $data['best_deals']         = $this->ajax_get_best_deals_product(array('widget' =>1));
            $data['banner_strip_two']   = $this->ajax_get_banner_strip_two(array('widget' =>1));
            $data['top_rated_products'] = $this->ajax_get_top_rated_products(array('widget' =>1));


        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    #THIS FUNCTION USE FOR ALL CATEGORY
    public function ajax_get_all_category_list($args=NULL)
    {
        $data       = array();
        $condition  = array('status'=> '1');
        $catlist    = $this->Query_model->get_data('ec_categories_prod', $condition);
        $count = 0;
        foreach ($catlist as $catlistdata) 
        {
            $row = array();
            $row['id']          = $catlistdata->id;
            $row['name']        = $catlistdata->name;
            $row['slug']        = $catlistdata->slug;
            $row['url']         = get_permalink($catlistdata->slug);
            $row['icon']        = isset($catlistdata->icon) ? base_url().'assets/categories/'.$catlistdata->icon : base_url().'assets/frontend/images/cl4.png';
            $row['thumbnail']   = isset($catlistdata->thumbnail) ? base_url().'assets/categories/'.$catlistdata->thumbnail : base_url().'assets/frontend/images/cl4.png';
            $data[] = $row;

            if($args['api'] == ''){
                $count++;
                if($count == 8){
                    break;
                }
            }
        }


        if(isset($args['widget']))
        {
            return $data;
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


    #THIS FUNCTION USE FOR MORE CATEGORY
    public function ajax_get_more_category_list($args=NULL)
    {
        $data       = array();
        $condition  = array('status'=> '1', 'orderby <=' => '0');
        $catlist    = $this->Query_model->get_data('ec_categories_prod', $condition);
        //print_r($catlist); exit;
        foreach ($catlist as $catlistdata) 
        {
            $row = array();
            $row['id']          = $catlistdata->id;
            $row['name']        = $catlistdata->name;
            $row['slug']        = $catlistdata->slug;
            $row['url']         = get_permalink($catlistdata->slug);
            $row['icon']        = isset($catlistdata->icon) ? base_url().'assets/categories/'.$catlistdata->icon : base_url().'assets/frontend/images/cl4.png';
            $row['thumbnail']   = isset($catlistdata->thumbnail) ? base_url().'assets/categories/'.$catlistdata->thumbnail : base_url().'assets/frontend/images/cl4.png';
            $data[] = $row;
        }


        if(isset($args['widget']))
        {
            return $data;
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

    #THIS FUNCTION USE FOR HOEM PAGE BANNER
    public function ajax_get_home_page_banner($args=NULL)
    {
        $data = array();
        $type = $this->input->post('type');
        $condition = array('enabled' => '1', 'type' => '1');
        $list = $this->Query_model->get_data('ec_banner', $condition, array('banner_id' => 'DESC'));

        foreach ($list as $productdata) 
        {
            $row = array();
            $row['banner_id']     = $productdata->banner_id;
            $row['title']         = isset($productdata->title) ? $productdata->title : '';
            $row['type']          = isset($productdata->type) ? $productdata->type : '';
            $row['banner_image'] = isset($productdata->banner_image) ? base_url().'assets/home_page_banner/'.$productdata->banner_image : base_url().'assets/frontend/images/cl4.png';
            $row['url']           = isset($productdata->url) ? $productdata->url : '';
            $row['height']        = isset($productdata->height) ? $productdata->height : '';
            $row['width']         = isset($productdata->width) ? $productdata->width : '';
            $row['enabled']       = $productdata->enabled;
            $data[] = $row;
        }

        if(isset($args['widget']))
        {
            return $data;
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


    #THIS FUNCTION USE FOR ALL CATEGORY
    public function ajax_get_top_category($args=NULL)
    {
        $data      = array();
        $condition = array('featured_cat' => '1'); 
        $catlist   = $this->Query_model->get_data('ec_categories_prod', $condition);
		//echo "<pre>"; print_r($catlist); echo "</pre>";die;
        foreach ($catlist as $catlistdata) 
        {
            $row = array();
            $row['id']          = $catlistdata->id;
            $row['name']        = $catlistdata->name;
            $row['slug']        = $catlistdata->slug;
            $row['url']         = get_permalink($catlistdata->slug);
            $row['icon']        = isset($catlistdata->icon) ? base_url().'assets/categories/'.$catlistdata->icon : base_url().'assets/frontend/images/cl4.png';
            $row['thumbnail']   = isset($catlistdata->thumbnail) ? base_url().'assets/categories/'.$catlistdata->thumbnail : base_url().'assets/frontend/images/cl4.png';
            $data[] = $row;
        }

        if(isset($args['widget']))
        {
            return $data;
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

    #THIS FUNCTION USE FOR NEW FEATIRED PRODUCTS
    public function ajax_get_featured_product($args=NULL)
    {
        $data = array();
        $length = $this->input->post('length');
        $list = $this->Query_model->get_data('ec_product');
        $count = 0;
        foreach ($list as $productdata) 
        {
            $row = array();
            $row['product_id']      = $productdata->product_id;
            $row['post_title']      = $productdata->post_title;
            $row['user_id']         = $productdata->user_id;
            $row['sale_price']      = $productdata->sale_price;
            $row['regular_price']   = $productdata->regular_price;
            $image_name             = isset(get_product_image($productdata->product_id)->file_name) ? get_product_image($productdata->product_id)->file_name : '';
            $row['featured_image']  = isset($image_name) ? base_url().'assets/uploads/files/'.$image_name : base_url().'assets/frontend/images/cl2.png';
            $row['post_slug']       = $productdata->post_slug;
            $row['url']             = get_permalink($productdata->post_slug);
            $data[] = $row;
            $count++;
            if(isset($args['widget']) && $count == 6){
                break;
            }
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        if(isset($args['widget']))
        {
            return $data;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }

     #THIS FUNCTION USE FOR ALL CATEGORY
    public function ajax_get_category_list($args=NULL)
    {
        $data       = array();
        $condition  = array('status'=> '1');
        $catlist    = $this->Query_model->get_data('ec_categories_prod', $condition);
        foreach ($catlist as $catlistdata) 
        {
            $row = array();
            $row['id']          = $catlistdata->id;
            $row['name']        = $catlistdata->name;
            $row['slug']        = $catlistdata->slug;
            $row['url']         = get_permalink($catlistdata->slug);
            $row['icon']        = isset($catlistdata->icon) ? base_url().'assets/images/'.$catlistdata->icon : base_url().'assets/frontend/images/cl4.png';
            $row['thumbnail']   = isset($catlistdata->thumbnail) ? base_url().'assets/images/'.$catlistdata->thumbnail : base_url().'assets/frontend/images/cl4.png';
            $data[] = $row;
        }


        if(isset($args['widget']))
        {
            return $data;
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


    #THIS FUNCTION USE FOR TOP CATEGORIES BANNER FOR WEB
    public function ajax_get_top_categories_banner($args=NULL)
    {
        $data = array();
        $type = $this->input->post('type');
        $condition = array('enabled' => '1', 'type' => '2');
        $list = $this->Query_model->get_data('ec_banner', $condition, array('banner_id' => 'DESC'));

        foreach ($list as $productdata) 
        {
            $row = array();
            $row['banner_id']     = $productdata->banner_id;
            $row['title']         = isset($productdata->title) ? $productdata->title : '';
            $row['type']          = isset($productdata->type) ? $productdata->type : '';
            $row['banner_image'] = isset($productdata->banner_image) ? base_url().'assets/home_page_banner/'.$productdata->banner_image : base_url().'assets/frontend/images/cl4.png';
            $row['url']           = isset($productdata->url) ? $productdata->url : '';
            $row['height']        = isset($productdata->height) ? $productdata->height : '';
            $row['width']         = isset($productdata->width) ? $productdata->width : '';
            $row['enabled']       = $productdata->enabled;
            $data[] = $row;
        }

        if(isset($args['widget']))
        {
            return $data;
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



    #THIS FUNCTION USE FOR BANNER STRIP ONE
    public function ajax_get_banner_strip_one($args=NULL)
    {
        $data = array();
        $type = $this->input->post('type');
        $condition = array('enabled' => '1', 'type' => '3');
        $list = $this->Query_model->get_data('ec_banner', $condition, array('banner_id' => 'DESC'));

        foreach ($list as $productdata) 
        {
            $row = array();
            $row['banner_id']     = $productdata->banner_id;
            $row['title']         = isset($productdata->title) ? $productdata->title : '';
            $row['type']          = isset($productdata->type) ? $productdata->type : '';
            $row['banner_image'] = isset($productdata->banner_image) ? base_url().'assets/home_page_banner/'.$productdata->banner_image : base_url().'assets/frontend/images/cl4.png';
            $row['url']           = isset($productdata->url) ? $productdata->url : '';
            $row['height']        = isset($productdata->height) ? $productdata->height : '';
            $row['width']         = isset($productdata->width) ? $productdata->width : '';
            $row['enabled']       = $productdata->enabled;
            $data[] = $row;
        }

        if(isset($args['widget']))
        {
            return $data;
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


    #THIS FUNCTION USE FOR NEW ARRIVALS PRODUCTS
    public function ajax_get_new_arrivals($args=NULL)
    {
        $data = array();
        $length = $this->input->post('length');
        $list = $this->Query_model->get_data('ec_product');
        $count = 0;
        foreach ($list as $productdata) 
        {
            $row = array();
            $row['product_id']      = $productdata->product_id;
            $row['post_title']      = $productdata->post_title;
            $row['user_id']         = $productdata->user_id;
            $row['sale_price']      = $productdata->sale_price;
            $row['regular_price']   = $productdata->regular_price;
            $image_name             = isset(get_product_image($productdata->product_id)->file_name) ? get_product_image($productdata->product_id)->file_name : '';
            $row['featured_image']  = isset($image_name) ? base_url().'assets/uploads/files/'.$image_name : base_url().'assets/frontend/images/cl2.png';
            $row['post_slug']       = $productdata->post_slug;
            $row['url']             = get_permalink($productdata->post_slug);
            $data[] = $row;
            $count++;
            if(isset($args['widget']) && $count == 6){
                break;
            }
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        if(isset($args['widget']))
        {
            return $data;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }


    #THIS FUNCTION USE FOR BEST DEALS PRODUCTS
    public function ajax_get_best_deals_product($args=NULL)
    {
        $data = array();
        $length = $this->input->post('length');
        $list = $this->Query_model->get_data('ec_product');
        $count = 0;
        foreach ($list as $productdata) 
        {
            $row = array();
            $row['product_id']      = $productdata->product_id;
            $row['post_title']      = $productdata->post_title;
            $row['user_id']         = $productdata->user_id;
            $row['sale_price']      = $productdata->sale_price;
            $row['regular_price']   = $productdata->regular_price;
            $image_name             = isset(get_product_image($productdata->product_id)->file_name) ? get_product_image($productdata->product_id)->file_name : '';
            $row['featured_image']  = isset($image_name) ? base_url().'assets/uploads/files/'.$image_name : base_url().'assets/frontend/images/cl2.png';
            $row['post_slug']       = $productdata->post_slug;
            $row['url']             = get_permalink($productdata->post_slug);
            $data[] = $row;
            $count++;
            if(isset($args['widget']) && $count == 6){
                break;
            }
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        if(isset($args['widget']))
        {
            return $data;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }

    #THIS FUNCTION USE FOR BANNER STRIP TWO
    public function ajax_get_banner_strip_two($args=NULL)
    {
        $data = array();
        $type = $this->input->post('type');
        $condition = array('enabled' => '1', 'type' => '5');
        $list = $this->Query_model->get_data('ec_banner', $condition, array('banner_id' => 'DESC'));

        foreach ($list as $productdata) 
        {
            $row = array();
            $row['banner_id']     = $productdata->banner_id;
            $row['title']         = isset($productdata->title) ? $productdata->title : '';
            $row['type']          = isset($productdata->type) ? $productdata->type : '';
            $row['banner_image'] = isset($productdata->banner_image) ? base_url().'assets/home_page_banner/'.$productdata->banner_image : base_url().'assets/frontend/images/cl4.png';
            $row['url']           = isset($productdata->url) ? $productdata->url : '';
            $row['height']        = isset($productdata->height) ? $productdata->height : '';
            $row['width']         = isset($productdata->width) ? $productdata->width : '';
            $row['enabled']       = $productdata->enabled;
            $data[] = $row;
        }

        if(isset($args['widget']))
        {
            return $data;
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


    #THIS FUNCTION USE FOR TOP RATED PRODUCTS
    public function ajax_get_top_rated_products($args=NULL)
    {
        $data = array();
        $length = $this->input->post('length');
        $list = $this->Query_model->get_data('ec_product');
        $count = 0;
        foreach ($list as $productdata) 
        {
            $row = array();
            $row['product_id']      = $productdata->product_id;
            $row['post_title']      = $productdata->post_title;
            $row['user_id']         = $productdata->user_id;
            $row['sale_price']      = $productdata->sale_price;
            $row['regular_price']   = $productdata->regular_price;
            $image_name             = isset(get_product_image($productdata->product_id)->file_name) ? get_product_image($productdata->product_id)->file_name : '';
            $row['featured_image']  = isset($image_name) ? base_url().'assets/uploads/files/'.$image_name : base_url().'assets/frontend/images/cl2.png';
            $row['post_slug']       = $productdata->post_slug;
            $row['url']             = get_permalink($productdata->post_slug);
            $data[] = $row;
            $count++;
            if(isset($args['widget']) && $count == 6){
                break;
            }
        }

        $response = array(
           'status'    => '1',
           'message'   => 'success',
           'data'      => $data
        );

        if(isset($args['widget']))
        {
            return $data;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }


	## add to cart 
	 public function ajaxaddtocart()
    {
		$this->validation();
        $data = array();
		$this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
		
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
        if(isset($args['DATA']) && $args['DATA'])
        {
			$url = base_url();
			//$args['DATA']['ip_address'] = $_SERVER['REMOTE_ADDR'];	
			//$args['DATA']['custype'] = 'customer';			
			//$email = $this->input->post('email');	
			
			$email = 'jpforever1999@gmail.com';
			$email2 = explode( "@", $email);
			$email_name= $email2[0];
			
			$args['DATA']['fname'] = $email_name;	

			//echo "<pre>"; print_r($args['DATA']); echo "</pre>";die;	 
			
            $last_inserted_id  =  $this->Query_model->insert_data('ec_enquiry',$args['DATA']);
			
			$details = array(
					'email'         => $email,
					'fname'         => $email_name,						
					'current_id'    => $last_inserted_id					
			);
			$this->session->set_userdata($this->TYPE, $details);
		
			
			$this->load->library('mailer');
			//$useremail = $email;
			$useremail = 'jpforever1999@gmail.com';
			$admin_email = 'jay@move2inbox.in';//admin@viralbake.com
			
			$msg = '<p style="text-align:center;">Thanks for purchase this product! We will be in touch with you shortly.</p>';
			
			$admin_msg = '<div style="text-align:center;"><p>'.$useremail.' has purchase product on klentano. <br ><br >Here is the submitted form data</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"><tr><td>Email</td><td>'.$email.'</td> </tr> </table></div>';
			
			$this->mailer->smtp(array('SUBJECT' => 'Thank You purchase', 'EMAIL' => $useremail, 'CONTENT' => $msg));
			$this->mailer->smtp(array('SUBJECT' => 'Klentano purchase', 'EMAIL' => $admin_email, 'CONTENT' => $admin_msg));
		   
		   if($last_inserted_id)
            {
                echo json_encode(array('msg' => 'Product added successfully', 'success' => 1));
            }
            else{
                echo json_encode(array('msg' => 'Form is not submitted', 'success' => 0));
            }
			
        }

    }
	#end add to cart

     #this function for add to Rating 
    public function ajax_add_to_review_rating()
    {
       if(!logged_in()){
            echo json_encode(array('msg' => 'Please Login', 'success' => 0));
            exit();
        }

        $data = array();
        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['error'] = false;
        $data['type'] = '';
        $data['message']['error'] = '';

        $this->insert_validation_review();

        if($_POST) {
            $data['user_id']           = $this->LOGIN_ID;
            $data['comment_post_ID']   = $this->input->post('comment_post_ID');
            $data['comment_content']   = $this->input->post('comment_content');
        }
        
        if ($this->form_validation->run())
        {
            $post_data = array(
                    'user_id'           => $data['user_id'],
                    'comment_post_ID'   => $data['comment_post_ID'],
                    'comment_content'   => $data['comment_content'],
            );

            $last_inserted_id = $this->Query_model->insert_data('ec_comments', $post_data);
            $this->session->set_flashdata('message', 'Data inserted sucessfully.');
        }
        
    }



    public function insert_validation_review()
    {
        $this->load->library('form_validation');        
        $this->form_validation->set_error_delimiters('<div>', '</div>');          
        $this->form_validation->set_rules('comment_content',' Product review', 'required'); 
    }
	
    public function ajax_set_default()
    {
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        if($id && $type == 'cur'){
            $obj = get_currency($id);
            if($obj){
                $this->session->set_userdata('cur', $obj->currency_id);
            }
        }else if($id && $type == 'ln'){
            $obj = get_language($id);
            if($obj){
                $this->session->set_userdata('ln', $obj->language_id);
            }
        }
        echo json_encode(array('msg' => 'Product added successfully', 'success' => 1));
    }


    public function ajax_add_to_wishlist()
    {
        if(!logged_in()){

            $response = array(
               'status'    => '0',
               'message'   => 'Please Login',
               'data'      => (array)$status
             );

            echo json_encode($response);
            exit();
        }

        $data = array();
        $data['csrf'] = csrf_token();
        $data['TYPE'] = $this->TYPE;
        $data['error'] = false;
        $data['type'] = '';
        $data['message']['error'] = '';


        if($_POST) {
            $data['customer_id']  = $this->input->post('customer_id');
            $data['product_id']   = $this->input->post('product_id');
        }

        $condition = array('customer_id'=> $data['customer_id'], 'product_id' => $data['product_id']);
        $status = $this->Query_model->get_data('ec_wishlist', $condition);

        if(count($status) > 0)
        {

            $response = array(
               'status'    => '0',
               'message'   => 'This product already in wishlist',
               'data'      => array(),
             );

            echo json_encode($response);
            exit();
        }

        $post_data = array(
                'customer_id'  => $data['customer_id'],
                'product_id'   => $data['product_id'],
        );

        $last_inserted_id = $this->Query_model->insert_data('ec_wishlist',$post_data);

        if($last_inserted_id)
        {
             $response = array(
               'status'    => '1',
               'message'   => 'Product add successfully in wishlist',
               'data'      => (array)$last_inserted_id
             );
            echo json_encode($response);
            exit();
           // echo json_encode(array('msg' => 'Product add successfully in wishlist', 'success' => 1, 'data' => $last_inserted_id));
        }
        else{
            $response = array(
               'status'    => '0',
               'message'   => 'Product not add successfully in wishlist',
               'data'      => (array)$data
             );
            //echo json_encode(array('msg' => 'Product not add successfully in wishlist', 'success' => 0, 'data' => array()));
            echo json_encode($response);
            exit();

        }

    }


}
