<?php
class Transactions_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // TABLES
    // tbl_transactiontype - category type
    // tbl_transactionsinfo - full details
    // tbl_transactions - debid and credit
    // tbl_transactionitems - Items inside transactions


    public function read_transactiontype_by_address($Id){
        $result = $this->db
            ->select('*')
            ->from('tbl_transactiontype')
            ->where('TransactionType_Id ', $Id)
            ->get()
            ->row()
            ->Name;    
        if ($result) {
            return ['status' => TRUE, 'response' => $result];
        } else {
            return ['status' => FALSE, 'response' => 'Invalid'];
        }
    }

    public function read_transactionsinfo_by_address($AccountAddress) {
        $result = $this->db
            ->select('*')
            ->from('tbl_transactionsinfos')
            ->group_start()
                ->where('Sender_Address', $AccountAddress)
                ->or_where('Receiver_Address', $AccountAddress)
            ->group_end()
            ->get();
        if ($result) {
            return ['status' => TRUE, 'response' => $result];
        } else {
            return ['status' => FALSE, 'response' => []];
        }
    }

    public function read_transactionsinfo_of_accounting(){
        $result = $this->db
            ->select('*')
            ->from('tbl_transactionsinfo')
            ->group_start()
                ->where('Sender_Address', 'Accounting')
                ->or_where('Receiver_Address', 'Accounting')
            ->group_end()
            ->get();

        return ['status' => TRUE, 'response' => $result];
    }

    public function read_transactionsinfo_of_merchants($MerchantsCategory_Id) {

        if (empty($MerchantsCategory_Id)) {
            $result = $this->db
                ->select('*')
                ->from('tbl_transactionsinfo')
                ->join('tbl_webaccounts', 'tbl_transactionsinfo.Receiver_Address = tbl_webaccounts.WebAccounts_Address')
                ->group_start()
                    ->where('tbl_webaccounts.ActorCategory_Id', '3')
                    ->or_where('tbl_webaccounts.ActorCategory_Id', '4')
                ->group_end()
                ->get();

        } else {
            $result = $this->db
                ->select('*')
                ->from('tbl_transactionsinfo')
                ->join('tbl_merchants', 'tbl_transactionsinfo.Receiver_Address = tbl_merchants.WebAccounts_Address')
                ->where('tbl_merchants.MerchantsCategory_Id', $MerchantsCategory_Id)
                ->get();
        }

        return ['status' => TRUE, 'response' => $result];
    }



    public function read_transactions_by_address($AccountAddress){
        $result = $this->db
            ->select('*')
            ->from('tbl_transactions')
            ->where('Account_Address', $AccountAddress)
            ->get();
        if ($result) {
            return ['status' => TRUE, 'response' => $result];
        } else {
            return ['status' => FALSE, 'response' => []];
        }
    }

    public function read_transactionitems_by_transaction_address($TransactionAddress){
        $result = $this->db
            ->select('*')
            ->from('tbl_transactionitems')
            ->where('Transaction_Address', $TransactionAddress)
            ->get();
        if ($result) {
            return ['status' => TRUE, 'response' => $result];
        } else {
            return ['status' => FALSE, 'response' => []];
        }
    }

    public function read_transactions($TargetCategory, $Startdate, $EndDate, $TransactionAddress, $SearchName, $StatusFilter) {
        $this->db->select('*')->from('tbl_transactionsinfo');
    
        if (!empty($TargetCategory) && $TargetCategory !== 'All') {
            if ($TargetCategory === 'merchant') {
                $this->db->join('tbl_merchants', 'tbl_merchants.WebAccounts_Address = tbl_transactionsinfo.Receiver_Address OR tbl_merchants.WebAccounts_Address = tbl_transactionsinfo.Sender_Address');
            } else if ($TargetCategory === 'accounting') {
                $this->db->where('Receiver_Address', 'Accounting');
            } else if ($TargetCategory === 'users') {
                $this->db->join('tbl_usersaccount', 'tbl_usersaccount.UsersAccount_Address = tbl_transactionsinfo.Receiver_Address OR tbl_usersaccount.UsersAccount_Address = tbl_transactionsinfo.Sender_Address');
            }
        }
    
        if (!empty($SearchName) && $StatusFilter !== 'All') {
            $this->db->where('Status', $StatusFilter);
        }
    
        if (!empty($Startdate)) {
            $this->db->where('Timestamp >=', $Startdate);
        }
    
        if (!empty($EndDate)) {
            $this->db->where('Timestamp <=', $EndDate);
        }
    
        if (!empty($TransactionAddress)) {
            $this->db->where('Transaction_Address', $TransactionAddress);
        }
    
        if (!empty($SearchName)) {
            $this->db->group_start()
                        ->like('Sender_Address', $SearchName)
                        ->or_like('Receiver_Address', $SearchName)
                      ->group_end();
        }
    
        $result = $this->db->get();
    
        return ['status' => ($result !== FALSE), 'response' => $result];
    }
    
    
   
}

