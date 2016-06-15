<?php
class User_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function get_all_user()
        {
                $query = $this->db->query('SELECT * FROM TB_USR_DW WHERE STATUS = 1 ORDER BY ID_USER ASC');
                return $query->result();
        }

        public function get_last_id_user()
        {
                $query = $this->db->query('SELECT MAX(ID_USER) ID_USER FROM TB_USR_DW');
                return $query->row();
        }

        public function login($email,$password)
        {                 
                $query = $this -> db -> query('SELECT * FROM TB_USR_DW WHERE EMAIL = ? AND PASSWORD = ?', array($email,$password));
                 
                return $query->result();
        }

        public function insert_user($data)
        {
                $this->db->insert('TB_USR_DW',$data,FALSE);
                
        }

        public function get_user($data)
        {
                $this->db->from('TB_USR_DW',FALSE);
                $this->db->where('ID_USER',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }


        public function update_user($id_user,$data)
        {
                $this->db->where('id_user',$id_user,FALSE);
                $this->db->update('TB_USR_DW',$data,NULL,FALSE);                
        }

        public function delete_user($id_user,$data)
        {
                $this->db->where('id_user',$id_user,FALSE);
                $this->db->update('TB_USR_DW',$data,NULL,FALSE);                
        }

}