<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verification {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                        'Authentications_Model',
                ]);
        }

        function Process($AccountAddress, $AuthToken, $validatedIpAddress, $validatedDevice, $validatedLocation, $validatedPin){

                $account = $this->CI->Functions_Model->getAccountsByAddress($AccountAddress);

                if (!(is_object($account) && property_exists($account, 'ActorCategory_Id'))) {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Response' => 'Invalid client category, Try-again!'
                        ];
                } else {

                        // Is Account Blocked
                        $Actor = $account->ActorCategory_Id;
                        if (!($this->CI->Functions_Model->validateAccountIfEnabled($AccountAddress))){
                                $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Response' => 'Access to this account is blocked!'
                                ];
                        } else {
                                if ($this->CI->Functions_Model->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
                                        log_message('error', "################ Generatring");
                                        $AuthToken = $this->CI->Authentications_Model->read_by_address(array('Account_Address'=>$AccountAddress))->AuthToken;
                                        log_message('error', "################ kuku = ".$AuthToken);

                                        // Check If New Sign In Device Or IP
                                        if ($this->CI->Functions_Model->validateIfNewAccountLogin($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)) {
                                                $this->CI->Functions_Model->generateOTP($AccountAddress);
                                                $parameters = [
                                                        'AccountAddress' => $AccountAddress,
                                                        'AuthorizationToken' => $AuthToken,
                                                        'Actor' => $Actor,
                                                ];
                                                $response = [
                                                        'Success' => True,
                                                        'Target' => 'OTPValidation',
                                                        'Parameters' => $parameters,
                                                        'Response' => 'New Sign-in detected, OTP validation required!'
                                                ];

                                        } else {
                                                $this->CI->Authentications_Model->clear_otp($AccountAddress);
                                                // Checking If User Has PIN Code Already
                                                if ($this->CI->Functions_Model->validateIfAccountHasPINCode($AccountAddress)) {
                                                        if (!empty($validatedPin)){
                                                                if ($this->CI->Functions_Model->validatePIN($AccountAddress, $validatedPin)) {
                                                                        $parameters = [
                                                                                'AccountAddress' => $AccountAddress,
                                                                                'AuthorizationToken' => $AuthToken,
                                                                                'Actor' => $Actor,
                                                                        ];
                                                                        $response = [
                                                                                'Success' => True,
                                                                                'Target' => $Actor,
                                                                                'Parameters' => $parameters,
                                                                                'Response' => 'Account is now Logged in!'
                                                                        ];
                                                                } else {
                                                                        $response = [
                                                                                'Success' => False,
                                                                                'Target' => 'PINValidation',
                                                                                'Parameters' => null,
                                                                                'Response' => 'Wrong account PIN!'
                                                                        ];
                                                                }
                                                        } else {
                                                                $parameters = [
                                                                        'AccountAddress' => $AccountAddress,
                                                                        'AuthorizationToken' => $AuthToken,
                                                                        'Actor' => $Actor,
                                                                ];
                                                                $response = [
                                                                        'Success' => False,
                                                                        'Target' => 'PINValidation',
                                                                        'Parameters' => $parameters,
                                                                        'Response' => 'PIN validation required!'
                                                                ];
                                                        }
                                                } else {
                                                
                                                        $parameters = [
                                                                'AccountAddress' => $AccountAddress,
                                                                'AuthorizationToken' => $AuthToken,
                                                                'Actor' => $Actor,
                                                        ];
                                                        $response = [
                                                                'Success' => True,
                                                                'Target' => 'PINCreation',
                                                                'Parameters' => $parameters,
                                                                'Response' => 'PIN creation required!'
                                                        ];
                                                }
                                        }
                                } else {
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Response' => 'Auth creation failed, Try-again!'
                                        ];
                                }
                        }
                }
                return $response;
        }
}