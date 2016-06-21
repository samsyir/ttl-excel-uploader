<?php
class Qhsse_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_seq_k3()
        {
                $query = $this->db->query('SELECT sq_qh_k3.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_k3($data)
        {
                $this->db->insert('TB_QH_K3',$data,FALSE);
                
        }

        public function get_seq_lingkungan()
        {
                $query = $this->db->query('SELECT sq_qh_lingkungan.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_lingkungan($data)
        {
                $this->db->insert('TB_QH_LINGKUNGAN',$data,FALSE);
                
        }

        public function get_seq_mutu()
        {
                $query = $this->db->query('SELECT sq_qh_mutu.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_mutu($data)
        {
                $this->db->insert('TB_QH_MUTU',$data,FALSE);
                
        }

        public function get_seq_kepuasan()
        {
                $query = $this->db->query('SELECT sq_qh_puas_kust.nextval ID FROM dual');
                return $query->row();
        }

        public function insert_kepuasan($data)
        {
                $this->db->insert('TB_QH_PUAS_KUST',$data,FALSE);
                
        }
        
}