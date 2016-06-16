<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
 
  function __construct()
  {
    parent::__construct();
    $this->load->model('user_model');
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

  public function get_all_list() {
    // field untuk ditampilkan di depan
    $column = "DEPARTMENT,MODULE,BULAN,TAHUN,JUMLAH";

    // paginate handle
    $take = $this->input->post('take');
    $page = $this->input->post('page');
    $skip = $this->input->post('skip');
    $pageSize = $this->input->post('pageSize');

    // sortir
    $sort = $this->input->post('sort');
    $sort_dir = $sort[0]['dir'];
    $sort_field = $sort[0]['field'];

    // filter
    $filter = $this->input->post('filter');
    if( $filter != '' ){
      $filterdata = array();
      $filterdata['field'] = $filter['filters'][0]['field'];
      $filterdata['operator'] = $filter['filters'][0]['operator'];
      $filterdata['value'] = $filter['filters'][0]['value'];
      $filterdata['logic'] = $filter['logic'];  

      $data = $this->user_model->get_all_kendo( $column, $take, $skip, $sort_dir, $sort_field, $filterdata );
      $total_data = $this->user_model->count_all_where($filterdata);
    }else{
      $filterdata = 0;
      $data = $this->user_model->get_all_kendo( $column, $take, $skip, $sort_dir, $sort_field, $filterdata );
      $total_data = $this->user_model->count_all();
    }
    
    $return['Result'] = $data;
    $return['CResult'] = $total_data;

    echo json_encode($return);

  }
 
}
 
?>