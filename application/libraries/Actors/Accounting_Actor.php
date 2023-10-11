<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guest_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('Actions/Transaction_Actions', NULL, 'Transaction_Actions');
        $this->CI->load->library('Actions/Account_Actions', NULL, 'Account_Actions');
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {

            case 'get my account details':
                $response = $this->CI->Account_Actions->View_My_Account_Details($Account);
                break;

            case 'get chart data':
                $response = null;
                break;

            case 'get top recent cash in':
                $response = null;
                break;

            case 'initiate cash in':
                $response = $this->CI->Transaction_Actions->Cash_In($Account, $requestPostBody);
                break;

            case 'get my transactions':
                $response = null;
                break;

            case 'get user transactions':
                $response = null;
                break;

            case 'get user accounts':
                $response = null;
                break;

            case 'update users accounts':
                $response = null;
                break;

            case 'get user details':
                $response = null;
                break;

            case 'get my notifications':
                $response = null;
                break;

            case 'get my settings':
                $response = $this->CI->Account_Actions->View_My_Account_Details($Account);
                break;

            case 'update my pin':
                $response = $this->CI->Account_Actions->Update_My_PinCode($Account, $requestPostBody);
                break;

            case 'update my password':
                $response = $this->CI->Account_Actions->Update_My_Password($Account, $requestPostBody);
                break;

            case 'get activity logs':
                $response = null;
                break;

            case 'get activity log details':
                $response = null;
                break;

            case 'get login history':
                $response = null;
                break;

            case 'update login history':
                $response = null;
                break;

            case 'clear login history':
                $response = null;
                break;

            case 'get top remittance':
                $response = null;
                break;

            case 'get remittance details':
                $response = null;
                break;

            case 'get todays total':
                $response = null;
                break;

            case 'initiate remittance':
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