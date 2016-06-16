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

                $data = $this->db->get('CHECK_JUMLAH_DATA',FALSE);
              }else{
                $this->db->order_by($sort_field, $sort_dir);
                $this->db->limit($take,$skip);
                $data = $this->db->get('CHECK_JUMLAH_DATA',FALSE);
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
                $data = $this->db->get('CHECK_JUMLAH_DATA',FALSE);
              }else{
                $this->db->limit($take,$skip);
                $data = $this->db->get('CHECK_JUMLAH_DATA',FALSE);
              }

            }
          
            return $data->result();
          }

        // menghitung total data table pada kendo
        public function count_all() {
            //$this->db->from('TRANSACTION',FALSE);
            $count = $this->db->count_all('CHECK_JUMLAH_DATA',FALSE);
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
            $this->db->from('CHECK_JUMLAH_DATA',FALSE);
            $count = $this->db->count_all_results();
            return $count;
          }

}