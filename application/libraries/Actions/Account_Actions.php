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

              ]);
       }

/* 
-- ---------------------
   VIEW MY ACCOUNT DETAILS
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
   UPDATE USER DETAILS 
-- ---------------------
*/  

       public function Update_User_Account($Account, $requestPostBody) {


       }


/*
-- ---------------------
   UPDATE MY PIN CODE
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
              } else if ($Account->ActorCategory_Id === '7') {
                     $this->CI->UsersAccount_Model->update_pin($Account->GuardianAccount_Address, $NewPinCode2);
              } else {
                     $this->CI->UsersAccount_Model->update_pin($Account->WebAccounts_Address, $NewPinCode2);
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }



/*
-- ---------------------
   UPDATE MY PASSWORD
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

              $this->CI->WebAccounts_Model->update_password($Account->WebAccounts_Address, $NewPassword2)

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }





}