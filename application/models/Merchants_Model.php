<?php
class Merchants_Model extends CI_Model {



       public function __construct() {
              parent::__construct();
              $this->load->database();
       }

       public function create_merchant_category($Account_Address) {
              $data = [
                     'WebAccounts_Address' => $Account_Address,
              ];
              $this->db->insert('tbl_usersdata', $data);
              $result = $this->db->insert_id();
              return ($result) ? TRUE : FALSE;
       }

       public function create_merchant_staff($Account_Address) {
              $data = [
                     'WebAccounts_Address' => $Account_Address,
              ];
              $this->db->insert('tbl_usersdata', $data);
              $result = $this->db->insert_id();
              return ($result) ? TRUE : FALSE;
       }

       public function create_merchant_admin($Account_Address) {
              $data = [
                     'WebAccounts_Address' => $Account_Address,
              ];
              $this->db->insert('tbl_usersdata', $data);
              $result = $this->db->insert_id();
              return ($result) ? TRUE : FALSE;
       }

       public function read_merchant_by_address($Account_Address) {
              $result = $this->db
                     ->select('*')
                     ->from('tbl_Merchants')
                     ->where('WebAccounts_Address ', $Account_Address)
                     ->get()
                     ->row();
              if ($result) {
                     return $result;
              } else {
                     return null; 
              }
       }

}
