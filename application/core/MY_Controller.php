<?php
class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('breadcrumbs');
        $this->load->library('session');
        $this->load->helper('url');
        $this->controller = $this->router->fetch_class();
        $this->model = $this->router->fetch_method();

        $user_type_array = array('customer', 'admin');

        $PATH_INFO = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');

        foreach ($user_type_array as $value)
        {
            $match = "\/$value\/";
            if (preg_match("/^$match/",$PATH_INFO)){
                $this->session->set_userdata('type', $value);
                break;
            }
        }
        $_SESSION['type'] = isset($_SESSION['type']) ? $_SESSION['type'] : 'customer';
        if(!preg_match('/login|logout|register|forgot|-ajax-|_ajax_|reset\//', current_url())){
          $current_url = current_url();
          $this->session->set_userdata('previous_url', $current_url);
        }

        $non_logged_in = array("api","auth","welcome","index","product","page","posts","basket","taxonomy","Taxonomy","cart","checkout","thanks");
        //echo $this->controller;
        if (in_array($this->controller, $non_logged_in) == false) 
        {
          $this->isUserLoggedIn(); 
        }
    }

    public function isUserLoggedIn()
    {
        $type = isset($_SESSION['type']) ? $_SESSION['type'] : 'customer';
        if($this->session->userdata("$type") && isset($this->session->userdata("$type")['logged_in']))
        {
        }
        else
        {
            if(is_api())
            {
                echo json_encode(array('STATUS' => 0, 'MSG' => array('login required.'), 'DATA' => array())); 
                die();           
            }
            else
            {
                redirect("$type/auth/login");
            }
        }
    }
	
	 protected function bootstrap_pagination($paging_config = array()){
	//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config = array_merge($paging_config,$config);
            $this->pagination->initialize($config);
           // echo "<pre>"; print_r( $this->pagination->create_links() ); echo "</pre>"; die;
            return $this->pagination->create_links(); 
	}
	
	
}
?>
