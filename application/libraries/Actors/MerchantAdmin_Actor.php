<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MerchantAdmin_Actor {

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
        $this->CI->load->library('Actions/Items_Actions', NULL, 'Items_Actions');
        $this->CI->load->library('Actions/Remittance_Actions', NULL, 'Remittance_Actions');
        $this->CI->load->library('Actions/Order_Actions', NULL, 'Order_Actions');
    }
    
    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {

            case 'Logout':
                $response = $this->CI->Account_Logout->Logout($Account);
                break;

            case 'get chart data':
                $response = $this->CI->Chart_Actions->View_MerchantAdmin_Charts($Account);
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

            case 'update my account':
                $response = $this->CI->Account_Actions->Update_My_Account($Account, $requestPostBody);
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

            case 'delete one login history':
                $response = $this->CI->LoginHistory_Actions->Clear_One_My_LoginHistory($Account, $requestPostBody);
                break;

            case 'delete all login history':
                $response = $this->CI->LoginHistory_Actions->Clear_All_My_LoginHistory($Account);
                break;

            case 'get my transactions':
                $response = $this->CI->Transaction_Actions->Merchant_View_All_Transaction_History ($Account, $requestPostBody);
                break;

            case 'get transactions details':
                $response = $this->CI->Transaction_Actions->Admin_Accounting_View_All_Transaction_History_Details ($Account, $requestPostBody);
                break;

            case 'add item':
                $response = $this->CI->Items_Actions->Add_Item($Account, $requestPostBody);
                break;

            case 'update item':
                $response = $this->CI->Items_Actions->Update_Item($Account, $requestPostBody);;
                break;

            case 'deactivate item':
                $response = $this->CI->Items_Actions->Deactivate_Item($Account, $requestPostBody);
                break;

            case 'get items':
                $response = $this->CI->Items_Actions->Get_Items($Account);
                break;

            case 'set order event':
                $response = $this->CI->Order_Actions->Set_Event($Account);
                break;

            case 'listen order event':
                $response = $this->CI->Order_Actions->Listen_Event($Account,$requestPostBody);
                break;

            case 'post order':
                $response = $this->CI->Transaction_Actions->Create_Order($Account, $requestPostBody);
                break;

            case 'get merchantstaff accounts':
                $response =  $this->CI->Account_Actions->View_MerchantStaff_Accounts($Account, $requestPostBody);
                break;

            case 'update staff account':
                $response =  $this->CI->Account_Actions->Update_Account_By_MTA($Account, $requestPostBody);
                break;
                
            case 'get my remittance':
                $response = $this->CI->Remittance_Actions->View_My_Remittance($Account);
                break;

            case 'get remittance details':
                $response = $this->CI->Remittance_Actions->View_Remittance_Details($Account, $requestPostBody);
                break;

            case 'get remaining remittance':
                $response = $this->CI->Remittance_Actions->View_My_Remaining_Remittance($Account);
                break;
                
            case 'Upload remittance':
                $response = $this->CI->Remittance_Actions->Upload_My_Remittance($Account);
                break;

            case 'get staff accounts':
                $response = $this->CI->Account_Actions->View_My_Staffs($Account, $requestPostBody);
                break;

            case 'listen confirmation event':
                $response = $this->CI->Order_Actions->Listen_Confirmation_Event($requestPostBody);
                break;

            default:
                $response = ['success' => FALSE, 'response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }

}