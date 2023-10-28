<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginHistory_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'LoginHistory_Model',
                     'ActivityLogs_Model',
              ]);
       }


/* 
-- ---------------------
   VIEW MY LOGIN HISTORY
   - all actors
-- ---------------------
*/  
       public function View_My_LoginHistory($Account) {

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $LoginHistory = $this->CI->LoginHistory_Model->read_by_address($Account->UsersAccount_Address);
              } else if ($Account->ActorCategory_Id === '7') {
                     $LoginHistory = $this->CI->LoginHistory_Model->read_by_address($Account->GuardianAccount_Address);
              } else {
                     $LoginHistory = $this->CI->LoginHistory_Model->read_by_address($Account->WebAccounts_Address);
              }
            return ['Success' => True,'Target' => null,'Parameters' => $LoginHistory,'Response' => ''];
       }


/* 
-- ---------------------
   DELETE ONE MY LOGIN HISTORY
   - all actors
-- ---------------------
*/ 
       public function Clear_One_My_LoginHistory($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required');
              $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
              $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $IpAddress = $this->CI->Functions_Model->sanitize($requestPostBody['IpAddress']);
              $Device = $this->CI->Functions_Model->sanitize($requestPostBody['Device']);
              $Location = $this->CI->Functions_Model->sanitize($requestPostBody['Location']);

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $LoginHistory = $this->CI->LoginHistory_Model->delete_specific($Account->UsersAccount_Address, $IpAddress, $Device, $Location);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->UsersAccount_Address,
                            'Target_Account_Address' => $Account->UsersAccount_Address,
                            'Action' => 'Delete',
                            'Task' => 'Deleted ['.$IpAddress.'|'.$Device.'|'.$Location.'] from login history.',
                     ));
              } else if ($Account->ActorCategory_Id === '7') {
                     $LoginHistory = $this->CI->LoginHistory_Model->delete_specific($Account->GuardianAccount_Address, $IpAddress, $Device, $Location);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->GuardianAccount_Address,
                            'Target_Account_Address' => $Account->GuardianAccount_Address,
                            'Action' => 'Delete',
                            'Task' => 'Deleted ['.$IpAddress.'|'.$Device.'|'.$Location.'] from login history.',
                     ));
              } else {
                     $LoginHistory = $this->CI->LoginHistory_Model->delete_specific($Account->WebAccounts_Address, $IpAddress, $Device, $Location);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Target_Account_Address' => $Account->WebAccounts_Address,
                            'Action' => 'Delete',
                            'Task' => 'Deleted ['.$IpAddress.'|'.$Device.'|'.$Location.'] from login history.',
                     ));
              }
              
              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Removed '.$IpAddress.' | '.$Device.' | '.$Location];
       }



/* 
-- ---------------------
   DELETE ALL MY LOGIN HISTORY
   - all actors
-- ---------------------
*/ 
       public function Clear_All_My_LoginHistory($Account) {

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $LoginHistory = $this->CI->LoginHistory_Model->delete($Account->UsersAccount_Address);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->UsersAccount_Address,
                            'Target_Account_Address' => $Account->UsersAccount_Address,
                            'Action' => 'Delete',
                            'Task' => 'Cleared login history.',
                     ));
              } else if ($Account->ActorCategory_Id === '7') {
                     $LoginHistory = $this->CI->LoginHistory_Model->delete($Account->GuardianAccount_Address);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->GuardianAccount_Address,
                            'Target_Account_Address' => $Account->GuardianAccount_Address,
                            'Action' => 'Delete',
                            'Task' => 'Cleared login history.',
                     ));
              } else {
                     $LoginHistory = $this->CI->LoginHistory_Model->delete($Account->WebAccounts_Address);
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Target_Account_Address' => $Account->WebAccounts_Address,
                            'Action' => 'Delete',
                            'Task' => 'Cleared login history.',
                     ));
              }
              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => ''];
       }
}