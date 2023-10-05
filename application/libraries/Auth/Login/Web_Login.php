<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web_Login {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model('WebAccounts_Model');
                $this->CI->load->library([
                        'Auth/Verification',
                ]);
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
                        if ($this->CI->form_validation->run() === FALSE) {
                                $validationErrors = validation_errors();
                                $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Message' => ''. $validationErrors .'!'
                                ];
                        } else {
                                $validAccount = $this->CI->WebAccounts_Model->read_by_username($validatedUsername);
                        
                                if ($validAccount) {
                                        if (password_verify($validatedPassword,$validAccount->Password)) {

                                                $AccountAddress = $validAccount->WebAccounts_Address;

                                                $response = $this->CI->Verification->Process($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                                        } else {
                                                $response = [
                                                        'Success' => False,
                                                        'Target' => 'Login',
                                                        'Parameters' => null,
                                                        'Message' => 'Incorrect Password!'
                                                ];
                                        }
                                } else {
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Message' => 'Invalid Account!'
                                        ];
                                }
                        }
                }
                return $response;
        }
}