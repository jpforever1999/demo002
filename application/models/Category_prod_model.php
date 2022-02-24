<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_prod_model extends MY_Model{
    function __construct() {
        parent::__construct();
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
    }

	var $table = 'ec_categories_prod';
	var $column_search = array('name','discount','start_date','end_date','enabled','date_added');
	
	function create($category){
		$category['slug'] = url_title($category['name'],'-',true);
		$this->master->insert($this->table, $category);
	}

	function update($category,$id){
		$category['slug'] = url_title($category['name'],'-',true);
		$this->master->where('id',$id);
		$this->master->update($this->table,$category);
	}

	function delete($id){
		$this->master->where('id',$id);
		$this->master->delete($this->table);
	}
	
	function find_by_id($id){
		$this->slave->where('id',$id);
		return $this->slave->get($this->table,1)->row_array();
	}

	function find_by_slug($id){
		$this->slave->where('slug',$id);
		return $this->slave->get($this->table,1)->row_array();
	}

	function find_list(){
		$this->slave->order_by('name','asc');
		$query = $this->slave->get($this->table);
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        return $data; 
	}

	function find_list_prod(){
		$this->slave->order_by('name','asc');
		$query = $this->slave->get($this->table);
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        return $data; 
	}

    public function get_datatable()
    {
        $this->slave->select('*');
        $this->slave->from('ec_categories_prod');
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
        $this->slave->from('ec_categories_prod');
        #$this->slave->where('login_id', $this->LOGIN_ID);
        #$this->slave->where('status', '1');
        $this->get_datatables_query();
        $query = $this->slave->get()->row();
        return $query->CNT;
    }

    public function count_all()
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from('ec_categories_prod');
        #$this->slave->where('login_id', $this->LOGIN_ID);
        #$this->slave->where('status', '1');
        $query = $this->slave->get()->row();
        return $query->CNT;
    }

    public function categoryTree($parent_id = 0, $sub_mark = '', $selected = 0){
        $query = $this->slave->query("SELECT * FROM ec_categories_prod WHERE parent_id = $parent_id AND status = '1' ORDER BY name ASC");
        if($query->num_rows() > 0){
            $result = $query->result();
            foreach($result as $row){
                $sel = ($selected == $row->id) ? 'selected' : '';
                echo '<option value="'.$row->id.'" '.$sel.'>'.$sub_mark.$row->name.'</option>';
                $this->categoryTree($row->id, $sub_mark.'-', $selected);
            }
        }
    }


}
