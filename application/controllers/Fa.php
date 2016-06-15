<?php
class Fa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Excel_reader');
		$this->load->model('Fa_model');
	}
	public function index() {
		redirect('welcome');
	}

	public function upload_kas($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/fa/upload_kas',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_kas() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_kas($error);

            } 
            else {
              // jika berhasil upload ambil data dan masukkan ke database
              $upload_data = $this->upload->data();
              
  
              //tentukan file
              //$this->excel_reader->setOutputEncoding('230787');
              $file = $upload_data['full_path'];
              $this->excel_reader->read($file);
              error_reporting(E_ALL ^ E_NOTICE);
 
              // array data
              $data = $this->excel_reader->sheets[0];
              //var_dump($data['cells']);
              $dataexcel = Array();
              for ($i = 1; $i <= $data['numRows']; $i++) {
                   // if ($data['cells'][$i][1] == '')
                   //     break;
              		$dataexcel[$i - 1]['INT_ID'] = $data['cells'][$i][1];
					$dataexcel[$i - 1]['CHR_URAIAN'] = $data['cells'][$i][2];
					$dataexcel[$i - 1]['CHR_COMPANY'] = $data['cells'][$i][3];
					$dataexcel[$i - 1]['CHR_TAHUN'] = $data['cells'][$i][4];
					$dataexcel[$i - 1]['CHR_BULAN'] = $data['cells'][$i][5];
					$dataexcel[$i - 1]['DEC_AMOUNT'] = $data['cells'][$i][6];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
              	$datainsert = array(
              	'INT_ID' => $this->db->escape($dataexcel[$i]['INT_ID']),
				'CHR_URAIAN' => $this->db->escape($dataexcel[$i]['CHR_URAIAN']),
				'CHR_COMPANY' => $this->db->escape($dataexcel[$i]['CHR_COMPANY']),
				'CHR_TAHUN' => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
				'CHR_BULAN' => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
				'DEC_AMOUNT' => $this->db->escape($dataexcel[$i]['DEC_AMOUNT']),
				'CHR_STATUS' => 1,
				'CHR_UPLOAD_DATE' => $this->db->escape(date('Ymd')),
				'CHR_UPLOAD_TIME' => $this->db->escape(date('His'))
				);

              	$this->Fa_model->insert_kas($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('fa/upload_kas'));

	}

	public function upload_neraca($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/fa/upload_neraca',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_neraca() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_neraca($error);

            } 
            else {
              // jika berhasil upload ambil data dan masukkan ke database
              $upload_data = $this->upload->data();
              
  
              //tentukan file
              //$this->excel_reader->setOutputEncoding('230787');
              $file = $upload_data['full_path'];
              $this->excel_reader->read($file);
              error_reporting(E_ALL ^ E_NOTICE);
 
              // array data
              $data = $this->excel_reader->sheets[0];
              //var_dump($data['cells']);
              $dataexcel = Array();
              for ($i = 1; $i <= $data['numRows']; $i++) {
                   // if ($data['cells'][$i][1] == '')
                   //     break;
              		$dataexcel[$i - 1]['INT_ID'] = $data['cells'][$i][1];
					$dataexcel[$i - 1]['CHR_HEADER'] = $data['cells'][$i][2];
					$dataexcel[$i - 1]['CHR_KODE'] = $data['cells'][$i][3];
					$dataexcel[$i - 1]['CHR_URAIAN'] = $data['cells'][$i][4];
					$dataexcel[$i - 1]['CHR_COMPANY'] = $data['cells'][$i][5];
					$dataexcel[$i - 1]['CHR_TAHUN'] = $data['cells'][$i][6];
					$dataexcel[$i - 1]['CHR_BULAN'] = $data['cells'][$i][7];
					$dataexcel[$i - 1]['DEC_AMOUNT'] = $data['cells'][$i][8];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
              	$datainsert = array(
              	'INT_ID' => $this->db->escape($dataexcel[$i]['INT_ID']),
        				'CHR_HEADER' => $this->db->escape($dataexcel[$i]['CHR_HEADER']),
        				'CHR_KODE' => $this->db->escape($dataexcel[$i]['CHR_KODE']),
        				'CHR_URAIAN' => $this->db->escape($dataexcel[$i]['CHR_URAIAN']),
        				'CHR_COMPANY' => $this->db->escape($dataexcel[$i]['CHR_COMPANY']),
        				'CHR_TAHUN' => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
        				'CHR_BULAN' => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
        				'DEC_AMOUNT' => $this->db->escape($dataexcel[$i]['DEC_AMOUNT']),
        				'CHR_STATUS' => 1,
        				'CHR_UPLOAD_DATE' => $this->db->escape(date('Ymd')),
        				'CHR_UPLOAD_TIME' => $this->db->escape(date('His'))
        				);

              	$this->Fa_model->insert_neraca($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('fa/upload_neraca'));

	}	

}