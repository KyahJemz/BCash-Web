<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
                $this->load->library('Auth/Login/Mobile_Login', NULL, 'Mobile_Login');
                $this->load->library('Auth/Login/OTP_Validation', NULL, 'OTP_Validation');
                $this->load->library('Auth/Login/PIN_Creation', NULL, 'PIN_Creation');
                $this->load->library('Auth/Login/PIN_Validation', NULL, 'PIN_Validation');
                $this->load->library('Auth/Account_Logout', NULL, 'Account_Logout');
        }

        public function Process() {

                $headers = $this->input->request_headers();

                foreach ($headers as $header => $value) {
                        log_message('debug', $header . ': ' . $value);
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $body = file_get_contents('php://input');
                        log_message('debug', 'Request Body: ' . $body);
                }

                $response = null;

                $AuthorizationTokenHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Authorization', TRUE));
                $AccountAddressHeader = $this->Functions_Model->sanitize($this->input->get_request_header('AccountAddress', TRUE));
                $ClientVersionHeader = $this->Functions_Model->sanitize($this->input->get_request_header('ClientVersion', TRUE));
                $IntentHeader = $this->Functions_Model->sanitize($this->input->get_request_header('Intent', TRUE));

                $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
                $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

                $IsMaintenance = $this->Configurations_Model->IsMaintenance();
                if ($IsMaintenance['Success']) {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Response' => $IsMaintenance['Response']
                        ];
                }

                if (!(is_array($requestPostBody))) {
                        $response = [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Response' => 'Invalid HTTPS body parameters!'
                        ];  
                }  else {

                        switch ($IntentHeader) {
                                case 'WebLogin':
                                        $response = $this->Web_Login->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader, $ClientVersionHeader);
                                        break;
                                
                                case 'MobileLogin':
                                        $response = $this->Mobile_Login->Process($requestPostBody, $AuthorizationTokenHeader, $AccountAddressHeader, $ClientVersionHeader);
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
                                        $response = $this->Account_Logout->Process($AuthorizationTokenHeader, $AccountAddressHeader);
                                        break;
                                
                                default:
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Response' => 'No headers!'
                                        ];
                        }   

                        $Maintenance = $this->Configurations_Model->AccountingAccess();
                        if(!$Maintenance['Success']){
                                $response = ['Success' => false,'Target' => 'Login','Parameters' => null,'Response' => $Maintenance['Response']];
                        }
                }

                $data = json_encode($response);
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
}