<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends MY_Model{

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

    public function get_admin()
    {
        $this->slave->select('*');
        $this->slave->from('ec_admin');
        
        return  $this->slave->get()->result();
    }   
}
