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
            'Sender_Address' => $params['Sender_Address'],
            'Receiver_Address' => $params['Receiver_Address'],
            'Status' => $params['Status'],
            'Amount' => $params['Amount'],
            'Discount' => $params['Discount'],
            'TotalAmount' => $params['TotalAmount'],
            'PostedBy' => $params['PostedBy'],
            'Notes' => $params['Notes'] ?? "",
            'PaymentMethod ' => $params['PaymentMethod'] ?? "",
            
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
            ->group_start()
                ->where('Status', 'Completed')
                ->or_where('Status', 'Paid')
            ->group_end()
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
        $this->db
            ->select('*')
            ->from('tbl_transactions')
            ->where('Account_Address', $params['Account_Address'])
            ->order_by('Timestamp', 'DESC')
            ->limit((int)$params['Limit']);
    
        $result = $this->db->get()->result();
    
        if ($result) {
            return ['status' => TRUE, 'response' => $result];
        } else {
            return ['status' => FALSE, 'response' => []];
        }
    }

    public function read_transactionsinfo_limit_by_address($params) {
        $this->db
            ->select('tbl_transactionsinfo.*, transactiontype.Name as TransactionType')
            ->from('tbl_transactionsinfo')
            ->join('tbl_transactiontype as transactiontype', 'tbl_transactionsinfo.TransactionType_Id = transactiontype.TransactionType_Id', 'left')
            ->group_start()
                ->where('tbl_transactionsinfo.Sender_Address', $params['Account_Address'])
                ->or_where('tbl_transactionsinfo.Receiver_Address', $params['Account_Address'])
            ->group_end()
            ->order_by('tbl_transactionsinfo.Timestamp', 'DESC')
            ->limit((int)$params['Limit']);
    
        $result = $this->db->get()->result();
    
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
                sender.Campus_Id AS sender_Campus_Id, 
                sender_data.SchoolPersonalId AS sender_SchoolPersonalId,
                receiver.Firstname AS Receiver_Firstname, 
                receiver.Lastname AS Receiver_Lastname, 
                receiver.Email AS Receiver_Email, 
                receiver.Campus_Id AS Receiver_Campus_Id, 
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
                ->where('receiver.Campus_Id', $params['Campus_Id'])
                ->or_where('sender.Campus_Id', $params['Campus_Id'])
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
            $this->db->group_start()
                ->like('tbl_transactionsinfo.Receiver_Address', $params['AccountAddress'], 'after')
                ->or_like('tbl_transactionsinfo.Sender_Address', $params['AccountAddress'], 'after')
            ->group_end();
        }
    
        if ($params['StatusFilter'] != 'All') {
            $this->db->where('tbl_transactionsinfo.Status', ($params['StatusFilter']));
        }
    
        $result = $this->db->limit($results_per_page)->get()->result();
    
        return ($result) ? $result : $result;
    }

    public function read_transactionsinfo_by_transactionaddress($params){
        $Sender = $this->db
            ->select('*')
            ->where('Transaction_Address', $params['TransactionAddress'])
            ->from('tbl_transactionsinfo')
            ->get()
            ->row()
            ->Sender_Address;

        $Receiver = $this->db
            ->select('*')
            ->where('Transaction_Address', $params['TransactionAddress'])
            ->from('tbl_transactionsinfo')
            ->get()
            ->row()
            ->Receiver_Address;

        if (substr($Sender, 0, 3) === "ACT") {
            $result = $this->db
                ->select('tbl_transactionsinfo.*, 
                        "Accounting" AS Sender_Firstname, 
                        " " AS Sender_Lastname, 
                        " " AS Sender_Email, 
                        " " AS sender_Campus_Id, 
                        receiver.Firstname AS Receiver_Firstname, 
                        receiver.Lastname AS Receiver_Lastname, 
                        receiver.Email AS Receiver_Email, 
                        receiver.Campus_Id AS Receiver_Campus_Id, 
                        receiver_data.SchoolPersonalId AS Receiver_SchoolPersonalId,
                        transactiontype.Name as TransactionType')
                ->from('tbl_transactionsinfo')
                ->join('tbl_usersaccount as receiver', 'tbl_transactionsinfo.Receiver_Address = receiver.UsersAccount_Address', 'left')
                ->join('tbl_usersdata as receiver_data', 'receiver.UsersAccount_Address = receiver_data.UsersAccount_Address', 'left')
                ->join('tbl_transactiontype as transactiontype', 'tbl_transactionsinfo.TransactionType_Id = transactiontype.TransactionType_Id', 'left')
                ->where('Transaction_Address', $params['TransactionAddress'])
                ->get()
                ->row();
            $items = [];
        } else if (substr($Receiver, 0, 3) === "MTA") {
            $result = $this->db
                ->select('tbl_transactionsinfo.*, 
                    sender.Firstname AS Sender_Firstname, 
                    sender.Lastname AS Sender_Lastname, 
                    sender.Email AS Sender_Email, 
                    sender.Campus_Id AS sender_Campus_Id, 
                    sender_data.SchoolPersonalId AS sender_SchoolPersonalId,
                    merchantcategory.ShopName AS Receiver_Firstname, 
                    " " AS Receiver_Lastname, 
                    " " AS Receiver_Email, 
                    " " AS Receiver_Campus_Id, 
                    transactiontype.Name as TransactionType')
                ->from('tbl_transactionsinfo')
                ->join('tbl_usersaccount as sender', 'tbl_transactionsinfo.Sender_Address = sender.UsersAccount_Address', 'left')
                ->join('tbl_usersdata as sender_data', 'sender.UsersAccount_Address = sender_data.UsersAccount_Address', 'left')

                ->join('tbl_merchants as merchant', 'tbl_transactionsinfo.Receiver_Address = merchant.WebAccounts_Address', 'left')
                ->join('tbl_merchantscategory as merchantcategory', 'merchant.MerchantsCategory_Id = merchantcategory.MerchantsCategory_Id', 'left')

                ->join('tbl_transactiontype as transactiontype', 'tbl_transactionsinfo.TransactionType_Id = transactiontype.TransactionType_Id', 'left')
                ->where('Transaction_Address', $params['TransactionAddress'])
                ->get()
                ->row();
            $items =  $this->db
                ->select('
                    items.Quantity as ItemQuantity,
                    items.Amount as ItemAmount,
                    details.Name as ItemName
                ')
                ->from('tbl_transactionitems as items')
                ->join('tbl_merchantitems as details', 'items.MerchantItems_Id = details.MerchantItems_Id', 'left')
                ->where('items.Transaction_Address', $params['TransactionAddress'])
                ->get()
                ->result();
        } else {
            $result = $this->db
                ->select('tbl_transactionsinfo.*, 
                    sender.Firstname AS Sender_Firstname, 
                    sender.Lastname AS Sender_Lastname, 
                    sender.Email AS Sender_Email, 
                    sender.Campus_Id AS sender_Campus_Id, 
                    sender_data.SchoolPersonalId AS sender_SchoolPersonalId,
                    receiver.Firstname AS Receiver_Firstname, 
                    receiver.Lastname AS Receiver_Lastname, 
                    receiver.Email AS Receiver_Email, 
                    receiver.Campus_Id AS Receiver_Campus_Id, 
                    receiver_data.SchoolPersonalId AS Receiver_SchoolPersonalId,
                    transactiontype.Name as TransactionType')
                ->from('tbl_transactionsinfo')
                ->join('tbl_usersaccount as sender', 'tbl_transactionsinfo.Sender_Address = sender.UsersAccount_Address', 'left')
                ->join('tbl_usersaccount as receiver', 'tbl_transactionsinfo.Receiver_Address = receiver.UsersAccount_Address', 'left')
                ->join('tbl_usersdata as sender_data', 'sender.UsersAccount_Address = sender_data.UsersAccount_Address', 'left')
                ->join('tbl_usersdata as receiver_data', 'receiver.UsersAccount_Address = receiver_data.UsersAccount_Address', 'left')
                ->join('tbl_transactiontype as transactiontype', 'tbl_transactionsinfo.TransactionType_Id = transactiontype.TransactionType_Id', 'left')
                ->where('Transaction_Address', $params['TransactionAddress'])
                ->get()
                ->row();
            $items = [];
        }

        return ['Info'=>$result, 'Items'=>$items];
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
    
    
    
  


    public function Create_Order_Event($params){
        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
        $this->db->delete('tbl_ordersvalidation');

        $data = [
            'WebAccounts_Address' => $params['WebAccounts_Address'],
            'UsersAccount_Address' => null,
        ];
        $this->db->insert('tbl_ordersvalidation', $data);
    }

    public function Update_Order_Event($params){
        $data = [
            'UsersAccount_Address' => $params['UsersAccount_Address'],
        ];
        
        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
        $this->db->update('tbl_ordersvalidation', $data);
    }

    public function Delete_Order_Event($params){
        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
        $this->db->delete('tbl_ordersvalidation');
    }

    public function Read_Order_Event($params){
        $this->db->select('*');
        $this->db->from('tbl_ordersvalidation');
        $this->db->where('WebAccounts_Address', $params['WebAccounts_Address']);
        return $this->db->get()->row();
    }

    public function Listen_Confirmation_Event($params){
        $this->db->select('*');
        $this->db->from('tbl_transactionsinfo');
        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function create_transaction_items($params){
        foreach ($params['Items'] as $row) {
            $data = [
                'Transaction_Address' => $params['Transaction_Address'],
                'MerchantItems_Id' => $row['MerchantItems_Id'],
                'Quantity' => $row['Quantity'],
                'Amount' => $row['Amount'],
            ];
            $this->db->insert('tbl_transactionitems', $data);
        }
    }

    public function read_pending_transactions($params) {
        return $this->db
            ->select('*')
            ->from('tbl_transactionsinfo')
            ->group_start()
                ->where('Sender_Address', $params['UsersAccount_Address'])
                ->or_where('Receiver_Address', $params['UsersAccount_Address'])
            ->group_end()
            ->where('Status', 'Payment')
            ->limit(1)
            ->get()
            ->row();
    }
    
    public function update_transactions_approved($params){
        $data = [
            'Status' => 'Paid'
        ];
        
        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->update('tbl_transactions', $data);
    }

    public function update_transactions_cancel($params){
        $data = [
            'Status' => 'Canceled'
        ];
        
        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->update('tbl_transactions', $data);
    }

    public function update_transactionsinfo_approved($params){
        $data = [
            'Status' => 'Paid'
        ];
        
        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->update('tbl_transactionsinfo', $data);
    }

    public function update_transactionsinfo_cancel($params){
        $data = [
            'Status' => 'Canceled'
        ];
        
        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->update('tbl_transactionsinfo', $data);
    }



    public function read_paid_transactions($params) {

        $Orders = $this->db
            ->select('
                items.Transaction_Address as Transaction_Address,
                transaction.Timestamp as Timestamp,
                transaction.Status as Status,
                transaction.TotalAmount as TotalAmount,
                account.Firstname as Firstname,
                account.Lastname as Lastname,
                details.Name as Name,
                items.Quantity as Quantity
            ')
            ->from('tbl_transactionitems as items')
            ->join('tbl_merchantitems as details', 'items.MerchantItems_Id = details.MerchantItems_Id', 'left')
            ->join('tbl_transactionsinfo as transaction', 'items.Transaction_Address = transaction.Transaction_Address', 'left')
            ->join('tbl_usersaccount as account', 'transaction.Sender_Address = account.UsersAccount_Address', 'left')
            ->where('transaction.Status', 'Paid')
            ->where('transaction.Receiver_Address', $params['Receiver_Address'])
            ->get()
            ->result();
    
        $OrdersArray = [];
        $processedTransactionAddresses = [];
    
        foreach ($Orders as $value) {
            $transactionAddress = $value->Transaction_Address;
    
            // Check if the transaction address has already been processed
            if (!in_array($transactionAddress, $processedTransactionAddresses)) {
                $order = [
                    'Transaction_Address' => $transactionAddress,
                    'Timestamp' => $value->Timestamp,
                    'Status' => $value->Status,
                    'TotalAmount' => $value->TotalAmount,
                    'Firstname' => $value->Firstname,
                    'Lastname' => $value->Lastname,
                    'Items' => [
                        [
                            'Name' => $value->Name,
                            'Quantity' => $value->Quantity
                        ]
                    ]
                ];
    
                $OrdersArray[] = $order;
    
                // Mark the transaction address as processed
                $processedTransactionAddresses[] = $transactionAddress;
            } else {
                // If the transaction address has already been processed, add items to the existing order
                $existingOrderIndex = array_search($transactionAddress, array_column($OrdersArray, 'Transaction_Address'));
                $OrdersArray[$existingOrderIndex]['Items'][] = [
                    'Name' => $value->Name,
                    'Quantity' => $value->Quantity
                ];
            }
        }
    
        return $OrdersArray;
    }

    public function complete_transaction($params) {
        $data = [
            'Status' => 'Completed'
        ];

        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->update('tbl_transactionsinfo', $data);

        $this->db->where('Transaction_Address', $params['Transaction_Address']);
        $this->db->update('tbl_transactions', $data);

        return ($this->db->affected_rows() > 0); 

    }
}

