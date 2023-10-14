<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
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
                            'Account'=> $Account,
                            'Details'=> ['MerchantCategory' => $Details->MerchantsCategory_Id],
                     ];
                     return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];

              } else if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6' || $Account->ActorCategory_Id === '7') {
                     $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                            'Account_Address' => $Account->UsersAccount_Address,
                     ));
                     $Details = $this->CI->UsersData_Model->read_by_address(array('Account_Address'=>$Account->UsersAccount_Address));
                     $parameters = [
                            'Account'=> $Account,
                            'Details'=> $Details,
                     ];
                     return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];

              } else {
                     $parameters = [
                            'Account'=> $Account,
                            'Details'=> null,
                     ];
                     return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];
              }
       }



/*
-- ---------------------
   UPDATE MY PIN CODE
   - for all
-- ---------------------
*/
       public function Update_My_PinCode ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('CurrentPIN', 'CurrentPIN', 'trim|required|numeric|exact_length[6]');
              $this->CI->form_validation->set_rules('NewPINCode1', 'NewPINCode1', 'trim|required|numeric|exact_length[6]');
              $this->CI->form_validation->set_rules('NewPINCode2', 'NewPINCode2', 'trim|required|numeric|exact_length[6]|matches[NewPINCode1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $CurrentPIN = $this->CI->Functions_Model->sanitize($requestPostBody['CurrentPIN']);
              $NewPINCode1 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPINCode1']);
              $NewPINCode2 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPINCode2']);

              if ($CurrentPIN != $Account->PinCode) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'PIN Code is incorrect!'];
              }

              if ($NewPINCode1 != $NewPINCode2) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'New PIN Code does not match!'];
              }

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $this->CI->UsersAccount_Model->update_pin($Account->UsersAccount_Address, $NewPINCode2);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->UsersAccount_Address,
                            'Task' => 'Updated its own PIN Code.',
                     ));
              } else if ($Account->ActorCategory_Id === '7') {
                     // $this->CI->GuardianAccount_Address->update_pin(array(
                     //        'Account_Address'=>$Account->GuardianAccount_Address, 
                     //        'PinCode' =>$NewPINCode2
                     // ));
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->GuardianAccount_Address,
                            'Task' => 'Updated its own PIN Code.',
                     ));
              } else {
                     $this->CI->WebAccounts_Model->update_pin($Account->WebAccounts_Address, $NewPINCode2);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Task' => 'Updated its own PIN Code.',
                     ));
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'PIN Code successfully updated!'];
       }



