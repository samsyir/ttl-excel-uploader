<?php
class Hc_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function insert_pegawai($data)
        {
                $this->db->insert('TB_HC_PEGAWAI',$data,FALSE);
                
        }

        public function insert_rkap($data)
        {
                $this->db->insert('TB_HC_RKAP',$data,FALSE);
                
        }

        public function insert_training($data)
        {
                $this->db->insert('TB_HC_TRAINING',$data,FALSE);
        }
        
}