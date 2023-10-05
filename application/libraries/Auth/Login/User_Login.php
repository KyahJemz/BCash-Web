<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Login {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
        $this->CI->load->model('UsersAccount_Model');
    }

    public function Process($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader,$ClientVersionHeader){


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
}