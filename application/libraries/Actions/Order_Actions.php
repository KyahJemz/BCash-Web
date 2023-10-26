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
                     'UsersAccount_Model',
                     'Card_Model'
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

       public function Listen_Event($Account,$requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('UserAddress', 'UserAddress', 'trim');
              $this->CI->form_validation->set_rules('CardAddress', 'CardAddress', 'trim');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $UserAddress = $this->CI->Functions_Model->sanitize($requestPostBody['UserAddress']) ?? "";
              $CardAddress = $this->CI->Functions_Model->sanitize($requestPostBody['CardAddress'])  ?? "";

              if (!empty($UserAddress) || !empty($CardAddress)){
                     $Card = $this->CI->Card_Model->read_by_CardAddress(array(
                            'Card_Address' => $CardAddress,
                     ));
                     if (!empty($Card)){
                            $UserAddress = $Card->UsersAccount_Address;
                     }
                     $UserBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                            'Account_Address' => $UserAddress,
                     ));
                     $UserName = $this->CI->UsersAccount_Model->read_name(array(
                            'UsersAccount_Address' => $UserAddress,
                     ));
                     if (empty($UserName)){
                            return ['Success' => True,'Target' => null,'Parameters' => ['UsersAccount_Address' => null],'Response' => ''];
                     }
                     return ['Success' => True,'Target' => null,'Parameters' => [
                            'UsersAccount_Address' => $UserAddress,
                            'UserName' => $UserName->Firstname ." ". $UserName->Lastname,
                            'UserBalance' => $UserBalance,
                     ],'Response' => ''];
              }

              $Event = $this->CI->Transactions_Model->Read_Order_Event(array(
                            'WebAccounts_Address' => $Account->WebAccounts_Address
                     ));

              if (!empty($Event->UsersAccount_Address)){
                     $UserBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                            'Account_Address' => $Event->UsersAccount_Address,
                     ));
                     $UserName = $this->CI->UsersAccount_Model->read_name(array(
                            'UsersAccount_Address' => $Event->UsersAccount_Address,
                     ));
                     return ['Success' => True,'Target' => null,'Parameters' => [
                            'UsersAccount_Address' => $Event->UsersAccount_Address,
                            'UserName' => $UserName->Firstname ." ". $UserName->Lastname,
                            'UserBalance' => $UserBalance,
                     ],'Response' => ''];
              }
       
              return ['Success' => True,'Target' => null,'Parameters' => $Event,'Response' => ''];
       }

       public function Listen_Confirmation_Event($requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);

              $Transaction = $this->CI->Transactions_Model->Listen_Confirmation_Event(array(
                     'Transaction_Address' => $TransactionAddress,
              ));
       
              return ['Success' => True,'Target' => null,'Parameters' => $Transaction,'Response' => ''];
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