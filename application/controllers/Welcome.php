<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
	   parent::__construct();
	   $this->load->model('user_model','',TRUE);
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
	     {
	        redirect('home');
	     }
	     else
	     {
	       //If no session, redirect to login page
	       redirect('welcome/login');
	     }
	}
 
	public function login()
	{
	   //This method will have the credentials validation
	   $this->load->library('form_validation');
	 
	   $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	   $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
	 
	    if($this->form_validation->run() == FALSE)
	    {
	    	//Field validation failed.  User redirected to login page
	   		$this->load->view('public/themes/default/header');
	    	$this->load->view('admin/login_form');
	   		$this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	     //Go to private area
	    	redirect('home');
	    }
	 
	}
 
	public function check_database($password)
	{
	   //Field validation succeeded.  Validate against database
	   $email = $this->input->post('email');
	 
	   //query the database
	   $result = $this->user_model->login($email, $password);
	 
	   if($result)
	   {
	     $sess_array = array();
	     foreach($result as $row)
	     {
	       $sess_array = array(
	         'id' => $row->ID_USER,
	         'nama' => $row->NAMA_USER,
	         'email' => $row->EMAIL,
	         'id_group' => $row->ID_GROUP,
	         'logged_in' =>TRUE
	       );
	       $this->session->set_userdata($sess_array);
	     }
	     return TRUE;
	   }
	   else
	   {
	     $this->form_validation->set_message('check_database', 'Invalid email or password');
	     return false;
	   }
	}

	public function logout()
    {
   	 $this->session->unset_userdata('logged_in');
   	 session_destroy();
   	 redirect('welcome');
  	}
}
