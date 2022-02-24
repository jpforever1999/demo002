<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

	function __construct() 
	{
        parent::__construct();
        $this->load->model('Query_model');	
        $this->load->model('Product_model'); 
        $this->load->model('Category_prod_model');
        $this->load->model('Tags_prod_model');		
        $this->load->model('files');
        $this->load->model('Attribute_model'); 
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
        $this->FNAME = $this->session->userdata($this->TYPE)['fname'];
	}
	 
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Product" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token(); 
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();		
		
        $this->load->template("$this->TYPE/product/index_product",$data);
	   //$this->load->view('imageUploadForm'); 
	}
	public function index_ajax_post()
    {
        $length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $type_array = array(1 => 'Fixed', 2 => 'Percentage');
        $list = $this->Product_model->get_datatable();			
        $data = array();
        foreach ($list as $obj) {
			
            $row = array();
			
			$author = $this->Query_model->get_author($obj->user_id);
			$autho_name = !empty($author->fname) ? $author->fname : $author->admin_uid;
			$row['product_id']   = $obj->product_id;
			$row['post_title']   = '<a href="/product/detail/'.$obj->post_slug.'">'.$obj->post_title.'</a>';
            $row['user_id']      = $autho_name;
			$row['comment']      = '-';
			$row['date']     	 = $obj->modified;
			$row['status']       = $obj->enabled;			
            $data[] = $row;
        } 
        $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Product_model->count_all(),
                "recordsFiltered" => $this->Product_model->count_filtered(),
                "data" => $data,
                );	
					
        echo json_encode($output);
    }
	/************upload image************/
	function files_upload(){
        $data = array();
        if($this->input->post('submitForm') && !empty($_FILES['upload_Files']['name'])){
			
            $filesCount = count($_FILES['upload_Files']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['upload_File']['name'] = $_FILES['upload_Files']['name'][$i];
                $_FILES['upload_File']['type'] = $_FILES['upload_Files']['type'][$i];
                $_FILES['upload_File']['tmp_name'] = $_FILES['upload_Files']['tmp_name'][$i];
                $_FILES['upload_File']['error'] = $_FILES['upload_Files']['error'][$i];
                $_FILES['upload_File']['size'] = $_FILES['upload_Files']['size'][$i];
                // $uploadPath = './assets/uploads/files/';
                // Desired folder structure
                $uploadPath = './assets/uploads/files/'.$this->input->post('sku').'/';

                // To create the nested structure, the $recursive parameter 
                // to mkdir() must be specified.

                if (!mkdir($uploadPath, 0777, true)) {
                        die('Failed to create folders...');
                }

                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png';                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('upload_File')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$i]['modified'] = date("Y-m-d H:i:s"); 
                }
            }            
            if(!empty($uploadData)){
                //Insert file information into the database
                $insert = $this->files->insert($uploadData);
                $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg',$statusMsg);
            }
			        }
        //Get files data from database
        $data['gallery'] = $this->files->getRows();
        //Pass the files data to view
        //$this->load->view('files_upload/index', $data);
		$this->load->template("$this->TYPE/product/upload_view", $data);
    }
	
	/******************end*********/
	
	public function get_slug($string){
        $string = trim($string);
        $string = strtolower($string);
        $string = str_replace(' ', '-', $string);
        $slug   = preg_replace('/[^A-Za-z0-9-]+/', '', $string);
        $slug   = preg_replace("/[\-]+/", '-', $slug);
        return $slug;
    }   
	
		
	public function add()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
		$this->post();
	}

	public function update($product_id)
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");       
		$this->post($product_id);
    }

	function post($product_id = NULL)
    {
        $data =array();	
        $data = $this->input->post();	
        //echo "<pre>"; print_r($data ); echo "</pre>";	die;
        $qtyrange = $this->input->post('quantity_range');
        if($qtyrange){
            $qtyrange = serialize($qtyrange);	
        }else{
            $qtyrange = '';
        }

        $pricerange = $this->input->post('price_range');
        if($pricerange){
            $pricerange = serialize($pricerange);	
        }else{
            $pricerange = '';
        }					
        $user = $this->session->userdata();		
        $current_id =$user['admin']['login_id'];		
        $data['categories'] = $this->Category_prod_model->find_list_prod();		
        $data['tags'] = $this->Tags_prod_model->find_list_prod();
        $allready = '';	
        if(isset($product_id)){
            $allready = $this->Attribute_model->get_attr_already($product_id);
        }
        if($allready){			
            $data['all_data_attr'] = $allready = $this->Attribute_model->get_attr_already($product_id);
        }else{
            $data['all_data_attr'] =$all_data_attr = $this->Attribute_model->get_attr();
        }
        if(isset($product_id)){
            $data['all_vari'] = $this->Attribute_model->get_attr_vari($product_id);
            $data['all_vari_term'] = $this->Attribute_model->get_attr_vari_item($product_id);
        }
        $all_attr =$this->Attribute_model->get_attr($id = null);		
        $all_attributes = array();
        if($all_attr){
            foreach($all_attr as $rr){
                $all_attributes[$rr->attribute_id] = $rr->name;
            }
        }
        if(isset($product_id)){
            $data['all_attr'] = $all_attributes;
        }

        $all_item = $this->Attribute_model->get_all_item($id = null);

        $iterm= array();
        foreach($all_item as $k=>$v){						
            $iterm[$v->attribute_id][]=$v;
        }
        $data['all_iterm'] =$iterm;

        $brand_array = array();
        $brand_obj = $this->Query_model->get_data('ec_brand', array('status' => '1'));
        $data['brand_obj'] = $brand_obj;	
        $supplier_obj = $this->Query_model->get_data('ec_supplier', array('status' => '1'));
        $data['supplier_obj'] = $supplier_obj;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_title', 'Post Title', 'trim|required');        
#$this->form_validation->set_rules('post_slug', 'Post Slug', 'trim|required|callback_unique_product_slug['.$this->LOGIN_ID.']');
        if(isset($product_id)){			
            $product_obj = $this->Query_model->get_data_obj('ec_product',array('product_id' => $product_id, 'enabled' => '1')); 
            if(!$product_obj){
                $this->session->set_flashdata('error', 'Invalid Error.');
                redirect("$this->TYPE/product");
            }			 
            $data['gallery'] = $this->Query_model->get_data('ec_gallery',array('product_id' => $product_id));		
        }
        if($_POST) {		
            $data =  array(
                    'type'                  => $data['type'],
                    'post_title'          	=> $data['post_title'],
                    'post_title_es'         => $data['post_title_es'],
                    'post_content'        	=> $data['post_content'],
                    'post_content_es'       => $data['post_content_es'],
                    'tax_id'                => $data['tax_id'],
                    'shipping_id'           => $data['shipping_id'],
                    'brand_id'              => $data['brand_id'],
                    'supplier_id'           => $data['supplier_id'],
                    'post_slug'           	=> $this->get_slug( $data['post_title'] ),
                    'regular_price'       	=> $data['regular_price'],
                    'sale_price'       	  	=> $data['sale_price'],
                    'sale_price_dates_from' => $data['sale_price_dates_from'],
                    'sale_price_dates_to'   => $data['sale_price_dates_to'],				
                    'sku'        		  	=> $data['sku'],
                    'stock'               	=> $data['stock'],
                    'weight'               	=> $data['weight'],
                    'length'               	=> $data['length'],
                    'width'               	=> $data['width'],
                    'height'               	=> $data['height'],			
                    'quantity_range'      	=> $qtyrange,
                    'price_range'         	=> $pricerange,
                    //'price_range'       	=> $data['price_range'],
                    'enabled'             	=> $data['enabled'],				   
                    );		

        }else{
            if(isset($product_id)){
                $current_category = $this->db->select('category_id')->where(array('post_id' => $product_id ))->get('ec_product_categories')->result_array();
                $current_tag = $this->db->select('tag_id')->where(array('post_id' => $product_id ))->get('ec_product_tags')->result_array();
                $current_attributes = $this->Attribute_model->get_data_attr($product_id);

                $category_ids = array();
                if(!empty($current_category)){
                    foreach($current_category as $current){
                        $category_ids[] = $current['category_id'];
                    }
                }

                $tag_ids = array();
                if(!empty($current_tag)){
                    foreach($current_tag as $cur_tag){
                        $tag_ids[] = $cur_tag['tag_id'];
                    }
                }
                $data['category_ids'] = $category_ids;
                $data['tag_ids'] = $tag_ids;	

                $attr_idds = array();
                $attributes_ids_array = array();			
                $selected_attr = array();
                if($current_attributes){
                    foreach($current_attributes as $cur_attr){

                        $attr_idds[$cur_attr->attribute_id][] = $cur_attr;
                        $selected_attr[$cur_attr->attribute_id] = $data['all_attr'][$cur_attr->attribute_id];
                        $attributes_ids_array[$cur_attr->attribute_item_id] = $cur_attr->name;

                    }
                }
                $data['attributes_ids'] = $attributes_ids_array;			
                $data['all_attr'] = $selected_attr;				

                $get_data = (array)$this->Product_model->edit($product_id);
                $data1['product_id'] = $get_data;			
                $data1 = array_merge($data,$get_data);			
                $data =  array(
                        'type'        	        => $product_obj->type,
                        'post_title'        	=> $product_obj->post_title,
                        'post_title_es'        	=> $product_obj->post_title_es,
                        'post_content'      	=> $product_obj->post_content,				
                        'post_content_es'      	=> $product_obj->post_content_es,				
                        'post_slug'         	=> $this->get_slug($product_obj->post_slug),
                        'tax_id'                => $product_obj->tax_id,
                        'shipping_id'           => $product_obj->shipping_id,
                        'brand_id'              => $product_obj->brand_id,
                        'supplier_id'           => $product_obj->supplier_id,
                        //'featured_image'  	=> $product_obj->featured_image,
                        'regular_price'    		=> $product_obj->regular_price,
                        'sale_price'     		=> $product_obj->sale_price,
                        'sale_price_dates_from' => $product_obj->sale_price_dates_from,
                        'sale_price_dates_to'   => $product_obj->sale_price_dates_to,
                        'sku'       			=> $product_obj->sku,
                        'stock'      			=> $product_obj->stock,
                        'weight'            	=> $product_obj->weight,
                        'length'            	=> $product_obj->length,
                        'width'             	=> $product_obj->width,
                        'height'            	=> $product_obj->height,
                        'quantity_range'  		=> $product_obj->quantity_range,
                        'price_range'     		=> $product_obj->price_range,
                        'enabled'         		=> $product_obj->enabled,						   
                        );

                $data = array_merge($data1,$get_data);
            }			
        }

        if ($this->form_validation->run() == FALSE){

            $action_bc = isset($product_id) ? 'Update' : 'Add';	
            $crumbs = array("Home" => "/$this->TYPE/dashboard", "product" => "/$this->TYPE/product/", "$action_bc" => 'action');
            $breadcrumbs = $this->breadcrumbs->show($crumbs);
            $data['breadcrumbs']    = $breadcrumbs;

            $data['csrf'] = csrf_token();
            $data['TYPE'] = $this->TYPE;
            $data['action'] = isset($product_id) ? 'update' : 'add';
            $data['product_id'] = isset($product_id) ? $product_id : NULL;

            $tax_obj = $this->Query_model->get_data('ec_tax', array('status' => '1'));
            $shipping_obj = $this->Query_model->get_data('ec_shipping', array('status' => '1'));

            if(isset($data['sale_price_dates_from']) && $data['sale_price_dates_from'] == '0000-00-00 00:00:00'){
                $data['sale_price_dates_from'] = '';
            }
            if(isset($data['sale_price_dates_to']) && $data['sale_price_dates_to'] == '0000-00-00 00:00:00'){
                $data['sale_price_dates_to'] = '';
            }
            $data['tax_obj'] = $tax_obj;
            $data['shipping_obj'] = $shipping_obj;

            $this->load->template("$this->TYPE/product/post_form",$data);
        }else{
            if(!empty($_FILES['upload_Files']['name'])){

                $uploadData = array();
                $filesCount = count($_FILES['upload_Files']['name']);
                for($i = 0; $i < $filesCount; $i++){

                    $img2_name = preg_replace('/\s*/', '', $_FILES['upload_Files']['name'][$i]);
                    // convert the string to all lowercase
                    $img2 = strtolower($img2_name); 					
                    $_FILES['upload_File']['name'] = $img2;
                    $_FILES['upload_File']['type'] = $_FILES['upload_Files']['type'][$i];
                    $_FILES['upload_File']['tmp_name'] = $_FILES['upload_Files']['tmp_name'][$i];
                    $_FILES['upload_File']['error'] = $_FILES['upload_Files']['error'][$i];
                    $_FILES['upload_File']['size'] = $_FILES['upload_Files']['size'][$i];
                    $uploadPath = './assets/uploads/files/'; 				
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'gif|jpg|png';  				
                    $this->load->library('upload', $config);				
                    $this->upload->initialize($config);				
                    if($this->upload->do_upload('upload_File')){					
                        $fileData = $this->upload->data();					
                        $img_name = preg_replace('/\s*/', '', $fileData['file_name']);
                        $img = strtolower($img_name);
                        $uploadData[$i]['file_name'] = $img;
                        $uploadData[$i]['created'] = date("Y-m-d H:i:s");
                        $uploadData[$i]['modified'] = date("Y-m-d H:i:s");
                    }
                } 

                $db_data =  array(
                        'type'       		    => $data['type'],
                        'post_title'       		=> $data['post_title'],
                        'post_title_es'       	=> $data['post_title_es'],
                        'post_content'     		=> $data['post_content'],
                        'post_content_es'     	=> $data['post_content_es'],
                        'tax_id'                => $data['tax_id'],
                        'shipping_id'           => $data['shipping_id'],
                        'brand_id'              => $data['brand_id'],
                        'supplier_id'           => $data['supplier_id'],
                        'post_slug'        		=> $this->get_slug( $data['post_title'] ),
                        'regular_price'    		=> $data['regular_price'],
                        'sale_price'       		=> $data['sale_price'],
                        'sale_price_dates_from' => $data['sale_price_dates_from'],
                        'sale_price_dates_to'   => $data['sale_price_dates_to'],
                        'sku'     		   		=> $data['sku'],
                        'stock'     	   		=> $data['stock'],
                        'weight'           		=> $data['weight'],
                        'length'           		=> $data['length'],
                        'width'            		=> $data['width'],
                        'height'           		=> $data['height'],					
                        'quantity_range'   		=> $qtyrange,
                        'price_range'      		=> $pricerange,					
                        'post_type'        		=> 'product',
                        'enabled'          		=> $data['enabled'],
                        'user_id'          		=> $current_id
                            );	
            }else{
                $db_data =  array(
                        'type'       		    => $data['type'],
                        'post_title'       		=> $data['post_title'],
                        'post_title_es'       	=> $data['post_title_es'],
                        'post_content'     		=> $data['post_content'],				
                        'post_content_es'     	=> $data['post_content_es'],				
                        'tax_id'                => $data['tax_id'],
                        'shipping_id'           => $data['shipping_id'],
                        'brand_id'              => $data['brand_id'],
                        'supplier_id'           => $data['supplier_id'],
                        'post_slug'        		=> $this->get_slug( $data['post_title'] ),
                        'regular_price'    		=> $data['regular_price'],
                        'sale_price'      		=> $data['sale_price'],
                        'sale_price_dates_from' => $data['sale_price_dates_from'],
                        'sale_price_dates_to'   => $data['sale_price_dates_to'],
                        'sku'     		   		=> $data['sku'],
                        'stock'    		   		=> $data['stock'],
                        'weight'           		=> $data['weight'],
                        'length'           		=> $data['length'],
                        'width'            		=> $data['width'],
                        'height'           		=> $data['height'],					
                        'quantity_range'   		=> $qtyrange,
                        'price_range'      		=> $pricerange,					
                        'enabled'          		=> $data['enabled'],
                        'post_type'        		=> 'product',
                        'user_id'          		=> $current_id
                            );
            }

            if(isset($product_id)){
                $this->Query_model->update_data('ec_product',$db_data,array('product_id' => $product_id));
                $this->session->set_flashdata('success', 'Updated Successfully.');				
                $post_id = $product_id;
                if(!empty($_POST['category'])){
                    $this->db->where('post_id',$post_id);
                    $this->db->where_not_in('category_id',$_POST['category']);
                    $this->db->delete('ec_product_categories');
                    foreach($_POST['category'] as $key => $cat_id){
                        if($this->db->where(array('post_id' => $post_id, 'category_id' => $cat_id))->get('ec_product_categories',1)->num_rows() < 1){
                            $post_category = array(
                                    'post_id' => $post_id,
                                    'category_id' => $cat_id
                                    );
                            $this->db->insert('ec_product_categories',$post_category);
                        }
                    }
                }

                if(!empty($_POST['tag'])){
                    $this->db->where('post_id',$post_id);
                    $this->db->where_not_in('tag_id',$_POST['tag']);
                    $this->db->delete('ec_product_tags');
                    foreach($_POST['tag'] as $key => $tag){
                        $existTag = $this->Tags_prod_model->find_by_id($tag);
                        if(!empty($existTag)){
                            if($this->db->where(array('post_id' => $post_id, 'tag_id' => $tag))->get('ec_product_tags',1)->num_rows() < 1){
                                $post_tag = array(
                                        'post_id' => $post_id,
                                        'tag_id' => $tag
                                        );
                                $this->db->insert('ec_product_tags',$post_tag);
                            }
                        }else{
                            $newTag = array(
                                    'name' => $tag,
                                    'slug' => url_title($tag,'-',true),
                                    'status' => 1
                                    );

                            $this->db->insert('ec_tags_prod',$newTag);
                            $tag_id = $this->db->insert_id();
                            $post_tag = array(
                                    'post_id' => $post_id,
                                    'tag_id' => $tag_id
                                    );
                            $this->db->insert('ec_product_tags',$post_tag);
                        }
                    }
                }

                $post_id = $product_id;
                if(!empty($_POST['attribute_item'])){
                    $this->db->where('product_id',$post_id);
                    $this->db->where_not_in('attribute_item_id',$_POST['attribute_item']);
                    $this->db->delete('ec_product_attribute');

                    foreach($_POST['attribute_item'] as $key => $cat_id){
                        if($this->db->where(array('product_id' => $post_id, 'attribute_item_id' => $cat_id))->get('ec_product_attribute',1)->num_rows() < 1){
                            $post_attribue_iterm = array(
                                    'product_id' => $post_id,
                                    'attribute_item_id' => $cat_id
                                    );
                            $this->db->insert('ec_product_attribute',$post_attribue_iterm);
                        }
                    }
                }				
                $post_id = $product_id;				
                //variation section							
                if(!empty($_FILES['_thumbnail_id']) && $_FILES['_thumbnail_id']!='' ){
                    $this->upload_color_image(array('product_id' =>$post_id ));				
                }elseif(!empty($_POST['_regular_price'])){
                    $this->db->where('product_id',$post_id);
                    $this->db->where_not_in('attribute_item_id',$_POST['attribute_item']);
                    $this->db->delete('ec_product_variation');

                    foreach($_POST['_regular_price'] as $index => $value){					
                        $attribute_item_id 	= $_POST['attr_itemid'][$index];
                        $sale_price 		= $_POST['_sale_price'][$index];
                        $regular_price 		= $_POST['_regular_price'][$index];
                        //$sku 				= $_POST['_sku'][$index];
                        $stock 				= $_POST['_stock'][$index];
                        $post_variation = array(
                                'product_id' => $post_id,
                                'attribute_item_id' => $attribute_item_id,
                                '_sale_price' => $sale_price,
                                '_regular_price' => $regular_price,
                                //'_sku' => $sku,
                                '_stock' => $sale_price,
                                );				
                        $this->db->insert('ec_product_variation',$post_variation);						
                    }
                }					
                $uploadData2 = array();						
                for($j = 0; $j < sizeof($uploadData); $j++){					
                    $uploadData2[$j]['file_name'] = $uploadData[$j]['file_name'];
                    $uploadData2[$j]['created'] =$uploadData[$j]['created'];
                    $uploadData2[$j]['modified'] =$uploadData[$j]['modified'];
                    $uploadData2[$j]['product_id'] = $product_id;
                }				
                if(!empty($uploadData2)){
                    //Insert file information into the database
                    $insert = $this->files->insert($uploadData2);
                    $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                    $this->session->set_flashdata('statusMsg',$statusMsg);
                }
            }else{				
                $last_inserted_id  = $this->Query_model->insert_data('ec_product',$db_data);
                $this->session->set_flashdata('success', 'Inserted Successfully.');

                $data = $_POST;
                unset($data['category']);
                unset($data['tag']);

                $_POST['category'] = $this->input->post('category');                  
                $_POST['tag'] = $this->input->post('tag');         

                if(!empty($_POST['category'])){
                    foreach($_POST['category'] as $key => $cat_id){
                        $post_category = array(
                                'post_id' => $last_inserted_id,
                                'category_id' => $cat_id
                                );
                        $this->db->insert('ec_product_categories',$post_category);
                    }
                }

                if(!empty($_POST['tag'])){
                    foreach($_POST['tag'] as $key => $tag){                                        
                        $post_tag = array(
                                'post_id' => $last_inserted_id,
                                'tag_id' => $tag
                                );
                        $this->db->insert('ec_product_tags',$post_tag);

                    }
                }

                if(!empty($_POST['attribute_item'])){
                    foreach($_POST['attribute_item'] as $key => $attribute_item){                                        
                        $attribute_item = array(
                                'product_id' => $last_inserted_id,
                                'attribute_item_id' => $attribute_item
                                );
                        $this->db->insert('ec_product_attribute',$attribute_item);

                    }
                }

                $uploadData1 = array();						
                for($j = 0; $j < sizeof($uploadData); $j++){					
                    $uploadData1[$j]['file_name'] = $uploadData[$j]['file_name'];
                    $uploadData1[$j]['created'] =$uploadData[$j]['created'];
                    $uploadData1[$j]['modified'] =$uploadData[$j]['modified'];
                    $uploadData1[$j]['product_id'] = $last_inserted_id;
                }
                if(!empty($uploadData1)){
                    //Insert file information into the database
                    $insert = $this->files->insert($uploadData1);
                    $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                    $this->session->set_flashdata('statusMsg',$statusMsg);
                }				
            }
            redirect("$this->TYPE/product");
        }
    }

    function unique_product_slug($value, $company_id)
    {
        $email = $this->input->post('email');
        $response = $this->Profile_model->unique_product_slug($email, $company_id);
        $status   = TRUE;
        $message  = '';
        $cnt = $response->cnt;

        if($cnt > 0) {
            $status   = FALSE;
            $message  = 'Product Title already exists <br/>';
        }

        if(!$status) {

            $this->form_validation->set_message('unique_product_slug', $message);
        }
        return $status;
    }

