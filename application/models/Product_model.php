<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends MY_Model{

    var $column_search = array('name','discount','start_date','end_date','enabled','date_added');

    function __construct() {
        parent::__construct();
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];		
    } 

    public function get_datatable()
    {
        $this->slave->select('*');
        $this->slave->from('ec_product');
        $this->slave->where('enabled', '1');
        //$this->slave->where('super_admin', 0);
        $this->get_datatables_query();
        $this->slave->order_by('product_id', 'desc');
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
        $this->slave->from('ec_product');
        $this->slave->where('enabled', '1');
        //$this->slave->where('super_admin', 0);
        $this->get_datatables_query();
        $query = $this->slave->get()->row();
        return $query->CNT;
    }

    public function count_all()
    {
        $this->slave->select('COUNT(*) CNT');
        $this->slave->from('ec_product');
        $this->slave->where('enabled', '1');
        //$this->slave->where('super_admin', 0);
        $query = $this->slave->get()->row();
        return $query->CNT;
    }

    public function edit($product_id)
    {
        $this->slave->select('*');
        $this->slave->from('ec_product');
        $this->slave->where("product_id='".$product_id."'");
        $postArray = $this->slave->get()->row();
        return $postArray;
    }

    public function delete_post($product_id)
    {
        $this->master->where('product_id',$product_id);
        $status = $this->master->delete('ec_product');
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function delete_image($img_id)
    {
        $this->master->where('id',$img_id);
        $status = $this->master->delete('ec_gallery');
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function delete_variation_post($id, $post_id)
    {
        $this->master->where('attribute_item_id',$id);
        $this->master->where('product_id',$post_id);
        $status = $this->master->delete('ec_product_variation');
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }

    function delete_cart($id)
    {
        $this->master->delete('ec_order_items', array('order_item_id' => $id)); 
        $this->master->delete('ec_order_itemmeta', array('order_item_id' => $id));
        $this->master->delete('ec_order_product', array('order_item_id' => $id));
        return ($this->master->affected_rows() > 0) ? TRUE : FALSE;
    }


    public function get_attr_item($product_id=null)
    {	
        $sql="select a.*,b.attribute_id, c.name as attribute_name, b.name 
            from ec_product_attribute a,ec_attribute_item b,ec_attribute c 
            where a.attribute_item_id = b.attribute_item_id and c.attribute_id=b.attribute_id and a.product_id=$product_id";	
        $query  =  $this->slave->query($sql);
        $data   =  $query->result();
        return $data;

    }

    public function taglist($product_id=null)
    {	
        $sql="select tag_id from ec_product_tags where post_id=$product_id";	
        $query  =  $this->slave->query($sql);
        $data   =  $query->result();
        ///echo $this->db->last_query();
        //die;
        return $data;

    } 

    public function delivery_return_widget($product_id=null)
    {
        $startdate = strtotime("+7 day");
        $start_date = date('d M', $startdate);
        $edate = strtotime("+12 day");
        $end_date = date('d M', $edate);

        $delivery_return_widget = '<div class="cart-totals p-3 border mt-3 ord">
            <h3> DELIVERY & RETURNS</h3>
            <hr>
            <h5><i class="fa fa-truck"></i> Delivery Information</h5>
            <p>
            Normally delivered <strong>'.$start_date.'</strong> - <strong>'.$end_date.'</strong> Please check exact dates in the Checkout page.<a href="/page/policies-rules"> more</a>
            </p>
            <!-- /form -->
            <hr>
            <h5><i class="fa fa-undo" aria-hidden="true"></i> Return Policy</h5>
            <p>
            Free return within 15 days for Jumia Mall items and 7 days for other eligible items.<a href="/page/return-policy"> more</a>
            </p>
            </div>';

        return $delivery_return_widget;
    }

    public function seller_imformation($product_id=null)
    {
        $seller_imformation = '<div class="cart-totals cart-totals2 p-3 border mt-3">
            <h3>Seller Imformation</h3>
            <hr>
            <table>
            <tbody>
            <tr>
            <td class="text-left w-100">DeFacto- COD</td>
            </tr>
            <tr>
            <td class="text-left w-100">100% Customer Satisfaction</td>
            </tr>
            <tr>
            <td class="text-left w-100">2808 Followers</td>
            </tr>
            <tr>
            <td class="text-left w-100">
            <hr>
            Order Fulfillment Rate: <strong>Excellent</strong>
            </td>
            </tr>
            <tr>
            <td class="text-left w-100">Quality: <strong>Excellent</strong></td>
            </tr>
            </tbody>
            </table>
            <!-- /form -->
            </div>';

        return $seller_imformation;
    }

    public function get_term_id_by_slug($table,$term_slug=null){	

        $sql="SELECT * FROM $table WHERE slug ='$term_slug'";	
        $query  =  $this->slave->query($sql);
        $data   =  $query->row();
        ///echo $this->db->last_query();
        //die;
        return $data;

    } 

    public function get_data_by_termid($termid=null){	

        $sql="SELECT * FROM ec_product
            LEFT JOIN ec_product_categories
            ON ec_product_categories.post_id = ec_product.product_id
            WHERE ec_product_categories.category_id=$termid";	
        $query  =  $this->slave->query($sql);
        $data   =  $query->result();
        //echo $this->db->last_query();
        //die;
        return $data;

    } 

    public function get_data_by_tagid($tagid=null){	

        $sql="SELECT * FROM ec_product_tags
            LEFT JOIN ec_product
            ON ec_product_tags.post_id = ec_product.product_id
            WHERE ec_product_tags.tag_id=$tagid";	
        $query  =  $this->slave->query($sql);
        $data   =  $query->result();
        ///echo $this->db->last_query();
        //die;
        return $data;
    }

    public function Does_email_exists($email) {

        $sql = "SELECT `email` FROM ec_customer
            WHERE `email`='$email'";
        $result=$this->slave->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function Does_note_otp_exists($otp) {

        $sql = "SELECT `otp` FROM ec_customer
            WHERE `otp`!='$otp'"; 
        $result=$this->slave->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }


    public function get_order_data($customer_id = NULL)
    {
        $this->slave->select('*');
        $this->slave->from('ec_order_stats as eos');
        $this->slave->join('ec_order_product as eop', 'eop.order_id =eos.order_id');
        $this->slave->where('eos.customer_id', $customer_id);
        $this->slave->where('eos.status >=1');
        //$this->slave->group_by('eos.order_id');
        $obj = $this->slave->get()->result();
        //echo $this->slave->last_query(); exit;
        return $obj;
    }

    public function get_order_count($customer_id = NULL)
    {
        $this->slave->select('count(*) as cnt');
        $this->slave->from('ec_order_stats as eos');
        $this->slave->join('ec_order_product as eop', 'eop.order_id =eos.order_id');
        $this->slave->where('eos.customer_id', $customer_id);
        $this->slave->where('eos.status', '1');
        $obj = $this->slave->get()->row();
        //echo $this->slave->last_query(); exit;
        return $obj;
    }


    public function get_order_completed($customer_id = NULL)
    {
        $this->slave->select('*');
        $this->slave->from('ec_order_stats as eos');
        $this->slave->from('ec_order_stats as eos');
        $this->slave->join('ec_order_product as eop', 'eop.order_id =eos.order_id');
        $this->slave->where('eos.customer_id', $customer_id);
        $this->slave->where('eos.status', '10');
        $obj = $this->slave->get()->row();
        //echo $this->slave->last_query(); exit;
        return $obj;
    }
}
