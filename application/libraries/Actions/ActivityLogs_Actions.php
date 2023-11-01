<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActivityLogs_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'ActivityLogs_Model',
                     'Merchants_Model',
                     'WebAccounts_Model',
              ]);
       }


/* 
-- ---------------------
   VIEW MY ACTIVITY LOGS
   - all actors
-- ---------------------
*/  
       public function View_My_ActivityLogs($Account) {

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $LoginHistory = $this->CI->ActivityLogs_Model->read_by_address(array(
                            'Account_Address' => $Account->UsersAccount_Address,
                     ));
              } else if ($Account->ActorCategory_Id === '7') {
                     $LoginHistory = $this->CI->ActivityLogs_Model->read_by_address(array(
                            'Account_Address' => $Account->GuardianAccount_Address,
                     ));
              } else {
                     $LoginHistory = $this->CI->ActivityLogs_Model->read_by_address(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                     ));
              }
            return ['Success' => True,'Target' => null,'Parameters' => $LoginHistory,'Response' => ''];
       }



/* 
-- ---------------------
   VIEW MY MERCHANT ACTIVITY LOGS
   - merchant admin
-- ---------------------
*/  
       public function View_My_Merchant_ActivityLogs($Account){

              $Merchants = $this->CI->Merchants_Model->read_merchants_by_category(array(
                     'Account_Address' => $Account->WebAccounts_Address,
              ));

              $accountAddresses = array(); 

              foreach ($Merchants as $merchant) {
                     $accountAddresses[] = $merchant->WebAccounts_Address;
              }

              $ActivityHistory = $this->CI->ActivityLogs_Model->read_by_address_bulk(array(
                     'Account_Address' => $accountAddresses,
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $ActivityHistory,'Response' => ''];
       }


/* 
-- ---------------------
   VIEW ALL ACTIVITY LOGS
   - all actors
-- ---------------------
*/  
       public function View_All_ActivityLogs($Account) {

              $ActivityHistory = $this->CI->ActivityLogs_Model->read_all();
           
              return ['Success' => True,'Target' => null,'Parameters' => $ActivityHistory,'Response' => ''];
       }



       public function View_All_Administrators_ActivityLogs($Account){

              $Administrators = $this->CI->WebAccounts_Model->read_administrartor_by_campusid(array(
                     'Campus_Id' => $Account->Campus_Id,
              ));

              $administratorAddresses = array(); 

              foreach ($Administrators as $Accounts) {
                     $administratorAddresses[] = $Accounts->WebAccounts_Address;
              }

              $ActivityHistory = $this->CI->ActivityLogs_Model->read_by_address_bulk(array(
                     'Account_Address' => $administratorAddresses,
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $ActivityHistory,'Response' => ''];
       }


       public function View_All_Accountings_ActivityLogs($Account){

              $Accountings = $this->CI->WebAccounts_Model->read_accounting_by_campusid(array(
                     'Campus_Id' => $Account->Campus_Id,
              ));

              $accountAddresses = array(); 

              foreach ($Accountings as $Accounts) {
                     $accountAddresses[] = $Accounts->WebAccounts_Address;
              }

              $ActivityHistory = $this->CI->ActivityLogs_Model->read_by_address_bulk(array(
                     'Account_Address' => $accountAddresses,
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $ActivityHistory,'Response' => ''];
       }

}