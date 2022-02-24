<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('Register_model');
        $this->load->library('session');
        $this->master = $this->load->database('master', TRUE);
		$this->TYPE = $this->session->userdata('type');
    }

    public function index($data=null)
    {
		$data=array();
		$data['msg'] = $data;
		$data['csrf'] = csrf_token();
		//$this->load->template('customer/form/register', $data);
		$this->load->template("$this->TYPE/register",$data);
    }

        
    public function ajax_form_data()
    {
       
	//echo "ddd"; die;
	   $this->check_validation();
        $data = array();
		
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
		
        if ($this->form_validation->run() == FALSE)
        {
			echo json_encode(array('msg' => validation_errors(), 'success' => 0));
        }
        else{
            $data = $this->input->post();
            $data = $this->security->xss_clean($data);
            $this->insert_contact_enquiry(array('DATA' => $data));
        }
   
    }  
    
    public function check_validation()
    {
        $this->load->helper(array('form', 'url'));		
        $this->load->library('form_validation');		
        $this->form_validation->set_error_delimiters('<div>', '</div>');
		
        $this->form_validation->set_rules('first_name', 'First name', 'required|min_length[2]|max_length[100]');      
        $this->form_validation->set_rules('email',' Email', 'trim|required|valid_email|is_unique[ec_customer.email]');       
       // $this->form_validation->set_rules('type', 'contact us', 'required');
    }
 
    public function insert_contact_enquiry($args)
    {
        $data['error'] = false;
       
        if(isset($args['DATA']) && $args['DATA'])
        {
			$url = base_url();
           // $args['DATA']['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$email = $this->input->post('email');
			$first_name = $this->input->post('first_name');	
			//$last_name = $this->input->post('last_name');	
			//$company_name = $this->input->post('company_name');	
			$mobile = $this->input->post('mobile');	
			$customer_uid = $this->input->post('customer_uid');	
			//$plan_type = $this->input->post('plan_type');	
			
			$pwd = random_string();
			$args['DATA']['password'] = md5($pwd);
            $last_inserted_id  =  $this->Register_model->insert_data('ec_customer',$args['DATA']);
			
			$details = array(
					'email'         => $email,
					'first_name'    => $first_name,
					//'last_name'     => $last_name,
					//'company_name'  => $company_name,
					'mobile'        => $mobile,
					'customer_uid'     => $customer_uid ,					
					'current_id'    => $last_inserted_id,
					'logged_in'     => TRUE
			);
			$this->session->set_userdata($this->TYPE, $details);
		
			
			$this->load->library('mailer');
			$useremail = $email;
			$admin_email = 'admin@viralbake.com';
			
			$msg = '<div style="text-align:center;"><h2>Hi '.$first_name.',</h2><br><p>Welcome to move2inbox. To view profile: <br ><br ><a href="'.$url.'/customer/auth/login"><button type="button" style="background-color:#1a73e8;border:1px solid #1a73e8;border-radius:4px; color: #ffffff; display:inline-block; font-family:Google Sans,Roboto,Arial; font-size:16px;line-height:25px;text-decoration:none;min-width:205px;padding:8px 0px 7px 0px;font-weight:500;text-align:center;">Click here</button></a></p><p style="display:block;">User name:'.$email.'<br> password:'.$pwd.'</p></div>';
			
			$admin_msg = '<div style="text-align:center;"><p>'.$first_name.' has just created an account on move2inbox. <br ><br >Here is the submitted registration form</p><table style="width:100%" border="1px"cellspacing="0" cellpadding="10"> <tr><td>First name</td><td>'.$first_name.'</td> </tr>    <tr><td>Last name</td><td>'.$last_name.'</td> </tr>  <tr><td>Company name</td><td>'.$company_name.'</td> </tr><tr><td>Email</td><td>'.$email.'</td> </tr> <tr><td>Mobile</td><td>'.$mobile.'</td> </tr> 	<tr><td>Plan type</td><td>'.$plan_type.'</td> </tr>	</table></div>';
			
			$this->mailer->smtp(array('SUBJECT' => 'move2inbox.in', 'EMAIL' => $useremail, 'CONTENT' => $msg));
			$this->mailer->smtp(array('SUBJECT' => 'move2inbox New registration', 'EMAIL' => $admin_email, 'CONTENT' => $admin_msg));
		   
		   if($last_inserted_id)
            {
                echo json_encode(array('msg' => 'Form submit Successfully', 'success' => 1));
            }
            else{
                echo json_encode(array('msg' => 'Form is not submitted', 'success' => 0));
            }
        }

    }
 


}

