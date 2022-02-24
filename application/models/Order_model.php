<?php

class Order_model extends MY_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }   


    public function get_order_data()
    {
        $this->slave->select('*, eos.status as orderstatus');
        $this->slave->from('ec_order_stats as eos');
        $this->slave->join('ec_order_product as eop', 'eop.order_id =eos.order_id');
        $this->slave->where('eos.status >=0');
        //$this->slave->group_by('eos.order_id');
        $obj = $this->slave->get()->result();
        //echo $this->slave->last_query(); exit;
        return $obj;
    }


     public function get_order_track_data($customer_id = NULL, $order_id = NULL)
    {
        $this->slave->select('*, eos.order_id as orderid, eos.status as orderstatus');
        $this->slave->from('ec_order_stats as eos');
        $this->slave->join('ec_order_product as eop', 'eop.order_id =eos.order_id');
        $this->slave->where('eos.customer_id', $customer_id);
        $this->slave->where('eos.order_id', $order_id);
        $obj = $this->slave->get()->result();
        //echo $this->slave->last_query(); exit;
        return $obj;
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

	
}
