<?php
class Alat_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_all_alat()
        {
                $query = $this->db->query('SELECT * FROM MASTER_ALAT WHERE STATUS = 1 ORDER BY ID_ALAT ASC');
                return $query->result();
        }

        public function get_last_id_alat()
        {
                $query = $this->db->query('SELECT MAX(ID_ALAT) ID_ALAT FROM MASTER_ALAT');
                return $query->row();
        }

        public function insert_alat($data)
        {
                $this->db->insert('MASTER_ALAT',$data,FALSE);
                
        }

        public function get_alat($data)
        {
                $this->db->from('MASTER_ALAT',FALSE);
                $this->db->where('ID_ALAT',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }


        public function update_alat($id_alat,$data)
        {
                $this->db->where('id_alat',$id_alat,FALSE);
                $this->db->update('MASTER_ALAT',$data,NULL,FALSE);                
        }

        public function delete_alat($id_alat,$data)
        {
                $this->db->where('id_alat',$id_alat,FALSE);
                $this->db->update('MASTER_ALAT',$data,NULL,FALSE);                
        }

}