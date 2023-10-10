<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OTP_Validation {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->model([
                        'Functions_Model',
                        'Authentications_Model',
                ]);
        }

        function Process($AuthorizationTokenHeader,$AccountAddressHeader){
 
                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {
                        if ($this->Functions_Model->validateAuthToken($AccountAddressHeader,$AuthorizationTokenHeader)) {
                                $this->Authorization_Model->setLogout($AccountAddressHeader);
                                $response = [
                                        'Success' => TRUE,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Message' => 'Success!'
                                ]; 
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: AuthToken Invalid!'
                                ]; 
                        }
                } else {
                        $response = [
                                'Success' => FALSE,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Logout parameters are empty!'
                        ];
                }
                return $response;
        }
}