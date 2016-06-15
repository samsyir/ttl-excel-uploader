<?php
class Fa_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_seq_kas()
        {
                $query = $this->db->query('SELECT sq_fi_kas.nextval FROM dual');
                return $query->row();
        }

        public function insert_kas($data)
        {
                $this->db->insert('TB_FI_KAS',$data,FALSE);
                
        }

        public function get_seq_neraca()
        {
                $query = $this->db->query('SELECT sq_fi_neraca.nextval FROM dual');
                return $query->row();
        }

        public function insert_neraca($data)
        {
                $this->db->insert('TB_FI_NERACA',$data,FALSE);
                
        }
        
}