<?php

class Login extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->model(['Login_Model', 'Authorization_Model']);
                $this->load->helper('string');
                $this->load->library(['form_validation']);
        }

        function sanitize($value) {
                if ($value === null) {
                        return null; // Return null if the value is null
                }
                $value = $this->db->escape_str($value);
                // $value = $this->input->xss_clean($value);
                return $value;
        }

        public function checkUser(){
            $AuthorizationTokenHeader = $this->sanitize($this->input->get_request_header('Authorization', TRUE));
            $AccountAddressHeader = $this->sanitize($this->input->get_request_header('AccountAddress', TRUE));
        }

        public function initiateWebLogin() {

                $AuthorizationTokenHeader = $this->sanitize($this->input->get_request_header('Authorization', TRUE));
                $AccountAddressHeader = $this->sanitize($this->input->get_request_header('AccountAddress', TRUE));

                $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
                $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES


                if (is_array($requestPostBody)) {
                        $this->form_validation->set_data($requestPostBody);
                        // Rest of your code
                
                $this->form_validation->set_rules('Username', 'Username', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Password', 'Password', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

               // $validatedRequestPostBody = $this->input->post(); 

                $validatedUsername = $requestPostBody['Username'];
                $validatedPassword = $requestPostBody['Password'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->validateAuthToken($AccountAddressHeader,$AuthorizationTokenHeader)) {

                                if ($this->validateClient($AccountAddressHeader,$validatedIpAddress,$validatedDevice,$validatedLocation)){
                        
                                        $webactor_category = $this->Authorization_Model->get_webactor_category($AccountAddressHeader);
                                        $parameters = [
                                                'AccountAddress' => $AccountAddressHeader ,
                                                'AuthorizationToken' => $AuthorizationTokenHeader,
                                                'Actor' => $webactor_category,
                                        ];
                                        $response = [
                                                'Success' => TRUE,
                                                'Target' => $webactor_category,
                                                'Parameters' => $parameters,
                                                'Message' => 'Success'
                                        ];
                                } else {
                                        $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddressHeader);
                                        $IpAddress = $tbl_authentications->IpAddress;
                                        $Device = $tbl_authentications->Device;
                                        $Location = $tbl_authentications->Location;
                                        $message = 'Failed, Reason: The login details provided does not match the current active session of the account. ' .
                                        "IpAddress: $IpAddress, Device: $Device, Location: $Location.";

                                        $response = [
                                                'Success' => FALSE,
                                                'Target' => null,
                                                'Parameters' => null,
                                                'Message' => $message
                                        ];
                                }
                        } else {
                                $response = [
                                        'Success' => FALSE,
                                        'Target' => null,
                                        'Parameters' => null,
                                        'Message' => 'Failed, Reason: Invalid token'
                                ];
                        }
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


                                                   // Debug statement: Log the AccountAddress for debugging


                                                if (!($this->validateAccountIfEnabled($AccountAddress))){
                                                        $response = [
                                                                'Success' => FALSE,
                                                                'Target' => null,
                                                                'Parameters' => null,
                                                                'Message' => 'Failed: Access to this account is blocked!'
                                                        ];
                                                } else {
                                                        if ($this->validateAccountIfOnline($AccountAddress)) {
                                                                $AuthorizationToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                                                                if ($this->validateClient($AccountAddress,$AuthorizationToken->AuthToken,$validatedIpAddress,$validatedDevice,$validatedLocation)) {
                                                                        $Actor = $this->Authorization_Model->get_webactor_category($AccountAddress);
                                                                        $parameters = [
                                                                                'AccountAddress' => $AccountAddress,
                                                                                'AuthorizationToken' => $AuthorizationToken->AuthToken,
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
                                                                                'Message' => 'Failed: Account already signed in on another device!'
                                                                        ];
                                                                }        
                                                        } else {
                                                                if ($this->validateIfNewAccountLogin($AccountAddress,$validatedIpAddress,$validatedDevice,$validatedLocation)) {
                                                                        $Actor = $this->Authorization_Model->get_webactor_category($AccountAddress);
                                                                        $AuthorizationToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                                                                        $parameters = [
                                                                                'AccountAddress' => $AccountAddress,
                                                                                'AuthorizationToken' => $AuthorizationToken->AuthToken,
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
                                                                                $Actor = $this->Authorization_Model->get_webactor_category($AccountAddress);
                                                                                $AuthorizationToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                                                                                $parameters = [
                                                                                        'AccountAddress' => $AccountAddress,
                                                                                        'AuthorizationToken' => $AuthorizationToken->AuthToken,
                                                                                        'Actor' => $Actor,
                                                                                ];
                                                                                $response = [
                                                                                        'Success' => TRUE,
                                                                                        'Target' => 'PIN validation',
                                                                                        'Parameters' => $parameters,
                                                                                        'Message' => 'Success: PIN validation required!'
                                                                                ];
                                                                        } else {
                                                                                $Actor = $this->Authorization_Model->get_webactor_category($AccountAddress);
                                                                                $AuthorizationToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                                                                                $parameters = [
                                                                                        'AccountAddress' => $AccountAddress,
                                                                                        'AuthorizationToken' => $AuthorizationToken->AuthToken,
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
                                                        }
                                                }

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
        } else {
                $response = [
                        'Success' => FALSE,
                        'Target' => null,
                        'Parameters' => null,
                        'Message' => 'FAILED'
                ];        
        }
                // Return the response as JSON
                
                $this->output->set_content_type('application/json')->set_output(json_encode($response));

    
        }

        public function initiateWebLogout() {
       
        }



        public function initiateMobileLogin() {

        }




        public function craetePIN() {
       
        }

        public function validatePIN() {
       
        }

        public function validateOTP() {
       
        }



        








        // function createResponse($status, $target,  $message) {
        //         $response = [];
        //         if ($status === "success") {
        //             $response = [
        //                 'Status' => TRUE,
        //                 'Target' => $target,
        //                 'Request' => ,
        //                 'Message' => $message,
        //             ];
        //         } else {
        //             $response = [
        //                 'status' => FALSE,
        //                 'Target' => $target,
        //                 'Parameters' => null,
        //                 'Message' => $message
        //             ];
        //         }
                
        //         return $response;
        //     }


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
                $result = $this->getAccountsByAddress($AccountAddress);
                if ($result && $result->IsAccountActive === '1') {
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