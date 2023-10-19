<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cards_Actions {

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
                     'Card_Model',
              ]);
       }


/* 
-- ---------------------
   VIEW MY ACTIVITY LOGS
   - all actors
-- ---------------------
*/  
       public function View_Cards($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Card_Address', 'Card_Address', 'trim');
              $this->CI->form_validation->set_rules('Account_Address', 'Account_Address', 'trim');
              $this->CI->form_validation->set_rules('Status', 'Status', 'trim|required');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $Card_Address = $this->CI->Functions_Model->sanitize($requestPostBody['Card_Address']);
              $Account_Address = $this->CI->Functions_Model->sanitize($requestPostBody['Account_Address']);
              $Status = $this->CI->Functions_Model->sanitize($requestPostBody['Status']);
              if (!empty($Status)) {
                     if ($Status === 'Active Cards') {
                            $Status = '1';
                     } else if ($Status === 'Inactive Cards') {
                            $Status = '0';
                     } else if ($Status === 'All') {
                            $Status = 'All';
                     } else {
                            return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid Status'];
                     }
              }
              $Campus_Id = $Account->Campus_Id;

              $Cards = $this->CI->Card_Model->read(array(
                     'Card_Address' => $Card_Address,
                     'Account_Address' => $Account_Address,
                     'Status' => $Status,
                     'Campus_Id' => $Campus_Id,
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $Cards,'Response' => ''];
       }

       public function Update_Card($Account,$requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Card_Address', 'Card_Address', 'trim|required');
              $this->CI->form_validation->set_rules('UsersAccount_Address', 'UsersAccount_Address', 'trim|max_length[15]');
              $this->CI->form_validation->set_rules('Notes', 'Notes', 'trim|max_length[255]');
              $this->CI->form_validation->set_rules('IsActive', 'IsActive', 'trim|required|max_length[1]');
              $this->CI->form_validation->set_rules('PinCode', 'PinCode', 'trim|required|max_length[6]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $Card_Address = $this->CI->Functions_Model->sanitize($requestPostBody['Card_Address']);
              $UsersAccount_Address = $this->CI->Functions_Model->sanitize($requestPostBody['UsersAccount_Address'] ?? null);
              $Notes = $this->CI->Functions_Model->sanitize($requestPostBody['Notes'] ?? null);
              $IsActive = $this->CI->Functions_Model->sanitize($requestPostBody['IsActive']);
              $PinCode = $this->CI->Functions_Model->sanitize($requestPostBody['PinCode']);

              if (!password_verify($PinCode, $Account->PinCode)){
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Wrong PIN code'];
              }

              $Card = $this->CI->Card_Model->read_by_CardAddress(array(
                     'Card_Address' => $Card_Address
              ));
              if (empty($Card)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid Card Address!'];
              }

              $changes = 'Changes: ';

              $this->CI->db->trans_start(); 

                     if (!empty($UsersAccount_Address) && $Card->UsersAccount_Address !== $UsersAccount_Address) {
                            $this->CI->Card_Model->update_UsersAccountAddress(array(
                                   'Card_Address' => $Card_Address,
                                   'UsersAccount_Address' => $UsersAccount_Address,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated UsersAccount_Address of ['.$Card_Address.'] to ['.$UsersAccount_Address.'].',
                            ));
                            $changes = $changes . 'UsersAccount_Address, ';
                     }

                     if (!empty($Notes) && $Card->Notes !== $Notes) {
                            $this->CI->Card_Model->update_Notes(array(
                                   'Card_Address' => $Card_Address,
                                   'Notes' => $Notes,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Notes of ['.$Card_Address.'] to ['.$Notes.'].',
                            ));
                            $changes = $changes . 'Notes, ';
                     }

                     if ($Card->IsActive !== $IsActive) {
                            $this->CI->Card_Model->update_IsActive(array(
                                   'Card_Address' => $Card_Address,
                                   'IsActive' => (int)$IsActive,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated IsActive of ['.$Card_Address.'] to ['.$IsActive.'].',
                            ));
                            $changes = $changes . 'IsActive, ';
                     }

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              if ($changes === 'Changes: ') {
                     $changes = 'No Changes';
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => $changes];
       }



       public function Add_Card($Account, $requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Card_Address', 'Card_Address', 'trim|required|max_length[15]');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $Card_Address = $this->CI->Functions_Model->sanitize($requestPostBody['Card_Address']);
              $Campus_Id = $Account->Campus_Id;

              $this->CI->db->trans_start(); 

                     $this->CI->Card_Model->create(array(
                            'Card_Address' => $Card_Address,
                            'Campus_Id' => $Campus_Id,
                            'UsersAccount_Address' => null,
                            'IsActive' => '1',
                            'Notes' => null,
                     ));

                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Task' => 'Uploaded a new card ['.$Card_Address.'].',
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => '','Response' => 'Card successfully added!'];
       }

       public function Activate_Card($Account) {

              $Cards = $this->CI->Card_Model->read();
             
              return ['Success' => True,'Target' => null,'Parameters' => '','Response' => ''];
       }

}