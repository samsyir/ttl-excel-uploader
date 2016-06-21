<?php
class Cpc_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_seq_investasi()
        {
                $query = $this->db->query('SELECT sq_cp_invst.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_investasi($data)
        {
                $this->db->insert('TB_CP_INVST',$data,FALSE);
                
        }

        public function get_seq_rkm()
        {
                $query = $this->db->query('SELECT sq_cp_rkm.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_rkm($data)
        {
                $this->db->insert('TB_CP_RKM',$data,FALSE);
                
        }
        
}