public function myupload() 
{
    $this->load->library('upload');//loading the library
    $imagePath = realpath(APPPATH . '../assets/images/carImages');//this is your real path APPPATH means you are at the application folder
    $number_of_files_uploaded = count($_FILES['files']['name']);

    if ($number_of_files_uploaded > 5){ // checking how many images your user/client can upload
        $carImages['return'] = false;
        $carImages['message'] = "You can upload 5 Images";
        echo json_encode($carImages);
    }
    else{
        for ($i = 0; $i < $number_of_files_uploaded; $i++) {
            $_FILES['userfile']['name']     = $_FILES['files']['name'][$i];
            $_FILES['userfile']['type']     = $_FILES['files']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $_FILES['files']['error'][$i];
            $_FILES['userfile']['size']     = $_FILES['files']['size'][$i];
            //configuration for upload your images
            $config = array(
                'file_name'     => random_string('alnum', 16),
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 3000,
                'overwrite'     => FALSE,
                'upload_path'
                =>$imagePath
            );
            $this->upload->initialize($config);
            $errCount = 0;//counting errrs
            if (!$this->upload->do_upload())
            {
                $error = array('error' => $this->upload->display_errors());
                $carImages[] = array(
                    'errors'=> $error
                );//saving arrors in the array
            }
            else
            {
                $filename = $this->upload->data();
                $carImages[] = array(
                    'fileName'=>$filename['file_name'],
                    'watermark'=> $this->createWatermark($filename['file_name'])
                );
            }//if file uploaded
            
        }//for loop ends here
        echo json_encode($carImages);//sending the data to the jquery/ajax or you can save the files name inside your database.
    }//else

}
	public function del()
    {

		$data['csrf'] = csrf_token();
	    $id = $this->input->post('id');
		$data['csrf'] = csrf_token();
        $data = array();
        $delete = $this->Product_model->delete_post($id);
        echo json_encode(array('success' => $delete));
		
    }	
	
	public function delimg()
    {
		$data['csrf'] = csrf_token();
	    $id = $this->input->post('id');
		$data['csrf'] = csrf_token();
        $data = array();
        $delete = $this->Product_model->delete_image($id);
        echo json_encode(array('success' => $delete));
    }

	public function delete_variation()
    {
		$data['csrf'] = csrf_token();
	    $id = $this->input->post('id');
		$postid = $this->input->post('postid');
		$data['csrf'] = csrf_token();
        $data = array();
        $delete = $this->Product_model->delete_variation_post($id,$postid);
        echo json_encode(array('success' => $delete));
    }
	
    public function get_attr(){
        $data = array();
        $data['csrf'] = csrf_token();
        $id = $this->input->post('id');
        $data['csrf'] = csrf_token();
        $data = array();
        $attribute_item = array();
        $attribute_item_obj = $this->Query_model->get_data('ec_attribute_item',array('attribute_id' => $id));
        if($attribute_item_obj){
            foreach($attribute_item_obj as $row){
                $attribute_item[$row->attribute_item_id] = $row->name;
            }
        }
    
        $response = array(
                'status' => 'success',
                'message' => 'success',
                'data' => $attribute_item
                );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
	public function get_vitem_ajax(){ 
        $data = array();
        $data['csrf'] = csrf_token();
        $id = $this->input->post('id');
        $data['csrf'] = csrf_token();
        $data = array();
		
        $attribute_item = array();
        $attribute_item_obj = $this->Query_model->get_data('ec_attribute_item',array('attribute_id' => $id));
        if($attribute_item_obj){
            foreach($attribute_item_obj as $row){
                $attribute_item[$row->attribute_item_id] = $row->name;
            }
        }
    
        $response = array(
                'status' => 'success',
                'message' => 'success',
                'data' => $attribute_item
                );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function upload_color_image($args)
    { 
        //print_r($args);die;
		//echo "<pre>"; print_r($_FILES['_thumbnail_id']['name']); echo "</pre>";
		
        $uploadData = array(); $error = ''; $errorUploadType = '';
        if(!empty($_FILES['_thumbnail_id']['name']))
        {
			//print_r($args);
			//die;
            $filesCount = count((array)$_FILES['_thumbnail_id']['name']);
            $fileNum = 0;
            for($i = 0; $i < $filesCount; $i++)
            {
                $fileNum++;
                $_FILES['file']['name']     = $_FILES['_thumbnail_id']['name'][$i];
                $_FILES['file']['type']     = $_FILES['_thumbnail_id']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['_thumbnail_id']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['_thumbnail_id']['error'][$i];
                $_FILES['file']['size']     = $_FILES['_thumbnail_id']['size'][$i];

				$img = preg_replace('/\s*/', '', $_FILES['file']['name']);
				$full_img = strtolower($img);
				//echo "<pre>"; print_r($config); echo "</pre>";	 die;	
                if($_FILES['file']['name'])
                {
                    $num = 1;
                                        
                    $config = array(
								'file_name' => $args['product_id'].'_'.$full_img,
								'upload_path' => "./assets/uploads",
								'allowed_types' => "gif|jpg|png|jpeg|pdf",
								'overwrite' => False,
								//'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
								//'max_height' => "800",
								//'max_width' => "800"
							); 
					
					//die;
							
                    $this->load->library('upload', $config);

                    $this->upload->initialize($config);

                    if($this->upload->do_upload('file'))
                    {
                        $fileData = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
                    }
                    else
                    {
                        if($this->upload->display_errors())
                        {
                            $error .= $this->upload->display_errors() . 'Picture'.$fileNum;
                        }
                        $errorUploadType .= $_FILES['file']['name'].' | ';
                    }
					
					//echo "<pre>"; print_r($uploadData); echo "</pre>";die;
                     
                }else{					
					//echo "hello";
					//echo "<pre>"; print_r($uploadData); echo "</pre>";die;
					
					 foreach($_POST['_regular_price'] as $index => $value){
                        $post_variation = array(
									'product_id' => $args['product_id'],
									'attribute_item_id' => $_POST['attr_itemid'][$index],
									'_sale_price' => $_POST['_sale_price'][$index],
									'_regular_price' => $_POST['_regular_price'][$index],
									//'_sku' => $_POST['_sku'][$index],
									'_stock' => $_POST['_stock'][$index],									
								);
						//echo "<pre>"; print_r($post_variation ); echo "</pre>";
						$this->db->where('product_id',$args['product_id']);
						$this->db->where('attribute_item_id',$_POST['attr_itemid'][$index]);
						$this->db->update('ec_product_variation',$post_variation);
                    }
					
				}
				
				
            }
			print_r($error);
		    //echo "<pre>";print_r($uploadData); echo "</pre>";die;
		   //echo $uploadData;
		   
		   foreach($uploadData as $index => $value){
				$post_variation = array(
							'product_id' => $args['product_id'],
							'attribute_item_id' => $_POST['attr_itemid'][$index],
							'_sale_price' => $_POST['_sale_price'][$index],
							'_regular_price' => $_POST['_regular_price'][$index],
							//'_sku' => $_POST['_sku'][$index],
							'_stock' => $_POST['_stock'][$index],
							'_thumbnail_id' => $value['file_name'],
						);
				$this->db->where('product_id',$args['product_id']);
				$this->db->where('attribute_item_id',$_POST['attr_itemid'][$index]);
				$this->db->update('ec_product_variation',$post_variation);
				}
		
			//echo "<pre>"; print_r($uploadData ); echo "</pre>";die;
			$attribute_item = '';		
			$attribute_item_obj = $this->Query_model->get_data('ec_product_variation',array('product_id'=>$args['product_id'],'attribute_item_id' => $_POST['attr_itemid'][$index]));
			 
			//echo "<pre>"; print_r($attribute_item_obj); echo "</pre>"; 
			
			if(empty($attribute_item_obj)){	
				foreach($uploadData as $index => $value){
					$post_variation = array(
								'product_id' => $args['product_id'],
								'attribute_item_id' => $_POST['attr_itemid'][$index],
								'_sale_price' => $_POST['_sale_price'][$index],
								'_regular_price' => $_POST['_regular_price'][$index],
								//'_sku' => $_POST['_sku'][$index],
								'_stock' => $_POST['_stock'][$index],
								'_thumbnail_id' => $value['file_name'],
							);
					//echo "<pre>"; print_r($post_variation ); echo "</pre>";die;
					$this->db->insert('ec_product_variation',$post_variation);
				}
			}		
                   // exit;
                     
        }
    }
    

}
