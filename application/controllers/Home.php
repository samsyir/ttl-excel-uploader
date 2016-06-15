<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
 
  function __construct()
  {
    parent::__construct();
  }
 
  function index()
  {
     if($this->session->userdata('logged_in'))
     {
        $session_data = $this->session->userdata('logged_in');
        $data['email'] = $session_data['email'];
        $data['id_group'] = $session_data['id_group'];
        //$data['transaction'] = $this->transaction_model->get_all_transaction();
        $this->load->view('public/themes/default/header');
        $this->load->view('admin/home_view', $data);
        $this->load->view('public/themes/default/footer');
     }
     else
     {
       //If no session, redirect to login page
       redirect('welcome');
     }
  }
 
}
 
?>