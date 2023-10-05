<?php

class Auth extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->helper('string');
                $this->load->library(['form_validation']);
                $this->load->database();
                $this->load->model([
                        'Functions_Model',
                        'Configurations_Model' 
                ]);
                $this->load->library('Auth/Login/Web_Login', NULL, 'Web_Login');
                $this->load->library('Auth/Login/User_Login', NULL, 'User_Login');
                $this->load->library('Auth/Login/Guardian_Login', NULL, 'Guardian_Login');
                $this->load->library('Auth/Login/OTP_Validation', NULL, 'OTP_Validation');
                $this->load->library('Auth/Login/PIN_Creation', NULL, 'PIN_Creation');
                $this->load->library('Auth/Login/PIN_Validation', NULL, 'PIN_Validation');
        }

        public function Process() {

                $response = null;

                $AuthorizationTokenHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Authorization', TRUE));
                $AccountAddressHeader = $this->Functions_Model->sanitize($this->input->get_request_header('AccountAddress', TRUE));
                $ClientVersionHeader = $this->Functions_Model->sanitize($this->input->get_request_header('ClientVersion', TRUE));
                $IntentHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Intent', TRUE));

                $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
                $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

                $IsMaintenance = $this->Configurations_Model->IsMaintenance();
                if ($IsMaintenance['success']) {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Message' => $IsMaintenance['response']
                        ];
                }

                if (!(is_array($requestPostBody))) {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Message' => 'Invalid HTTPS body parameters!'
                        ];  
                }  else {
                        switch ($IntentHeader) {
                                case 'WebLogin':
                                    $response = $this->Web_Login->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader, $ClientVersionHeader);
                                    break;
                            
                                case 'UserLogin':
                                    $response = $this->User_Login->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader, $ClientVersionHeader);
                                    break;
                            
                                case 'GuardianLogin':
                                    $response = $this->Guardian_Login->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader, $ClientVersionHeader);
                                    break;
                            
                                case 'OTPValidation':
                                    $response = $this->OTP_Validation->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader);
                                    break;
                            
                                case 'PINValidation':
                                    $response = $this->PIN_Validation->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader);
                                    break;
                            
                                case 'PINCreation':
                                    $response = $this->PIN_Creation->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader);
                                    break;
                            
                                case 'Logout':
                                    $response = $this->accountLogout($AuthorizationTokenHeader, $AccountAddressHeader);
                                    break;
                            
                                default:
                                    $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Message' => 'No headers!'
                                ];
                        }
                }
                // Return the response as JSON 

                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

        // function WebLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){

        //         $this->form_validation->set_data($requestPostBody);
                
        //         $this->form_validation->set_rules('Username', 'Username', 'trim|required|alpha_numeric');
        //         $this->form_validation->set_rules('Password', 'Password', 'trim|required|alpha_numeric');
        //         $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
        //         $this->form_validation->set_rules('Device', 'Device', 'trim|required');
        //         $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

        //         $validatedUsername = $requestPostBody['Username'];
        //         $validatedPassword = $requestPostBody['Password'];
        //         $validatedIpAddress = $requestPostBody['IpAddress'];
        //         $validatedDevice = $requestPostBody['Device'];
        //         $validatedLocation = $requestPostBody['Location'];

        //         if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

        //                 $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

        //         } else {
        //                 if ($this->form_validation->run() === FALSE) {
        //                         $validationErrors = validation_errors();
        //                         $response = [
        //                                 'Success' => FALSE,
        //                                 'Target' => 'WebLogin',
        //                                 'Parameters' => null,
        //                                 'Message' => 'Failed, Reason: '. $validationErrors .'.'
        //                         ];
        //                 } else {
        //                         $validAccount = $this->WebAccounts_Model->read_by_username($validatedUsername);
                        
        //                         if ($validAccount) {
        //                                 if (password_verify($validatedPassword,$validAccount->Password)) {

        //                                         $AccountAddress = $validAccount->WebAccounts_Address;

        //                                         $response = $this->verification($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

        //                                 } else {
        //                                         $response = [
        //                                                 'Success' => FALSE,
        //                                                 'Target' => 'WebLogin',
        //                                                 'Parameters' => null,
        //                                                 'Message' => 'Failed: Incorrect Password!'
        //                                         ];
        //                                 }
        //                         } else {
        //                                 $response = [
        //                                         'Success' => FALSE,
        //                                         'Target' => 'WebLogin',
        //                                         'Parameters' => null,
        //                                         'Message' => 'Failed: Invalid Account!'
        //                                 ];
        //                         }
        //                 }
        //         }
        //         return $response;
        // }

        // function UserLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){


        //         // $this->form_validation->set_data($requestPostBody);
                
        //         // $this->form_validation->set_rules('Email', 'Email', 'trim|required');
        //         // $this->form_validation->set_rules('EmailId', 'EmailId', 'trim|required|alpha_numeric');
        //         // $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
        //         // $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
        //         // $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

        //         // $validatedEmail = $requestPostBody['Email'];
        //         // $validatedEmailId = $requestPostBody['EmailId'];
        //         // $validatedIpAddress = $requestPostBody['IpAddress'];
        //         // $validatedDevice = $requestPostBody['Device'];
        //         // $validatedLocation = $requestPostBody['Location'];

        //         // if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

        //         //         $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation);

        //         // } else {
        //         //         if ($this->form_validation->run() === FALSE) {
        //         //                 $validationErrors = validation_errors();
        //         //                 $response = [
        //         //                         'Success' => FALSE,
        //         //                         'Target' => null,
        //         //                         'Parameters' => null,
        //         //                         'Message' => 'Failed, Reason: The provided parameters does not meet the validation requirements. [' . $validationErrors .']'
        //         //                 ];
        //         //         } else {
        //         //                 $validAccount = $this->Login_Model->get_tbl_webaccounts_by_username($validatedUsername);
                        
        //         //                 if ($validAccount) {
        //         //                         if (password_verify($validatedPassword,$validAccount->Password)) {

        //         //                                 $AccountAddress = $validAccount->WebAccounts_Address;

        //         //                                 $response = $this->verification($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation);

        //         //                         } else {
        //         //                                 $response = [
        //         //                                         'Success' => FALSE,
        //         //                                         'Target' => null,
        //         //                                         'Parameters' => null,
        //         //                                         'Message' => 'Failed: Incorrect Password!'
        //         //                                 ];
        //         //                         }
        //         //                 } else {
        //         //                         $response = [
        //         //                                 'Success' => FALSE,
        //         //                                 'Target' => null,
        //         //                                 'Parameters' => null,
        //         //                                 'Message' => 'Failed: Invalid Account!'
        //         //                         ];
        //         //                 }
        //         //         }
        //         // }
        //         // return $response;
        // }

        // function ParentLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader, $ClientVersionHeader){
                
        //         $Version = $this->Configurations_Model->ValidateMobileVersion($ClientVersionHeader);
        //         if (!($Version[0])){
        //                 $response = [
        //                         'Success' => FALSE,
        //                         'Target' => 'WebLogin',
        //                         'Parameters' => null,
        //                         'Message' => $Version[1]
        //                 ];   
        //                 return $response;
        //         }

        //         // return $response;
        // }

        // function OTPValidation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
        //         $this->form_validation->set_data($requestPostBody);
                
        //         $this->form_validation->set_rules('OTP', 'OTP', 'trim|required|numeric|min_length[6]');
        //         $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
        //         $this->form_validation->set_rules('Device', 'Device', 'trim|require');
        //         $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

        //         $validatedOTP = $requestPostBody['OTP'];
        //         $validatedIpAddress = $requestPostBody['IpAddress'];
        //         $validatedDevice = $requestPostBody['Device'];
        //         $validatedLocation = $requestPostBody['Location'];

        //         if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

        //                 if ($this->Functions_Model->validateOTP($AccountAddressHeader, $validatedOTP)) {
        //                         $this->Authentications_Model->create($AccountAddressHeader,$validatedIpAddress,$validatedLocation,$validatedDevice);
        //                         $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
        //                 } else {
        //                         $response = [
        //                                 'Success' => FALSE,
        //                                 'Target' => 'OTPValidation',
        //                                 'Parameters' => null,
        //                                 'Message' => 'Failed, Reason: Invalid OTP or time exeeded, Try-again!'
        //                         ];
        //                 }
        //         } else {
        //                 $response = [
        //                         'Success' => FALSE,
        //                         'Target' => 'WebLogin',
        //                         'Parameters' => null,
        //                         'Message' => 'Failed, Reason: Invalid entry point, refresh and try-again!'
        //                 ];
        //         }
        //         return $response;
        // }

        // function PINValidation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
        //         $this->form_validation->set_data($requestPostBody);
                
        //         $this->form_validation->set_rules('PIN', 'PIN', 'trim|required|numeric|min_length[6]');
        //         $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
        //         $this->form_validation->set_rules('Device', 'Device', 'trim|required');
        //         $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

        //         $validatedPIN = $requestPostBody['PIN'];
        //         $validatedIpAddress = $requestPostBody['IpAddress'];
        //         $validatedDevice = $requestPostBody['Device'];
        //         $validatedLocation = $requestPostBody['Location'];

        //         if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

        //                 if ($this->Functions_Model->validatePIN($AccountAddressHeader, $validatedPIN)) {
        //                         $this->Authentications_Model->update($AccountAddressHeader,$validatedIpAddress,$validatedLocation, $validatedDevice);
        //                         $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, $validatedPIN);
        //                 } else {
        //                         $response = [
        //                                 'Success' => FALSE,
        //                                 'Target' => 'PINValidation',
        //                                 'Parameters' => null,
        //                                 'Message' => 'Failed, Reason: Invalid PIN, Try-again!'
        //                         ];
        //                 }
        //         } else {
        //                 $response = [
        //                         'Success' => FALSE,
        //                         'Target' => 'WebLogin',
        //                         'Parameters' => null,
        //                         'Message' => 'Failed, Reason: Invalid entry point, refresh and try-again!'
        //                 ];
        //         }
        //         return $response;
        // }

        // function PINCreation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
        //         $this->form_validation->set_data($requestPostBody);
                
        //         $this->form_validation->set_rules('NewPIN', 'NewPIN', 'trim|required|numeric|min_length[6]');
        //         $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
        //         $this->form_validation->set_rules('Device', 'Device', 'trim|required');
        //         $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

        //         $validatedNewPIN = $requestPostBody['NewPIN'];
        //         $validatedIpAddress = $requestPostBody['IpAddress'];
        //         $validatedDevice = $requestPostBody['Device'];
        //         $validatedLocation = $requestPostBody['Location'];

        //         if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

        //                 if ($this->Functions_Model->validateNewPIN($AccountAddressHeader)) {
        //                         $this->Functions_Model->updatePIN($AccountAddressHeader,$validatedNewPIN);
        //                         $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
        //                 } else {
        //                         $response = [
        //                                 'Success' => FALSE,
        //                                 'Target' => 'PINCraetion',
        //                                 'Parameters' => null,
        //                                 'Message' => 'Failed, Reason: PIN registration failed, Try-again!'
        //                         ];
        //                 }
        //         } else {
        //                 $response = [
        //                         'Success' => FALSE,
        //                         'Target' => 'WebLogin',
        //                         'Parameters' => null,
        //                         'Message' => 'Failed, Reason: Invalid entry point, refresh and try-again!'
        //                 ];
        //         }
        //         return $response;
        // }

        //// FOR REVIEW
        function accountLogout($AuthorizationTokenHeader,$AccountAddressHeader){
 
                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {
                        if ($this->Functions_Model->validateAuthToken($AccountAddressHeader,$AuthorizationTokenHeader)) {
                                $this->Authorization_Model->setLogout($AccountAddressHeader);
                                $response = [
                                        'Success' => TRUE,
                                        'Target' => 'WebLogin',
                                        'Parameters' => null,
                                        'Message' => 'Success!'
                                ]; 
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => 'WebLogin',
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: AuthToken Invalid!'
                                ]; 
                        }
                } else {
                        $response = [
                                'Success' => FALSE,
                                'Target' => 'WebLogin',
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Logout parameters are empty!'
                        ];
                }

                return $response;
        }


        // function verification($AccountAddress, $AuthToken, $validatedIpAddress, $validatedDevice, $validatedLocation, $validatedPin){
        //         $account = $this->Functions_Model->getAccountsByAddress($AccountAddress);

        //         if (!(is_object($account) && property_exists($account, 'ActorCategory_Id'))) {
        //                 $response = [
        //                         'Success' => FALSE,
        //                         'Target' => 'WebLogin',
        //                         'Parameters' => null,
        //                         'Message' => 'Failed, Reason: Invalid client category, Try-again!'
        //                 ];
        //         } else {

        //                 $Actor = $account->ActorCategory_Id;
        //                 if (!($this->Functions_Model->validateAccountIfEnabled($AccountAddress))){
        //                         $response = [
        //                                 'Success' => FALSE,
        //                                 'Target' => 'WebLogin',
        //                                 'Parameters' => null,
        //                                 'Message' => 'Failed, Reason: Access to this account is blocked!'
        //                         ];
        //                 } else {
        //                         if ($this->Functions_Model->validateAccountIfOnline($AccountAddress)) {

        //                                 if ($this->Functions_Model->validateClient($AccountAddress, $AuthToken, $validatedIpAddress, $validatedDevice, $validatedLocation)) {

        //                                         if ($this->Functions_Model->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
        //                                                 $AuthToken = $this->Authentications_Model->read_by_address($AccountAddress)->AuthToken;

        //                                                 $parameters = [
        //                                                         'AccountAddress' => $AccountAddress,
        //                                                         'AuthorizationToken' => $AuthToken,
        //                                                         'Actor' => $Actor,
        //                                                 ];
        //                                                 $response = [
        //                                                         'Success' => TRUE,
        //                                                         'Target' => $Actor,
        //                                                         'Parameters' => $parameters,
        //                                                         'Message' => 'Success: Account already signed in!'
        //                                                 ];
        //                                         } else {
        //                                                 $response = [
        //                                                         'Success' => FALSE,
        //                                                         'Target' => 'WebLogin',
        //                                                         'Parameters' => null,
        //                                                         'Message' => 'Failed, Reason: Auth creation failed, Try-again!'
        //                                                 ]; 
        //                                         }

        //                                 } else {
        //                                         $this->Authorization_Model->setLogout($AccountAddress);
        //                                         $response = [
        //                                                 'Success' => FALSE,
        //                                                 'Target' => 'WebLogin',
        //                                                 'Parameters' => null,
        //                                                 'Message' => 'Failed, Reason: Account already signed in on another device, Try-again!'
        //                                         ];
        //                                 }        
        //                         } else {
        //                                 if ($this->Functions_Model->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
        //                                         $AuthToken = $this->Authentications_Model->read_by_address($AccountAddress)->AuthToken;

        //                                         if ($this->Functions_Model->validateIfNewAccountLogin($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)) {
        //                                                 $this->Functions_Model->generateOTP($AccountAddress);
        //                                                 $parameters = [
        //                                                         'AccountAddress' => $AccountAddress,
        //                                                         'AuthorizationToken' => $AuthToken,
        //                                                         'Actor' => $Actor,
        //                                                 ];
        //                                                 $response = [
        //                                                         'Success' => TRUE,
        //                                                         'Target' => 'OTPValidation',
        //                                                         'Parameters' => $parameters,
        //                                                         'Message' => 'Success: New Sign-in detected, OTP validation required!'
        //                                                 ];

        //                                                 // check also if blocked
        //                                         } else {
        //                                                 if ($this->Functions_Model->validateIfAccountHasPINCode($AccountAddress)) {
        //                                                         if (!empty($validatedPin)){
        //                                                                 if ($this->Functions_Model->validatePIN($AccountAddress, $validatedPin)) {
        //                                                                         $parameters = [
        //                                                                                 'AccountAddress' => $AccountAddress,
        //                                                                                 'AuthorizationToken' => $AuthToken,
        //                                                                                 'Actor' => $Actor,
        //                                                                         ];
        //                                                                         $response = [
        //                                                                                 'Success' => TRUE,
        //                                                                                 'Target' => $Actor,
        //                                                                                 'Parameters' => $parameters,
        //                                                                                 'Message' => 'Success: Account is now Logged in!'
        //                                                                         ];
        //                                                                 } else {
        //                                                                         $response = [
        //                                                                                 'Success' => FALSE,
        //                                                                                 'Target' => 'PINValidation',
        //                                                                                 'Parameters' => null,
        //                                                                                 'Message' => 'Failed, Reason: Wrong account PIN!'
        //                                                                         ];
        //                                                                 }
        //                                                         } else {
        //                                                                 $parameters = [
        //                                                                         'AccountAddress' => $AccountAddress,
        //                                                                         'AuthorizationToken' => $AuthToken,
        //                                                                         'Actor' => $Actor,
        //                                                                 ];
        //                                                                 $response = [
        //                                                                         'Success' => TRUE,
        //                                                                         'Target' => 'PINValidation',
        //                                                                         'Parameters' => $parameters,
        //                                                                         'Message' => 'Success: PIN validation required!'
        //                                                                 ];
        //                                                         }
        //                                                 } else {
                                                              
        //                                                         $parameters = [
        //                                                                 'AccountAddress' => $AccountAddress,
        //                                                                 'AuthorizationToken' => $AuthToken,
        //                                                                 'Actor' => $Actor,
        //                                                         ];
        //                                                         $response = [
        //                                                                 'Success' => TRUE,
        //                                                                 'Target' => 'PINCreation',
        //                                                                 'Parameters' => $parameters,
        //                                                                 'Message' => 'Success: PIN creation required!'
        //                                                         ];
        //                                                 }
        //                                         }
        //                                 } else {
        //                                         $response = [
        //                                                 'Success' => FALSE,
        //                                                 'Target' => 'WebLogin',
        //                                                 'Parameters' => null,
        //                                                 'Message' => 'Failed, Reason: Auth creation failed, Try-again!'
        //                                         ];
        //                                 }
        //                         }
        //                 }
        //         }
        //         return $response;
        // }
}