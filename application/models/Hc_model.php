<?php
class Hc_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_seq_organization()
        {
                $query = $this->db->query('SELECT sq_hc_organization.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_organization($data)
        {
                $this->db->insert('TB_HC_ORGANIZATION',$data,FALSE);
                
        }

        public function get_seq_workforce()
        {
                $query = $this->db->query('SELECT sq_hc_workforce.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_workforce($data)
        {
                $this->db->insert('TB_HC_WORKFORCE',$data,FALSE);
                
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