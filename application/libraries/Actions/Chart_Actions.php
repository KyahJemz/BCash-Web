<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Charts_Model',
                     'Functions_Model',
              ]);
       }



/* 
-- ---------------------
   VIEW ACCOUNTING CHARTS
   - accounting
-- ---------------------
*/  
       public function View_Accounting_Charts() {

              $TotalCashIn = $this->CI->Charts_Model->TotalCashIn();

              $TotalOrdersInMerchants = $this->CI->Charts_Model->TotalOrdersInMerchants();

              $TotalSalesInMerchants = $this->CI->Charts_Model->TotalSalesInMerchants();

              $TotalTransactions = $this->CI->Charts_Model->TotalTransactions();

              $DailyTransactions = $this->CI->Charts_Model->DailyTransactions();

              $CirculatingMoney = $this->CI->Charts_Model->CirculatingMoney();

              $RecentTransactions = $this->CI->Charts_Model->RecentTransactions();

              $RecentCashIn = $this->CI->Charts_Model->RecentCashIn();

              $RecentActivities = $this->CI->Charts_Model->RecentActivities();

              $CurrentTime = $this->CI->Functions_Model->get_current_timestamp();
              
              $Parameters = [
                     'TotalCashIn' => $TotalCashIn,
                     'TotalOrdersInMerchants' => $TotalOrdersInMerchants,
                     'TotalSalesInMerchants' => $TotalSalesInMerchants,
                     'TotalTransactions' => $TotalTransactions,
                     'DailyTransactions' => $DailyTransactions,
                     'CirculatingMoney' => $CirculatingMoney,
                     'RecentTransactions' => $RecentTransactions,
                     'RecentCashIn' => $RecentCashIn,
                     'RecentActivities' => $RecentActivities,
                     'CurrentTime' => $CurrentTime,
              ];

            return ['Success' => True,'Target' => null,'Parameters' => $Parameters,'Response' => ''];
       }


       
/* 
-- ---------------------
   VIEW ADMINISTRATOR CHARTS
   - administrator
-- ---------------------
*/  

       public function View_Administrator_Charts() {

              $TotalCashInsPerHour = $this->CI->Charts_Model->TotalCashInsPerHour();

              $TotalTransfersPerHour = $this->CI->Charts_Model->TotalTransfersPerHour();

              $TotalPurchasesPerHour = $this->CI->Charts_Model->TotalPurchasesPerHour();

              $EveryHourTransactions = $this->CI->Charts_Model->EveryHourTransactions();

              $NumberOfActors = $this->CI->Charts_Model->NumberOfActors();

              $RecentAdminActivities = $this->CI->Charts_Model->RecentAdminActivities();

              $RecentAccountingMerchantActivities = $this->CI->Charts_Model->RecentAccountingMerchantActivities();

              $RecentUsersActivities = $this->CI->Charts_Model->RecentUsersActivities();

              $CurrentTime = $this->CI->Functions_Model->get_current_timestamp();
              
              $Parameters = [
                     'TotalCashInsPerHour' => $TotalCashInsPerHour,
                     'TotalTransfersPerHour' => $TotalTransfersPerHour,
                     'TotalPurchasesPerHour' => $TotalPurchasesPerHour,
                     'EveryHourTransactions' => $EveryHourTransactions,
                     'NumberOfActors' => $NumberOfActors,
                     'RecentAdminActivities' => $RecentAdminActivities,
                     'RecentAccountingMerchantActivities' => $RecentAccountingMerchantActivities,
                     'RecentUsersActivities' => $RecentUsersActivities,
                     'CurrentTime' => $CurrentTime,
              ];

            return ['Success' => True,'Target' => null,'Parameters' => $Parameters,'Response' => ''];
       }



/* 
-- ---------------------
   VIEW MERCHANT ADMIN CHARTS
   - merchant admin
-- ---------------------
*/  
public function View_MerchantAdmin_Charts($Account) {

       $TotalOrdersPerHour = $this->CI->Charts_Model->TotalOrdersPerHour($Account->WebAccounts_Address);

       $TotalSalesPerHour = $this->CI->Charts_Model->TotalSalesPerHour($Account->WebAccounts_Address);

       $EveryDayTotalSales = $this->CI->Charts_Model->EveryDayTotalSales($Account->WebAccounts_Address);

       $TopItems = $this->CI->Charts_Model->TopItems($Account->WebAccounts_Address);

       $RecentMerchantActivities = $this->CI->Charts_Model->RecentMerchantActivities($Account->WebAccounts_Address);

       $RecentPurchases = $this->CI->Charts_Model->RecentPurchases($Account->WebAccounts_Address);

       $CurrentTime = $this->CI->Functions_Model->get_current_timestamp();
       
       $Parameters = [
              'TotalOrdersPerHour' => $TotalOrdersPerHour,
              'TotalSalesPerHour' => $TotalSalesPerHour,
              'EveryDayTotalSales' => $EveryDayTotalSales,
              'TopItems' => $TopItems,
              'RecentMerchantActivities' => $RecentMerchantActivities,
              'RecentPurchases' => $RecentPurchases,
              'CurrentTime' => $CurrentTime,
       ];

     return ['Success' => True,'Target' => null,'Parameters' => $Parameters,'Response' => ''];
}
}