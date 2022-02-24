<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Query_model');
		$this->load->model('Register_model');
        $this->TYPE = $this->session->userdata('type');
	}
	
	public function index()
    {
        $data['navigation'] = 0;
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $this->load->template("$this->TYPE/index",$data);
		
	}
	
	/**
	 * Login page
	*/
	public function login()
    {
		// Redirect to your logged in landing page here
        is_auth();
		 
        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        $email       = $this->input->post('email');
        $password    = $this->input->post('password');

        $response = array();
        $details  = array();

        if($this->form_validation->run()){
            $password = md5($password);
            $args = array('email' => $email, 'password' => $password);
            $customer = $this->Query_model->get_data_obj('ec_customer',$args);
            if($customer){
                 $details = array(
                                'email'         => $customer->email,
                                'fname'         => $customer->fname,
                                'lname'         => $customer->lname,
                                'login_id'      => $customer->customer_id,
                                'logged_in'     => TRUE
                         );
                 $this->session->set_userdata($this->TYPE, $details);
                 $response = array(
                    'status'  => 1,
                    'message' => 'success',
                 );
            }else{
                $response = array(
                    'status' => 0,
                    'message' => 'Your email address and/or password is incorrect.',
                );
            }
		}else{
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        }

        if(is_api()){
            if(count($details)){
                $response['data'][] = $details;
            }else{
                 $response['data'] = $details;
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }else{
            $data['navigation'] = 0;
            $data['TYPE'] = $this->TYPE;
            $data['csrf'] = csrf_token();
            $this->load->template("$this->TYPE/login",$data);
        }
	}

    public function impersonate($customer_uid)
    {
	/*
        $customer_data = $this->Auth_model->get_customer_data($customer_uid);
        $email = $customer_data->email;
        $password = $customer_data->password;
        $customer = $this->Auth_model->get_customer_login($email,$password);
            if($customer){
                 $details = array(
                                'email'         => $customer->email,
                                'fname'         => $customer->fname,
                                'login_id'      => $customer->customer_id,
                                'logged_in'     => TRUE
                         );
                 $this->session->set_userdata($this->TYPE, $details);
                 redirect("$this->TYPE/dashboard");
            }else{
                $data['message']['error']='Your email address and/or password is incorrect.';
            }
	*/
    }
	
	/**
	 * Logout page
	 */
	public function logout()
	{
        $this->session->unset_userdata($this->TYPE); 
        if(is_api()){
            $ret_data = array('status'  => 1, 'message' => 'Sucessfully logout.', 'data' => array());
            header('Content-Type: application/json');
            echo json_encode($ret_data);
            die();
        }else{
            redirect(base_url());
        }
	}
	
	/**
	 * Forgot password page
	 */
	public function forgot()
    {
        // Redirect to your logged in landing page here
        is_auth();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $email = $this->input->post('email');
        $response = array();
        if($this->form_validation->run()){
            $args = array('email' => $email, 'status' => '1');
            $customer = $this->Query_model->get_data_obj('ec_customer',$args);
            if($customer){
                $slug       = md5(random_string());
                $base_url   = $this->config->item('base_url');
                $site_url   = $base_url."/".$this->TYPE."/auth/reset/".$slug;
       
                $data =  array(
                        'customer_id'      => $customer->customer_id,
                        'reset_key'     => $slug,
                        'ip_address'    => $_SERVER['REMOTE_ADDR'],
                        );
                $last_inserted_id    =  $this->Query_model->insert_data('ec_customer_password_reset',$data);
                $email = $customer->email;
                #$email = 'neerajdiwakar@gmail.com';
                $this->load->library('mailer');
                $ret_status = $this->mailer->smtp(array('SUBJECT' => 'Reset your Password', 'EMAIL' => $email, 'CONTENT' => $this->forgot_mailer_content($site_url))); 
                if (!$ret_status) {
                    $response = array(
                            'status' => 0,
                            'message' => 'Failed to send password, please try again!',
                        );
                } else {
                    $response = array(
                            'status'  => 1,
                            'message' => 'Password sent to your email!',
                        );
                }
            }else{
                $response = array(
                    'status' => 0,
                    'message' => 'Your email address is incorrect.',
                );
            }
        }else{
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        }

        if(is_api()){
            $response['data'] = array();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }else{
            $data['navigation'] = 0;
            $data['TYPE'] = $this->TYPE;
            $data['csrf'] = csrf_token();
            $this->load->template("$this->TYPE/forgot_password",$data);
        }
    }

    public function register_mailer_content($fanme)
    {
        $date = date('j M Y');
        $html =<<<HTML
             Hi, $fanme
            <p>Thank you, for Register with us</p>
HTML;
        return $html;
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
		// Redirect to your logged in landing page here
        is_auth();
       
		$this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $response = array();
		if($this->form_validation->run()){
            $sid = $this->input->post('sid');
            if(isset($sid) && $sid != '' && $this->is_valid_md5($sid)){
                $customer_reset = $this->Query_model->get_data_obj('ec_customer_password_reset',array('reset_key' => $sid, 'status' => 'active'));
                if($customer_reset){
                    $customer = $this->Query_model->get_data_obj('ec_customer',array('customer_id' => $customer_reset->customer_id, 'status' => '1'));
                    if($customer){
                        $data =  array(
                            'password'      => md5($confirm_password),
                        );
                        $this->Query_model->update_data('ec_customer',$data,array('customer_id' => $customer_reset->customer_id));

                        $data =  array(
                            'status'      => 'reset',
                        );
                        $this->Query_model->update_data('ec_customer_password_reset',$data,array('customer_id' => $customer_reset->customer_id));

                        $details = array(
                                'email'         => $customer->email,
                                'fname'         => $customer->fname,
                                'login_id'      => $customer->customer_id,
                                'logged_in'     => TRUE
                                );
                        $this->session->set_userdata($this->TYPE, $details);
                        $response = array(
                            'status'  => 1,
                            'message' => 'Password has been changed.',
                        );
                    }else{
                        $response = array(
                            'status' => 0,
                            'message' => 'Oops, that link has expired. Please enter your email below to start again.',
                        );
                    }
                }else{
                    $response = array(
                        'status' => 0,
                        'message' => 'Invalid Parameter!!.',
                    );
                }
            }else{
                $response = array(
                    'status' => 0,
                    'message' => 'Invalid Parameter!',
                );
            }
        }else{
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        }

        if(is_api()){
            $response['data'] = array();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }else{
            $data['navigation'] = 0;
            $data['TYPE'] = $this->TYPE;
            $data['csrf'] = csrf_token();
            $data['sid']  = $sid;
            $this->load->template("$this->TYPE/reset_password", $data);
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
		// Redirect to your logged in landing page here
        is_auth();
		 
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('email',' Email', 'trim|required|valid_email|is_unique[ec_customer.email]'); 
        $this->form_validation->set_rules('mobile',' Mobile No', 'trim|required|regex_match[/^[0-9]{10}$/]');       
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[15]');
        
        $fname      = $this->input->post('fname');
        $lname      = $this->input->post('lname');
        $email      = $this->input->post('email');
		$mobile     = $this->input->post('mobile');	
		$password   = $this->input->post('password');

        $response = array(); 
        $details = array();

        if($this->form_validation->run()){
            $customer_uid = uniq_uid();
                
            $data =  array(
                'email'         => $email,
                'fname'         => $fname,
                'lname'         => $lname,
                'mobile'        => $mobile,
                'password'      => md5($password),
                'customer_uid'  => $customer_uid,
                'ip_address'    => $_SERVER['REMOTE_ADDR'],
            );
            $customer_id = $this->Register_model->insert_data('ec_customer',$data);
            if($customer_id){
                #$email = 'neerajdiwakar@gmail.com';
			    $this->load->library('mailer');
                $ret_status = $this->mailer->smtp(array('SUBJECT' => 'Successfully register with us.', 'EMAIL' => $email, 'CONTENT' => $this->register_mailer_content($fname)));
                $response = array(
                        'status'  => 1,
                        'message' => 'Successfully register.',
                    );

                 $details = array(
                                'email'         => $email,
                                'fname'         => $fname,
                                'lname'         => $lname,
                                'login_id'      => $customer_id,
                                'logged_in'     => TRUE
                         );
                 $this->session->set_userdata($this->TYPE, $details);
            }else{
                $response = array(
                        'status'  => 0,
                        'message' => 'Something going wrong, please try again!',
                    );
            }
		}else{
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        }

        if(is_api()){
            if(count($details)){
                $response['data'][] = $details;
            }else{
                 $response['data'] = $details;
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }else{
            $data['navigation'] = 0;
            $data['TYPE'] = $this->TYPE;
            $data['csrf'] = csrf_token();
		    $this->load->template("$this->TYPE/register",$data);
        }
	}
 
}
