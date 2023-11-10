<?php
class Charts_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

// ACCOUNTING 
    public function TotalCashIn(){
        $hourlyDebitCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, SUM(Debit) as TotalDebit')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->where('Account_Address LIKE', 'ACT%')
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();
    
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalDebit = $row->TotalDebit;
                $hourlyDebitCounts[$hour] = $totalDebit;
            }
        }
        return $hourlyDebitCounts;
    } 
    public function TotalOrdersInMerchants(){
        $TotalOrdersInMerchants = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Credit) as TotalCount')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->where('Account_Address LIKE', 'MTA%')
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();
    
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $total = $row->TotalCount;
                $TotalOrdersInMerchants[$hour] = $total;
            }
        }
        return $TotalOrdersInMerchants;
    } 
    public function TotalSalesInMerchants(){
        $TotalSalesInMerchants = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, SUM(Credit) as TotalSum')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->where('Account_Address LIKE', 'MTA%')
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();
    
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $total = $row->TotalSum;
                $TotalSalesInMerchants[$hour] = $total;
            }
        }
        return $TotalSalesInMerchants;
    } 
    public function TotalTransactions() {
        $TotalTransactions = array_fill(0, 24, 0);

        $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Credit) as TotalCount')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->group_start()
                ->like('Account_Address', 'USR', 'after')
                ->or_like('Account_Address', 'GST', 'after')
            ->group_end()
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $total = $row->TotalCount;
                $TotalTransactions[$hour] = $total;
            }
        }
        return $TotalTransactions;
    }
    public function DailyTransactions() {
        $CashIn = array_fill(0, 7, 0);
        $CashOut = array_fill(0, 7, 0);

    
        // Get the current timestamp
        $currentTimestamp = date('Y-m-d H:i:s');
    
        if ($currentTimestamp) {
            $this->db->select('DATE(Timestamp) as Date, SUM(Debit) as TotalDebit');
            $this->db->where('Account_Address LIKE', 'ACT%');
            $this->db->where("DATE(Timestamp) >= DATE_SUB('$currentTimestamp', INTERVAL 6 DAY)", null, false);
            $this->db->where('Status', 'Completed');
            $this->db->group_by('DATE(Timestamp)');
            $queryCashIn = $this->db->get('tbl_transactions');
            $CashInResults = $queryCashIn->result();

            foreach ($CashInResults as $result) {
                $date = new DateTime($result->Date);
                $dayIndex = 6 - intval($date->diff(new DateTime())->format('%a'));
                $CashIn[$dayIndex] = $result->TotalDebit;
            }

            $this->db->select('DATE(Timestamp) as Date, SUM(TotalAmount) as TotalAmount');
            $this->db->where("DATE(Timestamp) >= DATE_SUB('$currentTimestamp', INTERVAL 6 DAY)", null, false);
            $this->db->where('Status', 'Approved');
            $this->db->group_by('DATE(Timestamp)');
            $queryCashOut = $this->db->get('tbl_remittance');
            $CashOutResults = $queryCashOut->result();

            foreach ($CashOutResults as $result) {
                $date = new DateTime($result->Date);
                $dayIndex = 6 - intval($date->diff(new DateTime())->format('%a'));
                $CashOut[$dayIndex] = $result->TotalAmount;
            }
    
            return ['CashIn' => $CashIn, 'CashOut' => $CashOut];
        } else {
            return ['CashIn' => [], 'CashOut' => []];
        }
    
        
    }  
    public function CirculatingMoney(){
        $UsersTotal = $this->db
            ->select('SUM(Credit) - SUM(Debit) as TotalCash')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->like('Account_Address', 'USR', 'after')
            ->get()
            ->row()
            ->TotalCash;

        $GuestsTotal = $this->db
            ->select('SUM(Credit) - SUM(Debit) as TotalCash')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->like('Account_Address', 'GST', 'after')
            ->get()
            ->row()
            ->TotalCash;

        $MerchantsTotal = $this->db
            ->select('SUM(Credit) - SUM(Debit) as TotalCash')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->like('Account_Address', 'MTA', 'after')
            ->get()
            ->row()
            ->TotalCash;

        return ['UsersTotal'=>$UsersTotal,'GuestsTotal'=>$GuestsTotal,'MerchantsTotal'=>$MerchantsTotal];
    } 
    public function RecentTransactions() {
        $RecentTransactions = $this->db
            ->select('
                transactions.Transaction_Address as TransactionAddress,
                transactions.Timestamp as Timestamp,
                transactions.TotalAmount as TotalAmount,
                sender.Firstname as SenderFirstname,
                sender.Lastname as SenderLastname,
                receiver.Firstname as ReceiverFirstname,
                receiver.Lastname as ReceiverLastname
            ')
            ->from('tbl_transactionsinfo as transactions')

            ->group_start()
                ->like('transactions.Sender_Address', 'USR', 'after')
                ->or_like('transactions.Sender_Address', 'GST', 'after')
            ->group_end()
            ->group_start()
                ->like('transactions.Receiver_Address', 'USR', 'after')
                ->or_like('transactions.Receiver_Address', 'GST', 'after')
            ->group_end()

            ->join('tbl_usersaccount as sender', 'transactions.Sender_Address = sender.UsersAccount_Address', 'left')
            ->join('tbl_usersaccount as receiver', 'transactions.Receiver_Address = receiver.UsersAccount_Address', 'left')

            ->order_by('transactions.Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        return $RecentTransactions;
    }
    public function RecentCashIn(){
        $RecentTransactions = $this->db
            ->select('tbl_transactionsinfo.*, tbl_usersaccount.Firstname, tbl_usersaccount.Lastname')
            ->from('tbl_transactionsinfo')
            ->like('Sender_Address', 'ACT', 'after')
            ->join('tbl_usersaccount', 'tbl_transactionsinfo.Receiver_Address = tbl_usersaccount.UsersAccount_Address', 'right')
            ->order_by('Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        return $RecentTransactions;
    } 
    public function RecentActivities() {
        $RecentActivities = $this->db
            ->select('logs.*, 
                mobile.Firstname as MobileFirstname, 
                mobile.Lastname as MobileLastname, 
                web.Firstname as WebFirstname, 
                web.Lastname as WebLastname, 
                guardian.Firstname as GuardianFirstname, 
                guardian.Lastname as GuardianLastname')
            ->from('tbl_activitylogs as logs')
            ->join('tbl_usersaccount as mobile', 'logs.Account_Address = mobile.UsersAccount_Address', 'left')
            ->join('tbl_webaccounts as web', 'logs.Account_Address = web.WebAccounts_Address', 'left')
            ->join('tbl_guardianaccount as guardian', 'logs.Account_Address = guardian.GuardianAccount_Address', 'left')
            ->order_by('logs.Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
    
        return $RecentActivities;
    }



// ADMINISTRARTOR 
    public function TotalCashInsPerHour() {
        $hourlyCashInCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Debit) as TotalCashIn')
            ->from('tbl_transactions')
            ->where('Status', 'Completed')
            ->like('Account_Address', 'ACT', 'after')
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalCashIn = $row->TotalCashIn;
                $hourlyCashInCounts[$hour] = $totalCashIn;
            }
        }
        return $hourlyCashInCounts;
    }
    public function TotalTransfersPerHour() {
        $hourlyTransfersCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Transaction_Address) as TotalTransfers')
            ->from('tbl_transactionsinfo')
            ->where('Status', 'Completed')
            ->group_start()
                ->like('Sender_Address', 'USR', 'after')
                ->or_like('Sender_Address', 'GST', 'after')
            ->group_end()
            ->group_start()
                ->like('Receiver_Address', 'USR', 'after')
                ->or_like('Receiver_Address', 'GST', 'after')
            ->group_end()
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalTransfers = $row->TotalTransfers;
                $hourlyTransfersCounts[$hour] = $totalTransfers;
            }
        }
        return $hourlyTransfersCounts;
    }
    public function TotalPurchasesPerHour() {
        $hourlyPurchasesCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Transaction_Address) as TotalPurchases')
            ->from('tbl_transactionsinfo')
            ->where('Status', 'Completed')
            ->like('Receiver_Address', 'MTA', 'after')
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalPurchases = $row->TotalPurchases;
                $hourlyPurchasesCounts[$hour] = $totalPurchases;
            }
        }
        return $hourlyPurchasesCounts;
    }
    public function EveryHourTransactions() {
        $hourlyTransactionsCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Transaction_Address) as TotalTransactions')
            ->from('tbl_transactionsinfo')
            ->where('Status', 'Completed')
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalTransactions = $row->TotalTransactions;
                $hourlyTransactionsCounts[$hour] = $totalTransactions;
            }
        }
        return $hourlyTransactionsCounts;
    }
    public function NumberOfActors() {
        $ADM = $this->db
            ->select('COUNT(WebAccounts_Address) as ADM')
            ->from('tbl_webaccounts')
            ->like('WebAccounts_Address', 'ADM', 'after')
            ->get()
            ->row()
            ->ADM;

        $ACT = $this->db
            ->select('COUNT(WebAccounts_Address) as ACT')
            ->from('tbl_webaccounts')
            ->like('WebAccounts_Address', 'ACT', 'after')
            ->get()
            ->row()
            ->ACT;

        $MTA = $this->db
            ->select('COUNT(WebAccounts_Address) as MTA')
            ->from('tbl_webaccounts')
            ->like('WebAccounts_Address', 'MTA', 'after')
            ->get()
            ->row()
            ->MTA;

        $MTS = $this->db
            ->select('COUNT(WebAccounts_Address) as MTS')
            ->from('tbl_webaccounts')
            ->like('WebAccounts_Address', 'MTS', 'after')
            ->get()
            ->row()
            ->MTS;

        $USR = $this->db
            ->select('COUNT(UsersAccount_Address) as USR')
            ->from('tbl_usersaccount')
            ->like('UsersAccount_Address', 'USR', 'after')
            ->get()
            ->row()
            ->USR;

        $GST = $this->db
            ->select('COUNT(UsersAccount_Address) as GST')
            ->from('tbl_usersaccount')
            ->like('UsersAccount_Address', 'GST', 'after')
            ->get()
            ->row()
            ->GST;
        
        $GDN = $this->db
            ->select('COUNT(GuardianAccount_Address) as GDN')
            ->from('tbl_guardianaccount')
            ->get()
            ->row()
            ->GDN;

        return [
            'labels' => [
                'ADM',
                'ACT',
                'MTA',
                'MTS',
                'USR',
                'GST',
                'GDN',
            ],
            'numbers' => [
                (int)$ADM,
                (int)$ACT,
                (int)$MTA,
                (int)$MTS,
                (int)$USR,
                (int)$GST,
                (int)$GDN
            ]
        ];
    }
    public function RecentAdminActivities() {
        $RecentActivities = $this->db
            ->select('*')
            ->from('tbl_activitylogs as logs')
            ->join('tbl_webaccounts as web', 'logs.Account_Address = web.WebAccounts_Address', 'left')
            ->like('logs.Account_Address', 'ADM', 'after')
            ->order_by('logs.Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        return $RecentActivities;
    }
    public function RecentAccountingMerchantActivities() {
        $RecentActivities = $this->db
            ->select('*')
            ->from('tbl_activitylogs as logs')
            ->group_start()
                ->like('logs.Account_Address', 'ACT', 'after')
                ->or_like('logs.Account_Address', 'MTA', 'after')
                ->or_like('logs.Account_Address', 'MTS', 'after')
            ->group_end()
            ->join('tbl_webaccounts as web', 'logs.Account_Address = web.WebAccounts_Address', 'left')
            ->order_by('logs.Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        return $RecentActivities;
    }
    public function RecentUsersActivities() {
        $RecentActivities = $this->db
            ->select('logs.*, 
                mobile.Firstname as MobileFirstname, 
                mobile.Lastname as MobileLastname, 
                guardian.Firstname as GuardianFirstname, 
                guardian.Lastname as GuardianLastname')
            ->from('tbl_activitylogs as logs')
            ->join('tbl_usersaccount as mobile', 'logs.Account_Address = mobile.UsersAccount_Address', 'left')
            ->join('tbl_guardianaccount as guardian', 'logs.Account_Address = guardian.GuardianAccount_Address', 'left')
            ->group_start()
                ->like('Account_Address', 'USR', 'after')
                ->or_like('Account_Address', 'GST', 'after')
                ->or_like('Account_Address', 'GDN', 'after')
            ->group_end()
            ->order_by('logs.Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        return $RecentActivities;
    }



// MERCHANT ADMIN 
    public function TotalOrdersPerHour($Account_Address){
        $hourlyOrdersCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, COUNT(Transaction_Address) as TotalOrders')
            ->from('tbl_transactionsinfo')
            ->where('Status', 'Completed')
            ->where('Receiver_Address', $Account_Address)
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalOrders = $row->TotalOrders;
                $hourlyOrdersCounts[$hour] = $totalOrders;
            }
        }
        return $hourlyOrdersCounts;
    }
    public function TotalSalesPerHour($Account_Address){
        $hourlySalesCounts = array_fill(0, 24, 0);

        $query = $this->db
            ->select('HOUR(Timestamp) as Hour, SUM(TotalAmount) as TotalSales')
            ->from('tbl_transactionsinfo')
            ->where('Status', 'Completed')
            ->where('Receiver_Address', $Account_Address)
            ->where('Timestamp >= CURDATE()')
            ->group_by('HOUR(Timestamp)')
            ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hour = $row->Hour;
                $totalSales = $row->TotalSales;
                $hourlySalesCounts[$hour] = $totalSales;
            }
        }
        return $hourlySalesCounts;
    }
    public function EveryDayTotalSales($Account_Address){
        $Sales = array_fill(0, 7, 0);
    
        $currentTimestamp = date('Y-m-d H:i:s');
    
        if ($currentTimestamp) {
            $this->db->select('DATE(Timestamp) as Date, SUM(Credit) as TotalCredit');
            $this->db->where('Account_Address', $Account_Address);
            $this->db->where("DATE(Timestamp) >= DATE_SUB('$currentTimestamp', INTERVAL 6 DAY)", null, false);
            $this->db->where('Status', 'Completed');
            $this->db->group_by('DATE(Timestamp)');
            $querySales = $this->db->get('tbl_transactions');
            $SalesResults = $querySales->result();

            foreach ($SalesResults as $result) {
                $date = new DateTime($result->Date);
                $dayIndex = 6 - intval($date->diff(new DateTime())->format('%a'));
                $Sales[$dayIndex] = $result->TotalCredit;
            }
        }

        return ['Sales' => $Sales];
    }
    public function TopItems($Account_Address){
        $TopItemsList = $this->db
            ->select('items.MerchantItems_Id, itemdetails.Name, SUM(items.Quantity) as TotalQuantity')
            ->from('tbl_transactionitems as items')
            ->join('tbl_transactions as transaction', 'items.Transaction_Address = transaction.Transaction_Address', 'left')
            ->join('tbl_merchantitems as itemdetails', 'items.MerchantItems_Id = itemdetails.MerchantItems_Id', 'left')
            ->where('transaction.Account_Address', $Account_Address)
            ->group_by('items.MerchantItems_Id')
            ->order_by('TotalQuantity', 'DESC')
            ->limit(10)
            ->get()
            ->result();

        $names = [];
        $totalQuantities = [];

        foreach ($TopItemsList as $item) {
            $names[] = $item->Name;
            $totalQuantities[] = $item->TotalQuantity;
        }

        return ['Name'=>$names,'Total'=>$totalQuantities];
    }
    public function RecentMerchantActivities($Account_Address){
        $MerchantsCategory_Id = $this->db
            ->select('*')
            ->from('tbl_merchants')
            ->where('WebAccounts_Address', $Account_Address)
            ->get()
            ->row()
            ->MerchantsCategory_Id;

        $RecentActivities = $this->db
            ->select('
                logs.*,
                accounts.Firstname as Firstname,
                accounts.Lastname as Lastname
            ')
            ->from('tbl_activitylogs as logs')
            ->join('tbl_merchants as merchant', 'logs.Account_Address = merchant.WebAccounts_Address', 'left')
            ->join('tbl_webaccounts as accounts', 'logs.Account_Address = accounts.WebAccounts_Address', 'left')
            ->where('MerchantsCategory_Id', $MerchantsCategory_Id)
            ->order_by('Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();

        return $RecentActivities;
    }
    public function RecentPurchases($Account_Address){
        $recentPurchases = $this->db
            ->select('
                tbl_transactionsinfo.*,
                accounts.Firstname as Firstname,
                accounts.Lastname as Lastname,
                type.Name as TransactionType
            ')
            ->from('tbl_transactionsinfo')
            ->join('tbl_usersaccount as accounts', 'tbl_transactionsinfo.Sender_Address = accounts.UsersAccount_Address', 'left')
            ->join('tbl_transactiontype as type', 'tbl_transactionsinfo.TransactionType_Id = type.TransactionType_Id', 'left')
            ->where('tbl_transactionsinfo.Receiver_Address', $Account_Address)
            ->where('tbl_transactionsinfo.Status', 'Completed')
            ->order_by('tbl_transactionsinfo.Timestamp', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        return $recentPurchases;
    }



}
