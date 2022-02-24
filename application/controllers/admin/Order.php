<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends MY_Controller {

	function __construct() 
	{
        parent::__construct();
        $this->load->model('Order_model');
        $this->load->model('Query_model');	
        $this->TYPE = $this->session->userdata('type');
        $this->LOGIN_ID = $this->session->userdata($this->TYPE)['login_id'];
	}
	 
	public function index()
    {
		if(!logged_in()) redirect("$this->TYPE/auth/login");
        $crumbs = array("Home" => "/$this->TYPE/dashboard", "Order" => "");
        $breadcrumbs = $this->breadcrumbs->show($crumbs);
        $data['breadcrumbs']    = $breadcrumbs;

        $data['csrf'] = csrf_token(); 
        $data['TYPE'] = $this->TYPE;
        $data['page_count'] = page_count();		
        $this->load->template("$this->TYPE/order/index_order",$data);
	   //$this->load->view('imageUploadForm'); 
	}


	public function ajax_get_customer_order()
	{
		$length = (isset($_POST['length']))?$_POST['length']: page_count();
        $page  = (isset( $_POST['page']))?$_POST['page']: 1;

        $orderlist = $this->Order_model->get_order_data();
        $data = array();

        foreach ($orderlist as $orderlistdata) {

                $row = array();
                $row['order_id']        = $orderlistdata->order_id;
                $row['customer_name']   = get_customer($orderlistdata->customer_id)->fname.' '.get_customer($orderlistdata->customer_id)->lname;
                $row['quantity']        = $orderlistdata->product_qty;
                $row['net_total']       = $orderlistdata->net_total;
                $row['order_date']      = date("d-M-Y", strtotime($orderlistdata->date_created));
                $row['delivery_date']   = date("d-M-Y", strtotime($orderlistdata->date_created."+7 day"));
                $row['status']          = order_status($orderlistdata->orderstatus);
                $data[] = $row;
         }

         $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Order_model->count_all('ec_order_stats'),
                "recordsFiltered" => $this->Order_model->count_filtered('ec_order_stats'),
                "data" => $data,
                );
    
        echo json_encode($output);

        }



        public function update_ajax_status()
        {
            $order_id = $this->input->post('orderid');
            $statusval = $this->input->post('statusval');
            $post_data = array('status' => $statusval);
            $condition = array('order_id' => $order_id);
            $this->Query_model->update_data('ec_order_stats', $post_data, $condition);
            $data['message']  = 'Status Changed Successfully';
            echo json_encode($data);
            die();
        }



}
