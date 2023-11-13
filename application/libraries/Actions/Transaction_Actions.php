<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'UsersAccount_Model',
                     'Merchants_Model',
                     'Transactions_Model',
                     'Functions_Model',
                     'MerchantItems_Model',
                     'UsersData_Model',
                     'GuardianAccount_Model',
                     'Configurations_Model',
                     'Whitelist_Model'
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
   VIEW TOP TRANSACTION HISTORY
   - para sa users and guardian makita yung top history 
-- ---------------------
*/   
       public function View_Top_Transaction_History ($Account) {

              $TransactionHistory = $this->CI->Transactions_Model->read_transactions_by_address(array(
                     'Account_Address' => $Account->UsersAccount_Address,
                     'Limit' => '10',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $TransactionHistory,'Response' => 'Success'];
       }



/* 
-- ---------------------
   VIEW ALL TRANSACTION HISTORY
   - para sa users and guardian makita yung all history 
-- ---------------------
*/  
       public function View_All_Transaction_History ($Account) {

              $TransactionHistory = $this->CI->Transactions_Model->read_transactions_by_address(array(
                     'Account_Address' => $Account->UsersAccount_Address,
                     'Limit' => 'all',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $TransactionHistory,'Response' => 'Success'];
       }



/* 
-- ---------------------
   VIEW ALL TRANSACTION HISTORY
   - merchants use
-- ---------------------
*/  
public function Merchant_View_All_Transaction_History ($Account,$requestPostBody) {

       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('StartDate', 'StartDate', 'trim');
       $this->CI->form_validation->set_rules('EndDate', 'EndDate', 'trim');
       $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim');
       $this->CI->form_validation->set_rules('SearchName', 'SearchName', 'trim');
       $this->CI->form_validation->set_rules('StatusFilter', 'StatusFilter', 'trim|required');
       $this->CI->form_validation->set_rules('ResultsPerPage', 'ResultsPerPage', 'trim|required|numeric');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $StartDate = $this->CI->Functions_Model->sanitize($requestPostBody['StartDate']);
       $EndDate = $this->CI->Functions_Model->sanitize($requestPostBody['EndDate']);
       $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);
       $SearchName = $this->CI->Functions_Model->sanitize($requestPostBody['SearchName']);
       $StatusFilter = $this->CI->Functions_Model->sanitize($requestPostBody['StatusFilter']);

       $ResultsPerPage = $this->CI->Functions_Model->sanitize($requestPostBody['ResultsPerPage']);
       $Campus_Id = $Account->Campus_Id;

       $MerchantAdmin = $this->CI->Merchants_Model->get_merchantadminaddress(array(
              'WebAccounts_Address' => $Account->WebAccounts_Address,
       ));

       $TransactionHistory = $this->CI->Transactions_Model->read_all_user_transactions(array(
              'StartDate' => $StartDate,
              'EndDate' => $EndDate,
              'TransactionAddress' => $TransactionAddress,
              'AccountAddress' => $MerchantAdmin->WebAccounts_Address,
              'SearchName' => $SearchName,
              'StatusFilter' => $StatusFilter,
              'ResultsPerPage' => $ResultsPerPage,
              'Campus_Id' => $Campus_Id,
       ));
       return ['Success' => True,'Target' => null,'Parameters' => $TransactionHistory,'Response' => ''];
}



/* 
-- ---------------------
   VIEW USER TRANSACTION HISTORY INFO
   - for accounting and administrator
-- ---------------------
*/  
       public function Admin_Accounting_View_All_Transaction_History ($Account, $requestPostBody, $target) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('StartDate', 'StartDate', 'trim');
              $this->CI->form_validation->set_rules('EndDate', 'EndDate', 'trim');
              $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim');
              $this->CI->form_validation->set_rules('SearchName', 'SearchName', 'trim');
              $this->CI->form_validation->set_rules('StatusFilter', 'StatusFilter', 'trim|required');

              $this->CI->form_validation->set_rules('ResultsPerPage', 'ResultsPerPage', 'trim|required|numeric');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $StartDate = $this->CI->Functions_Model->sanitize($requestPostBody['StartDate']);
              $EndDate = $this->CI->Functions_Model->sanitize($requestPostBody['EndDate']);
              $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);
              $SearchName = $this->CI->Functions_Model->sanitize($requestPostBody['SearchName']);
              $StatusFilter = $this->CI->Functions_Model->sanitize($requestPostBody['StatusFilter']);

              $ResultsPerPage = $this->CI->Functions_Model->sanitize($requestPostBody['ResultsPerPage']);
              $Campus_Id = $Account->Campus_Id;

              if ($target === 'my') {
                     $AccountingTransactionHistoryInfo = $this->CI->Transactions_Model->read_all_user_transactions(array(
                            'StartDate' => $StartDate,
                            'EndDate' => $EndDate,
                            'TransactionAddress' => $TransactionAddress,
                            'AccountAddress' => 'ACT',
                            'SearchName' => $SearchName,
                            'StatusFilter' => $StatusFilter,
                            'ResultsPerPage' => $ResultsPerPage,
                            'Campus_Id' => $Campus_Id,
                     ));
                     return ['Success' => True,'Target' => null,'Parameters' => $AccountingTransactionHistoryInfo,'Response' => ''];
              } else if ($target === 'all'){
                     $AllTransactionHistoryInfo = $this->CI->Transactions_Model->read_all_user_transactions(array(
                            'StartDate' => $StartDate,
                            'EndDate' => $EndDate,
                            'TransactionAddress' => $TransactionAddress,
                            'SearchName' => $SearchName,
                            'StatusFilter' => $StatusFilter,
                            'ResultsPerPage' => $ResultsPerPage,
                            'Campus_Id' => $Campus_Id,
                     ));
                     return ['Success' => True,'Target' => null,'Parameters' => $AllTransactionHistoryInfo,'Response' => ''];
              } else {
                     return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
              }
       }





