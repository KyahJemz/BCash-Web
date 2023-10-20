<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web_Login {

        protected $CI;
        
        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'WebAccounts_Model',
                        'LoginHistory_Model',
                        'Authentications_Model'
                ]);
                $this->CI->load->library('Auth/Verification', NULL, 'Verification');
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){

                $this->CI->form_validation->set_data($requestPostBody);
                
                $this->CI->form_validation->set_rules('Username', 'Username', 'trim|required|alpha_numeric');
                $this->CI->form_validation->set_rules('Password', 'Password', 'trim|required|alpha_numeric');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedUsername = $requestPostBody['Username'];
                $validatedPassword = $requestPostBody['Password'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        $response = $this->CI->Verification->Process($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                } else {
                        if (empty($validatedUsername) && empty($validatedPassword)){
                                $response = [
                                        'Success' => true,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Response' => '',
                                ]; 
                                return $response;
                        }

                        if ($this->CI->form_validation->run() === FALSE) {
                                $validationErrors = validation_errors();
                                $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Response' => ''. $validationErrors
                                ];
                        } else {
                                $validAccount = $this->CI->WebAccounts_Model->read_by_Username(array('Username'=>$validatedUsername));
                        
                                if ($validAccount) {
                                        // log_message('debug', $validAccount->Password);
                                        if (password_verify($validatedPassword,$validAccount->Password)) {

                                                $AccountAddress = $validAccount->WebAccounts_Address;

                                                if ($this->CI->Authentications_Model->read_by_address(array('Account_Address'=>$AccountAddress))) {
                                                        $this->CI->Authentications_Model->delete($AccountAddress);
                                                        $response = [
                                                                'Success' => True,
                                                                'Target' => 'Login',
                                                                'Parameters' => null,
                                                                'Response' => 'Account is already active. Force logout activated, Please try again!'
                                                        ];
                                                } else {
                                                        $response = $this->CI->Verification->Process($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
                                                }

                                        } else {
                                                $response = [
                                                        'Success' => False,
                                                        'Target' => 'Login',
                                                        'Parameters' => null,
                                                        'Response' => 'Incorrect Password!'
                                                ];
                                        }
                                } else {
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Response' => 'Invalid Account!'
                                        ];
                                }
                        }
                }
                return $response;
        }
}