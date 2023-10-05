<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OTP_Validation {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                        'Authentications_Model',
                ]);
                $this->CI->load->library([
                        'Auth/Verification',
                ]);
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){

                $this->CI->form_validation->set_data($requestPostBody);
                
                $this->CI->form_validation->set_rules('OTP', 'OTP', 'trim|required|numeric|min_length[6]');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|require');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedOTP = $requestPostBody['OTP'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->CI->Functions_Model->validateOTP($AccountAddressHeader, $validatedOTP)) {
                                $this->CI->Authentications_Model->create($AccountAddressHeader,$validatedIpAddress,$validatedLocation,$validatedDevice);
                                $response = $this->CI->Verification->Process($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
                        } else {
                                $response = [
                                        'Success' => False,
                                        'Target' => 'OTPValidation',
                                        'Parameters' => null,
                                        'Message' => 'Invalid OTP or time exceeded, Try-again!'
                                ];
                        }
                } else {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Message' => 'Invalid entry point, refresh and try-again!'
                        ];
                }
                return $response;
        }
}