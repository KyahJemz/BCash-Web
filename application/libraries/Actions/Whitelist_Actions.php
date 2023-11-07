<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whitelist_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Functions_Model',
                     'Whitelist_Model'
              ]);
       }

       public function View_My_Whitelist($Account){
              $Whitelist = $this->CI->Whitelist_Model->read_by_address(array(
                     'AccountAddress' => $Account->UsersAccount_Address
              ));

              return ['Success' => True, 'Target' => null,'Parameters' => $Whitelist,'Response' => ''];
       }

       public function Add_To_Whitelist($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Id', 'Id', 'trim|required');
              $this->CI->form_validation->set_rules('PinCode', 'PinCode', 'trim|required|numeric|exact_length[6]');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $Id = $this->CI->Functions_Model->sanitize($requestPostBody['Id']);
              $PinCode = $this->CI->Functions_Model->sanitize($requestPostBody['PinCode']);

              if (!password_verify($PinCode, $Account->PinCode)){
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid PIN Code'];
              }

              $WhitelistData = $this->CI->UsersData_Model->read_by_SchoolPersonalId(array(
                     'SchoolPersonalId' => $Id,
              ));

              if (!empty($this->CI->Whitelist_Model->verify(array(
                     'AccountAddress' => $Account->UsersAccount_Address,
                     'WhitelistedAddress' => $WhitelistData->UsersAccount_Address
              )))){
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Record already exist!'];
              }

              $Created = $this->CI->Whitelist_Model->create(array(
                     'Account_Address' => $Account->UsersAccount_Address,
                     'Whitelisted_Address' => $WhitelistData->UsersAccount_Address
              ));

              if ($Created) {
                     return ['Success' => True, 'Target' => null,'Parameters' => null,'Response' => 'Successful Added!'];
              } else {
                     return ['Success' => False, 'Target' => null,'Parameters' => null,'Response' => 'Failed To Add!'];
              }
       }

       public function Remove_From_Whitelist($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Id', 'Id', 'trim|required');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $Id = $this->CI->Functions_Model->sanitize($requestPostBody['Id']);

              $Deleted = $this->CI->Whitelist_Model->delete_by_address(array(
                     'Account_Address' => $Account->UsersAccount_Address,
                     'Whitelisted_Address' => $Id
              ));

              if ($Deleted) {
                     return ['Success' => True, 'Target' => null,'Parameters' => null,'Response' => 'Successful Removed!'];
              } else {
                     return ['Success' => False, 'Target' => null,'Parameters' => null,'Response' => 'Failed To Remove!'];
              }
       }


}