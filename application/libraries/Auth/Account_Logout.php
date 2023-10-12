<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account_Logout {

        protected $CI;

        public function __construct() {
                $this->CI =& get_instance();
                $this->CI->load->model([
                        'Functions_Model',
                        'Authentications_Model',
                ]);
        }

        function Process($AuthorizationTokenHeader,$AccountAddressHeader){
 
                if (!empty($AuthorizationTokenHeader) && !empty($AccountAddressHeader)) {
                        if ($this->CI->Functions_Model->validateAuthToken($AccountAddressHeader,$AuthorizationTokenHeader)) {
                                $this->CI->Authentications_Model->delete($AccountAddressHeader);
                                $response = ['Success' => TRUE,'Target' => 'Login','Parameters' => null,'Message' => 'Success!']; 
                        } else {
                                $response = ['Success' => FALSE,'Target' => 'Login','Parameters' => null,'Message' => 'Failed, Reason: AuthToken Invalid!']; 
                        }
                } else {
                        $response = ['Success' => FALSE,'Target' => 'Login','Parameters' => null,'Message' => 'Failed, Reason: Logout parameters are empty!'];
                }
                return $response;
        }

        function Logout($Account) {

                if ($Account->ActorCategory_Id === '5' || $Account->ActorCategory_Id === '6') {
                        $this->CI->Authentications_Model->delete($Account->$UsersAccount_Address);;
                } else if ($Account->ActorCategory_Id === '7') {
                        $this->CI->Authentications_Model->delete($Account->$GuardianAccount_Address);
                } else {
                        $this->CI->Authentications_Model->delete($Account->$WebAccounts_Address);
                }

                return ['Success' => TRUE,'Target' => 'Login','Parameters' => null,'Message' => '']; 
        }
}