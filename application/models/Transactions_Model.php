<?php
class Transactions_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model([
            'UsersData_Model',
        ]);
    }

    public function create_transactioninfo($params): bool {
        $data = [
            'Transaction_Address' => $params['Transaction_Address'],
            'TransactionType_Id' => $params['TransactionType_Id'],
            'Sender_Address ' => $params['Sender_Address'],
            'Receiver_Address ' => $params['Receiver_Address'],
            'Status ' => $params['Status'],
            'Amount ' => $params['Amount'],
            'Discount ' => $params['Discount'],
            'DiscountReason ' => $params['DiscountReason'],
            'TotalAmount ' => $params['TotalAmount'],
            'PostedBy ' => $params['PostedBy'],
        ];
        $this->db->insert('tbl_transactionsinfo', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function create_transaction($params): bool {
        $data = [
            'Transaction_Address' => $params['Transaction_Address'],
            'Account_Address' => $params['Account_Address'],
            'Status ' => $params['Status'],
            'Debit ' => $params['Debit'],
            'Credit ' => $params['Credit'],
        ];
        $this->db->insert('tbl_transactions', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function update_status_transactioninfo($params): bool {
        $data = [
            'Status' => $params['Status'],  
        ];
    
        $this->db->where('Transaction_Address', $params['Transaction_Address']);  
        $this->db->update('tbl_transactionsinfo', $data);
    
        return ($this->db->affected_rows() > 0); 
    }
    
    public function update_status_transaction($params): bool {
        $data = [
            'Status' => $params['Status'],  
        ];
    
        $this->db->where('Transaction_Address', $params['Transaction_Address']);  
        $this->db->update('tbl_transactions', $data);
    
        return ($this->db->affected_rows() > 0);  
    }

    public function calculate_total_balance($params) {
        $result = $this->db
            ->select('SUM(Credit) - SUM(Debit) AS total_balance', FALSE)
            ->from('tbl_Transactions')
            ->where('Account_Address', $params['Account_Address'])
            ->where('Status !=', 'Canceled')
            ->get()
            ->row()
            ->total_balance;
    
        $total_balance = ($result !== null) ? $result : 0;

        $this->UsersData_Model->update_user_balance(array(
            'Account_Address'=> $params['Account_Address'],
            'Balance' => $total_balance,
        ));
    
        return ($total_balance) ? $total_balance : 0;
    }

    public function read_transactions_by_address($params) {
        $result = $this->db
            ->select('*')
            ->from('tbl_transactions')
            ->where('Account_Address', $params['Account_Address']);
    
        if (isset($params['Limit']) && strtolower($params['Limit']) !== 'all') {
            $limit = (int)$params['Limit'];
            $result->limit($limit);
        }
    
        $result = $result->get();
    
        if ($result) {
            return ['status' => TRUE, 'response' => $result];
        } else {
            return ['status' => FALSE, 'response' => []];
        }
    }

    public function read_recent_cashin($params) {
        $result = $this->db
            ->select('tbl_transactionsinfo.*, tbl_usersaccount.Firstname, tbl_usersaccount.Lastname')
            ->from('tbl_transactionsinfo')
            ->like('Sender_Address', 'ACT', 'after')
            ->limit($params['Limit'])
            ->order_by('Timestamp', 'DESC') 
            ->join('tbl_usersaccount', 'tbl_transactionsinfo.Receiver_Address = tbl_usersaccount.UsersAccount_Address', 'left')
            ->get()
            ->result();
            
        return ($result) ? $result : FALSE;
    }



    public function read_all_user_transactions($params) {
        $results_per_page = isset($params['ResultsPerPage']) ? (int)$params['ResultsPerPage'] : 50;
    
        // Start timestamp
        $start_timestamp = isset($params['StartDate']) && !empty($params['StartDate'])
            ? date('Y-m-d 00:00:00', strtotime($params['StartDate']))
            : date('Y-m-d 00:00:00');

        // End timestamp
        $end_timestamp = isset($params['EndDate']) && !empty($params['EndDate'])
            ? date('Y-m-d 23:59:59', strtotime($params['EndDate'] . ' 23:59:59'))
            : date('Y-m-d 23:59:59');
   
        $result = $this->db
            ->select('tbl_transactionsinfo.*, 
                sender.Firstname AS Sender_Firstname, 
                sender.Lastname AS Sender_Lastname, 
                sender.Email AS Sender_Email, 
                sender_data.Campus_Id AS sender_Campus_Id, 
                sender_data.SchoolPersonalId AS sender_SchoolPersonalId,
                receiver.Firstname AS Receiver_Firstname, 
                receiver.Lastname AS Receiver_Lastname, 
                receiver.Email AS Receiver_Email, 
                receiver_data.Campus_Id AS Receiver_Campus_Id, 
                receiver_data.SchoolPersonalId AS Receiver_SchoolPersonalId,
                transactiontype.Name as TransactionType')
            ->from('tbl_transactionsinfo')
            ->order_by('Timestamp', 'DESC') 
            ->join('tbl_usersaccount as sender', 'tbl_transactionsinfo.Sender_Address = sender.UsersAccount_Address', 'left')
            ->join('tbl_usersaccount as receiver', 'tbl_transactionsinfo.Receiver_Address = receiver.UsersAccount_Address', 'left')
            ->join('tbl_usersdata as sender_data', 'sender.UsersAccount_Address = sender_data.UsersAccount_Address', 'left')
            ->join('tbl_usersdata as receiver_data', 'receiver.UsersAccount_Address = receiver_data.UsersAccount_Address', 'left')
            ->join('tbl_transactiontype as transactiontype', 'tbl_transactionsinfo.TransactionType_Id = transactiontype.TransactionType_Id', 'left')
            ->group_start()
                ->where('receiver_data.Campus_Id', $params['Campus_Id'])
                ->or_where('sender_data.Campus_Id', $params['Campus_Id'])
            ->group_end()
            ->where('Timestamp >=', $start_timestamp)
            ->where('Timestamp <=', $end_timestamp)
            ->order_by('Timestamp', 'DESC') ;

        if (!empty($params['TransactionAddress'])) {
            $this->db->like('tbl_transactionsinfo.Transaction_Address', $params['TransactionAddress']);
        }
    
        if (!empty($params['SearchName'])) {
            $this->db->group_start()
                ->like('sender.Firstname', $params['SearchName'])
                ->or_like('sender.Lastname', $params['SearchName'])
                ->or_like('receiver.Firstname', $params['SearchName'])
                ->or_like('receiver.Lastname', $params['SearchName'])
            ->group_end();
        }

        if (isset($params['AccountAddress'])) {
            $this->db->like('tbl_transactionsinfo.Sender_Address', $params['AccountAddress'], 'after');
        }
    
        if ($params['StatusFilter'] != 'All') {
            $this->db->where('tbl_transactionsinfo.Status', ($params['StatusFilter']));
        }
    
        $result = $this->db->limit($results_per_page)->get()->result();

        $sql_query = $this->db->last_query();
        log_message('debug', 'SQL Query: ' . $sql_query);
    
        return ($result) ? $result : $result;
    }

    public function read_transactionsinfo_by_transactionaddress($pararms){
        $result = $this->db
            ->select('tbl_transactionsinfo.*, 
                sender.Firstname AS Sender_Firstname, 
                sender.Lastname AS Sender_Lastname, 
                sender.Email AS Sender_Email, 
                sender_data.Campus_Id AS sender_Campus_Id, 
                sender_data.SchoolPersonalId AS sender_SchoolPersonalId,
                receiver.Firstname AS Receiver_Firstname, 
                receiver.Lastname AS Receiver_Lastname, 
                receiver.Email AS Receiver_Email, 
                receiver_data.Campus_Id AS Receiver_Campus_Id, 
                receiver_data.SchoolPersonalId AS Receiver_SchoolPersonalId,
                transactiontype.Name as TransactionType')
            ->from('tbl_transactionsinfo')
            ->join('tbl_usersaccount as sender', 'tbl_transactionsinfo.Sender_Address = sender.UsersAccount_Address', 'left')
            ->join('tbl_usersaccount as receiver', 'tbl_transactionsinfo.Receiver_Address = receiver.UsersAccount_Address', 'left')
            ->join('tbl_usersdata as sender_data', 'sender.UsersAccount_Address = sender_data.UsersAccount_Address', 'left')
            ->join('tbl_usersdata as receiver_data', 'receiver.UsersAccount_Address = receiver_data.UsersAccount_Address', 'left')
            ->join('tbl_transactiontype as transactiontype', 'tbl_transactionsinfo.TransactionType_Id = transactiontype.TransactionType_Id', 'left')
            ->where('Transaction_Address ', $pararms['TransactionAddress'])
            ->get()
            ->row();
        return ($result) ? $result : $result;
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
            ->from('tbl_transactionsinfo')
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

    public function read_transactions_by_category($category, $id, $Startdate, $EndDate, $TransactionAddress, $SearchName, $StatusFilter) {
        $this->db->select('*')->from('tbl_transactionsinfo');
    
        if (!empty($category) && $category !== 'All') {
            if ($category === 'merchant') {
                $this->db->join('tbl_merchants', 'tbl_merchants.WebAccounts_Address = tbl_transactionsinfo.Receiver_Address OR tbl_merchants.WebAccounts_Address = tbl_transactionsinfo.Sender_Address');
                $this->db->where('tbl_merchants.MerchantsCategory_Id', $id);
            } else if ($category === 'accounting') {
                $this->db->where('Receiver_Address', 'Accounting');
            } else if ($category === 'users') {
                $this->db->join('tbl_usersaccount', 'tbl_usersaccount.UsersAccount_Address = tbl_transactionsinfo.Receiver_Address OR tbl_usersaccount.UsersAccount_Address = tbl_transactionsinfo.Sender_Address');
                $this->db->where('tbl_usersaccount.UsersAccount_Address', $id);
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

