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
                     'Functions_Model',
                     'MerchantItems_Model',
                     'UsersData_Model',
                     'GuardianAccount_Model'
              ]);
       }

/* 
-- ---------------------
   VIEW MY CURRENT BALANCE
-- ---------------------
*/   
       public function View_My_Balance ($Account) {

              $AccountBalance = (float)$this->CI->Transactions_Model->calculate_total_balance(array(
                     'Account_Address' => $Account->UsersAccount_Address,
              ));

              if (!is_numeric($AccountBalance)) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance!. Please contact system administrator.'];
              }

              $parameters = [
                     'AccountBalance' => $AccountBalance
              ];

              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => 'Success'];
       }



/* 
-- ---------------------
   GUARDIAN VIEW BALANCE
-- ---------------------
*/   
       public function Guardian_View_My_Balance ($Account) {

              $AccountAddress = $this->CI->GuardianAccount_Model->read_by_address($Account->UsersAccount_Address);

              $AccountBalance = (float)$this->CI->Transactions_Model->calculate_total_balance(array(
                     'Account_Address' => $AccountAddress,
              ));

              if (!is_numeric($AccountBalance)) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance!. Please contact system administrator.'];
              }

              $parameters = [
                     'AccountBalance' => $AccountBalance
              ];

              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => 'Success'];
       }



/* 
-- -----------
   CASH IN
-- -----------
*/
       public function Cash_In ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');
              $this->CI->form_validation->set_rules('Amount', 'Amount', 'trim|required|number');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $Amount = $this->CI->Functions_Model->sanitize($requestPostBody['Amount']);

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



/* 
-- -----------------
   TRANSFER CASH
-- -----------------
*/
       public function Transfer_Cash ($Account, $AccountData, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');
              $this->CI->form_validation->set_rules('Amount', 'Amount', 'trim|required|number');
              $this->form_validation->set_rules('Message', 'Message', 'trim');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $Amount = $this->CI->Functions_Model->sanitize($requestPostBody['Amount']);
              $Message = $this->CI->Functions_Model->sanitize($requestPostBody['Message']);

              $isAccountExist =  $this->CI->UsersAccount_Model->read_by_address($AccountAddress);
              if (!$isAccountExist) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid receivers account!'];
              }
              if ($isAccountExist->IsAccountActive === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver account was declared Inactive, cannot proceed to transaction!'];
              }
              if ($AccountData->CanDoTransfers === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The sender account has CanDoTransfers turned off!'];
              }
              if ($AccountData->CanDoTransfers === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver is not on the senders whitelist!'];
              }

              $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                     'Account_Address' => $Account->UsersAccount_Address,
              ));
              $AccountBalance = (float)$AccountBalance;
              $Amount = (float)$Amount;
              if (!is_numeric($AccountBalance) || !is_numeric($amount)) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance or amount provided.'];
              }
              if ($AccountBalance < $amount) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'The amount declared is higher than the sender\'s current balance!'];
              }

              $this->db->trans_start(); 

                     $TransactionAddress = $this->CI->Functions_Model->create_unique_transaction_address();

                     // SENDER
                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $Account->UsersAccount_Address,
                            'Status' => 'Completed',
                            'Debit' => $Amount,
                            'Credit' => '0',
                     ));

                     // RECEIVER
                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $AccountAddress,
                            'Status' => 'Completed',
                            'Debit' => '0',
                            'Credit' => $Amount,
                     ));

                     $this->CI->Transactions_Model->create_transactioninfo(array(
                            'Transaction_Address' => $TransactionAddress,
                            'TransactionType_Id' => '2', // TRANSFER
                            'Sender_Address' => $Account->UsersAccount_Address,
                            'Receiver_Address' => $AccountAddress,
                            'Status' => 'Completed',
                            'Amount' => $Amount,
                            'Discount' => '0',
                            'DiscountReason' => '',
                            'TotalAmount' => $Amount,
                            'PostedBy' => $Account->UsersAccount_Address,
                     ));

              $this->db->trans_complete(); 

              if ($this->db->trans_status() === FALSE) {
                     $this->db->trans_rollback();
                     $error = $this->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Success'];
       }



