<?php
class Charts_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model([
            'Functions_Model',
     ]);
    }

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

    } 
    public function RecentTransactions() {
        $RecentTransactions = $this->db
            ->select('*')
            ->from('tbl_transactionsinfo')
            ->group_start()
                ->like('Sender_Address', 'USR', 'after')
                ->or_like('Sender_Address', 'GST', 'after')
            ->group_end()
            ->group_start()
                ->like('Receiver_Address', 'USR', 'after')
                ->or_like('Receiver_Address', 'GST', 'after')
            ->group_end()

            ->order_by('Timestamp', 'DESC')
            ->limit(10)
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
            ->limit(10)
            ->get()
            ->result();
        return $RecentTransactions;
    } 
    public function RecentActivities(){
        $RecentActivities = $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->order_by('Timestamp', 'DESC')
            ->limit(10)
            ->get()
            ->result();
        return $RecentActivities;
    } 
}
