<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->model([
                     'UsersAccount_Model',
                     'Transactions_Model',
                     'Functions_Model'
              ]);
       }


       public Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
              switch ($Intent) {
                    
              }
              return $response;
       }

       public function Cash_In ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);
              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');
              $this->CI->form_validation->set_rules('Amount', 'Amount', 'trim|required|number');

              $AccountAddress = $requestPostBody['AccountAddress'];
              $Amount = $requestPostBody['Amount'];

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $isAccountExist =  $this->CI->UsersAccount_Model->read_by_address($AccountAddress);
              if (!$isAccountExist) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid receivers account!'];
              }
              if ($isAccountExist->IsAccountActive === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver account was declared Inactive, cannot proceed to transaction!'];
              }

              $this->db->trans_start(); 

                     $TransactionAddress = $this->CI->Functions_Model->create_unique_transaction_address();

                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $AccountAddress,
                            'Status' => 'Completed',
                            'Debit' => '0',
                            'Credit' => $Amount,
                     ));

                     $this->CI->Transactions_Model->create_transactioninfo(array(
                            'Transaction_Address' => $TransactionAddress,
                            'TransactionType_Id' => '1', // CASHIN
                            'Sender_Address' => $Account->WebAccounts_Address,
                            'Receiver_Address' => $AccountAddress,
                            'Status' => 'Completed',
                            'Amount' => $Amount,
                            'Discount' => '0',
                            'DiscountReason' => '',
                            'TotalAmount' => $Amount,
                            'PostedBy' => $Account->WebAccounts_Address,
                     ));

              $this->db->trans_complete(); 

              if ($this->db->trans_status() === FALSE) {
                     $this->db->trans_rollback();
                     $error = $this->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Success'];
       }





}