/* 
-- ---------------------
   VIEW USER TRANSACTION HISTORY INFO DETAILS
   - for user guest guardian
-- ---------------------
*/  
       public function View_My_Receipt($Account, $AccountData, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('TransactionAddress', 'StartDate', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);

              $TransactionDetails = $this->CI->Transactions_Model->read_transactionsinfo_by_transactionaddress(array(
                     'TransactionAddress'=>$TransactionAddress
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $TransactionDetails,'Response' => ''];

       }


/* 
-- ---------------------
   VIEW USER TRANSACTION HISTORY INFO DETAILS
   - for accounting and administrator
-- ---------------------
*/  
public function Admin_Accounting_View_All_Transaction_History_Details ($Account, $requestPostBody) {

       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);

       $AccountingTransactionHistoryInfoDetails = $this->CI->Transactions_Model->read_transactionsinfo_by_transactionaddress(array(
              'TransactionAddress' => $TransactionAddress,
       ));
       
       return ['Success' => True,'Target' => null,'Parameters' => $AccountingTransactionHistoryInfoDetails,'Response' => ''];
      
}


/* 
-- ---------------------
   VIEW ACCOUNTING TRANSACTION HISTORY INFO
   - for accounting
-- ---------------------
*/  
public function View_Accounting_Transaction_History_Info ($Account, $requestPostBody) {

       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('PageNumber', 'ResultsPerPage', 'trim|required|numeric');
       $this->CI->form_validation->set_rules('ResultsPerPage', 'ResultsPerPage', 'trim|required|numeric');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $PageNumber = $this->CI->Functions_Model->sanitize($requestPostBody['PageNumber']);
       $ResultsPerPage = $this->CI->Functions_Model->sanitize($requestPostBody['ResultsPerPage']);
       $Campus_Id = $Account->Campus_Id;

       $AllTransactionHistoryInfo = $this->CI->Transactions_Model->read_all_user_transactions(array(
              'PageNumber' => $PageNumber,
              'ResultsPerPage' => $ResultsPerPage,
              'Campus_Id' => $Campus_Id,
       ));

       return ['Success' => True,'Target' => null,'Parameters' => $AllTransactionHistoryInfo,'Response' => 'transactinsss'];
}


/*
-- ---------------------
   VIEW RECENT CASHIN
   - for accounting use
-- --------------------
*/
public function View_Recent_CashIn () {

       $RecentCashIn = $this->CI->Transactions_Model->read_recent_cashin(array(
              'Limit' => 10,
       ));

       return ['Success' => True,'Target' => null,'Parameters' => $RecentCashIn,'Response' => ''];
}




/*
-- ---------------------
   VIEW RECENT TRANSACTIONS
   - for user guest guardian
-- --------------------
*/
public function View_My_Recent_Transactions ($Account, $Limit) {

       $RecentTransactions = $this->CI->Transactions_Model->read_transactionsinfo_limit_by_address(array(
              'Account_Address'=>$Account->UsersAccount_Address,
              'Limit'=>$Limit
       ));
      
       return ['Success' => True,'Target' => null,'Parameters' => $RecentTransactions['response'],'Response' => ''];
}




