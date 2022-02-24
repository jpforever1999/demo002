<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_model extends MY_Model{

    function __construct() {
        parent::__construct();
    }   

    public function insert_data($table_name,$data)
    {
        $this->master->insert($table_name,$data);
        return  $this->master->insert_id();
    }

    public function update_data($table_name,$data,$condition)
    {
        foreach($condition as $column => $value){
            if(is_array($value)){
                $this->master->where_in($column, $value);
            }else{
                $this->master->where($column, $value);
            }
        }
        $this->master->update($table_name,$data);
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function get_data($table_name,$condition = NULL,$order = NULL,$limit = NULL)
    {
        $this->slave->select('*');
        $this->slave->from($table_name);
        if($condition){
            foreach($condition as $column => $value){
                if(is_array($value)){
                    $this->slave->where_in($column, $value);
                }else{
                    $this->slave->where($column, $value);
                }
            }
        }
        if($order){
            foreach($order as $column => $value){
                $this->slave->order_by($column, $value);
            }
        }
        if($limit){
            if(isset($limit['start'])){
            $this->slave->limit($limit['length'], $limit['start']);
            }else{
                $this->slave->limit($limit['length']);
            }
        }

        $obj = $this->slave->get()->result();
        //echo $this->slave->last_query(); exit;
        return $obj;
    }

    public function get_data_obj($table_name,$condition = NULL,$order = NULL,$limit = NULL)
    {
        $this->slave->select('*');
        $this->slave->from($table_name);
        if($condition){
            foreach($condition as $column => $value){
                if(is_array($value)){
                    $this->slave->where_in($column, $value);
                }else{
                    $this->slave->where($column, $value);
                }
            }
        }
        if($order){
            foreach($order as $column => $value){
                $this->slave->order_by($column, $value);
            }
        }
        if($limit){
            if(isset($limit['start'])){
                $this->slave->limit($limit['length'], $limit['start']);
            }else{
                $this->slave->limit($limit['length']);
            }
        }

        $obj = $this->slave->get()->result();
        if($obj && count($obj) == 1){
            $obj = $obj[0];
        }
        return $obj;
    }
	
	public function get_author($id)
    { 
        $this->slave->select('*');
        $this->slave->from('ec_admin');
        $this->slave->where('admin_id', $id);        
        $user = $this->slave->get()->row();
        return $user;
    }
    
    public function get_attr_vari_item($product_id=null)
    {	
    $sql="select a.*,b.attribute_id, c.name as attribute_name, b.name from ec_product_variation a,ec_attribute_item b,ec_attribute c 
where a.attribute_item_id = b.attribute_item_id and c.attribute_id=b.attribute_id and a.product_id=$product_id";	
    $query  =  $this->db->query($sql);
    $data   =  $query->result();
    return $data;
       
    }
    
    public function category($product_id=null)
    {	
    $sql="select group_concat(category_id) category_id from ec_product_categories where post_id=$product_id group by post_id";	
    $query  =  $this->db->query($sql);
    $data   =  $query->row();
    return $data;
       
    } 
	 /*public function taglist($product_id=null)
    {	
    $sql="select category_id category_id from ec_product_categories where post_id=$product_id";	
    $query  =  $this->db->query($sql);
    $data   =  $query->result();
	///echo $this->db->last_query();
	//die;
    return $data;
       
    } */
	
    
    
    public function related_post($category_id=null,$product_id=null)
    {
	$data = array();	
	if(isset($category_id)){	
	$sql= "select a.*, b.category_id from ec_product a,ec_product_categories b 
where b.category_id IN($category_id) and b.post_id !=$product_id and a.product_id = b.post_id group by a.product_id 
ORDER BY a.product_id DESC limit 10"; 	
	
    $query  =  $this->db->query($sql);
    $data   =  $query->result();
	}
	//echo $this->db->last_query();
	//die;
    return $data;
    }
 

    //add by Maharaj Singh

    public function delete($table_name, $condition)
    {
        if($condition){
        foreach($condition as $column => $value)
                $this->master->where($column, $value);
        }
        $this->master->delete($table_name);
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }
    

    public function count_filtered($table_name = NULL, $condition = NULL)
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from($table_name);
        if($condition){
            foreach($condition as $column => $value){
                if(is_array($value)){
                    $this->slave->where_in($column, $value);
                }else{
                    $this->slave->where($column, $value);
                }
            }
        }
        $query = $this->slave->get()->row();
        return $query->CNT;
    }


    public function count_all($table_name = NULL , $condition = NULL)
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from($table_name);
        if($condition){
            foreach($condition as $column => $value){
                if(is_array($value)){
                    $this->slave->where_in($column, $value);
                }else{
                    $this->slave->where($column, $value);
                }
            }
        }
        $query = $this->slave->get()->row();
        return $query->CNT;
    }


    public function find_by_id($table_name, $condition = NULL,$order = NULL,$limit = NULL)
    {
        $this->slave->select('*');
        $this->slave->from($table_name);
        if($condition){
            foreach($condition as $column => $value){
                if(is_array($value)){
                    $this->slave->where_in($column, $value);
                }else{
                    $this->slave->where($column, $value);
                }
            }
        }

        $obj = $this->slave->get()->result();
        //echo $this->slave->last_query(); exit;
        if($obj && count($obj) == 1){
            $obj = $obj[0];
        }
        return $obj;
    }


    public function delete_query($table = NULL, $condition = NULL)
    {
        if($condition){
            foreach($condition as $column => $value){
                if(is_array($value)){
                    $this->master->where_in($column, $value);
                }else{
                    $this->master->where($column, $value);
                }
            }
        }
        //$this->master->where('message_id',$message_id);
        $status = $this->master->delete($table);
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function get_subscription()
    {
        $this->slave->select('*');
        $this->slave->from('ec_enquiry');
        $this->slave->where('custype','subscribe');
        
        return  $this->slave->get()->result();
    }   

    public function get_contact()
    {
        $this->slave->select('*');
        $this->slave->from('ec_enquiry');
        $this->slave->where('custype','contact');

        return  $this->slave->get()->result();
    } 
}
