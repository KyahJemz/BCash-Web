<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {
            case 'View Transactions History':
                $response = null;
                break;

            case 'View Accounts':
                $response = null;
                break;

            case 'Update Account':
                $response = null;
                break;

            case 'View Settings':
                $response = null;
                break;

            case 'Update Settings':
                $response = null;
                break;

            case 'View Notifications':
                $response = null;
                break;

            case 'View Activity Logs':
                $response = null;
                break;

            case 'View Login History':
                $response = null;
                break;

            case 'Update Login History':
                $response = null;
                break;

            case 'Clear Login History':
                $response = null;
                break;

            case 'View Charts':
                $response = null;
                break;

            case 'Make CashIn':
                $response = null;
                break;

            case 'View CashIn':
                $response = null;
                break;

            case 'View Receiver Details':
                $response = null;
                break;

            case 'View Fund Remittance':
                $response = null;
                break;

            case 'View Specific Fund Remittance':
                $response = null;
                break;

            case 'Update Specific Fund Remittance':
                $response = null;
                break;

            case 'Logout':
                $response = null;
                break;
                
            default:
                $response = ['success' => FALSE, 'response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }
}