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
                                $this->form_validation->set_rules('TargetAccountAddress', 'TargetAccountAddress', 'trim|alpha_numeric');

                                $validatedNTransactionAddress = $requestPostBody['TransactionAddress'];
                                $validatedNTargetAccountAddress = $requestPostBody['TargetAccountAddress'];

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
                                                case 'getTransactions': // yung debit creadit
                                                        $Account = $this->functions_Model->getAccountsByAddress($AccountAddressHeader);
                                                        if ($Account['ActorCategory_Id'] === '1' || $Account['ActorCategory_Id'] === '2') {


                                                        } else if ($Account['ActorCategory_Id'] === '2' || $Account['ActorCategory_Id'] === '3') {
                                                                


                                                        } else {
                                                                $result = $this->Transactions_Model->read_transactions_by_address($AccountAddressHeader);
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'response' => $result['response']
                                                                ]; 
                                                        }
                                                        
                                                        break;


                                                case 'getUsersTransactionInfos': // yung full details
                                                        $Account = $this->functions_Model->getAccountsByAddress($AccountAddressHeader);
                                                        if ($Account['ActorCategory_Id'] === '1' || $Account['ActorCategory_Id'] === '2') {
                                                                if (empty($validatedNTargetAccountAddress)) {
                                                                        $result = $this->Transactions_Model->read_transactionsinfo_by_address($validatedNTargetAccountAddress);
                                                                        $response = [
                                                                                'Success' => TRUE,
                                                                                'response' => $$result['response']
                                                                        ]; 
                                                                } else {
                                                                        $result = $this->Transactions_Model->read_transactionsinfo_by_address($validatedNTargetAccountAddress);
                                                                        $response = [
                                                                                'Success' => TRUE,
                                                                                'response' => $$result['response']
                                                                        ]; 
                                                                }






                                                                // kulang pa pag mag rretrive yung mismong accounting asrili nila
                                                                $result = $this->Transactions_Model->read_transactionsinfo_by_address($validatedNTargetAccountAddress);
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'response' => $$result['response']
                                                                ]; 
                                                        } else if ($Account['ActorCategory_Id'] === '3' || $Account['ActorCategory_Id'] === '4') {
                                                                        // FOR MERCHANTS

                                                        } else {
                                                                $result = $this->Transactions_Model->read_transactionsinfo_by_address($AccountAddressHeader);
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'response' => $$result['response']
                                                                ]; 
                                                        }
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
