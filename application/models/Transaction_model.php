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
         public function set_date_format_detail(){
                $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT='DD-MON-YYYY HH24:MI:SS'");
        }
         public function set_date_index(){
                $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT='DD-MON-YYYY HH24'");
        }

        public function get_all_transaction()
        {
                $query = $this->db->query('SELECT ID_TRANSACTION, NAMA_ALAT, a.ID_STATUS, c.NAMA_STATUS, FROM_DATETIME, TO_DATETIME, CHECKED_BY, CHECK_DATE 
                        FROM TRANSACTION a, MASTER_ALAT b , MASTER_STATUS c WHERE a.ID_ALAT = b.ID_ALAT AND a.ID_STATUS = c.ID_STATUS ORDER BY ID_TRANSACTION ASC');
                return $query->result();
        }

        public function get_all_kendo( $column, $take, $skip, $sort_dir, $sort_field, $filterdata ) {
    
            //$this->db->from('TRANSACTION',FALSE);
            $this->db->select($column);
            
            // pengecekan apa ada trigger sort oleh user
            if( isset( $sort_dir ) ){
              
              // pengecekan apa ada trigger filter data oleh user
              if( $filterdata != 0 ){
                $this->db->order_by($sort_field, $sort_dir);
                $this->db->limit($take,$skip);

                // pengecekan filter operator kendo apa terset ?
                if( isset($filterdata['operator']) ) {
                  
                  // pengecekan filter operator default bawaaan kendo
                  if( $filterdata['operator'] == 'eq' ) {
                    $this->db->where($filterdata['field'], $filterdata['value']);
                  }
                  elseif( $filterdata['operator'] == 'neq' ) {
                    $field = $filterdata['field'] . ' != ';
                    $this->db->where($field, $filterdata['value']);
                  }
                  elseif( $filterdata['operator'] == 'startswith' ) {
                    $this->db->like($filterdata['field'], $filterdata['value'], 'after');
                  }
                  elseif( $filterdata['operator'] == 'contains' ) {
                    $this->db->like($filterdata['field'], $filterdata['value'], 'both');
                  }
                  elseif( $filterdata['operator'] == 'doesnotcontain' ) {
                    $this->db->not_like($filterdata['field'], $filterdata['value']);
                  }
                  elseif( $filterdata['operator'] == 'endswith' ) {
                    $this->db->like($filterdata['field'], $filterdata['value'],'before');
                  }
                }

                $data = $this->db->get('V_GET_ALL_TRANSACTION',FALSE);
              }else{
                $this->db->order_by($sort_field, $sort_dir);
                $this->db->limit($take,$skip);
                $data = $this->db->get('V_GET_ALL_TRANSACTION',FALSE);
              }
              
            }else{
              
              if( $filterdata != 0 ){

                if( isset($filterdata['operator']) ) {
                  if( $filterdata['operator'] == 'eq' ) {
                    $this->db->where($filterdata['field'], $filterdata['value']);
                  }
                  elseif( $filterdata['operator'] == 'neq' ) {
                    $field = $filterdata['field'] . ' != ';
                    $this->db->where($field, $filterdata['value']);
                  }
                  elseif( $filterdata['operator'] == 'startswith' ) {
                    $this->db->like($filterdata['field'], $filterdata['value'], 'after');
                  }
                  elseif( $filterdata['operator'] == 'contains' ) {
                    $this->db->like($filterdata['field'], $filterdata['value'], 'both');
                  }
                  elseif( $filterdata['operator'] == 'doesnotcontain' ) {
                    $this->db->not_like($filterdata['field'], $filterdata['value']);
                  }
                  elseif( $filterdata['operator'] == 'endswith' ) {
                    $this->db->like($filterdata['field'], $filterdata['value'],'before');
                  }
                }

                $this->db->limit($take,$skip);
                $data = $this->db->get('V_GET_ALL_TRANSACTION',FALSE);
              }else{
                $this->db->limit($take,$skip);
                $data = $this->db->get('V_GET_ALL_TRANSACTION',FALSE);
              }

            }
          
            return $data->result();
          }

        // menghitung total data table pada kendo
        public function count_all() {
            //$this->db->from('TRANSACTION',FALSE);
            $count = $this->db->count_all('V_GET_ALL_TRANSACTION',FALSE);
            $query = $this->db->last_query();
            return $count;
          }

          // menghitung total data jika terdapat kondisi tertentu pada kendo seperti filtering
        public function count_all_where($filterdata) {
            //$this->db->from('TRANSACTION',FALSE);
            if( isset($filterdata['operator']) ) {
              if( $filterdata['operator'] == 'eq' ) {
                $this->db->where($filterdata['field'], $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'neq' ) {
                $field = $filterdata['field'] . ' !=';
                $this->db->where($field, $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'startswith' ) {
                $this->db->like($filterdata['field'], $filterdata['value'], 'after');
              }
              elseif( $filterdata['operator'] == 'contains' ) {
                $this->db->like($filterdata['field'], $filterdata['value'], 'both');
              }
              elseif( $filterdata['operator'] == 'doesnotcontain' ) {
                $this->db->not_like($filterdata['field'], $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'endswith' ) {
                $this->db->like($filterdata['field'], $filterdata['value'],'before');
              }
            }
            $this->db->from('V_GET_ALL_TRANSACTION',FALSE);
            $count = $this->db->count_all_results();
            return $count;
          }

        public function get_all_transaction_details($id_transaction)
        {
                $query = $this->db->query('SELECT d.ID_TRANSACTION, d.ID_TRANSACTION_DETAIL, b.nama_alat, d.ID_ITEM, c.NAMA_ITEM,d.FROM_DATETIME,d.TO_DATETIME, PART 
                        FROM TRANSACTION a, MASTER_ALAT b , MASTER_ITEM c, TRANSACTION_DETAIL d
                        WHERE a.ID_ALAT = b.ID_ALAT AND a.ID_TRANSACTION = d.ID_TRANSACTION AND d.ID_ITEM = c.ID_ITEM AND d.ID_TRANSACTION = ?
                        ORDER BY ID_TRANSACTION_DETAIL ASC',array($id_transaction));
                return $query->result();
        }

        public function get_last_id_transaction()
        {
                $query = $this->db->query('SELECT nvl(MAX(ID_TRANSACTION),0) ID_TRANSACTION FROM TRANSACTION');
                return $query->row();
        }

        public function get_last_id_transaction_detail()
        {
                $query = $this->db->query('SELECT nvl(MAX(ID_TRANSACTION_DETAIL),0) ID_TRANSACTION_DETAIL FROM TRANSACTION_DETAIL');
                return $query->row();
        }

        public function insert_transaction($data)
        {
                $this->db->insert('TRANSACTION',$data,FALSE);
                
        }

        public function get_transaction($data)
        {
                $this->db->from('TRANSACTION',FALSE);
                $this->db->where('ID_TRANSACTION',$data,FALSE);
                $query = $this->db->get();

                return $query->row();                
        }

        public function get_transaction_pivot_all()
        {
                $this->db->from('V_TRANSACT_PIVOT',FALSE);
                $query = $this->db->get();

                return $query->result();                
        }

        public function get_transaction_pivot($date,$jenis_alat)
        {
                $this->db->from('V_TRANSACT_PIVOT',FALSE);
                $this->db->where('DATED',$date);
                $this->db->where('JENIS_ALAT',$jenis_alat);
                $query = $this->db->get();

                return $query->result();                
        }

        public function get_v_transaction_detail($status)
        {
                $this->db->from('V_TRANSACTION_DETAIL',FALSE);
                $this->db->where('KD_STATUS',$status);
                $query = $this->db->get();

                return $query->result();                
        }


        public function update_transaction($id_transaction,$data)
        {
                $this->db->where('ID_TRANSACTION',$id_transaction,FALSE);
                $this->db->update('TRANSACTION',$data,NULL,FALSE);         
        }

        public function update_transaction_detail($id_transaction_detail,$data)
        {
                $this->db->where('ID_TRANSACTION_DETAIL',$id_transaction_detail,FALSE);
                $this->db->update('TRANSACTION_DETAIL',$data,NULL,FALSE);         
        }


        public function delete_transaction($id_transaction)
        {
              //  $this->db->where('id_transaction',$id_transaction);
               // $this->db->delete('TRANSACTION');                
                 $this->db->query("delete from transaction where id_transaction='".$id_transaction."'");
        }
        public function delete_transaction_detail($id_transaction)
        {
              //  $this->db->where('id_transaction',$id_transaction);
               // $this->db->delete('TRANSACTION');                
                 $this->db->query("delete from transaction_detail where id_transaction='".$id_transaction."'");
        }
        public function delete_transaction_detail_1($id_transaction_detail)
        {
              //  $this->db->where('id_transaction',$id_transaction);
               // $this->db->delete('TRANSACTION');                
                 $this->db->query("delete from transaction_detail where id_transaction_detail='".$id_transaction_detail."'");
        }
        public function insert_transaction_detail($data)
        {
                $this->db->insert('TRANSACTION_DETAIL',$data,FALSE);
                
        }

        
}