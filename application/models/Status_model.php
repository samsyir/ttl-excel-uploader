<?php
class Status_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_all_status()
        {
                $query = $this->db->query('SELECT * FROM MASTER_STATUS ORDER BY ID_STATUS ASC');
                return $query->result();
        }

        public function get_last_id_status()
        {
                $query = $this->db->query('SELECT MAX(ID_STATUS) ID_STATUS FROM MASTER_STATUS');
                return $query->row();
        }

        public function insert_status($data)
        {
                $this->db->insert('MASTER_STATUS',$data,FALSE);
                
        }

        public function get_status($data)
        {
                $this->db->from('MASTER_STATUS',FALSE);
                $this->db->where('ID_STATUS',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }


        public function update_status($id_status,$data)
        {
                $this->db->where('id_status',$id_status,FALSE);
                $this->db->update('MASTER_STATUS',$data,FALSE);                
        }

        public function delete_status($id_status,$data)
        {
                $this->db->where('id_status',$id_status,FALSE);
                $this->db->update('MASTER_STATUS',$data,FALSE);                
        }

}