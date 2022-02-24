<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Product extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('Query_model');
		$this->load->model('Product_model');
        $this->load->helper('text');		
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

    public function index($arg=null) 
    { 
        $get_cart = get_cart();		
        $data         = array();
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $crumbs = array("Home" => "/$this->TYPE/product/", "product" => "");
        $breadcrumbs = $this->breadcrumbs->show_new($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $args = array('enabled' => '1');
        $data['count_all'] = $this->Query_model->count_all('ec_product',$args);

        $args = array('enabled' => '1');
        $data['products'] = $this->Query_model->get_data_obj('ec_product',$args);
        foreach($data['products'] as $k =>$val){	
            $args_image = array('product_id' => $val->product_id );
            $thumb_img = $this->Query_model->get_data('ec_gallery',$args_image);			
            if(isset($thumb_img) && !empty($thumb_img)){
                $val->image_path = base_url().'assets/uploads/files/'.$thumb_img[0]->file_name;
            } 				
        }			
        if(is_api()){

            unset($data['csrf']);
            unset($data['breadcrumbs']);
            unset($data['TYPE']);		
            $response = array(
                    'status' => '1',
                    'message' => 'success',
                    'data' => $data['products'],
                    );
            // $response['data'] = array();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }else{

            $this->load->template("$this->TYPE/product_list", $data);
        }

    }

    public function detail($slug=null) 
    {
        $data = array(); 
		$categories = '';
        $data['csrf'] = csrf_token(); 
        $data['TYPE'] = $this->TYPE;  
		
		if(is_api())
		{
			$product_id= $this->input->post('product_id');
		}else{
			if ($this->uri->segment(3) === FALSE){ 
				$post_slug = 0;
			}else{
				$post_slug = $this->uri->segment(3);
			}		
			$product_id = $this->get_page_id_by_slug($post_slug);					
        }
		
		$args = array('product_id' => $product_id, 'enabled' => '1');
		$data['detail'] = $this->Query_model->get_data_obj('ec_product',$args);	
			
		$title= $data['detail']->post_title;
		$crumbs = array("Home" => "/", "product" => "/shop", "$title" => '');
		$breadcrumbs = $this->breadcrumbs->show_new($crumbs);
		$data['breadcrumbs']    = $breadcrumbs;       
              
		$args_image = array('product_id' => $product_id );	
        $data['product_gallery'] = $this->Query_model->get_data('ec_gallery',$args_image);
		foreach($data['product_gallery'] as $key=>$val){			
			$val->url = base_url().'/assets/uploads/files/'.$val->file_name; 			
		}
		
        $args_variation = array('product_id' => $product_id );
        $variation = $this->Query_model->get_attr_vari_item($product_id);
		$vari_data = array();
        if(isset($variation)){
            foreach($variation as $k=>$v){         
                $vari_data[$v->attribute_name][] = $v;
            }
        }
		$data['variation']=$vari_data;
        
		$variat = array_keys($vari_data);
		$assoc = array();
		foreach ($variat as $i => $value) {
				$assoc[$value] = 1;
		}
		$attr_data = array();		 
		$get_attri = $this->Product_model->get_attr_item($product_id);
		if($get_attri){
            foreach($get_attri as $k=>$v){
				
				if(isset($assoc[$v->attribute_name])){
					unset($get_attri[$k]);
				}
            }
        }
		
		$attri_all = array();
        if(isset($get_attri)){
            foreach($get_attri as $k=>$v){               
                $attri_all[$v->attribute_name][] = $v;
            }
        }
        $data['attributes']=$attri_all;
		$args = array('post_id' => $product_id);
        $category = $this->Query_model->category($product_id);
		
		 if($category){
			$categories = $category->category_id;		 
			$data['related_post'] = $this->Query_model->related_post($categories,$product_id);
		 }
		$args = array('post_id' => $product_id);
        $taglist = $this->Product_model->taglist($product_id);
		$tag_array = array();
		if($taglist){
			foreach($taglist as $tl){
					$tag_array[] = $tl->tag_id;						
			}
			$tag_array = array_unique($tag_array);
			$tags= $this->Query_model->get_data('ec_tags_prod',array('id' => $tag_array));				
			$data['tags'] =$tags;
		}

		$data['delivery_return_widget']=$this->Product_model->delivery_return_widget();
		$data['seller_imformation']=$this->Product_model->seller_imformation();		
		$this->load->template("$this->TYPE/product_detail", $data);
		
		
        if(is_api()){
            unset($data['csrf']);
            unset($data['breadcrumbs']);
            unset($data['TYPE']);
            $response = array(
                'status' => '1',
                'message' => 'success',
                'data' => [$data],
             );
               // $response['data'] = array();
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
		
    }
    
    function get_page_id_by_slug($slug=null) {       
        $args = array('post_slug' => $slug, 'enabled' => '1');	
        $page= $this->Query_model->get_data_obj('ec_product',$args);      
        if ( $page ) {
           return (int) $page->product_id;
        }else{
           return null;
        }		
    }	    
}
