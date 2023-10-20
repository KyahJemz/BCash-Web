<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PIN_Validation {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                        'Authentications_Model',
                ]);
                $this->CI->load->library('Auth/Verification', NULL, 'Verification');
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){

                $this->CI->form_validation->set_data($requestPostBody);
                
                $this->CI->form_validation->set_rules('PIN', 'PIN', 'trim|required|numeric|min_length[6]');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedPIN = $requestPostBody['PIN'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->CI->Functions_Model->validatePIN($AccountAddressHeader, $validatedPIN)) {
                                // $this->CI->Authentications_Model->update($AccountAddressHeader,$validatedIpAddress,$validatedLocation, $validatedDevice);
                                $response = $this->CI->Verification->Process($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, $validatedPIN);
                        } else {
                                $response = [
                                        'Success' => False,
                                        'Target' => 'PINValidation',
                                        'Parameters' => null,
                                        'Response' => 'Invalid PIN, Try-again!'
                                ];
                        }
                } else {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Response' => 'Invalid entry point, refresh and try-again!'
                        ];
                }
                return $response;
        }
}