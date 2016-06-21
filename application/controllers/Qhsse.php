<?php
class Qhsse extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Excel_reader');
		$this->load->model('Qhsse_model');
	}
	public function index() {
		redirect('welcome');
	}

	public function upload_k3($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    	     $data['error'] = $error['error'];
			     $this->load->view('public/themes/default/header');
	         $this->load->view('admin/qhsse/upload_k3',$data);
	         $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_k3() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_k3($error);

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
              		$dataexcel[$i - 1]['INT_ID']        = $data['cells'][$i][1];
        					$dataexcel[$i - 1]['CHR_TAHUN']     = $data['cells'][$i][2];
        					$dataexcel[$i - 1]['CHR_BULAN']     = $data['cells'][$i][3];
        					$dataexcel[$i - 1]['INT_MAN_POW']   = $data['cells'][$i][4];
        					$dataexcel[$i - 1]['INT_MAN_HOUR']  = $data['cells'][$i][5];
        					$dataexcel[$i - 1]['INT_KTS']       = $data['cells'][$i][6];
                  $dataexcel[$i - 1]['INT_TTS']       = $data['cells'][$i][7];
                  $dataexcel[$i - 1]['INT_NM']        = $data['cells'][$i][8];
                  $dataexcel[$i - 1]['INT_FC']        = $data['cells'][$i][9];
                  $dataexcel[$i - 1]['INT_FA']        = $data['cells'][$i][10];
                  $dataexcel[$i - 1]['INT_MTI']       = $data['cells'][$i][11];
                  $dataexcel[$i - 1]['INT_RWI']       = $data['cells'][$i][12];
                  $dataexcel[$i - 1]['INT_LTI']       = $data['cells'][$i][13];
                  $dataexcel[$i - 1]['INT_FT']        = $data['cells'][$i][14];
                  $dataexcel[$i - 1]['INT_LOSS_DAY']  = $data['cells'][$i][15];
                  $dataexcel[$i - 1]['DEC_LOSS_COST'] = $data['cells'][$i][16];
                  $dataexcel[$i - 1]['INT_LTIFR']     = $data['cells'][$i][17];
                  $dataexcel[$i - 1]['INT_AIFR']      = $data['cells'][$i][18];
                  $dataexcel[$i - 1]['INT_SR']        = $data['cells'][$i][19];
                  $dataexcel[$i - 1]['INT_MNHLTI']    = $data['cells'][$i][20];
                  $dataexcel[$i - 1]['INT_LW_LTIFR']  = $data['cells'][$i][21];
                  $dataexcel[$i - 1]['INT_HT_LTIFR']  = $data['cells'][$i][22];
                  $dataexcel[$i - 1]['INT_IR']        = $data['cells'][$i][23];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
                $k3 = $this->Qhsse_model->get_seq_k3();
              	$datainsert = array(
              	'INT_ID'            => $this->db->escape($k3->ID),
        				'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
        				'CHR_BULAN'         => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
        				'INT_MAN_POW'       => $this->db->escape($dataexcel[$i]['INT_MAN_POW']),
        				'INT_MAN_HOUR'      => $this->db->escape($dataexcel[$i]['INT_MAN_HOUR']),
        				'INT_KTS'           => $this->db->escape($dataexcel[$i]['INT_KTS']),
                'INT_TTS'           => $this->db->escape($dataexcel[$i]['INT_TTS']),
                'INT_NM'            => $this->db->escape($dataexcel[$i]['INT_NM']),
                'INT_FC'            => $this->db->escape($dataexcel[$i]['INT_FC']),
                'INT_FA'            => $this->db->escape($dataexcel[$i]['INT_FA']),
                'INT_MTI'           => $this->db->escape($dataexcel[$i]['INT_MTI']),
                'INT_RWI'           => $this->db->escape($dataexcel[$i]['INT_RWI']),
                'INT_LTI'           => $this->db->escape($dataexcel[$i]['INT_LTI']),
                'INT_FT'            => $this->db->escape($dataexcel[$i]['INT_FT']),
                'INT_LOSS_DAY'      => $this->db->escape($dataexcel[$i]['INT_LOSS_DAY']),
                'DEC_LOSS_COST'     => $this->db->escape($dataexcel[$i]['DEC_LOSS_COST']),
                'INT_LTIFR'         => $this->db->escape($dataexcel[$i]['INT_LTIFR']),
                'INT_AIFR'          => $this->db->escape($dataexcel[$i]['INT_AIFR']),
                'INT_SR'            => $this->db->escape($dataexcel[$i]['INT_SR']),
                'INT_MNHLTI'        => $this->db->escape($dataexcel[$i]['INT_MNHLTI']),
                'INT_LW_LTIFR'      => $this->db->escape($dataexcel[$i]['INT_LW_LTIFR']),
                'INT_HT_LTIFR'      => $this->db->escape($dataexcel[$i]['INT_HT_LTIFR']),
                'INT_IR'            => $this->db->escape($dataexcel[$i]['INT_IR']),
        				'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
        				'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
				);

              	$this->Qhsse_model->insert_k3($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('qhsse/upload_k3'));

	}

	public function upload_lingkungan($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/qhsse/upload_lingkungan',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_lingkungan() {
    // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_lingkungan($error);

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
                  $dataexcel[$i - 1]['INT_ID']      = $data['cells'][$i][1];
                  $dataexcel[$i - 1]['CHR_TAHUN']   = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['CHR_BULAN']   = $data['cells'][$i][3];
                  $dataexcel[$i - 1]['INT_ENERGI']  = $data['cells'][$i][4];
                  $dataexcel[$i - 1]['INT_EMISI']   = $data['cells'][$i][5];
                  $dataexcel[$i - 1]['INT_INSIDEN'] = $data['cells'][$i][6];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $lingkungan = $this->Qhsse_model->get_seq_lingkungan();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($lingkungan->ID),
                'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
                'CHR_BULAN'         => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
                'INT_ENERGI'        => $this->db->escape($dataexcel[$i]['INT_ENERGI']),
                'INT_EMISI'         => $this->db->escape($dataexcel[$i]['INT_EMISI']),
                'INT_INSIDEN'       => $this->db->escape($dataexcel[$i]['INT_INSIDEN']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Qhsse_model->insert_lingkungan($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('qhsse/upload_lingkungan'));

  }	

  public function upload_mutu($error = NULL) {

    if($this->session->userdata('logged_in'))
      {
        $data['error'] = $error['error'];
      $this->load->view('public/themes/default/header');
          $this->load->view('admin/qhsse/upload_mutu',$data);
          $this->load->view('public/themes/default/footer');
      }
      else
      {
         //If no session, redirect to login page
         redirect('welcome');
      }

  }

  public function do_upload_mutu() {
    // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_mutu($error);

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
                  $dataexcel[$i - 1]['INT_ID']           = $data['cells'][$i][1];
                  $dataexcel[$i - 1]['CHR_TAHUN']        = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['CHR_BULAN']        = $data['cells'][$i][3];
                  $dataexcel[$i - 1]['INT_JML_KELUHAN']  = $data['cells'][$i][4];
                  $dataexcel[$i - 1]['INT_RAT_THN_LALU'] = $data['cells'][$i][5];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $mutu = $this->Qhsse_model->get_seq_mutu();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($mutu->ID),
                'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
                'CHR_BULAN'         => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
                'INT_JML_KELUHAN'   => $this->db->escape($dataexcel[$i]['INT_JML_KELUHAN']),
                'INT_RAT_THN_LALU'  => $this->db->escape($dataexcel[$i]['INT_RAT_THN_LALU']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Qhsse_model->insert_mutu($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('qhsse/upload_mutu'));

  }

  public function upload_kepuasan($error = NULL) {

    if($this->session->userdata('logged_in'))
      {
        $data['error'] = $error['error'];
      $this->load->view('public/themes/default/header');
          $this->load->view('admin/qhsse/upload_kepuasan',$data);
          $this->load->view('public/themes/default/footer');
      }
      else
      {
         //If no session, redirect to login page
         redirect('welcome');
      }

  }

  public function do_upload_kepuasan() {
    // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_kepuasan($error);

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
                  $dataexcel[$i - 1]['INT_ID']           = $data['cells'][$i][1];
                  $dataexcel[$i - 1]['CHR_TAHUN']        = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['INT_INDEKS']       = $data['cells'][$i][3];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $kepuasan = $this->Qhsse_model->get_seq_kepuasan();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($kepuasan->ID),
                'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
                'INT_INDEKS'        => $this->db->escape($dataexcel[$i]['INT_INDEKS']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Qhsse_model->insert_kepuasan($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('qhsse/upload_kepuasan'));

  }

}