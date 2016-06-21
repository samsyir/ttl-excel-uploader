<?php
class Gap extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Excel_reader');
		$this->load->model('Gap_model');
	}
	public function index() {
		redirect('welcome');
	}

	public function upload_procurement($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/gap/upload_procurement',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_procurement() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_procurement($error);

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
              		$dataexcel[$i - 1]['INT_ID'] 				= $data['cells'][$i][1];
					$dataexcel[$i - 1]['CHR_NO_EDOC'] 			= $data['cells'][$i][2];
					$dataexcel[$i - 1]['CHR_NO_PR'] 			= $data['cells'][$i][3];
					$dataexcel[$i - 1]['CHR_NAMA_PEKERJAAN'] 	= $data['cells'][$i][4];
					$dataexcel[$i - 1]['INT_STATUS']			= $data['cells'][$i][5];
					$dataexcel[$i - 1]['CHR_JENIS_KONTRAK'] 	= $data['cells'][$i][6];
					$dataexcel[$i - 1]['CHR_METODE'] 			= $data['cells'][$i][7];
					$dataexcel[$i - 1]['CHR_DEPT_PENGGUNA'] 	= $data['cells'][$i][8];
					$dataexcel[$i - 1]['CHR_PIC'] 				= $data['cells'][$i][9];
					$dataexcel[$i - 1]['CHR_TANGGAL_KONTRAK'] 	= $data['cells'][$i][10];
					$dataexcel[$i - 1]['INT_PERIOD'] 			= $data['cells'][$i][11];
					$dataexcel[$i - 1]['INT_FISCAL_YEAR'] 		= $data['cells'][$i][12];
					$dataexcel[$i - 1]['CHR_KONTRAK'] 			= $data['cells'][$i][13];
					$dataexcel[$i - 1]['DEC_NILAI_PENGADAAN'] 	= $data['cells'][$i][14];
              		$dataexcel[$i - 1]['DEC_NILAI_HPS'] 		= $data['cells'][$i][15];
					$dataexcel[$i - 1]['DEC_NILAI_PENAWARAN_1'] = $data['cells'][$i][16];
					$dataexcel[$i - 1]['DEC_NILAI_PENAWARAN_2']	= $data['cells'][$i][17];
					$dataexcel[$i - 1]['DEC_NILAI_PENAWARAN_3']	= $data['cells'][$i][18];
					$dataexcel[$i - 1]['DEC_NILAI_PENAWARAN_4']	= $data['cells'][$i][19];
					$dataexcel[$i - 1]['DEC_NILAI_AKHIR'] 		= $data['cells'][$i][20];
					$dataexcel[$i - 1]['DEC_PERFORMANCE_SAVING']= $data['cells'][$i][21];
					$dataexcel[$i - 1]['CHR_PO'] 				= $data['cells'][$i][22];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
              	$procurement = $this->Gap_model->get_seq_procurement();
              	$datainsert = array(
              	'INT_ID' 				=> $this->db->escape($procurement->ID),
				'CHR_NO_EDOC' 			=> $this->db->escape($dataexcel[$i]['CHR_NO_EDOC']),
				'CHR_NO_PR' 			=> $this->db->escape($dataexcel[$i]['CHR_NO_PR']),
				'CHR_NAMA_PEKERJAAN' 	=> $this->db->escape($dataexcel[$i]['CHR_NAMA_PEKERJAAN']),
				'INT_STATUS' 			=> $this->db->escape($dataexcel[$i]['INT_STATUS']),
				'CHR_JENIS_KONTRAK' 	=> $this->db->escape($dataexcel[$i]['CHR_JENIS_KONTRAK']),
				'CHR_METODE' 			=> $this->db->escape($dataexcel[$i]['CHR_METODE']),
				'CHR_DEPT_PENGGUNA' 	=> $this->db->escape($dataexcel[$i]['CHR_DEPT_PENGGUNA']),
				'CHR_PIC' 				=> $this->db->escape($dataexcel[$i]['CHR_PIC']),
				'CHR_TANGGAL_KONTRAK' 	=> $this->db->escape($dataexcel[$i]['CHR_TANGGAL_KONTRAK']),
				'INT_PERIOD' 			=> $this->db->escape($dataexcel[$i]['INT_PERIOD']),
				'INT_FISCAL_YEAR' 		=> $this->db->escape($dataexcel[$i]['INT_FISCAL_YEAR']),
				'CHR_KONTRAK' 			=> $this->db->escape($dataexcel[$i]['CHR_KONTRAK']),
				'DEC_NILAI_PENGADAAN' 	=> $this->db->escape($dataexcel[$i]['DEC_NILAI_PENGADAAN']),
				'DEC_NILAI_HPS' 		=> $this->db->escape($dataexcel[$i]['DEC_NILAI_HPS']),
				'DEC_NILAI_PENAWARAN_1' => $this->db->escape($dataexcel[$i]['DEC_NILAI_PENAWARAN_1']),
				'DEC_NILAI_PENAWARAN_2' => $this->db->escape($dataexcel[$i]['DEC_NILAI_PENAWARAN_2']),
				'DEC_NILAI_PENAWARAN_3' => $this->db->escape($dataexcel[$i]['DEC_NILAI_PENAWARAN_3']),
				'DEC_NILAI_PENAWARAN_4' => $this->db->escape($dataexcel[$i]['DEC_NILAI_PENAWARAN_4']),
				'DEC_NILAI_AKHIR' 		=> $this->db->escape($dataexcel[$i]['DEC_NILAI_AKHIR']),
				'DEC_PERFORMANCE_SAVING'=> $this->db->escape($dataexcel[$i]['DEC_PERFORMANCE_SAVING']),
				'CHR_PO' 				=> $this->db->escape($dataexcel[$i]['CHR_PO']),
				'CHR_UPLOAD_DATE' 		=> $this->db->escape(date('Ymd')),
				'CHR_UPLOAD_TIME' 		=> $this->db->escape(date('His'))
				);

              	$this->Gap_model->insert_procurement($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('fa/upload_kas'));

	}
}