<?php
defined('BASEPATH') or exit('No direct script access allowed');

// composer require guzzlehttp/guzzle
// use GuzzleHttp\Client;

class User_Login {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->library('form_validation');
                $this->CI->load->model([
                        'Functions_Model',
                        'UsersAccount_Model', 
                        'UsersData_Model',
                ]);
                $this->CI->load->library('Auth/Verification', NULL, 'Verification');
                $this->CI->load->database();
        }

        public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){

                $this->CI->form_validation->set_data($requestPostBody);
                
                // $this->CI->form_validation->set_rules('GoogleId', 'GoogleId', 'trim|required|alpha_numeric');
                // $this->CI->form_validation->set_rules('GoogleEmail', 'GoogleEmail', 'trim|required|alpha_numeric');
                // $this->CI->form_validation->set_rules('GoogleFirstName', 'GoogleFirstName', 'trim|required|alpha_numeric');
                // $this->CI->form_validation->set_rules('GoogleLastName', 'GoogleLastName', 'trim|required|alpha_numeric');
                $this->CI->form_validation->set_rules('GoogleToken', 'GoogleToken', 'trim|required|alpha_numeric');
                $this->CI->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required|valid_ip');
                $this->CI->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->CI->form_validation->set_rules('Location', 'Location', 'trim|required|alpha_numeric');

                // $validatedGoogleId = $requestPostBody['GoogleId'];
                // $validatedGoogleEmail = $requestPostBody['GoogleEmail'];
                // $validatedGoogleFirstName = $requestPostBody['GoogleFirstName'];
                // $validatedGoogleLastName = $requestPostBody['GoogleLastName'];
                $validatedGoogleToken = $requestPostBody['GoogleToken'];
                $validatedIpAddress = $requestPostBody['IpAddress'];
                $validatedDevice = $requestPostBody['Device'];
                $validatedLocation = $requestPostBody['Location'];

                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {

                        $response = $this->CI->Verification->Process($AccountAddressHeader, $AuthorizationTokenHeader, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                } else {
                        if ($this->CI->form_validation->run() === FALSE) {
                                $validationErrors = validation_errors();
                                $response = [
                                        'Success' => False,
                                        'Target' => 'Login',
                                        'Parameters' => null,
                                        'Message' => ''. $validationErrors
                                ];
                        } else {


                                $client = new Client();
                                $response = $client->post('https://www.googleapis.com/oauth2/v3/tokeninfo', 
                                        ['form_params' => ['id_token' => $token]]
                                );

                                $body = json_decode($response->getBody(), true);  // Parse the response JSON

                                if (!isset($body['error'])) {

                                        $validatedGoogleEmail = $body['email'];
                                        $validatedGoogleFirstName = $body['given_name'];
                                        $validatedGoogleLastName = $body['family_name'];

                                        $validAccount = $this->CI->UsersAccount_Model->read_by_Email($validatedGoogleEmail);

                                        if (!$validAccount) {
                                                try {

                                                        $UsersAccount_Address = $this->CI->Functions_Model->create_unique_address();

                                                        $this->CI->db->trans_start();

                                                                $this->UsersAccount_Model->create(array(
                                                                        'Account_Address' => $UsersAccount_Address,
                                                                        'ActorCategory_Id' => '5',
                                                                        'Email ' => $validatedGoogleEmail,
                                                                        'Firstname ' => $validatedGoogleFirstName,
                                                                        'Lastname ' => $validatedGoogleLastName,
                                                                        'Campus_Id ' => '1',
                                                                        'Password' => null,
                                                                ));

                                                                $this->UsersData_Model->create($UsersAccount_Address);

                                                        $this->CI->db->trans_complete();

                                                        if ($this->CI->db->trans_status() === FALSE) {
                                                                $this->CI->db->trans_rollback();
                                                                $response = [
                                                                        'Success' => False,
                                                                        'Target' => 'Login',
                                                                        'Parameters' => null,
                                                                        'Message' => 'Error during registering your account!'
                                                                ];
                                                        } else {
                                                                // Continue
                                                        }
                                                } catch (Exception $e) {
                                                        $this->CI->db->trans_rollback();
                                                        $response = [
                                                                'Success' => False,
                                                                'Target' => 'Login',
                                                                'Parameters' => null,
                                                                'Message' => 'Database Error! ' + $e
                                                        ];   
                                                }
                                        } 

                                        $AccountAddress = $validAccount->UsersAccount_Address;

                                        $response = $this->CI->Verification->Process($AccountAddress, null, $validatedIpAddress, $validatedDevice, $validatedLocation, null);

                                } else {
                                        $response = [
                                                'Success' => False,
                                                'Target' => 'Login',
                                                'Parameters' => null,
                                                'Message' => 'Invalid Token! ' + $body['error']
                                        ];   
                                }
                        }
                }
                return $response;
        }
}