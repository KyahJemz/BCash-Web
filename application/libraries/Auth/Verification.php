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
                                'Message' => 'Invalid client category, Try-again!'
                        ];
                } else {

                        // Is Account Blocked
                        $Actor = $account->ActorCategory_Id;
                        if (!($this->CI->Functions_Model->validateAccountIfEnabled($AccountAddress))){
                                $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Message' => 'Access to this account is blocked!'
                                ];
                        } else {

                                // Is Account Online Already
                                if ($this->CI->Functions_Model->validateAccountIfOnline($AccountAddress)) {

                                        // Is Account Online Already
                                        if ($this->CI->Functions_Model->validateClient($AccountAddress, $AuthToken, $validatedIpAddress, $validatedDevice, $validatedLocation)) {

                                                // Is Account Online Matches The User                                              
                                                if ($this->CI->Functions_Model->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
                                                        $AuthToken = $this->CI->Authentications_Model->read_by_address($AccountAddress)->AuthToken;

                                                        $parameters = [
                                                                'AccountAddress' => $AccountAddress,
                                                                'AuthorizationToken' => $AuthToken,
                                                                'Actor' => $Actor,
                                                        ];
                                                        $response = [
                                                                'Success' => True,
                                                                'Target' => $Actor,
                                                                'Parameters' => $parameters,
                                                                'Message' => 'Account already signed in!'
                                                        ];
                                                } else {
                                                        $response = [
                                                                'Success' => False,
                                                                'Target' => 'Login',
                                                                'Parameters' => null,
                                                                'Message' => 'Auth creation failed, Try-again!'
                                                        ]; 
                                                }  

                                        } else {
                                                // Force Logout Online User
                                                $this->CI->Authorization_Model->setLogout($AccountAddress);
                                                $response = [
                                                        'Success' => False,
                                                        'Target' => 'Login',
                                                        'Parameters' => null,
                                                        'Message' => 'Account already signed in on another device, Try-again!'
                                                ];
                                        }        
                                } else {

                                        if ($this->CI->Functions_Model->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
                                                $AuthToken = $this->CI->Authentications_Model->read_by_address($AccountAddress)->AuthToken;

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
                                                                'Message' => 'New Sign-in detected, OTP validation required!'
                                                        ];

                                                } else {

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
                                                                                        'Message' => 'Account is now Logged in!'
                                                                                ];
                                                                        } else {
                                                                                $response = [
                                                                                        'Success' => False,
                                                                                        'Target' => 'PINValidation',
                                                                                        'Parameters' => null,
                                                                                        'Message' => 'Wrong account PIN!'
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
                                                                                'Message' => 'PIN validation required!'
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
                                                                        'Message' => 'PIN creation required!'
                                                                ];
                                                        }
                                                }
                                        } else {
                                                $response = [
                                                        'Success' => False,
                                                        'Target' => 'Login',
                                                        'Parameters' => null,
                                                        'Message' => 'Auth creation failed, Try-again!'
                                                ];
                                        }
                                }
                        }
                }
                return $response;
        }
}