/*
-- ---------------------
   UPDATE MY PASSWORD
   - for all
-- ---------------------
*/
       public function Update_My_Password ($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('CurrentPassword', 'CurrentPassword', 'trim|required|max_length[50]');
              $this->CI->form_validation->set_rules('NewPassword1', 'NewPassword1', 'trim|required|min_length[8]|max_length[50]');
              $this->CI->form_validation->set_rules('NewPassword2', 'NewPassword2', 'trim|required|min_length[8]|max_length[50]|matches[NewPassword1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $CurrentPassword = $this->CI->Functions_Model->sanitize($requestPostBody['CurrentPassword']);
              $NewPassword1 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPassword1']);
              $NewPassword2 = $this->CI->Functions_Model->sanitize($requestPostBody['NewPassword2']);

              if (!password_verify($CurrentPassword, $Account->Password)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Password is incorrect!'];
              }

              if ($NewPassword1 != $NewPassword2) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'New password does not match!'];
              }

              $this->CI->WebAccounts_Model->update_password($Account->WebAccounts_Address, $NewPassword2);

              $this->CI->ActivityLogs_Model->create(array(
                     'Account_Address' => $Account->WebAccounts_Address,
                     'Task' => 'Updated its own password.',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Password successfully updated!'];
       }


/* 
-- ---------------------
   UPDATE MY DETAILS 
   - for user guest and guardian
-- ---------------------
*/  
       public function Update_My_Details($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('CanDoTransfers', 'CanDoTransfers', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanDoTransactions', 'CanDoTransactions', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanUseCard', 'CanUseCard', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanModifySettings', 'CanModifySettings', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('IsPurchaseAutoConfirm', 'IsPurchaseAutoConfirm', 'trim|required|numeric|exact_length[1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $Account->UsersAccount_Address;

              $CanDoTransfers = $this->CI->Functions_Model->sanitize($requestPostBody['CanDoTransfers']);
              $CanDoTransactions = $this->CI->Functions_Model->sanitize($requestPostBody['CanDoTransactions']);
              $CanUseCard = $this->CI->Functions_Model->sanitize($requestPostBody['CanUseCard']);
              $CanModifySettings = $this->CI->Functions_Model->sanitize($requestPostBody['CanModifySettings']);
              $IsPurchaseAutoConfirm = $this->CI->Functions_Model->sanitize($requestPostBody['IsPurchaseAutoConfirm']);

       
              $Details_ = $this->CI->UsersData_Model->read_by_address(array('Account_Address'=> $AccountAddress));

              $this->db->trans_start(); 

                     if (
                            $Details_->CanDoTransfers != $CanDoTransfers ||
                            $Details_->CanDoTransactions != $CanDoTransactions ||
                            $Details_->CanUseCard != $CanUseCard ||
                            $Details_->CanModifySettings != $CanModifySettings ||
                            $Details_->IsPurchaseAutoConfirm != $IsPurchaseAutoConfirm
                     ) {

                            if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                                   if ($Details_->CanModifySettings === '0') {
                                          return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'You do not have permission, CanModifySettings is turned off!'];
                                   }
                                   $this->CI->UsersData_Model->update_by_users(array(
                                          'UsersAccount_Address' => $AccountAddress,
                                          'CanDoTransfers ' => $CanDoTransfers,
                                          'CanDoTransactions ' => $CanDoTransactions,
                                          'CanUseCard ' => $CanUseCard,
                                          'IsPurchaseAutoConfirm' => $IsPurchaseAutoConfirm,
                                   ));
                            }

                            if ($Account->ActorCategory_Id === '7') {
                                   $this->CI->UsersData_Model->update_by_guardian(array(
                                          'UsersAccount_Address' => $AccountAddress,
                                          'CanDoTransfers ' => $CanDoTransfers,
                                          'CanDoTransactions ' => $CanDoTransactions,
                                          'CanUseCard ' => $CanUseCard,
                                          'CanModifySettings' => $CanModifySettings,
                                          'IsPurchaseAutoConfirm' => $IsPurchaseAutoConfirm,
                                   ));

                                   if ($Details_->CanModifySettings != $CanModifySettings) {
                                          $this->CI->ActivityLogs_Model->create(array(
                                                 'Account_Address' => $AccountAddress,
                                                 'Task' => 'Updated its own CanModifySettings settings to '.$CanModifySettings.'.',
                                          ));
                                   }
                            }
                            
                            if ($Details_->CanDoTransfers != $CanDoTransfers) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $AccountAddress,
                                          'Task' => 'Updated its own CanDoTransfers settings to '.$CanDoTransfers.'.',
                                   ));
                            }
                            if ($Details_->CanDoTransactions != $CanDoTransactions) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $AccountAddress,
                                          'Task' => 'Updated its own CanDoTransactions settings to '.$CanDoTransactions.'.',
                                   ));
                            }
                            if ($Details_->CanUseCard != $CanUseCard) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $AccountAddress,
                                          'Task' => 'Updated its own CanUseCard settings to '.$CanUseCard.'.',
                                   ));
                            }
                            if ($Details_->IsPurchaseAutoConfirm != $IsPurchaseAutoConfirm) {
                                   $this->CI->ActivityLogs_Model->create(array(
                                          'Account_Address' => $AccountAddress,
                                          'Task' => 'Updated its own IsPurchaseAutoConfirm settings to '.$IsPurchaseAutoConfirm.'.',
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
   UPDATE MY DETAILS 
   - for WEB ACTORS
-- ---------------------
*/  
       public function Update_My_Account($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Firstname', 'Firstname', 'trim|required|alpha_numeric_spaces|max_length[50]');
              $this->CI->form_validation->set_rules('Lastname', 'Lastname', 'trim|required|alpha_numeric_spaces|max_length[50]');
              $this->CI->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
              $this->CI->form_validation->set_rules('CurrentPassword', 'CurrentPassword', 'trim|required|max_length[50]');
              $this->CI->form_validation->set_rules('CurrentPIN', 'CurrentPIN', 'trim|required|numeric|exact_length[6]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $Firstname = $this->CI->Functions_Model->sanitize($requestPostBody['Firstname']);
              $Lastname = $this->CI->Functions_Model->sanitize($requestPostBody['Lastname']);
              $Email = $this->CI->Functions_Model->sanitize($requestPostBody['Email']);
              $CurrentPassword = $this->CI->Functions_Model->sanitize($requestPostBody['CurrentPassword']);
              $CurrentPIN = $this->CI->Functions_Model->sanitize($requestPostBody['CurrentPIN']);

              if (!password_verify($CurrentPassword, $Account->Password)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Password is incorrect!'];
              }

              if ($CurrentPIN != $Account->PinCode) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'PIN Code is incorrect!'];
              }

              $this->CI->db->trans_start(); 

                     if ($Account->Firstname != $Firstname) {
                            $this->CI->WebAccounts_Model->update_firstname()(array(
                                   'AccountAddress' => $Account->WebAccounts_Address,
                                   'Firstname' => $Firstname
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated its own Firstname to '.$Firstname.'.',
                            ));
                     }

                     if ($Account->Lastname != $Lastname) {
                            $this->CI->WebAccounts_Model->update_lastname(array(
                                   'AccountAddress' => $Account->WebAccounts_Address,
                                   'Lastname' => $Lastname
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated its own Lastname to '.$Lastname.'.',
                            ));
                     }

                     if ($Account->Email != $Email) {
                            $this->CI->WebAccounts_Model->update_email()(array(
                                   'AccountAddress' => $Account->WebAccounts_Address,
                                   'Email' => $Email
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated its own Email to '.$Email.'.',
                            ));
                     }

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Account updated successfully!'];
       } 



/* 
-- ---------------------
   UPDATE USER DETAILS 
   - for accounting
-- ---------------------
*/  
       public function Update_User_Account_By_Accounting($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');
              $this->CI->form_validation->set_rules('PINCode', 'PINCode', 'trim|required|numeric|exact_length[6]');

              $this->CI->form_validation->set_rules('Email', 'Email', 'trim|valid_email|max_length[50]');
              $this->CI->form_validation->set_rules('Firstname', 'Firstname', 'trim|alpha_numeric|max_length[50]');
              $this->CI->form_validation->set_rules('Lastname', 'Lastname', 'trim|alpha_numeric|max_length[50]');
              $this->CI->form_validation->set_rules('IsAccountActive', 'IsAccountActive', 'trim|required|numeric|exact_length[1]');

              $this->CI->form_validation->set_rules('SchoolPersonalId', 'SchoolPersonalId', 'trim|alpha_numeric');
              $this->CI->form_validation->set_rules('CanDoTransfers', 'CanDoTransfers', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanDoTransactions', 'CanDoTransactions', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanUseCard', 'CanUseCard', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('CanModifySettings', 'CanModifySettings', 'trim|required|numeric|exact_length[1]');
              $this->CI->form_validation->set_rules('IsTransactionAutoConfirm', 'IsTransactionAutoConfirm', 'trim|required|numeric|exact_length[1]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $PINCode = $this->CI->Functions_Model->sanitize($requestPostBody['PINCode']);

              $Email = $this->CI->Functions_Model->sanitize($requestPostBody['Email']);
              $Firstname = $this->CI->Functions_Model->sanitize($requestPostBody['Firstname']);
              $Lastname = $this->CI->Functions_Model->sanitize($requestPostBody['Lastname']);
              $IsAccountActive = $this->CI->Functions_Model->sanitize($requestPostBody['IsAccountActive']);

              $SchoolPersonalId = $this->CI->Functions_Model->sanitize($requestPostBody['SchoolPersonalId']);
              $CanDoTransfers = $this->CI->Functions_Model->sanitize($requestPostBody['CanDoTransfers']);
              $CanDoTransactions = $this->CI->Functions_Model->sanitize($requestPostBody['CanDoTransactions']);
              $CanUseCard = $this->CI->Functions_Model->sanitize($requestPostBody['CanUseCard']);
              $CanModifySettings = $this->CI->Functions_Model->sanitize($requestPostBody['CanModifySettings']);
              $IsTransactionAutoConfirm = $this->CI->Functions_Model->sanitize($requestPostBody['IsTransactionAutoConfirm']);

              if ($PINCode !== $Account->PinCode) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid PIN Code']; 
              }

              $Account_ = $this->CI->UsersAccount_Model->read_by_address(array('Account_Address'=> $AccountAddress));
              $Details_ = $this->CI->UsersData_Model->read_by_address(array('Account_Address'=> $AccountAddress));

              if (empty($Account_) || empty($Details_)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid Account'];
              }

              $changes = 'Changes: ';

              $this->CI->db->trans_start(); 

                     if ($Account_->Email !== $Email) {
                            $this->CI->UsersAccount_Model->update_Email(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'Email' => $Email,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] Email settings to '.$Email.'.',
                            ));
                            $changes = $changes . 'Email, ';
                     }

                     if ($Account_->Firstname !== $Firstname) {
                            $this->CI->UsersAccount_Model->update_Firstname(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'Firstname' => $Firstname,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] Firstname settings to '.$Firstname.'.',
                            ));
                            $changes = $changes . 'Firstname, ';
                     }

                     if ($Account_->Lastname !== $Lastname) {
                            $this->CI->UsersAccount_Model->update_Lastname(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'Lastname' => $Lastname,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] Lastname settings to '.$Lastname.'.',
                            ));
                            $changes = $changes . 'Lastname, ';
                     }

                     if ($Account_->IsAccountActive !== $IsAccountActive) {
                            $this->CI->UsersAccount_Model->update_IsAccountActive(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'IsAccountActive' => $IsAccountActive,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] IsAccountActive settings to '.$IsAccountActive.'.',
                            ));
                            $changes = $changes . 'IsAccountActive, ';
                     }

                     if ($Details_->SchoolPersonalId !== $SchoolPersonalId) {
                            $this->CI->UsersData_Model->update_SchoolPersonalId(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'SchoolPersonalId' => $SchoolPersonalId,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] SchoolPersonalId settings to '.$SchoolPersonalId.'.',
                            ));
                            $changes = $changes . 'SchoolPersonalId, ';
                     }

                     if ($Details_->CanDoTransfers !== $CanDoTransfers) {
                            $this->CI->UsersData_Model->update_CanDoTransfers(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'CanDoTransfers' => $CanDoTransfers,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] CanDoTransfers settings to '.$CanDoTransfers.'.',
                            ));
                            $changes = $changes . 'CanDoTransfers, ';
                     }

                     if ($Details_->CanDoTransactions !== $CanDoTransactions) {
                            $this->CI->UsersData_Model->update_CanDoTransactions(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'CanDoTransactions' => $CanDoTransactions,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] CanDoTransactions settings to '.$CanDoTransactions.'.',
                            ));
                            $changes = $changes . 'CanDoTransactions, ';
                     }

                     if ($Details_->CanUseCard !== $CanUseCard) {
                            $this->CI->UsersData_Model->update_CanUseCard(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'CanUseCard' => $CanDoTransactions,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] CanUseCard settings to '.$CanUseCard.'.',
                            ));
                            $changes = $changes . 'CanUseCard, ';
                     }

                     if ($Details_->CanModifySettings !== $CanModifySettings) {
                            $this->CI->UsersData_Model->update_CanModifySettings(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'CanModifySettings' => $CanDoTransactions,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] CanModifySettings settings to '.$CanModifySettings.'.',
                            ));
                            $changes = $changes . 'CanModifySettings, ';
                     }

                     if ($Details_->IsTransactionAutoConfirm !== $IsTransactionAutoConfirm) {
                            $this->CI->UsersData_Model->update_IsTransactionAutoConfirm(array(
                                   'UsersAccount_Address' => $AccountAddress,
                                   'IsTransactionAutoConfirm' => $IsTransactionAutoConfirm,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated ['.$AccountAddress.'] IsTransactionAutoConfirm settings to '.$IsTransactionAutoConfirm.'.',
                            ));
                            $changes = $changes . 'IsTransactionAutoConfirm, ';
                     }

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => $changes];
       }



