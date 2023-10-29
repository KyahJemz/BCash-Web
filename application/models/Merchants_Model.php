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

       public function get_categoryId($params) {
              $result = $this->db
              ->select('*')
              ->from('tbl_merchants')
              ->where('WebAccounts_Address', $params['Account_Address'])
              ->get()
              ->row();
       return $result;
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

       public function read_shopname_by_address($Account_Address) {
              $result = $this->db
                     ->select('*')
                     ->from('tbl_Merchants')
                     ->join('tbl_merchantscategory', 'tbl_Merchants.MerchantsCategory_Id = tbl_merchantscategory.MerchantsCategory_Id', 'left')
                     ->where('WebAccounts_Address ', $Account_Address)
                     ->get()
                     ->row();
              return $result;
       }

       public function read_merchantstaff_by_category($params) {
              $this->db
                     ->select('*')
                     ->from('tbl_Merchants')
                     ->join('tbl_webaccounts', 'tbl_Merchants.WebAccounts_Address = tbl_webaccounts.WebAccounts_Address', 'left')
                     ->where('tbl_Merchants.MerchantsCategory_Id ', $params['MerchantsCategory_Id'])
                     ->like('tbl_Merchants.WebAccounts_Address ', 'MTS', 'after');
              
              if (!empty($params['NameUsernameEmail'])){
                     $this->db
                     ->group_start()
                            ->like('tbl_webaccounts.WebAccounts_Address ', $params['NameUsernameEmail'])
                            ->or_like('tbl_webaccounts.Username ', $params['NameUsernameEmail'])
                            ->or_like('tbl_webaccounts.Email ', $params['NameUsernameEmail'])
                            ->or_like('tbl_webaccounts.Firstname ', $params['NameUsernameEmail'])
                            ->or_like('tbl_webaccounts.Lastname ', $params['NameUsernameEmail'])
                     ->group_end();
              }

              if ($params['Status'] !== 'All'){
                     $status = $params['Status'] === 'Active' ? '1' : '0';
                     $this->db->where('tbl_webaccounts.IsAccountActive ', (int)$status);
              }
                     
              return $this->db->get()->result();
       
       }

       public function read_merchants_by_category($params) {

              $MerchantId = $this->get_categoryId($params)->MerchantsCategory_Id;

              return $this->db
                     ->select('WebAccounts_Address')
                     ->from('tbl_Merchants')
                     ->where('MerchantsCategory_Id', $MerchantId) // Fixed the condition here
                     ->get()
                     ->result();
       }


}
