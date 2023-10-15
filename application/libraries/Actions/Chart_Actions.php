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


}