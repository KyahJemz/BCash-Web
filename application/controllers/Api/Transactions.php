<?php

class Transactions extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->model([
                        'Functions_Model',
                        'WebAccounts_Model',
                        'UsersAccount_Model',
                        'GuardianAccount_Model',
                        'Authentications_Model',
                        'Configurations_Model' ,
                        'Transactions_Model' ,
                        'ActorCategory_Model'
                ]);
                $this->load->helper('string');
                $this->load->library(['form_validation']);
                $this->load->database();
        }

        public function History() {

                $AuthorizationTokenHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Authorization', TRUE));
                $AccountAddressHeader = $this->Functions_Model->sanitize($this->input->get_request_header('AccountAddress', TRUE));
                $ClientVersionHeader = $this->Functions_Model->sanitize($this->input->get_request_header('ClientVersion', TRUE));
                $IpAddressHeader = $this->Functions_Model->sanitize($this->input->get_request_header('IpAddress', TRUE));
                $DeviceHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Device', TRUE));
                $LocationHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Location', TRUE));

                $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
                $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

                if(empty($AuthorizationTokenHeader)||empty($AccountAddressHeader)||empty($ClientVersionHeader)||empty($IpAddressHeader)||empty($DeviceHeader)||empty($LocationHeader)||empty($IntentHeader)) {
                        $response = [
                                'Success' => FALSE,
                                'response' => 'Invalsid Request'
                        ]; 
                } else {
                        $validated = $this->Functions_Model->validateRequest($AccountAddressHeader, $AuthorizationTokenHeader, $IpAddressHeader, $DeviceHeader, $LocationHeader, $ClientVersionHeader);
                        if ($validated['success']) {

                                $this->form_validation->set_data($requestPostBody);

                                $this->form_validation->set_rules('TargetActor', 'TargetActor', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('Startdate', 'Startdate', 'trim');
                                $this->form_validation->set_rules('EndDate', 'EndDate', 'trim');
                                $this->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('SearchName', 'SearchName', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('StatusFilter', 'StatusFilter', 'trim|alpha_numeric');

                                $validatedTargetCategory = $requestPostBody['TargetActor']; 
                                $validatedStartdate = $requestPostBody['Startdate'];
                                $validatedEndDate = $requestPostBody['EndDate'];
                                $validatedTransactionAddress = $requestPostBody['TransactionAddress']; 
                                $validatedSearchName = $requestPostBody['SearchName']; 
                                $validatedStatusFilter = $requestPostBody['StatusFilter']; 

                                if ($this->form_validation->run() === FALSE) {
                                        $validationErrors = validation_errors();
                                        $response = [
                                                'Success' => FALSE,
                                                'Target' => null,
                                                'Parameters' => null,
                                                'Message' => 'Failed, Reason: '. $validationErrors .'.'
                                        ];
                                } else {
                                        $Account = $this->functions_Model->getAccountsByAddress($AccountAddressHeader);

                                        if ($Account->ActorCategory_Id === '1') {
                                                $result = $this->Transactions_Model->read_transactions_by_category($validatedTargetCategory, '', ,$validatedStartdate,$validatedEndDate,$validatedTransactionAddress,$validatedSearchName,$validatedStatusFilter);
                                        
                                        } else if ($Account->ActorCategory_Id === '2'){
                                                $result = $this->Transactions_Model->read_transactions_by_category($validatedTargetCategory, '',$validatedStartdate,$validatedEndDate,$validatedTransactionAddress,$validatedSearchName,$validatedStatusFilter);
                                        
                                        } else if ($Account->ActorCategory_Id === '3' || $Account->ActorCategory_Id === '4') {
                                                //get merchant category id                                            HERE vv
                                                $result = $this->Transactions_Model->read_transactions_by_category($validatedTargetCategory, 'id here',$validatedStartdate,$validatedEndDate,$validatedTransactionAddress,$validatedSearchName,$validatedStatusFilter);
                                        
                                        } else if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '7') {
                                                $result = $this->Transactions_Model->read_transactions_by_category($validatedTargetCategory,$Account->UsersAccount_Address,$validatedStartdate,$validatedEndDate,$validatedTransactionAddress,$validatedSearchName,$validatedStatusFilter);
                                        
                                        } else if ($Account->ActorCategory_Id === '6'){
                                                $result = $this->Transactions_Model->read_transactions_by_category($validatedTargetCategory,$Account->UsersAccount_Address,$validatedStartdate,$validatedEndDate,$validatedTransactionAddress,$validatedSearchName,$validatedStatusFilter);
                                                $response = [
                                                        'Success' => $result['success'],
                                                        'response' => $result
                                                ]; 
                                        } else {
                                                $response = [
                                                        'Success' => FALSE,
                                                        'response' => 'Invalid Request'
                                                ]; 
                                        }
                                } 
                        }
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }









        public function Transactions() {

                $AuthorizationTokenHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Authorization', TRUE));
                $AccountAddressHeader = $this->Functions_Model->sanitize($this->input->get_request_header('AccountAddress', TRUE));
                $ClientVersionHeader = $this->Functions_Model->sanitize($this->input->get_request_header('ClientVersion', TRUE));
                $IpAddressHeader = $this->Functions_Model->sanitize($this->input->get_request_header('IpAddress', TRUE));
                $DeviceHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Device', TRUE));
                $LocationHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Location', TRUE));
                $IntentHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Intent', TRUE));

                $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
                $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

                if(empty($AuthorizationTokenHeader)||empty($AccountAddressHeader)||empty($ClientVersionHeader)||empty($IpAddressHeader)||empty($DeviceHeader)||empty($LocationHeader)||empty($IntentHeader)) {
                        $response = [
                                'Success' => FALSE,
                                'response' => 'Invalid Request'
                        ]; 
                } else {
                        $validated = $this->Functions_Model->validateRequest($AccountAddressHeader, $AuthorizationTokenHeader, $IpAddressHeader, $DeviceHeader, $LocationHeader, $ClientVersionHeader);
                        if ($validated['success']) {

                                $this->form_validation->set_data($requestPostBody);

                                $this->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|alpha_numeric');

                                $this->form_validation->set_rules('TargetActor', 'TargetActor', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('Startdate', 'Startdate', 'trim');
                                $this->form_validation->set_rules('EndDate', 'EndDate', 'trim');
                                $this->form_validation->set_rules('TransactionAddress', 'TransactionAddress', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('SearchName', 'SearchName', 'trim|alpha_numeric');
                                $this->form_validation->set_rules('StatusFilter', 'StatusFilter', 'trim|alpha_numeric');

                                $validatedTransactionAddress = $requestPostBody['TransactionAddress']; // target  tranaction
                                $validatedAccountAddress = $requestPostBody['TransactionAddress']; // target account

                                $validatedTargetCategory = $requestPostBody['TargetActor']; 
                                $validatedStartdate = $requestPostBody['Startdate'];
                                $validatedEndDate = $requestPostBody['EndDate'];
                                $validatedTransactionAddress = $requestPostBody['TransactionAddress']; 
                                $validatedSearchName = $requestPostBody['SearchName']; 
                                $validatedStatusFilter = $requestPostBody['StatusFilter']; 


                                if ($this->form_validation->run() === FALSE) {
                                        $validationErrors = validation_errors();
                                        $response = [
                                                'Success' => FALSE,
                                                'Target' => null,
                                                'Parameters' => null,
                                                'Message' => 'Failed, Reason: '. $validationErrors .'.'
                                        ];
                                } else {
                                
                                        switch ($IntentHeader) {
                                                
                                                // DEBIT - CREDIT
                                                case 'getTransactions': 
                                                        $Account = $this->functions_Model->getAccountsByAddress($AccountAddressHeader);

                                                        // ACCOUNTING
                                                        if ($Account['ActorCategory_Id'] === '2') { 
                                                                if (empty($validatedAccountAddress)) {
                                                                        $result = $this->Transactions_Model->read_transactions_by_address($AccountAddressHeader);
                                                                        $response = [
                                                                                'Success' => TRUE,
                                                                                'response' => $result['response']
                                                                        ]; 
                                                                } else {
                                                                        $result = $this->Transactions_Model->read_transactions_by_address($validatedAccountAddress);
                                                                        $response = [
                                                                                'Success' => TRUE,
                                                                                'response' => $result['response']
                                                                        ]; 
                                                                }

                                                        // MERCHANT ADMIN
                                                        } else if ($Account['ActorCategory_Id'] === '3') {
                                                                $result = $this->Transactions_Model->read_transactions_by_address($Account->WebAccounts_Address);
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'response' => $result['response']
                                                                ];
                              
                                                        // USERS, GUEST
                                                        } else if ($Account['ActorCategory_Id'] === '5' || $Account['ActorCategory_Id'] === '7') {
                                                                $result = $this->Transactions_Model->read_transactions_by_address($Account->UsersAccount_Address);
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'response' => $result['response']
                                                                ]; 
                                                        
                                                        // PARENTS
                                                        } else if ($Account['ActorCategory_Id'] === '6') {
                                                                $result = $this->Transactions_Model->read_transactions_by_address($Account->UsersAccount_Address);
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'response' => $result['response']
                                                                ]; 

                                                        // MERCHANT STAFF, ADMINISTRATOR
                                                        } else {
                                                                $response = [
                                                                        'Success' => FALSE,
                                                                        'response' => []
                                                                ]; 
                                                        }
                                                        
                                                        break;

                                                // TRANSACTION FULL DETAILS
                                                case 'getUsersTransactionInfos':
                                                        $Account = $this->functions_Model->getAccountsByAddress($AccountAddressHeader);


























                                                        // if (empty($validatedTargetCategory)) {
                                                        //         if ($Account['ActorCategory_Id'] === '1') {



                                                        //         } else if ($Account['ActorCategory_Id'] === '2') {



                                                        //         }
                                                        // } else if ($validatedTargetCategory === '2') {

                                                        //         // ADMINISTRATOR, ACCOUNTING
                                                        //         if ($Account['ActorCategory_Id'] === '1' || $Account['ActorCategory_Id'] === '2') {
                                                        //                 $result = $this->Transactions_Model->read_transactionsinfo_of_accounting();
                                                        //                 $response = [
                                                        //                         'Success' => TRUE,
                                                        //                         'response' => $result['response']
                                                        //                 ]; 

                                                        //         // OTHER USERS
                                                        //         } else {
                                                        //                 $response = [
                                                        //                         'Success' => FALSE,
                                                        //                         'response' => []
                                                        //                 ]; 
                                                        //         }
                                                        // } else if ($validatedTargetCategory === '3') {

                                                        //         // ADMINISTRATOR, ACCOUNTING
                                                        //         if ($Account['ActorCategory_Id'] === '1' || $Account['ActorCategory_Id'] === '2') {
                                                        //                 $result = $this->Transactions_Model->read_transactionsinfo_of_merchants();
                                                        //                 $response = [
                                                        //                         'Success' => TRUE,
                                                        //                         'response' => $result['response']
                                                        //                 ]; 

                                                        //         // OTHER USERS
                                                        //         } else {
                                                        //                 $response = [
                                                        //                         'Success' => FALSE,
                                                        //                         'response' => []
                                                        //                 ]; 
                                                        //         }
                                                        // }

                                                        
                                                        break;


                                                case 'getTransactionItems': // items na laman nung transactin info
                                                        $result = $this->Transactions_Model->read_transactionitems_by_transaction_address($validatedNTransactionAddress);
                                                        $response = [
                                                                'Success' => TRUE,
                                                                'response' => $$result['response']
                                                        ]; 
                                                        break;


                                                default:
                                                        $response = [
                                                                'Success' => FALSE,
                                                                'response' => 'Invalid Intent'
                                                        ]; 
                                                        break;
                                        }
                                }
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'response' => $validated['response']
                                ]; 
                        }
                }

                // Return the response as JSON 
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }










}
