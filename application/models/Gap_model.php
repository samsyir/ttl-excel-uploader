<?php
class Gap_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_seq_procurement()
        {
                $query = $this->db->query('SELECT sq_ga_procurement.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_procurement($data)
        {
                $this->db->insert('TB_GA_PROCUREMENT',$data,FALSE);
                
        }
        
}