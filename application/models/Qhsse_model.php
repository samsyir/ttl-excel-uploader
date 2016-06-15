<?php
class Qhsse_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function insert_k3($data)
        {
                $this->db->insert('TB_QH_K3',$data,FALSE);
                
        }

        public function insert_lingkungan($data)
        {
                $this->db->insert('TB_QH_LINGKUNGAN',$data,FALSE);
                
        }

        public function insert_mutu($data)
        {
                $this->db->insert('TB_QH_MUTU',$data,FALSE);
                
        }

        public function insert_puas_kust($data)
        {
                $this->db->insert('TB_QH_PUAS_KUST',$data,FALSE);
                
        }
        
}