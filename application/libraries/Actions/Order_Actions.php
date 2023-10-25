<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Transactions_Model',
              ]);
       }

       public function Set_Event($Account){

              $this->CI->db->trans_start(); 

                     $this->CI->Transactions_Model->Create_Order_Event(array(
                            'WebAccounts_Address' => $Account->WebAccounts_Address
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => $Account->WebAccounts_Address,'Response' => ''];
       }

       public function Listen_Event($Account){

              $Event = $this->CI->Transactions_Model->Read_Order_Event(array(
                            'WebAccounts_Address' => $Account->WebAccounts_Address
                     ));

              return ['Success' => True,'Target' => null,'Parameters' => $Event,'Response' => ''];
       }


       // public function Create_Order_Event($params){
       //        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
       //        $this->db->delete('tbl_ordersvalidation');
      
       //        $data = [
       //            'WebAccounts_Address' => $params['WebAccounts_Address'],
       //            'UsersAccount_Address' => null,
       //        ];
       //        $this->db->insert('tbl_ordersvalidation', $data);
       //    }
      
       //    public function Update_Order_Event($params){
       //        $data = [
       //            'UsersAccount_Address' => $params['UsersAccount_Address'],
       //        ];
              
       //        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
       //        $this->db->update('tbl_ordersvalidation', $data);
       //    }
      
       //    public function Delete_Order_Event($params){
       //        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
       //        $this->db->delete('tbl_ordersvalidation');
       //    }

}