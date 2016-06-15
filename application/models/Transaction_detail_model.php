<?php
class Transaction_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                $this->load->database();
        }

        public function set_date_format(){
                $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT='DD-MON-YYYY HH24:MI:SS'");
        }

        public function get_all_transaction_details()
        {
                $query = $this->db->query('SELECT ID_TRANSACTION, NAMA_ALAT, a.ID_STATUS, c.NAMA_STATUS, FROM_DATETIME, TO_DATETIME, CHECKED_BY, CHECK_DATE 
                        FROM TRANSACTION a, MASTER_ALAT b , MASTER_STATUS c WHERE a.ID_ALAT = b.ID_ALAT AND a.ID_STATUS = c.ID_STATUS ORDER BY ID_TRANSACTION ASC');
                return $query->result();
        }

        public function get_last_id_transaction()
        {
                $query = $this->db->query('SELECT MAX(ID_TRANSACTION) ID_TRANSACTION FROM TRANSACTION');
                return $query->row();
        }

        public function insert_transaction($data)
        {
                $this->db->insert('TRANSACTION',$data,FALSE);
                
        }

        public function get_transaction_detail($data)
        {
                $this->db->from('TRANSACTION',FALSE);
                $this->db->where('ID_TRANSACTION',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }


        public function update_transaction($id_transaction,$data)
        {
                $this->db->where('id_transaction',$id_transaction,FALSE);
                $this->db->update('TRANSACTION',$data,NULL,FALSE);         
        }

        public function delete_transaction($id_transaction,$data)
        {
                $this->db->where('id_transaction',$id_transaction,FALSE);
                $this->db->update('TRANSACTION',$data,NULL,FALSE);                
        }

        
}