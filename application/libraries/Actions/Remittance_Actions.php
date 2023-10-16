<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Remittance_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Remittance_Model',
                     'ActivityLogs_Model',
              ]);
       }

/* 
-- ---------------------
   VIEW REMITTANCE DETAILS
   - accounting & merchants
-- ---------------------
*/ 
public function View_Remittance_Details ($Account, $requestPostBody) {

       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('Remittance_Id', 'TransactionAddress', 'trim|required|numeric');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $Remittance_Id = $this->CI->Functions_Model->sanitize($requestPostBody['Remittance_Id']);

       $Remittance = $this->CI->Remittance_Model->read_row_by_id(array(
              'Remittance_Id' => $Remittance_Id,
       ));

       if ($Remittance && $Account->ActorCategory_Id === '2') {
              return ['Success' => True,'Target' => null,'Parameters' => $Remittance,'Response' => ''];
       } else if ($Remittance && $Account->ActorCategory_Id === '3') {
              if ($Account->WebAccounts_Address === $Remittance['Remittance']->Submitted_By ) {
                     return ['Success' => True,'Target' => null,'Parameters' => $Remittance,'Response' => ''];
              } else {
                     return ['Success' => False,'Target' => null,'Parameters' => $Remittance,'Response' => 'You are not authorized to view this content.'];
              }
       } else {
              return ['Success' => True,'Target' => null,'Parameters' => [],'Response' => ''];
       }   
}



/* 
-- ---------------------
   VIEW ALL REMITTANCE
   - accounting
-- ---------------------
*/  
public function View_All_Remittance() {

       $RemittanceList = $this->CI->Remittance_Model->read_all();

       return ['Success' => True,'Target' => null,'Parameters' => $RemittanceList,'Response' => ''];
}


/* 
-- ---------------------
   UPDATE REMITTANCE REJECT
   - accounting
-- ---------------------
*/ 
public function Update_Remittance_Reject($Account, $requestPostBody) {
       
       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('Remittance_Id', 'Remittance_Id', 'trim|required|numeric');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $Remittance_Id = $this->CI->Functions_Model->sanitize($requestPostBody['Remittance_Id']);

       $this->CI->db->trans_start(); 

              $this->CI->Remittance_Model->update_date_rejected(array(
                     'Remittance_Id' => $Remittance_Id,
              ));
              
       $this->CI->db->trans_complete(); 

       if ($this->CI->db->trans_status() === FALSE) {
              $this->CI->db->trans_rollback();
              $error = $this->CI->db->error();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
       }

       $this->CI->ActivityLogs_Model->create(array(
              'Account_Address' => $Account->WebAccounts_Address,
              'Task' => '[' . $Account->WebAccounts_Address . '] Rejected remittance id ['. $Remittance_Id .'].',
       ));

       $parameters = $this->CI->Remittance_Model->read_all();

       return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => 'Remittance update status to rejected!'];
}



/* 
-- ---------------------
   UPDATE REMITTANCE APPROVE
   - accounting
-- ---------------------
*/ 
public function Update_Remittance_Approve($Account, $requestPostBody) {
       
       $this->CI->form_validation->set_data($requestPostBody);

       $this->CI->form_validation->set_rules('Remittance_Id', 'Remittance_Id', 'trim|required|numeric');

       if ($this->CI->form_validation->run() === FALSE) {
              $validationErrors = validation_errors();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
       }

       $Remittance_Id = $this->CI->Functions_Model->sanitize($requestPostBody['Remittance_Id']);

       $this->CI->db->trans_start(); 

              $this->CI->Remittance_Model->update_date_approved(array(
                     'Remittance_Id' => $Remittance_Id,
              ));
              
       $this->CI->db->trans_complete(); 

       if ($this->CI->db->trans_status() === FALSE) {
              $this->CI->db->trans_rollback();
              $error = $this->CI->db->error();
              return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
       }

       $this->CI->ActivityLogs_Model->create(array(
              'Account_Address' => $Account->WebAccounts_Address,
              'Task' => '[' . $Account->WebAccounts_Address . '] Approved remittance id ['. $Remittance_Id .'].',
       ));

       $parameters = $this->CI->Remittance_Model->read_all();

       return ['Success' => True,'Target' => null,'Parameters' => $parameters,'Response' => 'Remittance update status to approved!'];
}



/* 
-- ---------------------
   CREATE REMITTANCE
   - merchantadmin
-- ---------------------
*/ 
      


}