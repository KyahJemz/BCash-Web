<?php

class Login extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->model(['Login_Model', 'Authorization_Model']);
                $this->load->helper('string');
                $this->load->library(['form_validation']);
        }

        function sanitize($value) {
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
                $this->form_validation->set_data($requestPostBody); // SET FORM VALIDATION

                $this->form_validation->set_rules('Username', 'Username', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Password', 'Password', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required|alpha_numeric');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                $validatedRequestPostBody = $this->input->post(); 

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        if ($this->validateAuthToken($AccountAddressHeader,$AuthorizationTokenHeader)) {

                                if ($this->validateClient($AccountAddressHeader,$validatedRequestPostBody['IpAddress'],$validatedRequestPostBody['Device'],$validatedRequestPostBody['Location'])){
                        
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
                                $Username = $validatedRequestPostBody['Username'];
                                $Password = $validatedRequestPostBody['Password'];
                                $IpAddress = $validatedRequestPostBody['IpAddress'];
                                $Device = $validatedRequestPostBody['Device'];
                                $Location = $validatedRequestPostBody['Location'];

                                $validAccount = $this->Login_Model->get_tbl_webaccounts_by_username($Username);
                        
                                if ($validAccount) {
                                        if (password_verify($Password,$validAccount->Password)) {
                                                
                                                $AccountAddress = $validAccount->WebAccounts_Address;
                                                $result = $this->Authorization_Model->initialize_login($AccountAddress,$IpAddress,$Device,$Location);




                                                
// check if account is enabled
// check if a login is detected
// check if has pin code
// chech if record existed in login history for new login   









                                                if ($result && $result === "Successful"){
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
                                                } else if ($result && $result === "OTP Validation") {
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
                                                } else if ($result && $result === "PIN Creation") {
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
                                                                'Parameters' => $parameters,,
                                                                'Message' => 'Success: PIN creation required!'
                                                        ];
                                                } else if ($result && $result === "Access Blocked") {
                                                        $response = [
                                                                'Success' => FALSE,
                                                                'Target' => null,
                                                                'Parameters' => null,
                                                                'Message' => 'Failed: Access to this account is blocked!'
                                                        ];
                                                } else {
                                                        $response = [
                                                                'Success' => FALSE,
                                                                'Target' => null,
                                                                'Parameters' => null,
                                                                'Message' => 'Failed: Authorization Failed!'
                                                        ];
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


        function getAccountCategoryId($AccountAddress) {
                $tbl_webaccounts = $this->login_Model->get_tbl_webaccounts_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        return $tbl_webaccounts->ActorCategory_Id;
                }
                
                $tbl_usersaccount = $this->login_Model->get_tbl_usersaccount_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        return $tbl_usersaccount->ActorCategory_Id;
                }

                $tbl_guardiansaccount = $this->login_Model->get_tbl_guardiansaccount_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        return $tbl_guardiansaccount->ActorCategory_Id;
                }

                return FALSE;
        }

        function validateAuthToken($AccountAddress, $AuthToken) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if (trim($AuthToken) === trim($tbl_authentications->AuthToken)) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        function validateClient($AccountAddress, $IpAddress, $Device, $Location) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if (
                        $tbl_authentications && 
                        trim($IpAddress) === trim($tbl_authentications->IpAddress) &&
                        trim($Device) === trim($tbl_authentications->Device) &&
                        trim($Location) === trim($tbl_authentications->Location)
                ) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        function validateNewClient($AccountAddress, $AuthToken) {

        }



        
}