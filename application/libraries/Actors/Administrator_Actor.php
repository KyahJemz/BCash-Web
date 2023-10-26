<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator_Actor {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
        $this->CI->load->model([
            'Merchants_Model',
            'ActorCategory_Model',
        ]);
        $this->CI->load->library('Auth/Account_Logout', NULL, 'Account_Logout');
        $this->CI->load->library('Actions/Transaction_Actions', NULL, 'Transaction_Actions');
        $this->CI->load->library('Actions/Account_Actions', NULL, 'Account_Actions');
        $this->CI->load->library('Actions/Notifications_Actions', NULL, 'Notifications_Actions');
        $this->CI->load->library('Actions/LoginHistory_Actions', NULL, 'LoginHistory_Actions');
        $this->CI->load->library('Actions/ActivityLogs_Actions', NULL, 'ActivityLogs_Actions');
        $this->CI->load->library('Actions/Remittance_Actions', NULL, 'Remittance_Actions');
        $this->CI->load->library('Actions/Chart_Actions', NULL, 'Chart_Actions');
        $this->CI->load->library('Actions/Cards_Actions', NULL, 'Cards_Actions');
        $this->CI->load->library('Actions/Configuration_Actions', NULL, 'Configuration_Actions');
    }

    public function Process ($Account, $ActorCategory, $Intent, $requestPostBody) {
        switch ($Intent) {


// Logout
            case 'Logout':
                $response = $this->CI->Account_Logout->Logout($Account);
                break;


// Charts
            case 'get chart data':
                $response = null;
                // $response = $this->CI->Chart_Actions->View_Accounting_Charts();
                break;


// Notifications
            case 'get my notifications':
                $response = $this->CI->Notifications_Actions->View_My_Notifications();
                break;

            case 'get my notifications details':
                $response = $this->CI->Notifications_Actions->View_My_Notifications_Details($requestPostBody);
                break;

            case 'add notification':
                $response = $this->CI->Notifications_Actions->Add_Notifications($Account,$requestPostBody);
                break;

            case 'delete notification':
                $response = $this->CI->Notifications_Actions->Delete_Notifications($Account,$requestPostBody);
                break;
                

// My Accounts
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


// Activity Logs
            case 'get all activity logs':
                $response = $this->CI->ActivityLogs_Actions->View_All_ActivityLogs($Account);
                break;

            case 'get my activity logs':
                $response = $this->CI->ActivityLogs_Actions->View_My_ActivityLogs($Account, $requestPostBody);
                break;



// Login History
            case 'get login history':
                $response = $this->CI->LoginHistory_Actions->View_My_LoginHistory($Account);
                break;

            case 'delete one login history':
                $response = $this->CI->LoginHistory_Actions->Clear_One_My_LoginHistory($Account, $requestPostBody);
                break;

            case 'delete all login history':
                $response = $this->CI->LoginHistory_Actions->Clear_All_My_LoginHistory($Account);
                break;

    
// Transactions
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


// Accounts  
            case 'get account category list':
                $response =  ['Success' => True, 'Parameters'=>$this->CI->ActorCategory_Model->read_accountcategory(), 'Target'=>null, 'Response'=>null];
                break;

            case 'get merchant category list':
                $response =  ['Success' => True, 'Parameters'=>$this->CI->Merchants_Model->read_merchantcategory(array('Campus_Id' => $Account->Campus_Id)), 'Target'=>null, 'Response'=>null];
                break;

            case 'add account':
                $response =  $this->CI->Account_Actions->Add_Account_By_ADM($Account, $requestPostBody);
                break;


// Cards
            case 'get cards':
                $response =  $this->CI->Cards_Actions->View_Cards($Account, $requestPostBody);
                break;

            case 'add card':
                $response =  $this->CI->Cards_Actions->Add_Card($Account, $requestPostBody);
                break;

            case 'update card':
                $response =  $this->CI->Cards_Actions->Update_Card($Account,$requestPostBody);
                break;


// Configurations

            case 'update configurations':
                $response =  $this->CI->Configuration_Actions->Update_Configurations($Account,$requestPostBody);
                break;

            case 'get configuration':
                $response =  $this->CI->Configuration_Actions->View_Configurations();
                break;



    






            default:
                $response = ['Success' => FALSE, 'Response' => 'Invalid Intent or Not Permittedsssssssss']; 
                break;
        }
        return $response;
    }
}