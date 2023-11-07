<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guardian_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
        $this->CI->load->library('Auth/Account_Logout', NULL, 'Account_Logout');
        $this->CI->load->library('Actions/Account_Logout', NULL, 'Account_Logout');
        $this->CI->load->library('Actions/Account_Actions', NULL, 'Account_Actions');
        $this->CI->load->library('Actions/Notifications_Actions', NULL, 'Notifications_Actions');
        $this->CI->load->library('Actions/LoginHistory_Actions', NULL, 'LoginHistory_Actions');
        $this->CI->load->library('Actions/ActivityLogs_Actions', NULL, 'ActivityLogs_Actions');
        $this->CI->load->library('Actions/Transaction_Actions', NULL, 'Transaction_Actions');
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {
            case 'Logout':
                $response = $this->CI->Account_Logout->Logout($Account);
                break;

            case 'get my notifications':
                $response = $this->CI->Notifications_Actions->View_My_Notifications();
                break;

            case 'get my account':
                $response = $this->CI->Account_Actions->View_My_Account_Details($Account);
                break;

            case 'get other account':
                $response = $this->CI->Account_Actions->View_User_Account_By_SPID($Account, $requestPostBody);
                break;

            case 'initiate transfer':
                $response = $this->CI->Transaction_Actions->Transfer_Cash($Account, $AccountData, $requestPostBody);
                break;

            case 'get receipt':
                $response = $this->CI->Transaction_Actions->View_My_Receipt($Account, $AccountData, $requestPostBody);
                break;

            case 'update my pin':
                $response = $this->CI->Account_Actions->Update_My_PinCode($Account, $requestPostBody);
                break;

            case 'get recent transactions':
                $response = $this->CI->Transaction_Actions->View_My_Recent_Transactions($Account, 10);
                break;

            case 'get all transactions':
                $response = $this->CI->Transaction_Actions->View_My_Recent_Transactions($Account, 100);
                break;

            case 'get my activity logs':
                $response = $this->CI->ActivityLogs_Actions->View_My_ActivityLogs($Account, $requestPostBody);
                break;
                
            case 'get my login history':
                $response = $this->CI->LoginHistory_Actions->View_My_LoginHistory($Account);
                break;

            case 'delete one login history':
                $response = $this->CI->LoginHistory_Actions->Clear_One_My_LoginHistory($Account, $requestPostBody);
                break;

            case 'delete all login history':
                $response = $this->CI->LoginHistory_Actions->Clear_All_My_LoginHistory($Account);
                break;

            case 'update my settings':
                $response = $this->CI->Account_Actions->Update_My_Details($Account, $requestPostBody);
                break;
                
            default:
                $response = ['Success' => FALSE, 'Response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }
}