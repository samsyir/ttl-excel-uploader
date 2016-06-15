<?php
class Cpc_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function insert_investasi($data)
        {
                $this->db->insert('TB_CP_INVST',$data,FALSE);
                
        }

        public function insert_rkm($data)
        {
                $this->db->insert('TB_CP_RKM',$data,FALSE);
                
        }
        
}