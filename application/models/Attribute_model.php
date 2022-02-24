<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute_model extends MY_Model{

    var $column_search = array('name','discount','start_date','end_date','status','date_added');
   // var $column_alias = array('date_added' => 'rep', 'amount' => 'rep'); //set column field database
	var $table = 'ec_attribute';
    function __construct() {
        parent::__construct();
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

    public function get_datatable()
    {
        $this->slave->select('*');
        $this->slave->from('ec_attribute');
        #$this->slave->where('login_id', $this->LOGIN_ID);
        #$this->slave->where('status', '1');
        $this->get_datatables_query();
        $this->slave->order_by('date_added', 'desc');
        $this->slave->limit($_POST['length'], $_POST['start']);
        $user = $this->slave->get()->result();
        return $user;
    }

    public function get_datatables_query()
    {
        if(isset($_POST['filter'])){
            $this->slave->group_start();
            foreach($_POST['filter'] as $col_name => $col_value){
                if (in_array($col_name, $this->column_search) && (is_array($col_value) || $col_value != '')) {
                    $column_name_alias = $col_name;
                    if(isset($this->column_alias[$col_name])){
                        $column_name_alias =  $this->column_alias[$col_name].".".$col_name;
                    }
                    if(is_array($col_value)){
                        $this->slave->where_in($column_name_alias, $col_value);
                    }else{
                        $this->slave->like($column_name_alias, $col_value); 
                    }
                }
            }
            $this->slave->group_end();
        }
    }

    public function count_filtered()
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from('ec_attribute');
        #$this->slave->where('login_id', $this->LOGIN_ID);
        #$this->slave->where('status', '1');
        $this->get_datatables_query();
        $query = $this->slave->get()->row();
        return $query->CNT;
    }

    public function count_all()
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from('ec_attribute');
        #$this->slave->where('login_id', $this->LOGIN_ID);
        #$this->slave->where('status', '1');
        $query = $this->slave->get()->row();
        return $query->CNT;
    }
    
     public function get_attr($id=null)
    {
		//echo "die".$id;die;
		$sql="select distinct a.attribute_id,a.name from ec_attribute a,ec_attribute_item b where a.status = '1' and b.status = '1' and a.attribute_id = b.attribute_id";
        if($id){
            $sql.=" and a.attribute_id = $id";
        }
		$query  =  $this->slave->query($sql);
        $data 	=   $query->result();
        return $data;
    }

	public function get_attr_already($product_id=null)
    {
		
		$sql="select a.* from ec_attribute a where status = '1' and a.attribute_id not in ( select distinct(b.attribute_id) from ec_product_attribute a, ec_attribute_item b where a.attribute_item_id = b.attribute_item_id and b.status = '1' and a.product_id=$product_id)";	
		$query  =  $this->slave->query($sql);
        $data 	=   $query->result();
        return $data;
	}
	
	public function get_attr_vari($product_id=null)
    {	
		//$product_id=81;		
		#$sql="select a.*,b.attribute_id,b.name from ec_product_attribute a, ec_attribute_item b where a.attribute_item_id = b.attribute_item_id and a.product_id=$product_id and a.attribute_item_id not in ( select attribute_item_id from ec_product_variation c where c.product_id=$product_id)";	
		$sql="select a.*,b.attribute_id,b.name from ec_product_attribute a, ec_attribute_item b where a.attribute_item_id = b.attribute_item_id and a.product_id=$product_id"; 
		$query  =   $this->slave->query($sql);
        $data 	=   $query->result();
        return $data;
       
    }
	
	public function get_attr_vari_item($product_id=null)
    {	
        //$product_id=81;		
        $sql="select a.*,b.attribute_id,b.name from ec_product_variation a,ec_attribute_item b  where a.attribute_item_id = b.attribute_item_id and a.product_id=$product_id";	
        $query  = $this->db->query($sql);
        $data 	= $query->result();
		
		
        return $data;
       
    }
	
	 public function get_data_attr($product_id = null)
    {
		if($product_id){
		  $sql 	=	"select a.*,b.attribute_id,b.name from ec_product_attribute a,ec_attribute_item b  where a.attribute_item_id = b.attribute_item_id and a.product_id=$product_id";	
		}else{
		  $sql 	=	"select a.*,b.attribute_id,b.name from ec_product_attribute a,ec_attribute_item b where a.attribute_item_id = b.attribute_item_id";	
		}		
	    
		$query  =   $this->db->query($sql);
        $data 	=   $query->result();
        return $data;
    }
	
	 public function get_all_item()
    {
		$sql 	=	"select * from ec_attribute_item";	
		$query  =   $this->slave->query($sql);
        $data 	=   $query->result();
        return $data;
    }
	
	function find_list_prod(){
		$this->slave->order_by('name','asc');
		$query = $this->slave->get('ec_attribute_item');
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['attribute_item_id']] = $row['name'];
            }
        }
        return $data; 
	}
	
	function get_attr_val($attr_id = null){
		$this->slave->order_by('name','ASC');
		$this->slave->where('attribute_id', $attr_id);    
		$query = $this->slave->get('ec_attribute_item');		
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
				
                $data[$row['attribute_item_id']] = $row['name'];
            }
        }
        return $data; 
	}
    
}
