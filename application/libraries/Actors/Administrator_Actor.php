<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
        $this->CI->load->library('Auth/Account_Logout', NULL, 'Account_Logout');
        $this->CI->load->library('Actions/Transaction_Actions', NULL, 'Transaction_Actions');
        $this->CI->load->library('Actions/Account_Actions', NULL, 'Account_Actions');
        $this->CI->load->library('Actions/Notifications_Actions', NULL, 'Notifications_Actions');
        $this->CI->load->library('Actions/LoginHistory_Actions', NULL, 'LoginHistory_Actions');
        $this->CI->load->library('Actions/ActivityLogs_Actions', NULL, 'ActivityLogs_Actions');
        $this->CI->load->library('Actions/Remittance_Actions', NULL, 'Remittance_Actions');
        $this->CI->load->library('Actions/Chart_Actions', NULL, 'Chart_Actions');
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {

            case 'Logout':
                $response = $this->CI->Account_Logout->Logout($Account);
                break;

            case 'get chart data':
                $response = null;
                // $response = $this->CI->Chart_Actions->View_Accounting_Charts();
                break;

            case 'get my notifications':
                $response = $this->CI->Notifications_Actions->View_My_Notifications();
                break;

            case 'get my notifications details':
                $response = $this->CI->Notifications_Actions->View_My_Notifications_Details($requestPostBody);
                break;

            case 'get my account':
                $response = $this->CI->Account_Actions->View_My_Account_Details($Account);
                break;

            case 'update my pin':
                $response = $this->CI->Account_Actions->Update_My_PinCode($Account, $requestPostBody);
                break;

            case 'update my password':
                $response = $this->CI->Account_Actions->Update_My_Password($Account, $requestPostBody);
                break;

            case 'get all activity logs':
                $response = $this->CI->ActivityLogs_Actions->View_All_ActivityLogs($Account);
                break;

            case 'get my activity logs':
                $response = $this->CI->ActivityLogs_Actions->View_My_ActivityLogs($Account, $requestPostBody);
                break;

            case 'get login history':
                $response = $this->CI->LoginHistory_Actions->View_My_LoginHistory($Account);
                break;

            case 'update login history':
                $response = $this->CI->LoginHistory_Actions->Update_My_LoginHistory($Account, $requestPostBody);
                break;

            case 'delete one login history':
                $response = $this->CI->LoginHistory_Actions->Clear_One_My_LoginHistory($Account, $requestPostBody);
                break;

            case 'delete all login history':
                $response = $this->CI->LoginHistory_Actions->Clear_My_LoginHistory($Account);
                break;

            case 'get all transactions':
                $response = $this->CI->Transaction_Actions->Admin_Accounting_View_All_Transaction_History ($Account, $requestPostBody, 'all');
                break;

            case 'get transactions details':
                $response = $this->CI->Transaction_Actions->Admin_Accounting_View_All_Transaction_History_Details ($Account, $requestPostBody);
                break;

            case 'get user details':
                $response =  $this->CI->Account_Actions->View_User_Account($Account, $requestPostBody);
                break;

            case 'update user details': 
                $response =  $this->CI->Account_Actions->Update_User_Account_By_Accounting($Account, $requestPostBody);
                break;

            case 'get user accounts':
                $response =  $this->CI->Account_Actions->View_User_Accounts($Account, $requestPostBody);
                break;

            case 'get guardian accounts':
                $response =  $this->CI->Account_Actions->View_Guardian_Accounts($Account, $requestPostBody);
                break;

            case 'get merchant accounts':
                $response =  $this->CI->Account_Actions->View_Merchant_Accounts($Account, $requestPostBody);
                break;

            case 'get merchantstaff accounts':
                $response =  $this->CI->Account_Actions->View_MerchantStaff_Accounts($Account, $requestPostBody);
                break;

            case 'get accounting accounts':
                $response =  $this->CI->Account_Actions->View_Accounting_Accounts($Account, $requestPostBody);
                break;

            case 'get administrator accounts':
                $response =  $this->CI->Account_Actions->View_Administrator_Accounts($Account, $requestPostBody);
                break;

            case 'update account':
                $response =  $this->CI->Account_Actions->Update_Account_By_ADM($Account, $requestPostBody);
                break;


    






            default:
                $response = ['Success' => FALSE, 'Response' => 'Invalid Intent or Not Permittedsssssssss']; 
                break;
        }
        return $response;
    }
}