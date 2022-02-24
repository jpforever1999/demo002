<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends MY_Model{

    var $column_search = array('name','discount','start_date','end_date','enabled','date_added');
   
    function __construct() {
        parent::__construct();
    }

    public function get_datatable()
    {
        $this->slave->select('*');
        $this->slave->from('ec_page');
        $this->slave->where('enabled', '1');
        //$this->slave->where('super_admin', 0);
        $this->get_datatables_query();
        $this->slave->order_by('page_id', 'desc');
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
        $this->slave->from('ec_page');
        $this->slave->where('enabled', '1');
       // $this->slave->where('super_admin', 0);
        $this->get_datatables_query();
        $query = $this->slave->get()->row();
        return $query->CNT;
    }

    public function count_all()
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from('ec_page');
        $this->slave->where('enabled', '1');
        //$this->slave->where('super_admin', 0);
        $query = $this->slave->get()->row();
        return $query->CNT;
    }
	 public function delete_post($product_id)
    {
        $this->master->where('page_id',$product_id);
        $status = $this->master->delete('ec_page');
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }
}
