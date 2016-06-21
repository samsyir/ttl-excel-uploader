<?php
class Hc_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_seq_pegawai()
        {
                $query = $this->db->query('SELECT sq_hc_pegawai.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_pegawai($data)
        {
                $this->db->insert('TB_HC_PEGAWAI',$data,FALSE);
                
        }

        public function get_seq_rkap()
        {
                $query = $this->db->query('SELECT sq_hc_rkap.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_rkap($data)
        {
                $this->db->insert('TB_HC_RKAP',$data,FALSE);
                
        }

        public function get_seq_training()
        {
                $query = $this->db->query('SELECT sq_hc_training.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_training($data)
        {
                $this->db->insert('TB_HC_TRAINING',$data,FALSE);
        }
        
}