<?php

class Login extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->model(['Login_Model', 'Authorization_Model']);
                $this->load->helper('string');
                $this->load->library(['form_validation','email']);
        }

        function sanitize($value) {
                if ($value === null) {
                        return null; // Return null if the value is null
                }
                $value = $this->db->escape_str($value);
                // $value = $this->input->xss_clean($value);
                return $value;
        }

        function authenticate($AccountAddress,$AuthToken){
                if (empty($AccountAddress) || empty($AuthToken)) {
                        return FALSE;
                } else {
                        $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                        if ($AuthToken === $tbl_authentications->AuthToken) {
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                }
        }

        function sendMmail($receiver,$OTP) {
        
                return true;
        }

        public function AuthenticateLogin() {

                $AuthorizationTokenHeader = $this->sanitize($this->input->get_request_header('Authorization', TRUE));
                $AccountAddressHeader = $this->sanitize($this->input->get_request_header('AccountAddress', TRUE));
                $IntentHeader = $this->sanitize($this->input->get_request_header('Intent', TRUE));

                $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
                $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

                if (!(is_array($requestPostBody))) {
                        $response = [
                                'Success' => FALSE,
                                'Target' => null,
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Invalid HTTPS Body parameters!'
                        ];  
                }  else {

                        if ($IntentHeader === "Web Login") {
                                $response = $this->WebLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader);
                        } else if ($IntentHeader === "User Login") {
                                $response = $this->UserLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader);
                        } else if ($IntentHeader === "Parent Login") {
                                $response = $this->ParentLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader);
                        } else if ($IntentHeader === "OTP Validation") {
                                $response = $this->OTPValidation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader);
                        } else if ($IntentHeader === "PIN Validation") {
                                $response = $this->PINValidation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader);
                        } else if ($IntentHeader === "PIN Creation") {
                                $response = $this->PINCreation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader);
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: Invalid HTTPS Headers parameters!'
                                ];   
                        }
                }
                // Return the response as JSON 
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

        function WebLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
                $this->form_validation->set_data($requestPostBody);
                
                $this->form_validation->set_rules('Username', 'Username', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Password', 'Password', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedUsername = $requestPostBody['Username'];
                $validatedPassword = $requestPostBody['Password'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                } else {
                        if ($this->form_validation->run() === FALSE) {
                                $validationErrors = validation_errors();
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: The provided parameters does not meet the validation requirements. [' . $validationErrors .']'
                                ];
                        } else {
                                $validAccount = $this->Login_Model->get_tbl_webaccounts_by_username($validatedUsername);
                        
                                if ($validAccount) {
                                        if (password_verify($validatedPassword,$validAccount->Password)) {

                                                $AccountAddress = $validAccount->WebAccounts_Address;

                                                $response = $this->verification($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                                        } else {
                                                $response = [
                                                        'Success' => FALSE,
                                                        'Target' => null,
                                                        'Parameters' => null,
                                                        'Message' => 'Failed: Incorrect Password!'
                                                ];
                                        }
                                } else {
                                        $response = [
                                                'Success' => FALSE,
                                                'Target' => null,
                                                'Parameters' => null,
                                                'Message' => 'Failed: Invalid Account!'
                                        ];
                                }
                        }
                }
                return $response;
        }

        function UserLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
                // $this->form_validation->set_data($requestPostBody);
                
                // $this->form_validation->set_rules('Email', 'Email', 'trim|required');
                // $this->form_validation->set_rules('EmailId', 'EmailId', 'trim|required|alpha_numeric');
                // $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                // $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                // $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                // $validatedEmail = $requestPostBody['Email'];
                // $validatedEmailId = $requestPostBody['EmailId'];
                // $validatedIpAddress = $requestPostBody['IpAddress'];
                // $validatedDevice = $requestPostBody['Device'];
                // $validatedLocation = $requestPostBody['Location'];

                // if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                //         $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation);

                // } else {
                //         if ($this->form_validation->run() === FALSE) {
                //                 $validationErrors = validation_errors();
                //                 $response = [
                //                         'Success' => FALSE,
                //                         'Target' => null,
                //                         'Parameters' => null,
                //                         'Message' => 'Failed, Reason: The provided parameters does not meet the validation requirements. [' . $validationErrors .']'
                //                 ];
                //         } else {
                //                 $validAccount = $this->Login_Model->get_tbl_webaccounts_by_username($validatedUsername);
                        
                //                 if ($validAccount) {
                //                         if (password_verify($validatedPassword,$validAccount->Password)) {

                //                                 $AccountAddress = $validAccount->WebAccounts_Address;

                //                                 $response = $this->verification($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation);

                //                         } else {
                //                                 $response = [
                //                                         'Success' => FALSE,
                //                                         'Target' => null,
                //                                         'Parameters' => null,
                //                                         'Message' => 'Failed: Incorrect Password!'
                //                                 ];
                //                         }
                //                 } else {
                //                         $response = [
                //                                 'Success' => FALSE,
                //                                 'Target' => null,
                //                                 'Parameters' => null,
                //                                 'Message' => 'Failed: Invalid Account!'
                //                         ];
                //                 }
                //         }
                // }
                // return $response;
        }

        function ParentLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){

                // return $response;
        }

        function OTPValidation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
                $this->form_validation->set_data($requestPostBody);
                
                $this->form_validation->set_rules('OTP', 'OTP', 'trim|required|numeric|min_length[6]');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedOTP = $requestPostBody['OTP'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->validateOTP($AccountAddressHeader, $validatedOTP)) {
                                $this->Authorization_Model->setLoginHistory($AccountAddressHeader,$validatedIpAddress,$validatedDevice,$validatedLocation);
                                $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: Invalid OTP or time exeeded, Try-again!'
                                ];
                        }
                } else {
                        $response = [
                                'Success' => FALSE,
                                'Target' => null,
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Invalid entry point, refresh and try-again!'
                        ];
                }
                return $response;
        }

        function PINValidation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
                $this->form_validation->set_data($requestPostBody);
                
                $this->form_validation->set_rules('PIN', 'PIN', 'trim|required|numeric|min_length[6]');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedPIN = $requestPostBody['PIN'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->validatePIN($AccountAddressHeader, $validatedPIN)) {
                                $this->Authorization_Model->updateLoginHistory($AccountAddressHeader,$validatedIpAddress,$validatedDevice,$validatedLocation);
                                $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, $validatedPIN);
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: Invalid PIN, Try-again!'
                                ];
                        }
                } else {
                        $response = [
                                'Success' => FALSE,
                                'Target' => null,
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Invalid entry point, refresh and try-again!'
                        ];
                }
                return $response;
        }

        function PINCreation($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader){
                $this->form_validation->set_data($requestPostBody);
                
                $this->form_validation->set_rules('NewPIN', 'NewPIN', 'trim|required|numeric|min_length[6]');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedNewPIN = $requestPostBody['NewPIN'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->validateNewPIN($AccountAddressHeader)) {
                                $this->updatePIN($AccountAddressHeader,$validatedNewPIN);
                                $response = $this->verification($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: PIN registration failed, Try-again!'
                                ];
                        }
                } else {
                        $response = [
                                'Success' => FALSE,
                                'Target' => null,
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Invalid entry point, refresh and try-again!'
                        ];
                }
                return $response;
        }

        function verification($AccountAddress, $AuthToken, $validatedIpAddress, $validatedDevice, $validatedLocation, $validatedPin){
                $account = $this->getAccountsByAddress($AccountAddress);

                if (!(is_object($account) && property_exists($account, 'ActorCategory_Id'))) {
                        $response = [
                                'Success' => FALSE,
                                'Target' => null,
                                'Parameters' => null,
                                'Message' => 'Failed, Reason: Invalid client category, Try-again!'
                        ];
                } else {

                        $Actor = $account->ActorCategory_Id;
                        if (!($this->validateAccountIfEnabled($AccountAddress))){
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: Access to this account is blocked!'
                                ];
                        } else {
                                if ($this->validateAccountIfOnline($AccountAddress)) {

                                        if ($this->validateClient($AccountAddress, $AuthToken, $validatedIpAddress, $validatedDevice, $validatedLocation)) {

                                                if ($this->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
                                                        $AuthToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress)->AuthToken;

                                                        $parameters = [
                                                                'AccountAddress' => $AccountAddress,
                                                                'AuthorizationToken' => $AuthToken,
                                                                'Actor' => $Actor,
                                                        ];
                                                        $response = [
                                                                'Success' => TRUE,
                                                                'Target' => $Actor,
                                                                'Parameters' => $parameters,
                                                                'Message' => 'Success: Account already signed in!'
                                                        ];
                                                } else {
                                                        $response = [
                                                                'Success' => FALSE,
                                                                'Target' => null,
                                                                'Parameters' => null,
                                                                'Message' => 'Failed, Reason: Auth creation failed, Try-again!'
                                                        ]; 
                                                }

                                        } else {
                                                $this->Authorization_Model->setLogout($AccountAddress);
                                                $response = [
                                                        'Success' => FALSE,
                                                        'Target' => null,
                                                        'Parameters' => null,
                                                        'Message' => 'Failed, Reason: Account already signed in on another device, Try-again!'
                                                ];
                                        }        
                                } else {
                                        if ($this->generateNewAuth($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)){
                                                $AuthToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress)->AuthToken;

                                                if ($this->validateIfNewAccountLogin($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)) {
                                                        $this->generateOTP($AccountAddress);
                                                        $parameters = [
                                                                'AccountAddress' => $AccountAddress,
                                                                'AuthorizationToken' => $AuthToken,
                                                                'Actor' => $Actor,
                                                        ];
                                                        $response = [
                                                                'Success' => TRUE,
                                                                'Target' => 'OTP Validation',
                                                                'Parameters' => $parameters,
                                                                'Message' => 'Success: New Sign-in detected, OTP validation required!'
                                                        ];
                                                } else {
                                                        if ($this->validateIfAccountHasPINCode($AccountAddress)) {
                                                                if (!empty($validatedPin)){
                                                                        if ($this->validatePIN($AccountAddress, $validatedPin)) {
                                                                                $parameters = [
                                                                                        'AccountAddress' => $AccountAddress,
                                                                                        'AuthorizationToken' => $AuthToken,
                                                                                        'Actor' => $Actor,
                                                                                ];
                                                                                $response = [
                                                                                        'Success' => TRUE,
                                                                                        'Target' => $Actor,
                                                                                        'Parameters' => $parameters,
                                                                                        'Message' => 'Success: Account is now Logged in!'
                                                                                ];
                                                                        } else {
                                                                                $response = [
                                                                                        'Success' => FALSE,
                                                                                        'Target' => null,
                                                                                        'Parameters' => null,
                                                                                        'Message' => 'Failed, Reason: Wrong account PIN!'
                                                                                ];
                                                                        }
                                                                } else {
                                                                        $parameters = [
                                                                                'AccountAddress' => $AccountAddress,
                                                                                'AuthorizationToken' => $AuthToken,
                                                                                'Actor' => $Actor,
                                                                        ];
                                                                        $response = [
                                                                                'Success' => TRUE,
                                                                                'Target' => 'PIN validation',
                                                                                'Parameters' => $parameters,
                                                                                'Message' => 'Success: PIN validation required!'
                                                                        ];
                                                                }
                                                        } else {
                
                                                                $parameters = [
                                                                        'AccountAddress' => $AccountAddress,
                                                                        'AuthorizationToken' => $AuthToken,
                                                                        'Actor' => $Actor,
                                                                ];
                                                                $response = [
                                                                        'Success' => TRUE,
                                                                        'Target' => 'PIN Creation',
                                                                        'Parameters' => $parameters,
                                                                        'Message' => 'Success: PIN creation required!'
                                                                ];
                                                        }
                                                }
                                        } else {
                                                $response = [
                                                        'Success' => FALSE,
                                                        'Target' => null,
                                                        'Parameters' => null,
                                                        'Message' => 'Failed, Reason: Auth creation failed, Try-again!'
                                                ];
                                        }
                                }
                        }
                }
                return $response;
        }

        function generateNewAuth($AccountAddress,$IpAddress,$Device,$Location){
                $existingAccount = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);

                $type = empty($existingAccount) ? "new" : "old"; // IF HAS RECORDS OR NONE

                if ($this->Authorization_Model->setAuthorization($type, $AccountAddress, $IpAddress, $Device, $Location)) {
                        return TRUE; 
                } else {
                        return FALSE; 
                }
        }

        function generateOTP($AccountAddress) {
                $OTP = $this->Authorization_Model->setOTP($AccountAddress);
                if (empty($OTP)){
                        return FALSE;
                } else {
                        $receiver = $this->getAccountsByAddress($AccountAddress)->Email;
                        if ($this->sendMmail($receiver,$OTP)){
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                }
        }


        function getAccountsByAddress($AccountAddress) {
                $tbl_webaccounts = $this->Login_Model->get_tbl_webaccounts_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        return $tbl_webaccounts;
                }
                
                $tbl_usersaccount = $this->Login_Model->get_tbl_usersaccount_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        return $tbl_usersaccount;
                }

                $tbl_guardiansaccount = $this->Login_Model->get_tbl_guardiansaccount_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        return $tbl_guardiansaccount;
                }

                return FALSE;
        }

        function validateAuthToken($AccountAddress, $AuthToken) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if ($AuthToken === $tbl_authentications->AuthToken) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        function validateOTP($AccountAddress, $OTP) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if ($OTP === $tbl_authentications->OtpCode) {
                        $cretionTime = strtotime($tbl_authentications->OtpCreationTime); // First timestamp
                        $expirationTime = strtotime($tbl_authentications->OtpExpirationTime); // Second timestamp
                        if ($cretionTime <= $expirationTime) {
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function validatePIN($AccountAddress, $PIN) {
                $Account = $this->getAccountsByAddress($AccountAddress);
                if ($PIN === $Account->PinCode) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        function validateNewPIN($AccountAddress) {
                $Account = $this->getAccountsByAddress($AccountAddress);
                if (empty($Account->PinCode)) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        public function updatePIN($AccountAddress, $PIN) {
                $tbl_webaccounts = $this->Login_Model->get_tbl_webaccounts_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        $this->Authorization_Model->updateWebsPIN($AccountAddress, $PIN);
                        return TRUE;
                }
                
                $tbl_usersaccount = $this->Login_Model->get_tbl_usersaccount_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        $this->Authorization_Model->updateUsersPIN($AccountAddress, $PIN);
                        return TRUE;
                }

                $tbl_guardiansaccount = $this->Login_Model->get_tbl_guardiansaccount_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        $this->Authorization_Model->updateParentsPIN($AccountAddress, $PIN);
                        return TRUE;
                }

                return FALSE;
        }

        function validateClient($AccountAddress, $IpAddress, $Device, $Location) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if (
                        $tbl_authentications && 
                        $IpAddress === $tbl_authentications->IpAddress &&
                        $Device === $tbl_authentications->Device &&
                        $Location === $tbl_authentications->Location
                ) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        function validateAccountIfEnabled($AccountAddress) {
                $Account = $this->getAccountsByAddress($AccountAddress);
                if ($Account && $Account->IsAccountActive === '1') {
                        return  TRUE;
                } else {
                        return  FALSE;
                }
        }

        function validateAccountIfOnline($AccountAddress) {
                $result = $this->getAccountsByAddress($AccountAddress);
                if ($result && $result->IsAccountActive === 1) {
                        return  TRUE;
                } else {
                        return  FALSE;
                }
        }

        function validateIfNewAccountLogin($AccountAddress,$IpAddress,$Device,$Location) {
                $result = $this->Authorization_Model->get_tbl_loginhistory_by_data($AccountAddress,$IpAddress,$Device,$Location);
                if ($result) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

        function validateIfAccountHasPINCode($AccountAddress) {
                $result = $this->getAccountsByAddress($AccountAddress);
                if ($result && !($result->PinCode === null || $result->PinCode === '')){
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
}