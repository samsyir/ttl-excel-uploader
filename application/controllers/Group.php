<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model');
	}
	public function index() {
		if($this->session->userdata('logged_in'))
    	{
        	$session_data = $this->session->userdata('logged_in');
			$data['user'] = $this->user_model->get_all_user();


	        $this->load->view('public/themes/default/header');
	        $this->load->view('admin/user/index', $data);
	        $this->load->view('public/themes/default/footer');
    	}
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function get_insert() {

		$this->load->view('public/themes/default/header');
        $this->load->view('admin/user/create');
        $this->load->view('public/themes/default/footer');

	}

	public function set_insert() {
		$this->load->library('form_validation');
		$this->load->database();
		$session_data = $this->session->userdata('logged_in');

		$this->form_validation->set_rules('nipp_user', 'NIPP', 'trim|required');
		$this->form_validation->set_rules('nama_user', 'Nama', 'trim|required');	 
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password]');

		$get_id_user = $this->user_model->get_last_id_user();
		$id_user = $get_id_user->ID_USER;
		
		if($this->form_validation->run() == TRUE){
			$data = array(
				'id_user'   => $this->db->escape($id_user+1),
				'nipp_user' => $this->db->escape($this->input->post('nipp_user')),
				'nama_user' => $this->db->escape($this->input->post('nama_user')),
				'email'		=> $this->db->escape($this->input->post('email')),
				'jabatan'	=> $this->db->escape($this->input->post('jabatan')),
				'password'	=> $this->db->escape($this->input->post('password')),
				'id_group'	=> $this->db->escape($this->input->post('group')),
				'status'	=> 1,
				'created_by'   => $this->db->escape($session_data['nama']),
				'created_date' => $this->db->escape(date('d-M-Y'))
			);

			$this->user_model->insert_user($data);
			redirect('user');
		}

	}

	public function get_update($id_user) {
		$data['get_user'] =$this->user_model->get_user($id_user);

		$this->load->view('public/themes/default/header');
        $this->load->view('admin/user/update',$data);
        $this->load->view('public/themes/default/footer');
	}

	public function set_update() {
		$this->load->library('form_validation');
		$this->load->database();
		$session_data = $this->session->userdata('logged_in');

		$this->form_validation->set_rules('nipp_user', 'NIPP', 'trim|required');
		$this->form_validation->set_rules('nama_user', 'Nama', 'trim|required');	 
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password]');
		
		if($this->form_validation->run() == TRUE){
			$id_user = $this->db->escape($this->input->post('id_user'));
			$data = array(
				'NIPP_USER' => ($this->input->post('nipp_user')),
				'NAMA_USER' => ($this->input->post('nama_user')),
				'EMAIL'		=> ($this->input->post('email')),
				'JABATAN'	=> ($this->input->post('jabatan')),
				'PASSWORD'	=> ($this->input->post('password')),
				'ID_GROUP'	=> ($this->input->post('group')),
				'MODIFIED_BY'   => ($session_data['nama']),
				'MODIFIED_DATE' => (date('d-M-Y'))
			);

			$this->user_model->update_user($id_user,$data);
			redirect('user');
		}

	}

	public function delete() {

		$this->load->database();
		$session_data = $this->session->userdata('logged_in');

		$id_user = $this->db->escape($this->input->post('id_user'));
		$data = array(
				'status'	=> 0,
				'modified_by'   => ($session_data['nama']),
				'modified_date' => (date('d-M-Y'))
		);

		$this->user_model->delete_user($id_user,$data);
		redirect('user');

	}

}