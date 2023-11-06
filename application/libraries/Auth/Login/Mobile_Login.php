<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';
use GuzzleHttp\Client;

class Mobile_Login {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                        'UsersAccount_Model', 
                        'UsersData_Model',
                        'GuardianAccount_Model',
                        'SchoolId_Model',
                ]);
                $this->CI->load->library('Auth/Verification', NULL, 'Verification');
                $this->CI->load->database();
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){

                $this->CI->form_validation->set_data($requestPostBody);
                
                $this->CI->form_validation->set_rules('GoogleToken', 'GoogleToken', 'trim|required');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required');

                $validatedGoogleToken = $requestPostBody['GoogleToken'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        $response = $this->CI->Verification->Process($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                } else {
                        if ($this->CI->form_validation->run() === FALSE) {
                                $validationErrors = validation_errors();
                                $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Response' => ''. $validationErrors
                                ];
                        } else {

                                $client = new Client();
                                $response = $client->post('https://www.googleapis.com/oauth2/v3/tokeninfo', 
                                        ['form_params' => ['id_token' => $validatedGoogleToken]]
                                );

                                $body = json_decode($response->getBody(), true);

                                if (!isset($body['error'])) {

                                        $validatedGoogleEmail = $body['email'];
                                        $validatedGoogleFirstName = $body['given_name'];
                                        $validatedGoogleLastName = $body['family_name'];

                                        log_message('debug', "---TEST---".$validatedGoogleEmail);

                                        $validUserAccount = $this->CI->UsersAccount_Model->read_by_Email($validatedGoogleEmail);
                                        $validGuardianAccount = $this->CI->GuardianAccount_Model->read_by_Email($validatedGoogleEmail);

                                        if (!empty($validGuardianAccount)){

                                                $AccountAddress = $validGuardianAccount->GuardianAccount_Address;

                                                $response = $this->CI->Verification->Process($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                                        } else {
                                                if (!empty($validUserAccount)) {

                                                        $AccountAddress = $validUserAccount->UsersAccount_Address;

                                                        $response = $this->CI->Verification->Process($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                                                } else if (strtoupper(substr($validatedGoogleEmail, -9)) === strtoupper("@sscr.edu")){

                                                        $UsersAccount_Address = $this->CI->Functions_Model->create_unique_address("USR");

                                                        $UserPersonalId = $this->CI->SchoolId_Model->read_by_email(array(
                                                                'Email' => strtoupper($validatedGoogleEmail),
                                                        ));

                                                        if (!empty($UserPersonalId)){
                                                                $UserPersonalId = $UserPersonalId->SchoolId;
                                                        } else {
                                                                return [
                                                                        'Success' => False,
                                                                        'Target' => 'Login',
                                                                        'Parameters' => null,
                                                                        'Response' => 'SSCR Account not registered.'
                                                                ];
                                                        }

                                                        $this->CI->db->trans_start();

                                                                $this->CI->UsersAccount_Model->create(array(
                                                                        'Account_Address' => $UsersAccount_Address,
                                                                        'ActorCategory_Id' => '5',
                                                                        'Email' => $validatedGoogleEmail,
                                                                        'Firstname' => $validatedGoogleFirstName,
                                                                        'Lastname' => $validatedGoogleLastName,
                                                                        'Campus_Id' => '1',
                                                                        'Password' => null,
                                                                ));

                                                                $this->CI->UsersData_Model->create(array (
                                                                        'Account_Address' => $UsersAccount_Address,
                                                                        'SchoolPersonalId' => $UserPersonalId,
                                                                        'CanDoTransfers' => '1',
                                                                        'CanDoTransactions' => '1',
                                                                        'CanUseCard' => '1',
                                                                        'CanModifySettings' => '1',
                                                                        'IsTransactionAutoConfirm' => '0',
                                                                ));

                                                        $this->CI->db->trans_complete();

                                                        if ($this->CI->db->trans_status() === FALSE) {
                                                                $this->CI->db->trans_rollback();
                                                                return [
                                                                        'Success' => False,
                                                                        'Target' => 'Login',
                                                                        'Parameters' => null,
                                                                        'Response' => 'Error during registering your account!'
                                                                ];
                                                        } 

                                                        $response = $this->CI->Verification->Process($UsersAccount_Address, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                                                } else {
                                                        return [
                                                                'Success' => False,
                                                                'Target' => 'Login',
                                                                'Parameters' => null,
                                                                'Response' => 'Unregistered Account!'
                                                        ];
                                                }
                                        } 
                                } else {
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Response' => 'Invalid Token! ' + $body['error']
                                        ];   
                                }
                        }
                }
                return $response;
        }
}