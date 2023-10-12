<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account_Actions {

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
                     'GuardianAccount_Model',
                     'Merchants_Model',
                     'WebAccounts_Model',
                     'ActivityLogs_Model',

              ]);
       }

/* 
-- ---------------------
   VIEW MY ACCOUNT DETAILS
   - all actors
-- ---------------------
*/  
       public function View_My_Account_Details($Account) {

              if ($Account->ActorCategory_Id === '3' || $Account->ActorCategory_Id === '4') {
                     $Details = $this->CI->Merchants_Model->read_merchant_by_address($Account->WebAccounts_Address);
                     $parameters = [
                            'Account': $Account,
                            'Details': ['MerchantCategory': $Details->MerchantsCategory_Id],
                     ]
                     return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];

              } else if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6' || $Account->ActorCategory_Id === '7') {
                     $Details = $this->CI->UsersData_Model->read_by_address($Account->UsersAccount_Address);
                     $parameters = [
                            'Account': $Account,
                            'Details': $Details,
                     ]
                     return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];

              } else {
                     $parameters = [
                            'Account': $Account,
                            'Details': null,
                     ]
                     return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];
              }
       }



/* 
-- ---------------------
   VIEW USER DETAILS
   - user guest only
-- ---------------------
*/  
       public function View_User_Details($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);

              $Account_ = $this->CI->UsersAccount_Model->read_by_address($AccountAddress);
              $Details_ = $this->CI->UsersData_Model->read_by_address($AccountAddress);
              $parameters = [
                     'Account': $Account_,
                     'Details': $Details_,
              ]
              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];
       }



