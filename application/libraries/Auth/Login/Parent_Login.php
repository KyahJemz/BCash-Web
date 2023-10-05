<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parent_Login {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
    }

    public function ParentLogin($requestPostBody,$AuthorizationTokenHeader,$AccountAddressHeader, $ClientVersionHeader){
                
        $Version = $this->Configurations_Model->ValidateMobileVersion($ClientVersionHeader);
        if (!($Version[0])){
                $response = [
                        'Success' => FALSE,
                        'Target' => 'WebLogin',
                        'Parameters' => null,
                        'Message' => $Version[1]
                ];   
                return $response;
        }

        // return $response;
    }

}