/* 
-- -----------------
   CREATE ORDER
-- -----------------
*/   
       public function Create_Order($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');
              $this->CI->form_validation->set_rules('Discount', 'Discount', 'trim|required|numeric');
              $this->CI->form_validation->set_rules('DiscountReason', 'DiscountReason', 'trim');
              foreach ($requestPostBody['ItemsArray'] as $index => $item) {
                     $this->CI->form_validation->set_rules('ItemsArray[' . $index . '][ItemId]', 'ItemId', 'trim|required|numeric');
                     $this->CI->form_validation->set_rules('ItemsArray[' . $index . '][ItemQuantity]', 'ItemQuantity', 'trim|required|numeric');
              }

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $Discount = $this->CI->Functions_Model->sanitize($requestPostBody['Discount']);
              $DiscountReason = $this->CI->Functions_Model->sanitize($requestPostBody['DiscountReason']);
              $Amount = 0;
              $TotalAmount = 0;
              $ItemId = [];
              $transformedItems = [];
              foreach ($requestPostBody['ItemsArray'] as $index => $item) {
                     $transformedItems[$index] = [
                         'ItemId' => $this->CI->Functions_Model->sanitize($item['ItemId']),
                         'ItemQuantity' => $this->CI->Functions_Model->sanitize($item['ItemQuantity']),
                     ];
                     $ItemId[] = $this->CI->Functions_Model->sanitize($item['ItemId']);
              }

              $Items = $this->CI->MerchantItems_Model->read_all_by_id(array(
                     'ItemId' => $ItemId,
              ));

              if (count($ItemId) !== count($Items)) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid items!'];
              } else {
                     foreach ($Items as $row) {
                            $Amount += (float)$row->Price;
                            if ($row->IsActive === '0') {
                                   return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => $row->Name . ' - is not available!'];
                            }
                     }
                     $TotalAmount = $Amount - (float)$Discount;
              }

              $ReceiverAccount =  $this->CI->UsersAccount_Model->read_by_address($AccountAddress);
              $ReceiverAccountData = $this->CI->UsersData_Model->read_by_address($AccountAddress);
              if (!$ReceiverAccount) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid receivers account!'];
              }
              if ($ReceiverAccount->IsAccountActive === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver account was declared Inactive, cannot proceed to transaction!'];
              }
              if ($ReceiverAccountData->CanDoTransactions === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver account has CanDoTransactions turned off!'];
              }

              $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                     'Account_Address' => $AccountAddress,
              ));
              $AccountBalance = (float)$AccountBalance;
              if (!is_numeric($AccountBalance) || !is_numeric($TotalAmount)) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance or amount provided.'];
              }
              if ($AccountBalance < $TotalAmount) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'The amount declared is higher than the receivers\'s current balance!'];
              }

              $this->db->trans_start(); 

                     $TransactionAddress = $this->CI->Functions_Model->create_unique_transaction_address();

                     // SENDER
                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $Account->UsersAccount_Address,
                            'Status' => ($ReceiverAccountData->IsPurchaseAutoConfirm === '1') ? 'Completed' : 'Pending Payment',  
                            'Debit' => $TotalAmount,
                            'Credit' => '0',
                     ));

                     // RECEIVER
                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $AccountAddress,
                            'Status' => ($ReceiverAccountData->IsPurchaseAutoConfirm === '1') ? 'Completed' : 'Pending Payment',  
                            'Debit' => '0',
                            'Credit' => $TotalAmount,
                     ));

                     $this->CI->Transactions_Model->create_transactioninfo(array(
                            'Transaction_Address' => $TransactionAddress,
                            'TransactionType_Id' => '3', // Purchase
                            'Sender_Address' => $Account->UsersAccount_Address, /// shop name
                            'Receiver_Address' => $AccountAddress,
                            'Status' => ($ReceiverAccountData->IsPurchaseAutoConfirm === '1') ? 'Completed' : 'Pending Payment',  
                            'Amount' => $Amount,
                            'Discount' => $Discount,
                            'DiscountReason' => $DiscountReason,
                            'TotalAmount' => $TotalAmount,
                            'PostedBy' => $Account->UsersAccount_Address,
                     ));

              $this->db->trans_complete(); 

              if ($this->db->trans_status() === FALSE) {
                     $this->db->trans_rollback();
                     $error = $this->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              $parameters = [
                     'TransactionAddress' => $TransactionAddress
              ];

              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => 'Success'];
       }
    


/* 
-- -----------------
   APPROVE ORDER
-- -----------------
*/   
public function Approve_Order ($Account, $AccountData, $requestPostBody) {

       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|required|alpha_numeric|exact_length[20]');
       $this->CI->form_validation->set_rules('Status', 'Status', 'trim|required');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);
       $Status = $this->CI->Functions_Model->sanitize($requestPostBody['Status']);

       if ($Status === 'canceled' || $Status === 'confirmed') {
              $Status = ($Status === 'canceled') ? 'Canceled' : 'Completed';
       } else {
              return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid status parameter'];
       }

       $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
              'Account_Address' => $Account->UsersAccount_Address,
       ));
       $AccountBalance = (float)$AccountBalance;
       $Amount = (float)$Amount;
       if (!is_numeric($AccountBalance) || !is_numeric($amount)) {
              return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance or amount provided.'];
       }
       if ($AccountBalance < $amount) {
              return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'The amount declared is higher than the sender\'s current balance!'];
       }

       $this->db->trans_start(); 

              $this->CI->Transactions_Model->update_status_transaction(array(
                     'Transaction_Address' => $TransactionAddress,
                     'Status' => $Status,
              ));

              $this->CI->Transactions_Model->update_status_transactioninfo(array(
                     'Transaction_Address' => $TransactionAddress,
                     'Status' => $Status,
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