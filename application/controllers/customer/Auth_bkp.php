<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
        $this->TYPE = $this->session->userdata('type');
        $this->load->helper('cookie');
	}
	
	public function index()
    {
        if(is_api() && $this->logged_in())
        {   
            $this->api_auth(array('section' => 'login', 'status' => 1, 'msg' => 'Already Login.', 'data' => array()));
        }

		if(!$this->logged_in()) redirect("$this->TYPE/auth/login");
		 
		// Redirect to your logged in landing page here
		redirect("$this->TYPE/dashboard");
	}
	
	/**
	 * Login page
	*/
	public function login()
    {
		// Redirect to your logged in landing page here
        if(is_api() && $this->logged_in())
        {               
            $this->api_auth(array('section' => 'login', 'status' => 1, 'msg' => 'Already Login.', 'data' => array()));  
        }
		if($this->logged_in()) redirect("$this->TYPE/dashboard");
		 
		$this->load->library('form_validation');
		$data['error'] = false;
		$data['message']['error'] = ''; 

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
        $email       = $this->input->post('email');
        $password    = $this->input->post('password');
        if($this->form_validation->run()){
            $password = md5($password);
            $customer = $this->Query_model->get_customer($email,$password);
            if($customer){
                $name = ($customer->type == 'company') ? $customer->cname : $customer->fname;
                $details = array(
                               'email'         => $customer->email,
                               'image'         => $customer->image,
                               'fname'         => $name,
                               'type'          => $customer->type,
                               'login_id'      => $customer->customer_id,
                               'logged_in'     => TRUE
                        );
                $this->session->set_userdata($this->TYPE, $details);
                set_cookie('type',$this->TYPE,'3600');
                if(is_api())
                {
                    $this->api_auth(array('section' => 'login', 'status' => 1, 'msg' => 'Success', 'data' => $customer));                    
                }
                redirect("$this->TYPE/requirement/post_advance");
/*
                $previous_url = $this->session->userdata('previous_url');
                $base_url = base_url();
                if($base_url == $previous_url) $previous_url = '';
                if($previous_url){
                    redirect("$previous_url");
                }else{
                    redirect("$this->TYPE/dashboard");
                }
*/
            }else{
                if(is_api())
                {
                    $this->api_auth(array('section' => 'login', 'status' => 0, 'msg' => 'Your email address and/or password is incorrect.' , 'data' => array()));
                }
                $data['message']['error']='Your email address and/or password is incorrect.';
            }
		}
        if(is_api())
        {
            $this->api_auth(array('sec' => 'login', 'status' => 0, 'msg' => 'Something went wrong.' , 'data' => array()));
        }
        $data['navigation'] = 0;
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $this->load->template("$this->TYPE/login",$data);
	}

	/**
	 * Logout page
	 */
	public function logout()
	{
        $this->session->unset_userdata($this->TYPE);
        delete_cookie('type');
        if(is_api())
        {
            $ret_data['STATUS'] = 1;
            $ret_data['MSG'] = array('Sucessfully logout');
            $ret_data['DATA'] = array('');
            header('Content-Type: application/json');
            echo json_encode($ret_data);
            die();
        } 
        redirect("$this->TYPE/auth/login");
	}
	
	/**
	 * Forgot password page
	 */
	public function forgot()
    {
        // Redirect to your logged in landing page here
		if($this->logged_in()) redirect("$this->TYPE/dashboard");

        $this->load->library('form_validation');
        $data['error'] = false;
        $data['message']['error'] = '';
 
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $email = $this->input->post('email');
        if($this->form_validation->run()){
            $customer       = $this->Query_model->get_customer_by_email($email);
            if($customer){
                $slug       = md5($this->Query_model->random_password());
                $base_url   = $this->config->item('base_url');
                $site_url   = $base_url."/".$this->TYPE."/auth/reset/".$slug;
       
                $data =  array(
                        'customer_id'   => $customer->customer_id,
                        'reset_key'     => $slug,
                        'ip_address'    => $_SERVER['REMOTE_ADDR'],
                        );
                $last_inserted_id    =  $this->Query_model->set_customer_password_reset('li_customer_password_reset',$data);
                $email = $customer->email;
                $this->load->library('mailer');
                $ret_status = $this->mailer->smtp(array('SUBJECT' => 'Reset your Password', 'EMAIL' => $email, 'CONTENT' => $this->forgot_mailer_content($site_url))); 
                if (!$ret_status) {
                    if(is_api())
                    {
                        $this->api_auth(array('section' => 'forgot', 'status' => 0, 'msg' => 'Failed to send password, please try again!', 'data' => array()));
                    }
                    $this->session->set_flashdata('message','Failed to send password, please try again!');
                } else {
                    if(is_api())
                    {
                        $this->api_auth(array('section' => 'forgot', 'status' => 1, 'msg' => 'Password sent to your email!', 'data' => array()));
                    }   
                    $this->session->set_flashdata('message','Password sent to your email!');
                }
            }else{
                if(is_api())
                {   
                    $this->api_auth(array('section' => 'forgot', 'status' => 0, 'msg' => 'Your email address is incorrect.', 'data' => array()));
                }
                $data['message']['error']='Your email address is incorrect.';
            }
        }
        else
        {
            if(is_api())
            {
                $this->api_auth(array('section' => 'forgot', 'status' => 0, 'msg' => remove_extra_for_api(validation_errors()), 'data' => array()));
            }
        }
        $data['navigation'] = 0;
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        
        $this->load->template("$this->TYPE/forgot_password",$data);
    }

    public function forgot_mailer_content($site_url)
    {
        $date = date('j M Y');
        $html =<<<HTML
            <p>To reset your password please click the link below and follow the instructions:</p>

            <p>$site_url</p>
            <p>If you did not request to reset your password then please just ignore this email and no changes will occur. </p>

            <p>Note: This reset code will expire after $date .</p>
HTML;
        return $html;
    }
	
	/**
	 * Reset password page
	 */
	public function reset($sid = NULL)
	{
        $this->session->set_flashdata('message','');
		// Redirect to your logged in landing page here
        if(is_api() && $this->logged_in())
        {
            $this->api_auth(array('section' => 'reset', 'status' => 1, 'msg' => 'Already Login.', 'data' => array()));
        }
		if($this->logged_in()) redirect("$this->TYPE/dashboard");
        
		$this->load->library('form_validation');
		$data['error'] = false;
		$data['message']['error'] = '';

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
		if($this->form_validation->run()){
            if(isset($sid) && $sid != '' && $this->is_valid_md5($sid)){
                $customer_reset = $this->Query_model->get_customer_reset_key($sid);
                if($customer_reset){
                    $customer = $this->Query_model->get_customer_by_id($customer_reset->customer_id);
                    if($customer){
                        $data =  array(
                            'password'      => md5($confirm_password),
                        );
                        $this->Query_model->set_customer_password('li_customer',$data,$customer_reset->customer_id);

                        $data =  array(
                            'status'      => 'reset',
                        );
                        $this->Query_model->set_customer_password_reset_status('li_customer_password_reset',$data,$customer_reset->customer_id);

                        $name = ($customer->type == 'company') ? $customer->cname : $customer->fname;
                        $details = array(
                               'email'         => $customer->email,
                               'image'         => $customer->image,
                               'fname'         => $name,
                               'type'          => $customer->type,
                               'login_id'      => $customer->customer_id,
                               'logged_in'     => TRUE
                        );
                        $this->session->set_userdata($this->TYPE, $details);
                        if(is_api())
                        {
                            $this->api_auth(array('section' => 'reset', 'status' => 1, 'msg' => 'Reset Successfully.', 'data' => array()));
                        }

                        redirect("$this->TYPE/dashboard");
                    }else{
                        if(is_api())
                        {
                            $this->api_auth(array('section' => 'forgot', 'status' => 0, 'msg' => 'Oops, that link has expired. Please enter your email below to start again.', 'data' => array()));
                        }
                        $data['message']['error']='Oops, that link has expired. Please enter your email below to start again.';
                    }
                }else{
                    if(is_api())
                    {
                        $this->api_auth(array('section' => 'forgot', 'status' => 0, 'msg' => 'Invalid Parameter!!', 'data' => array()));
                    }
                    $data['message']['error']='Invalid Parameter!!.';
                }
            }else{
                if(is_api())
                {
                    $this->api_auth(array('section' => 'forgot', 'status' => 0, 'msg' => 'Invalid Parameter!', 'data' => array()));
                }
                $this->session->set_flashdata('message','Invalid Parameter!');
            }
        }
        else
        {
            if(is_api())
            {
                $this->api_auth(array('section' => 'reset', 'status' => 0, 'msg' => remove_extra_for_api(validation_errors()), 'data' => array()));
            }
        }
        $data['navigation'] = 0;
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
		$this->load->template("$this->TYPE/reset_password", $data);
	}

    public function logged_in()
    {
        if($this->session->userdata($this->TYPE) && isset($this->session->userdata($this->TYPE)['logged_in'])){
            return true;
        }else{
            return false;
        }
    }

    public function set_session($details) 
    {
        $this->session->set_userdata($details);
    }

    public function is_valid_md5($md5 ='')
    {
        return strlen($md5) == 32 && ctype_xdigit($md5);
    }

    public function register()
    {
        if($this->logged_in()) redirect("$this->TYPE/dashboard");
        $country_arr        =  get_country();
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        if(is_api())
        {
            $this->form_validation->set_rules('type', 'Company Type', 'trim|required');
        }
        if($this->input->post('type') == 'company'){
            $this->form_validation->set_rules('cname', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('cvr', 'CVR Number', 'trim|required');
        }else{
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[li_customer.email]');
        $this->form_validation->set_rules('mobile', 'Mobile No.', 'required|regex_match[/^[0-9]{8,10}$/]');

        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        //$this->form_validation->set_rules('floor', 'Floor', 'trim|required');
        $this->form_validation->set_rules('street', 'Street', 'trim|required');
        $this->form_validation->set_rules('country_id', 'Country', 'trim|required');

        if($_POST) {
            $data =  array(
                    'email'             => $this->input->post('email'),
                    'mobile'            => $this->input->post('mobile'),
                    'street'            => $this->input->post('street'),
                    'country_id'        => $this->input->post('country_id'),
                    'type'              => $this->input->post('type'),
                );
            if($this->input->post('type') == 'company'){
                $data['cname']          = $this->input->post('cname');
                $data['cvr']            = $this->input->post('cvr');
            }else{
                $data['fname']          = $this->input->post('fname');
                $data['lname']          = $this->input->post('lname');
            }
        }

        if ($this->form_validation->run() == FALSE)
        {
            $data['country_arr']          =  $country_arr;

            $data['navigation'] = 0;
            $data['TYPE'] = $this->TYPE;
            $data['csrf'] = csrf_token();
            if(is_api())
            {
                $this->api_auth(array('section' => 'signup', 'status' => 0, 'msg' => remove_extra_for_api(validation_errors()), 'data' => array()));
            }
            $this->config->load('custom_config');
            $data['AUTOCOMPLETION_URL'] = $this->config->item('AUTOCOMPLETION_URL');
            $data['ROUTE_API_KEY']      = $this->config->item('ROUTE_API_KEY');
            $this->load->template("$this->TYPE/register",$data);
        }else{
            $data['customer_uid']   = uniq_uid();
            $data['password']       = md5($this->input->post('password'));
            $last_inserted_id       = $this->Query_model->insert_data('li_customer',$data);
            if(isset($last_inserted_id)){
                $useremail = $data['email'];
                if(isset($data['cname'])){
                    $username = $data['cname'];
                }else{
                    $username = $data['fname'];
                }

        $Uname = ucfirst($username);
        $msg =<<<HTML
            Hi, $Uname

            <div style="display:block;text-align:left;">Thank you, for Register with us</div>
HTML;

                $this->load->library('mailer');
                $this->mailer->smtp(array('SUBJECT' => 'Thank You For Register', 'EMAIL' => $useremail, 'CONTENT' => $msg));
                if(is_api())
                {
                    $ret_data['STATUS'] = 1;
                    $ret_data['MSG'] = array('Signup successfully.');
                    $ret_data['DATA'] = array('');
                    header('Content-Type: application/json');
                    echo json_encode($ret_data);
                    die();
                } 
                $type = ($this->input->post('type') == 'company') ? 'company' : 'private';
                $details = array(
                               'email'         => $useremail,
                               'fname'         => $username,
                               'type'          => $type,
                               'login_id'      => $last_inserted_id,
                               'logged_in'     => TRUE
                        );
                $this->session->set_userdata($this->TYPE, $details);
                set_cookie('type',$this->TYPE,'3600');
                $this->session->set_flashdata('message', 'Register Successfully.');
                redirect("$this->TYPE/requirement/post_advance");
            }else{
                if(is_api())
                {
                    $ret_data['STATUS'] = 0;
                    $ret_data['MSG'] = array('Your Email Address is Incorrect.');
                    $ret_data['DATA'] = array('Your Email Address is Incorrect.');
                    header('Content-Type: application/json');
                    echo json_encode($ret_data);
                    die();
                }
                $data['message']['error']='Your Email Address is Incorrect.';
            }
            redirect("$this->TYPE/auth/register");
        }  
    }

    public function api_auth($args)
    {
        $ret_data = array();
        $msg = gettype($args['msg']) == 'array' ? $args['msg'] : array($args['msg']);
        $data = gettype($args['data']) == 'array' ? $args['data'] : array($args['data']);
        if($args['status'])
        {
            $ret_data['STATUS'] = 1;
            $ret_data['MSG'] = $msg;
            $ret_data['DATA'] = $data;
        }
        else
        {
            $ret_data['STATUS'] = 0;
            $ret_data['MSG'] =  $msg;
            $ret_data['DATA'] = $data;
        }
        header('Content-Type: application/json');
        echo json_encode($ret_data);
        die();
    }

    public function index_ajax_address()
    {
        $this->load->model('Here_address_api');
        $searchText = $this->input->post('searchTerm');
        $this->Here_address_api->ajax_address($searchText);
    }    
}
