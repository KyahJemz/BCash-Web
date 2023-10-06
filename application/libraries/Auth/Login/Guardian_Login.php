<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guardian_Login {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                        'GuardianAccount_Model', 
                ]);
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){

                $this->webAccounts_Model->uploadPass();

                $this->CI->form_validation->set_data($requestPostBody);
                
                $this->CI->form_validation->set_rules('Id', 'Id', 'trim|required|alpha_numeric');
                $this->CI->form_validation->set_rules('Password', 'Password', 'trim|required|alpha_numeric');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedId = $requestPostBody['Id'];
                $validatedPassword = $requestPostBody['Password'];
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
                                        'Message' => ''. $validationErrors
                                ];
                        } else {

                                $client = new Client();
                                $response = $client->post('https://www.googleapis.com/oauth2/v3/tokeninfo', 
                                        ['form_params' => ['id_token' => $token]]
                                );

                                $body = json_decode($response->getBody(), true);  // Parse the response JSON

                                if (!isset($body['error'])) {

                                        $validatedGoogleId = $body['sub'];
                                        $validatedGoogleEmail = $body['email'];
                                        $validatedGoogleFirstName = $body['given_name'];
                                        $validatedGoogleLastName = $body['family_name'];

                                        $validAccount = $this->CI->GuardianAccount_Model->read_by_emailid($validatedGoogleId);

                                        if ($validAccount) {

                                                $AccountAddress = $validAccount->GuardianAccount_Address;

                                                $response = $this->CI->Verification->Process($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
                                                
                                        } else {
                                                $response = [
                                                        'Success' => False,
                                                        'Target' => 'Login',
                                                        'Parameters' => null,
                                                        'Message' => 'Account does not exist!'
                                                ];
                                        }
                                } else {
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Message' => 'Invalid Token! ' + $body['error']
                                        ];   
                                }
                        }
                }
                return $response;
        }
}