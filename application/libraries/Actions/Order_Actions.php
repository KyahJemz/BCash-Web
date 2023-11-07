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

       public function Update_Event($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('MerchantAddress', 'MerchantAddress', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $MerchantAddress = $this->CI->Functions_Model->sanitize($requestPostBody['MerchantAddress']) ?? "";

              $this->CI->db->trans_start(); 

                     $this->CI->Transactions_Model->Update_Order_Event(array(
                            'WebAccounts_Address' => $MerchantAddress,
                            'UsersAccount_Address'=> $Account->UsersAccount_Address
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Scan QR Complete'];
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






       public function Set_Purchase_Approved($Account,$requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);

              $this->CI->db->trans_start(); 

                     $this->CI->Transactions_Model->update_transactions_approved(array(
                            'Transaction_Address' => $TransactionAddress
                     ));

                     $this->CI->Transactions_Model->update_transactionsinfo_approved(array(
                            'Transaction_Address' => $TransactionAddress
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => $TransactionAddress,'Response' => ''];

       }

       public function Set_Purchase_Cancel($Account,$requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);

              $this->CI->db->trans_start(); 

                     $this->CI->Transactions_Model->update_transactions_cancel(array(
                            'Transaction_Address' => $TransactionAddress
                     ));

                     $this->CI->Transactions_Model->update_transactionsinfo_cancel(array(
                            'Transaction_Address' => $TransactionAddress
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => $TransactionAddress,'Response' => ''];
       }

       public function Get_Pending_Purchase($Account,$requestPostBody){
              $Pending = $this->CI->Transactions_Model->read_pending_transactions(array(
                     'UsersAccount_Address' => $Account->UsersAccount_Address
              ));

              if (!empty($Pending)){
                     return ['Success' => true,'Target' => null,'Parameters' => $Pending->Transaction_Address,'Response' => ''];
              } else {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => ''];
              }

              
       }
}