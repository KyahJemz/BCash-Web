<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuration_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Configurations_Model',
              ]);
       }

       public function View_Configurations() {
              
              $Configurations = $this->CI->Configurations_Model->Read();
              
              return ['Success' => True,'Target' => null,'Parameters' => $Configurations,'Response' => ''];
       }

       public function Update_Configurations($Account,$requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('PinCode', 'PinCode', 'trim|required|numeric|exact_length[6]'); // to validate changes 

              $this->CI->form_validation->set_rules('IsMaintenance', 'IsMaintenance', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('Transactions', 'Transactions', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('Transfers', 'Transfers', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('CashIn', 'CashIn', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('AndroidAppVersion', 'AndroidAppVersion', 'trim|required');
              $this->CI->form_validation->set_rules('WebAppVersion', 'WebAppVersion', 'trim|required');
              $this->CI->form_validation->set_rules('Accounting', 'Accounting', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('MerchantAdmin', 'MerchantAdmin', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('MerchantStaff', 'MerchantStaff', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('User', 'User', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('Guest', 'Guest', 'trim|required|exact_length[1]');
              $this->CI->form_validation->set_rules('Guardian', 'Guardian', 'trim|required|exact_length[1]');

              $this->CI->form_validation->set_rules('IsMaintenanceDescription', 'IsMaintenanceDescription', 'trim');
              $this->CI->form_validation->set_rules('TransactionsDescription', 'TransactionsDescription', 'trim');
              $this->CI->form_validation->set_rules('TransfersDescription', 'TransfersDescription', 'trim');
              $this->CI->form_validation->set_rules('CashInDescription', 'CashInDescription', 'trim');
              $this->CI->form_validation->set_rules('AndroidAppVersionDescription', 'AndroidAppVersionDescription', 'trim');
              $this->CI->form_validation->set_rules('WebAppVersionDescription', 'WebAppVersionDescription', 'trim');
              $this->CI->form_validation->set_rules('AccountingDescription', 'AccountingDescription', 'trim');
              $this->CI->form_validation->set_rules('MerchantAdminDescription', 'MerchantAdminDescription', 'trim');
              $this->CI->form_validation->set_rules('MerchantStaffDescription', 'MerchantStaffDescription', 'trim');
              $this->CI->form_validation->set_rules('UserDescription', 'UserDescription', 'trim');
              $this->CI->form_validation->set_rules('GuestDescription', 'GuestDescription', 'trim');
              $this->CI->form_validation->set_rules('GuardianDescription', 'GuardianDescription', 'trim');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }
       
              $PinCode = $this->CI->Functions_Model->sanitize($requestPostBody['PinCode']);

              $IsMaintenance = $this->CI->Functions_Model->sanitize($requestPostBody['IsMaintenance']);
              $IsMaintenanceDescription = $this->CI->Functions_Model->sanitize($requestPostBody['IsMaintenanceDescription']);

              $Transactions = $this->CI->Functions_Model->sanitize($requestPostBody['Transactions']);
              $TransactionsDescription = $this->CI->Functions_Model->sanitize($requestPostBody['TransactionsDescription']);

              $Transfers = $this->CI->Functions_Model->sanitize($requestPostBody['Transfers']);
              $TransfersDescription = $this->CI->Functions_Model->sanitize($requestPostBody['TransfersDescription']);
              
              $CashIn = $this->CI->Functions_Model->sanitize($requestPostBody['CashIn']);
              $CashInDescription = $this->CI->Functions_Model->sanitize($requestPostBody['CashInDescription']);

              $AndroidAppVersion = $this->CI->Functions_Model->sanitize($requestPostBody['AndroidAppVersion']);
              $AndroidAppVersionDescription = $this->CI->Functions_Model->sanitize($requestPostBody['AndroidAppVersionDescription']);

              $WebAppVersion = $this->CI->Functions_Model->sanitize($requestPostBody['WebAppVersion']);
              $WebAppVersionDescription = $this->CI->Functions_Model->sanitize($requestPostBody['WebAppVersionDescription']);

              $Accounting = $this->CI->Functions_Model->sanitize($requestPostBody['Accounting']);
              $AccountingDescription = $this->CI->Functions_Model->sanitize($requestPostBody['AccountingDescription']);

              $MerchantAdmin = $this->CI->Functions_Model->sanitize($requestPostBody['MerchantAdmin']);
              $MerchantAdminDescription = $this->CI->Functions_Model->sanitize($requestPostBody['MerchantAdminDescription']);

              $MerchantStaff = $this->CI->Functions_Model->sanitize($requestPostBody['MerchantStaff']);
              $MerchantStaffDescription = $this->CI->Functions_Model->sanitize($requestPostBody['MerchantStaffDescription']);

              $User = $this->CI->Functions_Model->sanitize($requestPostBody['User']);
              $UserDescription = $this->CI->Functions_Model->sanitize($requestPostBody['UserDescription']);

              $Guest = $this->CI->Functions_Model->sanitize($requestPostBody['Guest']);
              $GuestDescription = $this->CI->Functions_Model->sanitize($requestPostBody['GuestDescription']);

              $Guardian = $this->CI->Functions_Model->sanitize($requestPostBody['Guardian']);
              $GuardianDescription = $this->CI->Functions_Model->sanitize($requestPostBody['GuardianDescription']);

              if (!password_verify($PinCode, $Account->PinCode)){
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Incorrect PIN Code'];
              }

              $Changes = "Changes: ";

              $this->CI->db->trans_start(); 

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'IsMaintenance',
                            'Value' => $IsMaintenance,
                            'Description' => $IsMaintenanceDescription,
                     ))) {
                            $Changes = $Changes . ' IsMaintenance,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [IsMaintenance].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'Transactions',
                            'Value' => $Transactions,
                            'Description' => $TransactionsDescription,
                     ))) {
                            $Changes = $Changes . ' Transactions,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [Transactions].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'Transfers',
                            'Value' => $Transfers,
                            'Description' => $TransfersDescription,
                     ))) {
                            $Changes = $Changes . ' Transfers,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [Transfers].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'CashIn',
                            'Value' => $CashIn,
                            'Description' => $CashInDescription,
                     ))) {
                            $Changes = $Changes . ' CashIn,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [CashIn].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'AndroidAppVersion',
                            'Value' => $AndroidAppVersion,
                            'Description' => $AndroidAppVersionDescription,
                     ))) {
                            $Changes = $Changes . ' AndroidAppVersion,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [AndroidAppVersion].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'WebAppVersion',
                            'Value' => $WebAppVersion,
                            'Description' => $WebAppVersionDescription,
                     ))) {
                            $Changes = $Changes . ' WebAppVersion,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [WebAppVersion].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'Accounting',
                            'Value' => $Accounting,
                            'Description' => $AccountingDescription,
                     ))) {
                            $Changes = $Changes . ' Accounting,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [Accounting].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'MerchantAdmin',
                            'Value' => $MerchantAdmin,
                            'Description' => $MerchantAdminDescription,
                     ))) {
                            $Changes = $Changes . ' MerchantAdmin,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [MerchantAdmin].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'MerchantStaff',
                            'Value' => $MerchantStaff,
                            'Description' => $MerchantStaffDescription,
                     ))) {
                            $Changes = $Changes . ' MerchantStaff,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [MerchantStaff].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'User',
                            'Value' => $User,
                            'Description' => $UserDescription,
                     ))) {
                            $Changes = $Changes . ' User,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [User].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'Guest',
                            'Value' => $Guest,
                            'Description' => $GuestDescription,
                     ))) {
                            $Changes = $Changes . ' Guest,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [Guest].',
                            ));
                     }

                     if ($this->CI->Configurations_Model->Update(array(
                            'Title' => 'Guardian',
                            'Value' => $Guardian,
                            'Description' => $GuardianDescription,
                     ))) {
                            $Changes = $Changes . ' Guardian,';
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Task' => 'Updated Configuration [Guardian].',
                            ));
                     }

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              if ($Changes === "Changes: "){
                     $Changes = "No Changes.";
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => $Changes];
       
       }
}