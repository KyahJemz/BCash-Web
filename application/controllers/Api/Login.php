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

        public function initiateLogin() {

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
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddressHeader);

                if ($tbl_authentications && $tbl_authentications->AuthToken === $AuthorizationTokenHeader) {
                    if (
                        $tbl_authentications->IpAddress === $validatedRequestPostBody['IpAddress'] && 
                        $tbl_authentications->Device === $validatedRequestPostBody['Device'] && 
                        $tbl_authentications->Location === $validatedRequestPostBody['Location']
                    ) {
                        $webactor_category = $this->Authorization_Model->get_webactor_category($AccountAddressHeader);
                        $parameters = [
                            'AccountAddress' => $AccountAddressHeader ,
                            'AuthorizationToken' => $AuthorizationTokenHeader,
                            'Actor' => $webactor_category,
                        ];
                        $response = [
                            'Success' => true,
                            'Target' => $webactor_category,
                            'Parameters' => $parameters,
                            'Message' => 'Re-Login successful'
                        ];
                    } else {
                        $IpAddress = $tbl_authentications->IpAddress;
                        $Device = $tbl_authentications->Device;
                        $Location = $tbl_authentications->Location;
                        $message = 'Re-Login Failed, Reason: The login details provided does not match the current active session of the account. ' .
                            "IpAddress: $IpAddress, Device: $Device, Location: $Location.";

                        $response = [
                            'Success' => false,
                            'Target' => null,
                            'Parameters' => null,
                            'Message' => $message
                        ];
                    }
                } else {
                    $response = [
                        'Success' => false,
                        'Target' => null,
                        'Parameters' => null,
                        'Message' => 'Re-Login Failed, Reason: Invalid token'
                    ];
                }
            } else {
                if ($this->form_validation->run() === FALSE) {
                    $validationErrors = validation_errors();
                    $response = [
                        'Success' => false,
                        'Target' => null,
                        'Parameters' => null,
                        'Message' => 'Login Failed, Reason: The provided parameters does not meet the validation requirements. [' . $validationErrors .']'
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

                                if ($result === "Successful"){
                                    $Actor = $this->Authorization_Model->get_webactor_category($AccountAddress);
                                    $AuthorizationToken = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                                    $parameters = [
                                        'AccountAddress' => $AccountAddress,
                                        'AuthorizationToken' => $AuthorizationToken->AuthToken,
                                        'Actor' => $Actor,
                                    ];
                                    $response = [
                                        'Success' => true,
                                        'Target' => 'pin',
                                        'Parameters' => $parameters,
                                        'Message' => 'Re-Login successful'
                                    ];
                                } else if ($result === "OTP Required") {
                                        $this->switchControler("login");
                                } else if ($result === "Access Blocked") {
                                        $this->switchControler("login");
                                } else if ($result === "Failed") {
                                        $this->switchControler("login");
                                } 

                        } else {
                                redirect('login');
                                echo ("wrong pass");
                        }
                    } else {
                            redirect('login');
                            echo ("no accounts");
                    }



                }
            }





            // Check if the headers are present
            if (!empty($authorizationToken) && !empty($authenticated)) {

        
                if ($authenticated) {
                    // User authentication successful
                    $response = [
                        'success' => true,
                        'message' => 'Login successful',
                    ];
                } else {
                    // User authentication failed
                    $response = [
                        'success' => false,
                        'message' => 'Login failed',
                    ];
                }
            } else {
                // Authorization header is missing
                $response = [
                    'success' => false,
                    'message' => 'Authorization header missing',
                ];
            }
        
            // Return the response as JSON
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }


        





















        function displayAlert($type, $text) {
                $jsImport = base_url('assets/javascript/modules/alerts.js');
                echo "<script type='module'>
                    import { createAlert } from '{$jsImport}';
                    createAlert('{$type}', '{$text}');
                </script>";
        }

        
        function validate_client(){
                $IpAddress = $_SERVER['REMOTE_ADDR'];
                $Device = $_SERVER['HTTP_USER_AGENT'];
                $Location = "Unknown";

                $pattern = '/\((.*?)\)/';
                if (preg_match($pattern, $Device, $matches)) {
                        $Device = $matches[1];
                } else {
                        $Device = "Unknown";
                }

                $this->session->set_userdata('IpAddress', $IpAddress);
                $this->session->set_userdata('Device', $Device);
                $this->session->set_userdata('Location', $Location);
        }

        function is_account_active ($Account_Address) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($Account_Address);
                if ($tbl_authentications){
                        if ($tbl_authentications->IsOnline === 1) {
                                return TRUE;
                            } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function is_account_same_user ($Account_Address) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($Account_Address);
                if ($tbl_authentications) {
                        if (
                                $this->session->userdata('IpAddress') === $tbl_authentications->IpAddress && 
                                $this->session->userdata('Device') === $tbl_authentications->Device && 
                                $this->session->userdata('Location') === $tbl_authentications->Location
                        ) {
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function is_account_enabled ($Account_Address) {
                $tbl_webaccounts = $this->Login_Model->get_tbl_webaccounts_by_address($Account_Address);
                if ($tbl_webaccounts) {
                        if ($tbl_webaccounts->IsAccountActive === '1'){
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function check_user() {
                $this->validate_client();
                if ($this->session->userdata('Account_Address')) {
                        $accountAddress = $this->session->userdata('Account_Address');

                        $isEnabled = $this->is_account_enabled($accountAddress);
                        if ($isEnabled) {

                                $isActive = $this->is_account_active($accountAddress);
                                if ($isActive) {

                                        $isSameUser = $this->is_account_same_user($accountAddress);
                                        if($isSameUser){
                                                $this->switchControler($accountAddress);
                                        } else {
                                                $this->displayAlert("warning","Online in other device, Please logout!");
                                                return "Online in other account";
                                        }
                                } else {
                                        return "no online";
                                }
                        } else {
                                $this->displayAlert("danger","errrrrr");
                                return "not Enabled";
                        }
                } else {
                        return "no  session";
                }
        }




        public function logout() {
       
        }
}