/* 
-- ---------------------
   UPDATE USER DETAILS 
   - for accounting and admin
-- ---------------------
*/  
       public function Update_User_Account($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');

              $this->CI->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
              $this->CI->form_validation->set_rules('EmailId', 'EmailId', 'trim|required|valid_email');
              $this->CI->form_validation->set_rules('Firstname', 'Firstname', 'trim|required|alpha_numeric');
              $this->CI->form_validation->set_rules('Lastname', 'Lastname', 'trim|required|alpha_numeric');
              $this->CI->form_validation->set_rules('IsAccountActive', 'IsAccountActive', 'trim|required|numeric|exact_length[1]');

              $this->CI->form_validation->set_rules('Campus_Id', 'Campus_Id', 'trim|required|numeric');
              $this->CI->form_validation->set_rules('SchoolPersonalId', 'SchoolPersonalId', 'trim|required|numeric');
              $this->CI->form_validation->set_rules('CanDoTransfers', 'CanDoTransfers', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanDoTransactions', 'CanDoTransactions', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanUseCard', 'CanUseCard', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanModifySettings', 'CanModifySettings', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('IsPurchaseAutoConfirm', 'IsPurchaseAutoConfirm', 'trim|required|numeric|exact_length[1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['OldPinCode']);

              $Email = $this->CI->Functions_Model->sanitize($requestPostBody['Email']);
              $EmailId = $this->CI->Functions_Model->sanitize($requestPostBody['EmailId']);
              $Firstname = $this->CI->Functions_Model->sanitize($requestPostBody['Firstname']);
              $Lastname = $this->CI->Functions_Model->sanitize($requestPostBody['Lastname']);
              $IsAccountActive = $this->CI->Functions_Model->sanitize($requestPostBody['IsAccountActive']);

              $Campus_Id = $this->CI->Functions_Model->sanitize($requestPostBody['Campus_Id']);
              $SchoolPersonalId = $this->CI->Functions_Model->sanitize($requestPostBody['SchoolPersonalId']);
              $CanDoTransfers = $this->CI->Functions_Model->sanitize($requestPostBody['CanDoTransfers']);
              $CanDoTransactions = $this->CI->Functions_Model->sanitize($requestPostBody['CanDoTransactions']);
              $CanUseCard = $this->CI->Functions_Model->sanitize($requestPostBody['CanUseCard']);
              $CanModifySettings = $this->CI->Functions_Model->sanitize($requestPostBody['CanModifySettings']);
              $IsPurchaseAutoConfirm = $this->CI->Functions_Model->sanitize($requestPostBody['IsPurchaseAutoConfirm']);

              $Account_ = $this->CI->UsersAccount_Model->read_by_address(array('Account_Address': $AccountAddress));
              $Details_ = $this->CI->UsersData_Model->read_by_address(array('Account_Address': $AccountAddress));

              $this->db->trans_start(); 

                     if (
                            $Account_->Email != $Email || 
                            $Account_->EmailId != $EmailId || 
                            $Account_->Firstname != $Firstname || 
                            $Account_->Lastname != $Lastname ||
                            $Account_->IsAccountActive != $IsAccountActive
                     ) {

                            $this->CI->UsersAccount_Model->update(array(
                                   'UsersAccount_Address' => $AccountAddress
                                   'Email ' => $Email,
                                   'EmailId ' => $EmailId,
                                   'Firstname ' => $Firstname,
                                   'Lastname ' => $Lastname,
                                   'IsAccountActive' => $IsAccountActive,
                            ));
                            
                            if ($Account_->Email != $Email) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] Email settings to '.$Email.'.',
                                   ));
                            }
                            if ($Account_->EmailId != $EmailId) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] EmailId settings to '.$EmailId.'.',
                                   ));
                            }
                            if ($Account_->Firstname != $Firstname) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] Firstname settings to '.$Firstname.'.',
                                   ));
                            }
                            if ($Account_->Lastname != $Lastname) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] Lastname settings to '.$Lastname.'.',
                                   ));
                            }
                            if ($Account_->IsAccountActive != $IsAccountActive) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] IsAccountActive settings to '.$IsAccountActive.'.',
                                   ));
                            }
                     }

                     if (
                            $Details_->Campus_Id != $Campus_Id ||
                            $Details_->CanDoTransfers != $CanDoTransfers ||
                            $Details_->CanDoTransactions != $CanDoTransactions ||
                            $Details_->CanUseCard != $CanUseCard ||
                            $Details_->CanModifySettings != $CanModifySettings ||
                            $Details_->IsPurchaseAutoConfirm != $IsPurchaseAutoConfirm ||
                     ) else {

                            $this->CI->UsersData_Model->update(array(
                                   'UsersAccount_Address' => $AccountAddress
                                   'Campus_Id ' => $Campus_Id,
                                   'CanDoTransfers ' => $CanDoTransfers,
                                   'CanDoTransactions ' => $CanDoTransactions,
                                   'CanUseCard ' => $CanUseCard,
                                   'CanModifySettings' => $CanModifySettings,
                                   'IsPurchaseAutoConfirm' => $IsPurchaseAutoConfirm,
                            ));

                            if ($Details_->Campus_Id != $Campus_Id) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] Campus_Id settings to '.$Campus_Id.'.',
                                   ));
                            }
                            if ($Details_->CanDoTransfers != $CanDoTransfers) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] CanDoTransfers settings to '.$CanDoTransfers.'.',
                                   ));
                            }
                            if ($Details_->CanDoTransactions != $CanDoTransactions) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] CanDoTransactions settings to '.$CanDoTransactions.'.',
                                   ));
                            }
                            if ($Details_->CanUseCard != $CanUseCard) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] CanUseCard settings to '.$CanUseCard.'.',
                                   ));
                            }
                            if ($Details_->CanModifySettings != $CanModifySettings) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] CanModifySettings settings to '.$CanModifySettings.'.',
                                   ));
                            }
                            if ($Details_->IsPurchaseAutoConfirm != $IsPurchaseAutoConfirm) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $Account->WebAccounts_Address,
                                          'Task ' => 'Updated ['.$AccountAddress.'] IsPurchaseAutoConfirm settings to '.$IsPurchaseAutoConfirm.'.',
                                   ));
                            }
                     }

              $this->db->trans_complete(); 

              if ($this->db->trans_status() === FALSE) {
                     $this->db->trans_rollback();
                     $error = $this->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }



/* 
-- ---------------------
   VIEW USER ACCOUNT 
-- ---------------------
*/  
       public function View_User_Account($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);

              $Account_ = $this->CI->UsersAccount_Model->read_by_address($AccountAddress);
              $Details_ = $this->CI->UsersData_Model->read_by_address($AccountAddress);
              $parameters = [
                     'Account': $Account_,
                     'Details': $Details_,
              ]
              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE MY PIN CODE
   - for all
