<?php
class Merchants_Model extends CI_Model {



       public function __construct() {
              parent::__construct();
              $this->load->database();
       }

       public function read_merchantcategory($params) {
              $result = $this->db
              ->select('*')
              ->from('tbl_merchantscategory')
              ->where('Campus_Id', $params['Campus_Id'] )
              ->get()
              ->result();
          if ($result) {
              return $result;
          } else {
              return []; 
          }
       }

       public function get_merchantadminaddress($params) {
              $merchant = $this->db
                     ->select('*')
                     ->from('tbl_Merchants')
                     ->where('WebAccounts_Address ', $params['WebAccounts_Address'])
                     ->get()
                     ->row();
              $result = $this->db
                     ->select('*')
                     ->from('tbl_Merchants')
                     ->where('MerchantsCategory_Id', $merchant->MerchantsCategory_Id)
                     ->like('WebAccounts_Address', 'MTA', 'after')
                     ->get()
                     ->row();
              
          if ($result) {
              return $result;
          } else {
              return $result; 
          }
       }

       public function read_merchantcategory_by_ShopeName($params) {
              $result = $this->db
              ->select('*')
              ->from('tbl_merchantscategory')
              ->where('ShopName', $params['ShopName'] )
              ->get()
              ->row()
              ->MerchantsCategory_Id;
          if ($result) {
              return $result;
          } else {
              return false; 
          }
       }

       public function create_merchantcategory($params) {
              $data = [
                     'Campus_Id' => $params['Campus_Id'],
                     'ShopName' => $params['ShopName'],
              ];
              $this->db->insert('tbl_merchantscategory', $data);
              $result = $this->db->insert_id();
              return ($result) ? $result : FALSE;
       }

       public function create_merchant($params) {
              $data = [
                     'WebAccounts_Address' => $params['Account_Address'],
                     'MerchantsCategory_Id' => $params['MerchantsCategory_Id'],
              ];
              $this->db->insert('tbl_merchants', $data);
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
