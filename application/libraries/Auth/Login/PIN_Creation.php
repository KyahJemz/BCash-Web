<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PIN_Creation {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                ]);
                $this->CI->load->library('Auth/Verification', NULL, 'Verification');
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){

                $this->CI->form_validation->set_data($requestPostBody);
                
                $this->CI->form_validation->set_rules('NewPIN', 'NewPIN', 'trim|required|numeric|min_length[6]');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required');

                $validatedNewPIN = $requestPostBody['NewPIN'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->CI->Functions_Model->validateNewPIN($AccountAddressHeader)) {
                                
                                $this->CI->Functions_Model->updatePIN($AccountAddressHeader,$validatedNewPIN);

                                $response = $this->CI->Verification->Process($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
                        } else {
                                $response = [
                                        'Success' => False,
                                        'Target' => 'PINCreation',
                                        'Parameters' => null,
                                        'Response' => 'PIN registration failed, Try-again!'
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