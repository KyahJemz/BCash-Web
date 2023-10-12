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
                $this->load->library('Auth/Account_Logout', NULL, 'Account_Logout');
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
                                    $response = $this->Account_Logout->Process($AuthorizationTokenHeader, $AccountAddressHeader);
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
}