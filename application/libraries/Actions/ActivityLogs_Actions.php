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
              ]);
       }


/* 
-- ---------------------
   VIEW MY ACTIVITY LOGS
   - all actors
-- ---------------------
*/  
       public function View_My_ActivityLogs($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('PageNumber', 'PageNumber', 'trim|required|number');
              $this->CI->form_validation->set_rules('ResultsPerPage', 'ResultsPerPage', 'trim|required|number');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $PageNumber = $this->CI->Functions_Model->sanitize($requestPostBody['PageNumber']);
              $ResultsPerPage = $this->CI->Functions_Model->sanitize($requestPostBody['ResultsPerPage']);

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $LoginHistory = $this->CI->ActivityLogs_Model->read_by_address(array(
                            'PageNumber' => $PageNumber,
                            'ResultsPerPage' => $ResultsPerPageResultsPerPage,
                            'Account_Address' => $Account->UsersAccount_Address,
                     ));
              } else if ($Account->ActorCategory_Id === '7') {
                     $LoginHistory = $this->CI->ActivityLogs_Model->read_by_address(array(
                            'PageNumber' => $PageNumber,
                            'ResultsPerPage' => $ResultsPerPageResultsPerPage,
                            'Account_Address' => $Account->GuardianAccount_Address,
                     ));
              } else {
                     $LoginHistory = $this->CI->ActivityLogs_Model->read_by_address(array(
                            'PageNumber' => $PageNumber,
                            'ResultsPerPage' => $ResultsPerPageResultsPerPage,
                            'Account_Address' => $Account->WebAccounts_Address,
                     ));
              }
            return ['Success' => True,'Target' => null,'Parameters' => $LoginHistory,'Response' => ''];
       }



/* 
-- ---------------------
   VIEW ALL ACTIVITY LOGS
   - all actors
-- ---------------------
*/  
       public function View_All_ActivityLogs($Account) {

              if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                     $LoginHistory = $this->CI->LoginHistory->read_by_address($Account->UsersAccount_Address);
              } else if ($Account->ActorCategory_Id === '7') {
                     $LoginHistory = $this->CI->LoginHistory->read_by_address($Account->GuardianAccount_Address);
              } else {
                     $LoginHistory = $this->CI->LoginHistory->read_by_address($Account->WebAccounts_Address);
              }
            return ['Success' => True,'Target' => null,'Parameters' => $LoginHistory,'Response' => ''];
       }

}