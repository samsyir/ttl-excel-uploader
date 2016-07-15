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

	public function upload_organization($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/hc/upload_organization',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_organization() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls';
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
              		$dataexcel[$i - 1]['INT_ID']               = $data['cells'][$i][1];
        					$dataexcel[$i - 1]['CHR_BULAN']            = $data['cells'][$i][2];
        					$dataexcel[$i - 1]['CHR_TAHUN']            = $data['cells'][$i][3];
        					$dataexcel[$i - 1]['CHR_DEPT']             = $data['cells'][$i][4];
        					$dataexcel[$i - 1]['CHR_COUNT_PAP']        = $data['cells'][$i][5];
        					$dataexcel[$i - 1]['CHR_GEN_PRODUKSI']     = $data['cells'][$i][6];
                  $dataexcel[$i - 1]['CHR_GEN_NONPRODUKSI']  = $data['cells'][$i][7];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
                $organization = $this->Hc_model->get_seq_organization();
              	$datainsert = array(
              	'INT_ID'            => $this->db->escape($organization->ID),
        				'CHR_BULAN'          => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
        				'CHR_TAHUN'     => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
        				'CHR_DEPT'          => $this->db->escape($dataexcel[$i]['CHR_DEPT']),
        				'CHR_COUNT_PAP'        => $this->db->escape($dataexcel[$i]['CHR_COUNT_PAP']),
        				'CHR_GEN_PRODUKSI'       => $this->db->escape($dataexcel[$i]['CHR_GEN_PRODUKSI']),
                'CHR_GEN_NONPRODUKSI'           => $this->db->escape($dataexcel[$i]['CHR_GEN_NONPRODUKSI']),
        				'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
        				'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
				);

              	$this->Hc_model->insert_organization($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('hc/upload_organization'));

	}

	public function upload_workforce($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/hc/upload_workforce',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_workforce() {
    // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_workforce($error);

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
                  $dataexcel[$i - 1]['CHR_BULAN']         = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['CHR_TAHUN']         = $data['cells'][$i][3];
                  $dataexcel[$i - 1]['CHR_EMP_GROUP']     = $data['cells'][$i][4];
                  $dataexcel[$i - 1]['CHR_GEN_MAN']       = $data['cells'][$i][5];
                  $dataexcel[$i - 1]['CHR_GEN_WMN']       = $data['cells'][$i][6];
                  $dataexcel[$i - 1]['CHR_SER_DIR']       = $data['cells'][$i][7];
                  $dataexcel[$i - 1]['CHR_SER_IND']       = $data['cells'][$i][8];
                  $dataexcel[$i - 1]['CHR_SER_SUP']       = $data['cells'][$i][9];
                  $dataexcel[$i - 1]['CHR_EDU_AB']        = $data['cells'][$i][10];
                  $dataexcel[$i - 1]['CHR_EDU_05']        = $data['cells'][$i][11];
                  $dataexcel[$i - 1]['CHR_EDU_06']        = $data['cells'][$i][12];
                  $dataexcel[$i - 1]['CHR_EDU_07']        = $data['cells'][$i][13];
                  $dataexcel[$i - 1]['CHR_EDU_08']        = $data['cells'][$i][14];
                  $dataexcel[$i - 1]['CHR_AGE_30']        = $data['cells'][$i][15];
                  $dataexcel[$i - 1]['CHR_AGE_3135']      = $data['cells'][$i][16];
                  $dataexcel[$i - 1]['CHR_AGE_3640']      = $data['cells'][$i][17];
                  $dataexcel[$i - 1]['CHR_AGE_4145']      = $data['cells'][$i][18];
                  $dataexcel[$i - 1]['CHR_AGE_4650']      = $data['cells'][$i][19];
                  $dataexcel[$i - 1]['CHR_AGE_50']        = $data['cells'][$i][20];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $workforce = $this->Hc_model->get_seq_workforce();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($workforce->ID),
                'CHR_BULAN'         => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
                'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
                'CHR_EMP_GROUP'     => $this->db->escape($dataexcel[$i]['CHR_EMP_GROUP']),
                'CHR_GEN_MAN'       => $this->db->escape($dataexcel[$i]['CHR_GEN_MAN']),
                'CHR_GEN_WMN'       => $this->db->escape($dataexcel[$i]['CHR_GEN_WMN']),
                'CHR_SER_DIR'       => $this->db->escape($dataexcel[$i]['CHR_SER_DIR']),
                'CHR_SER_IND'       => $this->db->escape($dataexcel[$i]['CHR_SER_IND']),
                'CHR_SER_SUP'       => $this->db->escape($dataexcel[$i]['CHR_SER_SUP']),
                'CHR_EDU_AB'        => $this->db->escape($dataexcel[$i]['CHR_EDU_AB']),
                'CHR_EDU_05'        => $this->db->escape($dataexcel[$i]['CHR_EDU_05']),
                'CHR_EDU_06'        => $this->db->escape($dataexcel[$i]['CHR_EDU_06']),
                'CHR_EDU_07'        => $this->db->escape($dataexcel[$i]['CHR_EDU_07']),
                'CHR_EDU_08'        => $this->db->escape($dataexcel[$i]['CHR_EDU_08']),
                'CHR_AGE_30'        => $this->db->escape($dataexcel[$i]['CHR_AGE_30']),
                'CHR_AGE_3135'      => $this->db->escape($dataexcel[$i]['CHR_AGE_3135']),
                'CHR_AGE_3640'      => $this->db->escape($dataexcel[$i]['CHR_AGE_3640']),
                'CHR_AGE_4145'      => $this->db->escape($dataexcel[$i]['CHR_AGE_4145']),
                'CHR_AGE_4650'      => $this->db->escape($dataexcel[$i]['CHR_AGE_4650']),
                'CHR_AGE_50'        => $this->db->escape($dataexcel[$i]['CHR_AGE_50']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Hc_model->insert_workforce($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('hc/upload_workforce'));

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
            $config['allowed_types'] = 'xls';
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
                  $dataexcel[$i - 1]['CHR_BULAN']         = $data['cells'][$i][2];
                  $dataexcel[$i - 1]['CHR_TAHUN']         = $data['cells'][$i][3];
                  $dataexcel[$i - 1]['CHR_EMP_GROUP']     = $data['cells'][$i][4];
                  $dataexcel[$i - 1]['CHR_DEPT']          = $data['cells'][$i][5];
                  $dataexcel[$i - 1]['CHR_COUNT_MONTH']   = $data['cells'][$i][6];
                  $dataexcel[$i - 1]['CHR_COUNT_YTD']     = $data['cells'][$i][7];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
                # code...
                $training = $this->Hc_model->get_seq_training();
                $datainsert = array(
                'INT_ID'            => $this->db->escape($training->ID),
                'CHR_BULAN'         => $this->db->escape($dataexcel[$i]['CHR_BULAN']),
                'CHR_TAHUN'         => $this->db->escape($dataexcel[$i]['CHR_TAHUN']),
                'CHR_EMP_GROUP'     => $this->db->escape($dataexcel[$i]['CHR_EMP_GROUP']),
                'CHR_DEPT'          => $this->db->escape($dataexcel[$i]['CHR_DEPT']),
                'CHR_COUNT_MONTH'   => $this->db->escape($dataexcel[$i]['CHR_COUNT_MONTH']),
                'CHR_COUNT_YTD'     => $this->db->escape($dataexcel[$i]['CHR_COUNT_YTD']),
                'CHR_UPLOAD_DATE'   => $this->db->escape(date('Ymd')),
                'CHR_UPLOAD_TIME'   => $this->db->escape(date('His'))
        );

                $this->Hc_model->insert_training($datainsert);
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