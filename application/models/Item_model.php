<?php
class Item_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_all_item()
        {
                $query = $this->db->query('SELECT * FROM MASTER_ITEM WHERE STATUS = 1 ORDER BY ID_ITEM ASC');
                return $query->result();
        }

        public function get_last_id_item()
        {
                $query = $this->db->query('SELECT MAX(ID_ITEM) ID_ITEM FROM MASTER_ITEM');
                return $query->row();
        }

        public function insert_item($data)
        {
                $this->db->insert('MASTER_ITEM',$data,FALSE);
                
        }

        public function get_item($data)
        {
                $this->db->from('MASTER_ITEM',FALSE);
                $this->db->where('ID_ITEM',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }


        public function update_item($id_item,$data)
        {
                $this->db->where('id_item',$id_item,FALSE);
                $this->db->update('MASTER_ITEM',$data,NULL,FALSE);                
        }

        public function delete_item($id_item,$data)
        {
                $this->db->where('id_item',$id_item,FALSE);
                $this->db->update('MASTER_ITEM',$data,FALSE);                
        }

}