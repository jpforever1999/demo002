<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	    $this->load->model('Auth_model');
        $this->TYPE = $this->session->userdata('type');
	}
	
	public function index()
    {
        $data['navigation'] = 0;
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $this->load->template("$this->TYPE/index",$data);

		#if(!$this->logged_in()) redirect("$this->TYPE/auth/login");
		// Redirect to your logged in landing page here
		#redirect("$this->TYPE/dashboard");
	}
	
	/**
	 * Login page
	*/
	public function login()
    {
		// Redirect to your logged in landing page here
		if($this->logged_in()) redirect("$this->TYPE/dashboard");
		 
		$data['error'] = false;
		$data['message']['error'] = ''; 

        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        $email       = $this->input->post('email');
        $password    = $this->input->post('password');
        if($this->form_validation->run()){
            $password = md5($password);
            $admin = $this->Auth_model->get_admin($email,$password);
            if($admin){
                 $details = array(
                                'email'         => $admin->email,
                                'fname'         => $admin->fname,
                                'login_id'      => $admin->admin_id,
                                'logged_in'     => TRUE
                         );
                 $this->session->set_userdata($this->TYPE, $details);
                 redirect("$this->TYPE/dashboard");
            }else{
                $data['message']['error']='Your email address and/or password is incorrect.';
            }
		}

        $data['navigation'] = 0;
        $data['TYPE'] = $this->TYPE;
        $data['csrf'] = csrf_token();
        $this->load->template("$this->TYPE/login",$data);
	}

    public function impersonate($admin_uid)
    {
        $admin_data = $this->Auth_model->get_customer_data($admin_uid);
        $email = $admin_data->email;
        $password = $admin_data->password;
        $admin = $this->Auth_model->get_customer_login($email,$password);
            if($admin){
                 $details = array(
                                'email'         => $admin->email,
                                'fname'         => $admin->fname,
                                'login_id'      => $admin->customer_id,
                                'logged_in'     => TRUE
                         );
                 $this->session->set_userdata($this->TYPE, $details);
                 redirect("$this->TYPE/dashboard");
            }else{
                $data['message']['error']='Your email address and/or password is incorrect.';
            }

    }
	
	/**
	 * Logout page
	 */
	public function logout()
	{
        $this->session->unset_userdata($this->TYPE); 
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
            $admin       = $this->Auth_model->get_admin_by_email($email);
            if($admin){
                $slug       = md5($this->Auth_model->random_password());
                $base_url   = $this->config->item('base_url');
                $site_url   = $base_url."/".$this->TYPE."/auth/reset/".$slug;
       
                $data =  array(
                        'admin_id'      => $admin->admin_id,
                        'reset_key'     => $slug,
                        'ip_address'    => $_SERVER['REMOTE_ADDR'],
                        );
                $last_inserted_id    =  $this->Auth_model->set_admin_password_reset('li_admin_password_reset',$data);
                $email = $admin->email;
                $this->load->library('mailer');
                $ret_status = $this->mailer->smtp(array('SUBJECT' => 'Reset your Password', 'EMAIL' => $email, 'CONTENT' => $this->forgot_mailer_content($site_url))); 
                if (!$ret_status) {
                    $this->session->set_flashdata('message','Failed to send password, please try again!');
                } else {
                    $this->session->set_flashdata('message','Password sent to your email!');
                }
            }else{
                $data['message']['error']='Your email address is incorrect.';
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
                $admin_reset = $this->Auth_model->get_admin_reset_key($sid);
                if($admin_reset){
                    $admin = $this->Auth_model->get_admin_by_id($admin_reset->admin_id);
                    if($admin){
                        $data =  array(
                            'password'      => md5($confirm_password),
                        );
                        $this->Auth_model->set_admin_password('li_admin',$data,$admin_reset->admin_id);

                        $data =  array(
                            'status'      => 'reset',
                        );
                        $this->Auth_model->set_admin_password_reset_status('li_admin_password_reset',$data,$admin_reset->admin_id);

                        $details = array(
                                'email'         => $admin->email,
                                'fname'         => $admin->fname,
                                'login_id'      => $admin->admin_id,
                                'logged_in'     => TRUE
                                );
                        $this->session->set_userdata($this->TYPE, $details);

                        redirect("$this->TYPE/dashboard");
                    }else{
                        $data['message']['error']='Oops, that link has expired. Please enter your email below to start again.';
                    }
                }else{
                    $data['message']['error']='Invalid Parameter!!.';
                }
            }else{
                $this->session->set_flashdata('message','Invalid Parameter!');
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
        $country_arr        =  $this->Auth_model->get_country();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[2]|max_length[15]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[sb_register.email]');
        $this->form_validation->set_rules('mobileno', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]'); 
        /**************************** company Details ******************************/
        $this->form_validation->set_rules('company_name', 'Company Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('company_gst_no', 'GST Number', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('company_contact_person','Contact Person', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('company_person_email', 'Contact Person Email', 'required|valid_email');
        $this->form_validation->set_rules('company_person_mobile', 'Contact Person Mobile', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('company_address', 'Address', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('company_city', 'City', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('country_id','Country', 'required');
        $this->form_validation->set_rules('state_id', 'State', 'required');
        $this->form_validation->set_rules('company_pincode', 'Pin Code', 'required|regex_match[/^[0-9]{6}$/]');


        if ($this->form_validation->run() == FALSE)
        {
            $admin_data['fname']                = $this->input->post('fname');
            $admin_data['lname']                = $this->input->post('lname');
            $admin_data['email']                = $this->input->post('email');
            $admin_data['mobileno']             = $this->input->post('mobileno');
            #$admin_data['password']             = $this->input->post('password');
            $admin_data['company_name']         = $this->input->post('company_name');
            $admin_data['company_gst_no']       = $this->input->post('company_gst_no');
            $admin_data['company_contact_person'] = $this->input->post('company_contact_person');
            $admin_data['company_person_email'] = $this->input->post('company_person_email');
            $admin_data['company_person_mobile']= $this->input->post('company_person_mobile');
            $admin_data['company_address']      = $this->input->post('company_address');
            $admin_data['company_city']         = $this->input->post('company_city');
            $admin_data['state_id']             = $this->input->post('state_id');
            $admin_data['country_id']           = $this->input->post('country_id');
            $admin_data['company_pincode']      = $this->input->post('company_pincode');
            $country_id                         = ($admin_data['country_id']!='')?$admin_data['country_id']:'99';
            $state_arr                          =  $this->Auth_model->get_state($country_id);  
            $data['state_arr']                  =  $state_arr;
            $data['country_arr']                =  $country_arr;

            $data= array_merge($data,$admin_data); 
            $data['navigation'] = 0;
            $data['TYPE'] = $this->TYPE;
            $data['csrf'] = csrf_token();
            $this->load->template("$this->TYPE/auth/register",$data);
        }else{
            $uniqid =  $this->Auth_model->generateUid();
            $data =  array(
                    'register_uid'              => $uniqid,
                    'fname'                     => $this->input->post('fname'),
                    'lname'                     => $this->input->post('lname'),
                    'email'                     => $this->input->post('email'),
                    'mobileno'                  => $this->input->post('mobileno'),
                    #'password'                  => md5($this->input->post('password')),
                    'password'                  => md5($this->input->post('email')),
                    'status'                    => '0',
                    'company_name'              => $this->input->post('company_name'),
                    'company_gst_no'            => $this->input->post('company_gst_no'),
                    'company_contact_person'    => $this->input->post('company_contact_person'),
                    'company_person_email'      => $this->input->post('company_person_email'),
                    'company_person_mobile'     => $this->input->post('company_person_mobile'),
                    'company_address'           => $this->input->post('company_address'),
                    'company_city'              => $this->input->post('company_city'),
                    'country_id'                => $this->input->post('country_id'),
                    'state_id'                  => $this->input->post('state_id'),
                    'company_pincode'           => $this->input->post('company_pincode'),
                    );
            $useremail = $this->input->post('email');
            $username =$this->input->post('fname');
            $lastname                = $this->input->post('lname');
            $mobile                  = $this->input->post('mobileno');
            $company_name            = $this->input->post('company_name');
            $company_gst_no          = $this->input->post('company_gst_no');
            $company_contact_person  = $this->input->post('company_contact_person');
            $company_person_email    = $this->input->post('company_person_email');
            $company_person_mobile   = $this->input->post('company_person_mobile');
            $company_address         = $this->input->post('company_address');
            $company_city            = $this->input->post('company_city');
            $country_id              = $this->input->post('country_id');
            $state_id                = $this->input->post('state_id');
            $company_pincode         = $this->input->post('company_pincode');
            $last_inserted_id        = $this->Auth_model->insert_data('sb_register',$data);
            if(isset($last_inserted_id)){
            $country_name = $this->Auth_model->get_country_name($country_id);
            $state_name = $this->Auth_model->get_state_name($state_id);
            
                $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" style="border:1px solid #e1e1e1;">
  <tr>
    <td colspan="4" align="center" style="font-family:Arial, Helvetica, sans-serif;"><h1 style="margin:0px;padding:0px;font-size:48px">SMARTBIZ</h1>
      <h4 style="margin:0px;padding:0px;font-weight:300;">Registration Confirmation</h4></td>
  </tr>
  <tr>
    <td width="35%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">First Name</td>
    <td width="5%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td width="60%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$username.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Last Name</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$lastname.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Email</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$useremail.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Mobile</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$mobile.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company Name</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_name.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company GST NO</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_gst_no.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company Contact Person</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_contact_person.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company person email</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_person_email.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company Person Mobile</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_person_mobile.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company Address</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_address.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Company City</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_city.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">State ID</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$state_name.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Country ID</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$country_name.'</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;border-bottom:1px solid #e1e1e1;color:#999;">Pincode</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;border-bottom:1px solid #e1e1e1;">:</td>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-bottom:1px solid #e1e1e1;">'.$company_pincode.'</td>
  </tr>
  <tr>
    <td colspan="3" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:18px;"><br>Thanks for registering with SMARTBIZ.<br />
    <br />
    Sincerly,<br />
    <strong>SMARTBIZ Team</strong>
    <br>&nbsp;</td>
  </tr>
</table>
</body>
</html>';
            
                $this->load->library('email');
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';

                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from('info@smartbizz.buynbag.pics', 'SmartBizz'); // Change these details
                $this->email->to('kumarlove630@gmail.com');
                $this->email->subject('Register Query');
                $this->email->message($message);
                $this->email->send();
            }else{
                $data['message']['error']='Your Email Address is Incorrect.';
            }
            $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smartbiz</title>
</head>
<body>
<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" style="border:1px solid #e1e1e1;">
  <tr>
    <td width="100%" height="100" colspan="2" align="center" bgcolor="#f1f1f1" style="font-family:Arial, Helvetica, sans-serif;"><h1 style="margin:0px;padding:0px;font-size:30px;">SMARTBIZ</h1></td>
  </tr>
  <tr>
    <td align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:18px;border-bottom:1px solid #e1e1e1;padding:50px;color:#000;">
<h2>Hi, '.ucfirst($username).'!</h2>
      Thank you, for Query with us. <br />
    Our Representative will contact you shortly.</td>
  </tr>
  <tr>
    <td align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:18px;" bgcolor="#f1f1f1"><br />
    Sincerely,<br />
    <strong>SMARTBIZ Team</strong>
    <br>&nbsp;</td>
  </tr>
</table>
</body>
</html>';
            $this->load->library('email');
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';

            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('info@smartbizz.buynbag.pics', 'SmartBizz'); // Change these details
            $this->email->to($useremail); //User email submited in form
            $this->email->subject('Thank You For Register');
            $this->email->message($msg);
            $this->email->send();
            $this->session->set_flashdata('message', 'Query Register Successfully.');
            redirect('customer/auth/register');
        }  
    }
    
}
