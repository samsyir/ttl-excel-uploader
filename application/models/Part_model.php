<?php
class Part_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_all_part()
        {
                $query = $this->db->query('SELECT * FROM MASTER_PART ORDER BY ID_PART ASC');
                return $query->result();
        }

        public function get_last_id_part()
        {
                $query = $this->db->query('SELECT MAX(ID_PART) ID_PART FROM MASTER_PART');
                return $query->row();
        }

        public function insert_part($data)
        {
                $this->db->insert('MASTER_PART',$data,FALSE);
                
        }

        public function get_part($data)
        {
                $this->db->from('TRANSACTION_DETAIL',FALSE);
                $this->db->where('ID_TRANSACTION',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }


        public function update_part($id_part,$data)
        {
                $this->db->where('id_part',$id_part,FALSE);
                $this->db->update('MASTER_PART',$data,NULL,FALSE);                
        }

        public function delete_part($id_part,$data)
        {
                $this->db->where('id_part',$id_part,FALSE);
                $this->db->update('MASTER_PART',$data,FALSE);                
        }

}