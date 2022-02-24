<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/QueryPath.php';
require APPPATH . 'libraries/Html2Text.php';

class Api extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->model('Api_customer_model');
        $this->load->model('Customer_model');
        $this->load->model('Auth_model');
        $this->load->library('session');
    }

    public function data_get()
    {
        $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_BAD_REQUEST);

    }

// dheeru
    public function data_post()
    {
        $message = ['status'  => 1, 'message' => 'Success'];
        $_POST['app-id'] = '7a614fd06c325499f1680b9896beedeb';
        $_POST['secret-key'] = '0396df57e78b6d04b6854dd682e27b3c';
        if( !empty($this->input->post('app-id')) && !empty($this->input->post('secret-key')) && !empty($this->input->post('action')) )
        {
            $APP_ID = $this->input->post('app-id');
            $SECRET_KEY = $this->input->post('secret-key');
            $ACTION = $this->input->post('action');


            $customer =  $this->Api_model->get_customer($APP_ID,$SECRET_KEY);
            if($customer)
            {
                if(method_exists($this, $ACTION))
                {
                    $message = $this->{$ACTION}($this->input->post());
                }
                else
                {
                    $message['status'] = 0;
                    $message['message'] = 'Invalid ACTION';
                }
            }
            else
            {
                $message['status'] = 0;
                $message['message'] = 'Invalid APP-ID or SECRET-KEY';
            }
        }
        else
        {
            $message['status'] = 0;
            $message['message'] = 'APP-ID or SECRET-KEY or ACTION missing';
        }

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function users_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

// dheeru

    private function customer_signup($args)
    {
        $this->check_validation($args);
        if($this->form_validation->run() === FALSE)
        {
            $data = (array('SUCCESS' => 0, 'MSG' => validation_errors()));
            $this->response(array("status" => 0, "message" => validation_errors()), REST_Controller::HTTP_NOT_FOUND);       
        }
        else
        {
            $ret_status = $this->insert_user_detail(array('DATA' => $args));
            $message = ['status'  => 1,'message' => 'Success..'];
            return $message;
        }
    }

    private function check_validation($args)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('fname', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[li_customer.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
    }

    private function insert_user_detail($args)
    {
        if(isset($args['DATA']) && $args['DATA'])
        {
            $insert_data = array();
            $insert_data['fname'] = $args['DATA']['fname'];
            $insert_data['email'] = $args['DATA']['email'];
            $insert_data['password']   = md5($args['DATA']['password']);
            $insert_data['type']       = 'private';
            $last_inserted_id    =  $this->Customer_model->insert_data('li_customer', $insert_data);
            if($last_inserted_id)
            {
                $details = array(
                               'email'         => $args['DATA']['email'],
                               'fname'         => $args['DATA']['fname'],
                               'type'          => 'private',
                               'login_id'      => $last_inserted_id,
                               'logged_in'     => TRUE
                        );
                $this->session->set_userdata('customer', $details);
                return 1;
            }
        }
    }

    private function customer_signin($args)
    {
        $this->check_validation_signin($args);
        if($this->form_validation->run() === FALSE)
        {
            $data = (array('SUCCESS' => 0, 'MSG' => validation_errors()));
            $ret_data['STATUS'] = 0;
                $ret_data['MSG'] = array(validation_errors());
                $ret_data['DATA'] = array();
            $this->response($ret_data, REST_Controller::HTTP_NOT_FOUND);
        }
        else
        {
            $password = md5($args['password']);
            $email = $args['email'];
            $customer = $this->Auth_model->get_customer($email,$password);
            if($customer){
                $name = ($customer->type == 'company') ? $customer->cname : $customer->fname;
                $details = array(
                               'email'         => $customer->email,
                               'fname'         => $name,
                               'type'          => $customer->type,
                               'login_id'      => $customer->customer_id,
                               'logged_in'     => TRUE
                        );
                $this->session->set_userdata('customer', $details);
                $ret_data['STATUS'] = 1;
                $ret_data['MSG'] = array(trim($name));
                $ret_data['DATA'] = array(trim($name));
                return $ret_data;
            
            }            
        }
    }

    private function check_validation_signin($args)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
    } 

    private function customer_forgot($args)
    {
        require_once(APPPATH.'controllers/Customer_ap.php'); //include controller
        $aObj = new Customer_ap();  //create object 
        
        echo 'test1fg';exit;
        $aObj->customer_forgot(); //call function
    }
    

    private function demo1()
    {
        $message = [
            'status'  => 1,
            'message' => 'Success..'
        ];
        return $message;
    }

    private function demo2()
    {
        $message = [
            'status'  => 1,
            'message' => 'Success.......'
        ];
        return $message;
    }

}
