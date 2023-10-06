<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MerchantStaff_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {
            case 'xxx':
                $response = null;
                break;

                
            default:
                $response = ['success' => FALSE, 'response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }
}