/* 
-- ---------------------
   VIEW USER ACCOUNT 
   - for admin accounting use
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
              $AccountBalance = $this->CI->Transactions_Model->calculate_total_balance(array(
                     'Account_Address' => $AccountAddress,
              ));
              $Account_ = $this->CI->UsersAccount_Model->read_by_address(array('Account_Address'=>$AccountAddress));
              $Details_ = $this->CI->UsersData_Model->read_by_address(array('Account_Address'=>$AccountAddress));
              $parameters = [
                     'Account'=> $Account_,
                     'Details'=> $Details_,
              ];
              return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => ''];
       }



/* 
-- ---------------------
   VIEW USER ACCOUNTS
   - for admin accounting use
-- ---------------------
*/  
       public function View_User_Accounts($Account,$requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim');
              $this->CI->form_validation->set_rules('SchoolPersonalId', 'SchoolPersonalId', 'trim');
              $this->CI->form_validation->set_rules('Name', 'Name', 'trim');
              $this->CI->form_validation->set_rules('Email', 'Email', 'trim');
              $this->CI->form_validation->set_rules('Status', 'Status', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $Campus_Id = $Account->Campus_Id;

              $AccountAddress = $this->CI->Functions_Model->sanitize($requestPostBody['AccountAddress']);
              $SchoolPersonalId = $this->CI->Functions_Model->sanitize($requestPostBody['SchoolPersonalId']);
              $Name = $this->CI->Functions_Model->sanitize($requestPostBody['Name']);
              $Email = $this->CI->Functions_Model->sanitize($requestPostBody['Email']);
              $Status = $this->CI->Functions_Model->sanitize($requestPostBody['Status']);

              $Accounts = $this->CI->UsersAccount_Model->read_all_with_view_columns(array(
                     'Campus_Id' => $Campus_Id,
                     'AccountAddress' => $AccountAddress,
                     'SchoolPersonalId' => $SchoolPersonalId,
                     'Name' => $Name,
                     'Email' => $Email,
                     'Status' => $Status
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $Accounts,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE USER PIN CODE
   - from admin use
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
                     'Task' => 'Updated [' . $AccountAddress .'] PIN Code.',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE WEB ACCOUNT PASSWORD
   - from admin use
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
                     'Task' => 'Updated [' . $AccountAddress . '] password.',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }


}