-- ---------------------
*/
       public function Update_My_PinCode ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('OldPinCode', 'OldPinCode', 'trim|required|number|exact_length[6]');
              $this->CI->form_validation->set_rules('NewPinCode1', 'NewPinCode1', 'trim|required|number|exact_length[6]');
              $this->CI->form_validation->set_rules('NewPinCode2', 'NewPinCode2', 'trim|required|number|exact_length[6]|matches[NewPinCode1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $OldPinCode = $this->CI->Functions_Model->sanitize($requestPostBody['OldPinCode']);
              $NewPinCode1 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPinCode1']);
              $NewPinCode2 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPinCode2']);

              if ($OldPinCode != $Account->PinCode) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Old PIN Code does not match with the current PIN Code!'];
              }
       
              if ($NewPinCode1 != $NewPinCode2) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'New PIN Code does not match!'];
              }

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $this->CI->UsersAccount_Model->update_pin($Account->UsersAccount_Address, $NewPinCode2);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->UsersAccount_Address,
                            'Task ' => 'Updated its own PIN Code.',
                     ));
              } else if ($Account->ActorCategory_Id === '7') {
                     $this->CI->UsersAccount_Model->update_pin($Account->GuardianAccount_Address, $NewPinCode2);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->GuardianAccount_Address,
                            'Task ' => 'Updated its own PIN Code.',
                     ));
              } else {
                     $this->CI->UsersAccount_Model->update_pin($Account->WebAccounts_Address, $NewPinCode2);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Task ' => 'Updated its own PIN Code.',
                     ));
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE USER PIN CODE
   - from admin to update user
-- ---------------------
*/
       public function Update_User_PinCode ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|exact_length[15]');
              $this->CI->form_validation->set_rules('NewPinCode1', 'NewPinCode1', 'trim|required|number|exact_length[6]');
              $this->CI->form_validation->set_rules('NewPinCode2', 'NewPinCode2', 'trim|required|number|exact_length[6]|matches[NewPinCode1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $NewPinCode1 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPinCode1']);
              $NewPinCode2 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPinCode2']);

              if ($NewPinCode1 != $NewPinCode2) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'New PIN Code does not match!'];
              }

              if ($Account_->ActorCategory_Id === '5' || $Account_->ActorCategory_Id === '6') {
                     $this->CI->UsersAccount_Model->update_pin($AccountAddress, $NewPinCode2);
              } else if ($Account_->ActorCategory_Id === '7') {
                     $this->CI->GuardianAccount_Model->update_pin($AccountAddress, $NewPinCode2);
              } else {
                     $this->CI->WebAccounts_Model->update_pin($AccountAddress, $NewPinCode2);
              }

              $this->CI->ActivityLogs_Model->create(array(
                     'Account_Address' => $Account->WebAccounts_Address,
                     'Task ' => 'Updated [' . $AccountAddress .'] PIN Code.',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE MY PASSWORD
   - for all
-- ---------------------
*/
       public function Update_My_Password ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('OldPassword', 'OldPassword', 'trim|required|min_length[8]|max_length[50]');
              $this->CI->form_validation->set_rules('NewPassword1', 'NewPassword1', 'trim|required|min_length[8]|max_length[50]');
              $this->CI->form_validation->set_rules('NewPassword2', 'NewPassword2', 'trim|required|min_length[8]|max_length[50]|matches[NewPassword1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $OldPassword = $this->CI->Functions_Model->sanitize($requestPostBody['OldPassword']);
              $NewPassword1 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPassword1']);
              $NewPassword2 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPassword2']);

              if (!password_verify($OldPassword, $Account->Password)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Old password does not match with the current password!'];
              }

              if ($NewPassword1 != $NewPassword2) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'New password does not match!'];
              }

              $this->CI->WebAccounts_Model->update_password($Account->WebAccounts_Address, $NewPassword2);

              $this->CI->ActivityLogs_Model->create(array(
                     'Account_Address' => $Account->WebAccounts_Address,
                     'Task ' => 'Updated its own password.',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE WEB ACCOUNT PASSWORD
   - from admin to update WebAccounts passwords
-- ---------------------
*/
       public function Update_WebAccount_Password ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|exact_length[15]');
              $this->CI->form_validation->set_rules('NewPassword1', 'NewPassword1', 'trim|required|min_length[8]|max_length[50]');
              $this->CI->form_validation->set_rules('NewPassword2', 'NewPassword2', 'trim|required|min_length[8]|max_length[50]|matches[NewPassword1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $NewPassword1 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPassword1']);
              $NewPassword2 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPassword2']);

              if ($NewPassword1 != $NewPassword2) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'New password does not match!'];
              }

              $this->CI->WebAccounts_Model->update_password($AccountAddress, $NewPassword2);

              $this->CI->ActivityLogs_Model->create(array(
                     'Account_Address' => $Account->WebAccounts_Address,
                     'Task ' => 'Updated [' . $AccountAddress . '] password.',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }






}