/* 
-- -----------
   CASH IN
-- -----------
*/
       public function Cash_In ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Id', 'Id', 'trim|required');
              $this->CI->form_validation->set_rules('Amount', 'Amount', 'trim|required|numeric');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $Id = $this->CI->Functions_Model->sanitize($requestPostBody['Id']);
              $Amount = $this->CI->Functions_Model->sanitize($requestPostBody['Amount']);

              $AccountData = $this->CI->UsersData_Model->read_by_id(array('SchoolPersonalId'=>$Id));
              if (!$AccountData) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid receivers account!'];
              }
              $AccountAddress = $AccountData->UsersAccount_Address;

              $isAccountExist =  $this->CI->UsersAccount_Model->read_by_address(array('Account_Address'=>$AccountAddress));
              if (!$isAccountExist) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid receivers account!'];
              }
              if ($isAccountExist->IsAccountActive === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver account was declared Inactive, cannot proceed to transaction!'];
              }

              $this->CI->db->trans_start(); 

                     $TransactionAddress = $this->CI->Functions_Model->create_unique_transaction_address();

                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $AccountAddress,
                            'Status' => 'Completed',
                            'Debit' => '0',
                            'Credit' => $Amount,
                     ));

                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Status' => 'Completed',
                            'Debit' => $Amount,
                            'Credit' => '0',
                     ));

                     $this->CI->Transactions_Model->create_transactioninfo(array(
                            'Transaction_Address' => $TransactionAddress,
                            'TransactionType_Id' => '1', // CASHIN
                            'Sender_Address' => $Account->WebAccounts_Address,
                            'Receiver_Address' => $AccountAddress,
                            'Status' => 'Completed',
                            'Amount' => $Amount,
                            'Discount' => '0',
                            'TotalAmount' => $Amount,
                            'PostedBy' => $Account->WebAccounts_Address,
                            'Notes ' => "",
                            'PaymentMethod ' => "Cash",
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Transfer Success'];
       }



/* 
-- -----------------
   TRANSFER CASH
-- -----------------
*/
       public function Transfer_Cash($Account, $AccountData, $requestPostBody) {

              $CanTransfers = $this->CI->Configurations_Model->CanTransfers();
              if (!$CanTransfers['Success']){
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => $CanTransfers['Response']];
              }

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('SchoolPersonalId', 'SchoolPersonalId', 'trim|required');
              $this->CI->form_validation->set_rules('Amount', 'Amount', 'trim|required|numeric');
              $this->CI->form_validation->set_rules('Message', 'Message', 'trim');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $SchoolPersonalId = $this->CI->Functions_Model->sanitize($requestPostBody['SchoolPersonalId']);
              $Amount = $this->CI->Functions_Model->sanitize($requestPostBody['Amount']);
              $Message = $this->CI->Functions_Model->sanitize($requestPostBody['Message']) ?? "";

              $ReceiverDetails = $this->CI->UsersData_Model->read_by_SchoolPersonalId(array('SchoolPersonalId'=>$SchoolPersonalId));
              $ReceiverAccount = $this->CI->UsersAccount_Model->read_by_address(array('Account_Address'=>$ReceiverDetails->UsersAccount_Address));

              if (empty($ReceiverDetails)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid receivers account!'];
              }
              if ($ReceiverAccount->IsAccountActive === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The receiver account was declared Inactive, cannot proceed to transaction!'];
              }
              if ($Account->IsAccountActive === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Your account was declared Inactive, cannot proceed to transaction!'];
              }
              if ($AccountData->CanDoTransfers === '0') {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'The sender account has CanDoTransfers turned off!'];
              }

              $Whitelist = $this->CI->Whitelist_Model->verify(array(
                     'AccountAddress' => $Account->UsersAccount_Address,
                     'WhitelistedAddress' => $ReceiverAccount->UsersAccount_Address,
              ));
              if (empty($Whitelist)){
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Receiver account is not in the list of your whitlisted accounts.'];
              }

              $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                     'Account_Address' => $Account->UsersAccount_Address,
              ));
              $AccountBalance = (float)$AccountBalance;
              $Amount = (float)$Amount;
              if (!is_numeric($AccountBalance) || !is_numeric($Amount)) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance or amount provided.'];
              }
              if ($AccountBalance < $Amount) {
                     return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'The amount declared is higher than the sender\'s current balance!'];
              }

              $TransactionAddress = null;

              $this->CI->db->trans_start(); 

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
                            'Account_Address' => $ReceiverAccount->UsersAccount_Address,
                            'Status' => 'Completed',
                            'Debit' => '0',
                            'Credit' => $Amount,
                     ));

                     $this->CI->Transactions_Model->create_transactioninfo(array(
                            'Transaction_Address' => $TransactionAddress,
                            'TransactionType_Id' => '2', // TRANSFER
                            'Sender_Address' => $Account->UsersAccount_Address,
                            'Receiver_Address' => $ReceiverAccount->UsersAccount_Address,
                            'Status' => 'Completed',
                            'Amount' => $Amount,
                            'Discount' => '0',
                            'TotalAmount' => $Amount,
                            'PostedBy' => $Account->UsersAccount_Address,
                            'Notes' => $Message,
                            'PaymentMethod ' => "BCash",
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => $TransactionAddress,'Response' => 'Transfer Success'];
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
              $ItemToSave = [];
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
                     foreach ($transformedItems as $order) {
                            foreach ($Items as $item){
                                   if ($order['ItemId'] === $item->MerchantItems_Id){
                                          $Amount += ((float)$item->Price * (float)$order['ItemQuantity']);
                                          $ItemToSave[] = [
                                                 'MerchantItems_Id' => $item->MerchantItems_Id,
                                                 'Quantity' => $order['ItemQuantity'],
                                                 'Amount' => $item->Price,
                                          ];
                                          if ($item->IsActive === '0') {
                                                 return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => $item->Name . ' - is not available!'];
                                          }
                                   }
                            }
                     }

                     $TotalAmount = $Amount - (float)$Discount;
              }

              $MerchantAddress = $this->CI->Merchants_Model->get_merchantadminaddress(array(
                     'WebAccounts_Address'=>$Account->WebAccounts_Address,
              ))->WebAccounts_Address;
              $ReceiverAccount =  $this->CI->UsersAccount_Model->read_by_address(array('Account_Address'=>$AccountAddress));
              $ReceiverAccountData = $this->CI->UsersData_Model->read_by_address(array('Account_Address'=>$AccountAddress));
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

              $this->CI->db->trans_start(); 

                     $TransactionAddress = $this->CI->Functions_Model->create_unique_transaction_address();

                     // SENDER
                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $AccountAddress,
                            'Status' => ($ReceiverAccountData->IsTransactionAutoConfirm === '1') ? 'Paid' : 'Payment',  
                            'Debit' => $TotalAmount,
                            'Credit' => '0',
                     ));

                     // RECEIVER
                     $this->CI->Transactions_Model->create_transaction(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Account_Address' => $MerchantAddress,
                            'Status' => ($ReceiverAccountData->IsTransactionAutoConfirm === '1') ? 'Paid' : 'Payment',  
                            'Debit' => '0',
                            'Credit' => $TotalAmount,
                     ));

                     $this->CI->Transactions_Model->create_transactioninfo(array(
                            'Transaction_Address' => $TransactionAddress,
                            'TransactionType_Id' => '3', // Purchase
                            'Sender_Address' => $AccountAddress, 
                            'Receiver_Address' => $MerchantAddress,
                            'Status' => ($ReceiverAccountData->IsTransactionAutoConfirm === '1') ? 'Paid' : 'Payment',  
                            'Amount' => $Amount,
                            'Discount' => $Discount,
                            'TotalAmount' => $TotalAmount,
                            'PostedBy' => $Account->WebAccounts_Address,
                            'Notes ' => "",
                            'PaymentMethod ' => "BCash",
                     ));

                     $this->CI->Transactions_Model->create_transaction_items(array(
                            'Transaction_Address' => $TransactionAddress,
                            'Items' => $ItemToSave,
                     ));


              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              $parameters = [
                     'TransactionAddress' => $TransactionAddress
              ];

              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => 'Order posted, Waiting for payment.'];
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
              $Status = ($Status === 'canceled') ? 'Canceled' : 'Paid';
       } else {
              return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid status parameter'];
       }

       $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
              'Account_Address' => $Account->UsersAccount_Address,
       ));
       $AccountBalance = (float)$AccountBalance;
       $Amount = (float)$Amount;
       if (!is_numeric($AccountBalance) || !is_numeric($Amount)) {
              return ['Success' => false,'Target' => null,'Parameters' => null,'Response' => 'Invalid balance or amount provided.'];
       }
       if ($AccountBalance < $Amount) {
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

public function Get_Orders($Account){

       $MerchantAddress = $this->CI->Merchants_Model->get_merchantadminaddress(array(
              'WebAccounts_Address'=>$Account->WebAccounts_Address,
       ))->WebAccounts_Address;

       $PainOrders = $this->CI->Transactions_Model->read_paid_transactions(array(
              'Receiver_Address' => $MerchantAddress,
       ));

       return ['Success' => True,'Target' => null,'Parameters' => $PainOrders,'Response' => ''];
}

public function Complete_Order($Account, $requestPostBody){

       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|required|alpha_numeric|exact_length[20]');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $TransactionAddress = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionAddress']);

       $MerchantAddress = $this->CI->Merchants_Model->get_merchantadminaddress(array(
              'WebAccounts_Address'=>$Account->WebAccounts_Address,
       ))->WebAccounts_Address;

       $Transaction = $this->CI->Transactions_Model->read_transactionsinfo_by_transactionaddress(array(
              'TransactionAddress' => $TransactionAddress
       ));

       if ($Transaction['Info']->Receiver_Address !== $MerchantAddress){
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid, Not Your Orders.'];
       }

       $this->CI->Transactions_Model->complete_transaction(array(
              'Transaction_Address' => $TransactionAddress,
       ));

       return ['Success' => True,'Target' => null,'Parameters' => $Transaction,'Response' => 'Suucessfull'];
}



}