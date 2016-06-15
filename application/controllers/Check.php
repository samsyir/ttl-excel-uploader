<?php
class Cpc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Excel_reader');
		$this->load->model('cpc_model');
	}
	public function index() {
		redirect('welcome');
	}

	public function upload_investasi($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/cpc/upload_investasi',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}

	public function do_upload_investasi() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload('nama_file')) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_investasi($error);
            } 
            else {
              // jika berhasil upload ambil data dan masukkan ke database
              $upload_data = $this->upload->data();
  
              //tentukan file
              $this->excel_reader->setOutputEncoding('230787');
              $file = $upload_data['full_path'];
              $this->excel_reader->read($file);
              error_reporting(E_ALL ^ E_NOTICE);
 
              // array data
              $data = $this->excel_reader->sheets[0];
              $dataexcel = Array();
              for ($i = 1; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
					$dataexcel[$i - 1]['CHR_KODE_TTL'] = $data['cells'][$i][1];
					$dataexcel[$i - 1]['CHR_INV_NAME'] = $data['cells'][$i][2];
					$dataexcel[$i - 1]['CHR_SATUAN'] = $data['cells'][$i][3];
					$dataexcel[$i - 1]['DEC_ANGGARAN'] = $data['cells'][$i][4];
					$dataexcel[$i - 1]['INT_VOLUME'] = $data['cells'][$i][5];
					$dataexcel[$i - 1]['DEC_BIAYA'] = $data['cells'][$i][6];
					$dataexcel[$i - 1]['INT_JMLH_PROGRAM'] = $data['cells'][$i][7];
					$dataexcel[$i - 1]['CHR_NO_KONTRAK'] = $data['cells'][$i][8];
					$dataexcel[$i - 1]['DEC_NILAI_KONTRAK'] = $data['cells'][$i][9];
					$dataexcel[$i - 1]['DEC_LEVEL_REVENUE'] = $data['cells'][$i][10];
					$dataexcel[$i - 1]['DEC_LEVEL_SERVICE'] = $data['cells'][$i][11];
					$dataexcel[$i - 1]['DEC_LEVEL_SAFETY'] = $data['cells'][$i][12];
					$dataexcel[$i - 1]['DEC_MIN_REQ'] = $data['cells'][$i][13];
					$dataexcel[$i - 1]['CHR_DURASI'] = $data['cells'][$i][14];
					$dataexcel[$i - 1]['CHR_RENCANA_MULAI'] = $data['cells'][$i][15];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_1'] = $data['cells'][$i][16];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_2'] = $data['cells'][$i][17];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_3'] = $data['cells'][$i][18];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_4'] = $data['cells'][$i][19];
					$dataexcel[$i - 1]['INT_REALISASI_FISIK'] = $data['cells'][$i][20];
					$dataexcel[$i - 1]['DEC_REALISASI_ANG'] = $data['cells'][$i][21];
					$dataexcel[$i - 1]['DEC_PEMBAYARAN'] = $data['cells'][$i][22];
					$dataexcel[$i - 1]['CHR_REALISASI_PROGRAM'] = $data['cells'][$i][23];
					$dataexcel[$i - 1]['CHR_KETERANGAN'] = $data['cells'][$i][24];
              }
              
              for ($i=0; $i < count($dataexcel); $i++) { 
              	# code...
              	$datainsert = array(
				'CHR_KODE_TTL' => $dataexcel[$i]['CHR_KODE_TTL'],
				'CHR_INV_NAME' => $dataexcel[$i]['CHR_INV_NAME'],
				'CHR_SATUAN' => $dataexcel[$i]['CHR_SATUAN'],
				'DEC_ANGGARAN' => $dataexcel[$i]['DEC_ANGGARAN'],
				'INT_VOLUME' => $dataexcel[$i]['INT_VOLUME'],
				'DEC_BIAYA' => $dataexcel[$i]['DEC_BIAYA'],
				'INT_JMLH_PROGRAM' => $dataexcel[$i]['INT_JMLH_PROGRAM'],
				'CHR_NO_KONTRAK' => $dataexcel[$i]['CHR_NO_KONTRAK'],
				'DEC_NILAI_KONTRAK' => $dataexcel[$i]['DEC_NILAI_KONTRAK'],
				'DEC_LEVEL_REVENUE' => $dataexcel[$i]['DEC_LEVEL_REVENUE'],
				'DEC_LEVEL_SERVICE' => $dataexcel[$i]['DEC_LEVEL_SERVICE'],
				'DEC_LEVEL_SAFETY' => $dataexcel[$i]['DEC_LEVEL_SAFETY'],
				'DEC_MIN_REQ' => $dataexcel[$i]['DEC_MIN_REQ'],
				'CHR_DURASI' => $dataexcel[$i]['CHR_DURASI'],
				'CHR_RENCANA_MULAI' => $dataexcel[$i]['CHR_RENCANA_MULAI'],
				'DEC_ANG_TRIWULAN_1' => $dataexcel[$i]['DEC_ANG_TRIWULAN_1'],
				'DEC_ANG_TRIWULAN_2' => $dataexcel[$i]['DEC_ANG_TRIWULAN_2'],
				'DEC_ANG_TRIWULAN_3' => $dataexcel[$i]['DEC_ANG_TRIWULAN_3'],
				'DEC_ANG_TRIWULAN_4' => $dataexcel[$i]['DEC_ANG_TRIWULAN_4'],
				'INT_REALISASI_FISIK' => $dataexcel[$i]['INT_REALISASI_FISIK'],
				'DEC_REALISASI_ANG' => $dataexcel[$i]['DEC_REALISASI_ANG'],
				'DEC_PEMBAYARAN' => $dataexcel[$i]['DEC_PEMBAYARAN'],
				'CHR_REALISASI_PROGRAM' => $dataexcel[$i]['CHR_REALISASI_PROGRAM'],
				'CHR_KETERANGAN' => $dataexcel[$i]['CHR_KETERANGAN'],
				'INT_BULAN' => $this->input->post('bulan'),
				'CHR_TAHUN' => $this->input->post('tahun'),
				'CHR_STATUS' => 1,
				'CHR_UPLOAD_DATE' => date('Ymd'),
				'CHR_UPLOAD_TIME' => date('His')
				);
              }
              var_dump($datainsert);
              exit();
              $this->Cpc_model->insert_investasi($datainsert);
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('cpc/upload_investasi'));

	}

	public function upload_rkm($error = NULL) {

		if($this->session->userdata('logged_in'))
    	{
    		$data['error'] = $error['error'];
			$this->load->view('public/themes/default/header');
	        $this->load->view('admin/cpc/upload_rkm',$data);
	        $this->load->view('public/themes/default/footer');
	    }
	    else
	    {
	       //If no session, redirect to login page
	       redirect('welcome');
	    }

	}	

}