<?php
class Hc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Excel_reader');
		$this->load->model('Hc_model');
	}
	public function index() {
		redirect('welcome');
	}

	public function upload_pegawai($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/hc/upload_pegawai',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_pegawai() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_pegawai($error);

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
              		$dataexcel[$i - 1]['INT_ID']            = $data['cells'][$i][1];
        					$dataexcel[$i - 1]['CHR_NAMA']          = $data['cells'][$i][2];
        					$dataexcel[$i - 1]['CHR_EMP_GROUP']     = $data['cells'][$i][3];
        					$dataexcel[$i - 1]['CHR_DEPT']          = $data['cells'][$i][4];
        					$dataexcel[$i - 1]['CHR_GENDER']        = $data['cells'][$i][5];
        					$dataexcel[$i - 1]['DEC_EDUKASI']       = $data['cells'][$i][6];
                  $dataexcel[$i - 1]['CHR_BOD']           = $data['cells'][$i][7];
                  $dataexcel[$i - 1]['CHR_SERV_CENTER']   = $data['cells'][$i][8];
                  $dataexcel[$i - 1]['DEC_PRODUCTIVITY']  = $data['cells'][$i][9];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
                $pegawai = $this->Hc_model->get_seq_pegawai();
              	$datainsert = array(
              	'INT_ID'            => $this->db->escape($pegawai->ID),
        				'CHR_NAMA'          => $this->db->escape($dataexcel[$i]['CHR_NAMA']),
        				'CHR_EMP_GROUP'     => $this->db->escape($dataexcel[$i]['CHR_EMP_GROUP']),
        				'CHR_DEPT'          => $this->db->escape($dataexcel[$i]['CHR_DEPT']),
        				'CHR_GENDER'        => $this->db->escape($dataexcel[$i]['CHR_GENDER']),
        				'CHR_EDUKASI'       => $this->db->escape($dataexcel[$i]['DEC_EDUKASI']),
                'CHR_BOD'           => $this->db->escape($dataexcel[$i]['CHR_BOD']),
                'CHR_SERV_CENTER'   => $this->db->escape($dataexcel[$i]['CHR_SERV_CENTER']),
                'CHR_PRODUCTIVITY'  => $this->db->escape($dataexcel[$i]['DEC_PRODUCTIVITY']),
                'CHR_BULAN' => $this->db->escape($this->input->post('bulan')),
                'CHR_TAHUN' => $this->db->escape($this->input->post('tahun')),
        				'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
        				'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
				);

              	$this->Hc_model->insert_pegawai($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('hc/upload_pegawai'));

	}

	public function upload_rkap($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/hc/upload_rkap',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_rkap() {
    // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_rkap($error);

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
                  $dataexcel[$i - 1]['INT_ID']            = $data['cells'][$i][1];
                  $dataexcel[$i - 1]['CHR_TAHUN']         = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['CHR_EMP_GROUP']     = $data['cells'][$i][3];
                  $dataexcel[$i - 1]['INT_JMLH_PEGAWAI']  = $data['cells'][$i][4];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $rkap = $this->Hc_model->get_seq_rkap();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($rkap->ID),
                'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
                'CHR_EMP_GROUP'     => $this->db->escape($dataexcel[$i]['CHR_EMP_GROUP']),
                'INT_JMLH_PEGAWAI'  => $this->db->escape($dataexcel[$i]['INT_JMLH_PEGAWAI']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Hc_model->insert_pegawai($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('hc/upload_rkap'));

  }	

  public function upload_training($error = NULL) {

    if($this->session->userdata('logged_in'))
      {
        $data['error'] = $error['error'];
      $this->load->view('public/themes/default/header');
          $this->load->view('admin/hc/upload_training',$data);
          $this->load->view('public/themes/default/footer');
      }
      else
      {
         //If no session, redirect to login page
         redirect('welcome');
      }

  }

  public function do_upload_training() {
    // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_rkap($error);

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
                  $dataexcel[$i - 1]['INT_ID']            = $data['cells'][$i][1];
                  $dataexcel[$i - 1]['CHR_NAMA']          = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['CHR_EMP_GROUP']     = $data['cells'][$i][3];
                  $dataexcel[$i - 1]['CHR_DEPT']          = $data['cells'][$i][4];
                  $dataexcel[$i - 1]['CHR_TRAIN_NAME']    = $data['cells'][$i][5];
                  $dataexcel[$i - 1]['CHR_TRAINING_MONTH']= $data['cells'][$i][6];
                  $dataexcel[$i - 1]['CHR_BEBAN_TRAINING']= $data['cells'][$i][7];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $training = $this->Hc_model->get_seq_training();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($training->ID),
                'CHR_NAMA'          => $this->db->escape($dataexcel[$i]['CHR_NAMA']),
                'CHR_EMP_GROUP'     => $this->db->escape($dataexcel[$i]['CHR_EMP_GROUP']),
                'CHR_DEPT'          => $this->db->escape($dataexcel[$i]['CHR_DEPT']),
                'CHR_TRAIN_NAME'    => $this->db->escape($dataexcel[$i]['CHR_GENDER']),
                'CHR_TRAINING_MONTH'=> $this->db->escape($dataexcel[$i]['DEC_EDUKASI']),
                'CHR_BEBAN_TRAINING'=> $this->db->escape($dataexcel[$i]['CHR_BOD']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Hc_model->insert_pegawai($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('hc/upload_training'));

  }

}