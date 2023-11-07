<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('UsersData_Model');
        $this->CI->load->library('form_validation');
        $this->CI->load->library('Auth/Account_Logout', NULL, 'Account_Logout');
        $this->CI->load->library('Actions/Account_Logout', NULL, 'Account_Logout');
        $this->CI->load->library('Actions/Account_Actions', NULL, 'Account_Actions');
        $this->CI->load->library('Actions/Notifications_Actions', NULL, 'Notifications_Actions');
        $this->CI->load->library('Actions/LoginHistory_Actions', NULL, 'LoginHistory_Actions');
        $this->CI->load->library('Actions/ActivityLogs_Actions', NULL, 'ActivityLogs_Actions');
        $this->CI->load->library('Actions/Transaction_Actions', NULL, 'Transaction_Actions');
        $this->CI->load->library('Actions/Whitelist_Actions', NULL, 'Whitelist_Actions');
        $this->CI->load->library('Actions/Order_Actions', NULL, 'Order_Actions');
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {

        $AccountData = $this->CI->UsersData_Model->read_by_address(array('Account_Address'=>$Account->UsersAccount_Address));

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

            case 'get my whitelist':
                $response = $this->CI->Whitelist_Actions->View_My_Whitelist($Account);
                break;

            case 'remove one from whitelist':
                $response = $this->CI->Whitelist_Actions->Remove_From_Whitelist($Account, $requestPostBody);
                break;
    
            case 'add one to whitelist':
                $response = $this->CI->Whitelist_Actions->Add_To_Whitelist($Account, $requestPostBody);
                break;

            case 'update my settings':
                $response = $this->CI->Account_Actions->Update_My_Details($Account, $requestPostBody);
                break;

            case 'QRscan for purchase':
                $response = $this->CI->Order_Actions->Update_Event($Account, $requestPostBody);
                break;


            case 'scan for purchases':
                $response = $this->CI->Order_Actions->Get_Pending_Purchase($Account, $requestPostBody);
                break;

            case 'set purchase cancel':
                $response = $this->CI->Order_Actions->Set_Purchase_Cancel($Account, $requestPostBody);
                break;

            case 'set purchase approved':
                $response = $this->CI->Order_Actions->Set_Purchase_Approved($Account, $requestPostBody);
                break;

            default:
                $response = ['Success' => FALSE, 'Response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }
}