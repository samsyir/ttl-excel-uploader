<?php
class Cpc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Excel_reader');
		$this->load->model('Cpc_model');
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
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_investasi($error);

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
					$dataexcel[$i - 1]['CHR_KODE_TTL'] 			= $data['cells'][$i][2];
					$dataexcel[$i - 1]['CHR_AKTIVA'] 			= $data['cells'][$i][3];
					$dataexcel[$i - 1]['CHR_KATEGORI'] 			= $data['cells'][$i][4];
					$dataexcel[$i - 1]['CHR_INV_NAME'] 			= $data['cells'][$i][5];
					$dataexcel[$i - 1]['CHR_SATUAN'] 			= $data['cells'][$i][6];
					$dataexcel[$i - 1]['DEC_ANGGARAN'] 			= $data['cells'][$i][7];
					$dataexcel[$i - 1]['INT_VOLUME'] 			= $data['cells'][$i][8];
					$dataexcel[$i - 1]['DEC_BIAYA'] 			= $data['cells'][$i][9];
					$dataexcel[$i - 1]['INT_JMLH_PROGRAM'] 		= $data['cells'][$i][10];
					$dataexcel[$i - 1]['CHR_NO_KONTRAK'] 		= $data['cells'][$i][11];
					$dataexcel[$i - 1]['DEC_NILAI_KONTRAK'] 	= $data['cells'][$i][12];
					$dataexcel[$i - 1]['DEC_LEVEL_REVENUE'] 	= $data['cells'][$i][13];
					$dataexcel[$i - 1]['DEC_LEVEL_SERVICE'] 	= $data['cells'][$i][14];
					$dataexcel[$i - 1]['DEC_LEVEL_SAFETY'] 		= $data['cells'][$i][15];
					$dataexcel[$i - 1]['DEC_MIN_REQ'] 			= $data['cells'][$i][16];
					$dataexcel[$i - 1]['CHR_DURASI'] 			= $data['cells'][$i][17];
					$dataexcel[$i - 1]['CHR_RENCANA_MULAI'] 	= $data['cells'][$i][18];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_1'] 	= $data['cells'][$i][19];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_2'] 	= $data['cells'][$i][20];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_3'] 	= $data['cells'][$i][21];
					$dataexcel[$i - 1]['DEC_ANG_TRIWULAN_4'] 	= $data['cells'][$i][22];
					$dataexcel[$i - 1]['INT_REALISASI_FISIK'] 	= $data['cells'][$i][23];
					$dataexcel[$i - 1]['DEC_REALISASI_ANG'] 	= $data['cells'][$i][24];
					$dataexcel[$i - 1]['DEC_PEMBAYARAN'] 		= $data['cells'][$i][25];
					$dataexcel[$i - 1]['CHR_REALISASI_PROGRAM'] = $data['cells'][$i][26];
					$dataexcel[$i - 1]['CHR_KETERANGAN'] 		= $data['cells'][$i][27];
					$dataexcel[$i - 1]['CHR_PIC_DEPT'] 			= $data['cells'][$i][28];
					$dataexcel[$i - 1]['CHR_STATUS'] 			= $data['cells'][$i][29];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
              	$investasi = $this->Cpc_model->get_seq_investasi();

              	$datainsert = array(
              	'INT_ID' => $this->db->escape($investasi->ID),
				'CHR_KODE_TTL' => $this->db->escape($dataexcel[$i]['CHR_KODE_TTL']),
				'CHR_AKTIVA' => $this->db->escape($dataexcel[$i]['CHR_AKTIVA']),
				'CHR_KATEGORI' => $this->db->escape($dataexcel[$i]['CHR_KATEGORI']),
				'CHR_INV_NAME' => $this->db->escape($dataexcel[$i]['CHR_INV_NAME']),
				'CHR_SATUAN' => $this->db->escape($dataexcel[$i]['CHR_SATUAN']),
				'DEC_ANGGARAN' => $this->db->escape($dataexcel[$i]['DEC_ANGGARAN']),
				'INT_VOLUME' => $this->db->escape($dataexcel[$i]['INT_VOLUME']),
				'DEC_BIAYA' => $this->db->escape($dataexcel[$i]['DEC_BIAYA']),
				'INT_JMLH_PROGRAM' => $this->db->escape($dataexcel[$i]['INT_JMLH_PROGRAM']),
				'CHR_NO_KONTRAK' => $this->db->escape($dataexcel[$i]['CHR_NO_KONTRAK']),
				'DEC_NILAI_KONTRAK' => $this->db->escape($dataexcel[$i]['DEC_NILAI_KONTRAK']),
				'DEC_LEVEL_REVENUE' => $this->db->escape($dataexcel[$i]['DEC_LEVEL_REVENUE']),
				'DEC_LEVEL_SERVICE' => $this->db->escape($dataexcel[$i]['DEC_LEVEL_SERVICE']),
				'DEC_LEVEL_SAFETY' => $this->db->escape($dataexcel[$i]['DEC_LEVEL_SAFETY']),
				'DEC_MIN_REQ' => $this->db->escape($dataexcel[$i]['DEC_MIN_REQ']),
				'CHR_DURASI' => $this->db->escape($dataexcel[$i]['CHR_DURASI']),
				'CHR_RENCANA_MULAI' => $this->db->escape($dataexcel[$i]['CHR_RENCANA_MULAI']),
				'DEC_ANG_TRIWULAN_1' => $this->db->escape($dataexcel[$i]['DEC_ANG_TRIWULAN_1']),
				'DEC_ANG_TRIWULAN_2' => $this->db->escape($dataexcel[$i]['DEC_ANG_TRIWULAN_2']),
				'DEC_ANG_TRIWULAN_3' => $this->db->escape($dataexcel[$i]['DEC_ANG_TRIWULAN_3']),
				'DEC_ANG_TRIWULAN_4' => $this->db->escape($dataexcel[$i]['DEC_ANG_TRIWULAN_4']),
				'INT_REALISASI_FISIK' => $this->db->escape($dataexcel[$i]['INT_REALISASI_FISIK']),
				'DEC_REALISASI_ANG' => $this->db->escape($dataexcel[$i]['DEC_REALISASI_ANG']),
				'DEC_PEMBAYARAN' => $this->db->escape($dataexcel[$i]['DEC_PEMBAYARAN']),
				'CHR_REALISASI_PROGRAM' => $this->db->escape($dataexcel[$i]['CHR_REALISASI_PROGRAM']),
				'CHR_KETERANGAN' => $this->db->escape($dataexcel[$i]['CHR_KETERANGAN']),
				'CHR_PIC_DEPT' => $this->db->escape($dataexcel[$i]['CHR_PIC_DEPT']),
				'INT_BULAN' => $this->db->escape($this->input->post('bulan')),
				'CHR_TAHUN' => $this->db->escape($this->input->post('tahun')),
				'CHR_STATUS' =>  $this->db->escape($dataexcel[$i]['CHR_STATUS']),
				'CHR_UPLOAD_DATE' => $this->db->escape(date('Ymd')),
				'CHR_UPLOAD_TIME' => $this->db->escape(date('His'))
				);

              	$this->Cpc_model->insert_investasi($datainsert);
              }
 
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

	public function do_upload_rkm() {
		// config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->upload_rkm($error);

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
					$dataexcel[$i - 1]['CHR_KATEGORI'] = $data['cells'][$i][2];
					$dataexcel[$i - 1]['CHR_BIDANG'] = $data['cells'][$i][3];
					$dataexcel[$i - 1]['CHR_RKM'] = $data['cells'][$i][4];
					$dataexcel[$i - 1]['CHR_PROGRAM_AKSI'] = $data['cells'][$i][5];
					$dataexcel[$i - 1]['CHR_TARGET_SELESAI'] = $data['cells'][$i][6];
					$dataexcel[$i - 1]['CHR_SASARAN'] = $data['cells'][$i][7];
					$dataexcel[$i - 1]['CHR_PIC_DEPT'] = $data['cells'][$i][8];
					$dataexcel[$i - 1]['CHR_STATUS_BELUM'] = $data['cells'][$i][9];
					$dataexcel[$i - 1]['CHR_STATUS_PROSES'] = $data['cells'][$i][10];
					$dataexcel[$i - 1]['CHR_STATUS_SELESAI'] = $data['cells'][$i][11];
					$dataexcel[$i - 1]['CHR_STATUS_TDK_DILAKSANAKAN'] = $data['cells'][$i][12];
					$dataexcel[$i - 1]['CHR_KETERANGAN'] = $data['cells'][$i][13];
              }
              
              for ($i=1; $i < count($dataexcel); $i++) { 
              	# code...
              	$rkm = $this->Cpc_model->get_seq_rkm();
              	$datainsert = array(
              	'INT_ID' => $this->db->escape($rkm->ID),
				'CHR_KATEGORI' => $this->db->escape($dataexcel[$i]['CHR_KATEGORI']),
				'CHR_BIDANG' => $this->db->escape($dataexcel[$i]['CHR_BIDANG']),
				'CHR_RKM' => $this->db->escape($dataexcel[$i]['CHR_RKM']),
				'CHR_PROGRAM_AKSI' => $this->db->escape($dataexcel[$i]['CHR_PROGRAM_AKSI']),
				'CHR_TARGET_SELESAI' => $this->db->escape($dataexcel[$i]['CHR_TARGET_SELESAI']),
				'CHR_SASARAN' => $this->db->escape($dataexcel[$i]['CHR_SASARAN']),
				'CHR_PIC_DEPT' => $this->db->escape($dataexcel[$i]['CHR_PIC_DEPT']),
				'CHR_STATUS_BELUM' => $this->db->escape($dataexcel[$i]['CHR_STATUS_BELUM']),
				'CHR_STATUS_PROSES' => $this->db->escape($dataexcel[$i]['CHR_STATUS_PROSES']),
				'CHR_STATUS_SELESAI' => $this->db->escape($dataexcel[$i]['CHR_STATUS_SELESAI']),
				'CHR_STATUS_TDK_DILAKSANAKAN' => $this->db->escape($dataexcel[$i]['CHR_STATUS_TDK_DILAKSANAKAN']),
				'CHR_KETERANGAN' => $this->db->escape($dataexcel[$i]['CHR_KETERANGAN']),
				'CHR_BULAN' => $this->db->escape($this->input->post('bulan')),
				'CHR_TAHUN' => $this->db->escape($this->input->post('tahun')),
				'CHR_STATUS' => 1,
				'CHR_UPLOAD_DATE' => $this->db->escape(date('Ymd')),
				'CHR_UPLOAD_TIME' => $this->db->escape(date('His'))
				);

              	$this->Cpc_model->insert_rkm($datainsert);
              }
 
              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);
            }
        //redirect ke halaman awal
        redirect(site_url('cpc/upload_rkm'));

	}	

}