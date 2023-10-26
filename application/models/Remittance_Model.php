<?php
class Remittance_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Functions_Model');
    }

    // read specific
    public function read_row_by_id($params){
        $Remittance = $this->db
            ->select('*')
            ->from('tbl_remittance')
            ->where('Remittance_Id', $params['Remittance_Id'])
            ->get()
            ->row();
    
        $RemittanceRawList = $this->db
            ->select('
                transactions.*,
                items.Quantity as ItemQuantity,
                items.Amount as ItemAmount,
                names.Name as ItemName
            ')
            ->from('tbl_transactions as transactions')
            ->where('transactions.Remittance_Id', $params['Remittance_Id'])  // Fix: Use 'transactions.Remittance_Id' instead of just 'Remittance_Id'
            ->join('tbl_transactionitems as items', 'transactions.Transaction_Address = items.Transaction_Address')
            ->join('tbl_merchantitems as names', 'items.MerchantItems_Id = names.MerchantItems_Id')
            ->get()
            ->result();
    
        $RemittanceList = [];
    
        foreach ($RemittanceRawList as $transaction) {
            $transactionAddress = $transaction->Transaction_Address;  // Use -> to access object properties
    
            if (!isset($RemittanceList[$transactionAddress])) {
                $RemittanceList[$transactionAddress] = [
                    'Transaction_Address' => $transactionAddress,
                    'Account_Address' => $transaction->Account_Address,
                    'Status' => $transaction->Status,
                    'Debit' => $transaction->Debit,
                    'Credit' => $transaction->Credit,
                    'Remittance_Id' => $transaction->Remittance_Id,
                    'Timestamp' => $transaction->Timestamp,
                    'Items' => []
                ];
            }
    
            $item = [
                'ItemQuantity' => $transaction->ItemQuantity,
                'ItemName' => $transaction->ItemName,
                'ItemAmount' => $transaction->ItemAmount
            ];
    
            $RemittanceList[$transactionAddress]['Items'][] = $item;
        }
    
        return ($Remittance && $RemittanceList) ? ['Remittance' => $Remittance, 'RemittanceList' => array_values($RemittanceList)] : ['Remittance' => [], 'RemittanceList' => []];
    }
    

    public function read_all(){
        $Remittance = $this->db
            ->select('*')
            ->from('tbl_remittance')
            ->order_by('Timestamp', 'DESC') 
            ->get()
            ->result();

        return ($Remittance) ? $Remittance : [];
    }

    public function read_by_address($params){
        $Remittance = $this->db
            ->select('*')
            ->from('tbl_remittance')
            ->where('Submitted_By', $params['Account_Address'])
            ->order_by('Timestamp', 'DESC') 
            ->get()
            ->result();

        return ($Remittance) ? $Remittance : [];
    }

    public function read_remaining_by_address($params){
        $RemittanceRawList = $this->db
            ->select('
                transactions.*,
                items.Quantity as ItemQuantity,
                items.Amount as ItemAmount,
                names.Name as ItemName
            ')
            ->from('tbl_transactions as transactions')
            ->where('transactions.Account_Address', $params['Account_Address'])
            ->where('transactions.Remittance_Id', null)  
            ->where('transactions.Status', 'Completed')  
            ->join('tbl_transactionitems as items', 'transactions.Transaction_Address = items.Transaction_Address')
            ->join('tbl_merchantitems as names', 'items.MerchantItems_Id = names.MerchantItems_Id')
            ->get()
            ->result();
    
        $RemittanceList = [];
    
        foreach ($RemittanceRawList as $transaction) {
            $transactionAddress = $transaction->Transaction_Address;  // Use -> to access object properties
    
            if (!isset($RemittanceList[$transactionAddress])) {
                $RemittanceList[$transactionAddress] = [
                    'Transaction_Address' => $transactionAddress,
                    'Account_Address' => $transaction->Account_Address,
                    'Status' => $transaction->Status,
                    'Debit' => $transaction->Debit,
                    'Credit' => $transaction->Credit,
                    'Remittance_Id' => $transaction->Remittance_Id,
                    'Timestamp' => $transaction->Timestamp,
                    'Items' => []
                ];
            }
    
            $item = [
                'ItemQuantity' => $transaction->ItemQuantity,
                'ItemName' => $transaction->ItemName,
                'ItemAmount' => $transaction->ItemAmount
            ];
    
            $RemittanceList[$transactionAddress]['Items'][] = $item;
        }

        log_message('debug',$this->db->last_query());
    
        return array_values($RemittanceList);

    }

    public function update_date_approved($params){
        $Timestamp =  $this->Functions_Model->get_current_timestamp();
        $data = [
            'DateResponse' => $Timestamp,
            'Status' => 'Approved',
        ];
        $this->db->where('Remittance_Id', $params['Remittance_Id'])
            ->update('tbl_remittance', $data);
        $updatedRows = $this->db->affected_rows();
        return ($updatedRows) ? True : False;
    }

    public function update_date_rejected($params){
        $Timestamp =  $this->Functions_Model->get_current_timestamp();
        $data = [
            'DateResponse' => '$Timestamp',
            'Status' => 'Rejected',
        ];
        $this->db->where('Remittance_Id', $params['Remittance_Id'])
            ->update('tbl_remittance', $data);
        $updatedRows = $this->db->affected_rows();
        return ($updatedRows) ? True : False;
    }

    public function create($params){

        $RemittanceListTotal = $this->db
            ->select('
                SUM(Credit) AS TotalAmount,
                COUNT(Credit) AS TotalOrders
            ')
            ->from('tbl_transactions')
            ->where('Account_Address', $params['Account_Address'])
            ->where('Remittance_Id', null)  
            ->where('Status', 'Completed')  
            ->get()
            ->row();

        $data = [
            'Submitted_By' => $params['Account_Address'],
            'TotalOrders' => $RemittanceListTotal->TotalOrders,
            'TotalAmount' => $RemittanceListTotal->TotalAmount,
        ];
        $this->db->insert('tbl_remittance', $data);

        $Remittance = $this->db->insert_id();

        $data = [
            'Remittance_Id' => $Remittance
        ];

        $this->db
            ->where('Account_Address', $params['Account_Address'])
            ->where('Remittance_Id', null)  
            ->where('Status', 'Completed')  
            ->update('tbl_transactions', $data);

        $updatedRows = $this->db->affected_rows();

        log_message('debug', $RemittanceListTotal->TotalOrders);
        log_message('debug', $updatedRows);
        if ((int)$updatedRows != (int)$RemittanceListTotal->TotalOrders) {
            throw new Exception('Mismatch in updated rows. Rolling back transaction.');
        }

        return $updatedRows;
    }
}
