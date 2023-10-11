<?php

// DATABASE CREATE
$data = [
    'column_name1' => 'value1',
    'column_name2' => 'value2'
];
$this->db->insert('table_name', $data);

// DATABASE READ
    $this->db->select('*');
    $this->db->from('table_name');
    $this->db->where('column_name','values');
    $result = $this->db->get();

// DATABASE UPDATE
    $data = [
        'column_name1' => 'new_value1',
        'column_name2' => 'new_value2'
    ];
    
    $this->db->where('column_name', 'values');
    $this->db->update('table_name', $data);
    
// DATABASE DELETE
    $this->db->where('Account_Address', $AccountAddress);
    $this->db->delete('tbl_authentications');


// LOGGING MESSAGE
    log_message('debug', $OTP . ' === ' . $tbl_authentications->OtpCode);

/*



HEADERS
    AuthorizationToken
    AccountAddress
    ClientVersion
    IpAddress
    Device
    Location
    Intent

BODY: depends sa intent
- Actor category is automatically created




    

ACCOUNTING
    - CHARTS 
        Total cash-in today
        Total orders in merchants
        Total Sales in merchants
        Total transactions today
        Daily Transactions Line Graph
        Circulating Money
        Recent Transactions
        Recent Cash-In
        Recent Activities
    - CASH IN  
        RECENT CASH IN
        SEARCH USER
        PROVIDE CASH IN
    - TRANSACTIONS
        MY TRANSACTION
        ALL TRANSACTIONS
        USER TRANSACTIONS
    - ACCOUNTS
        SEARCH ALL USER ACCOUNTS
        EDIT USER ACCOUNT
    - FUN REMITTANCe
        VIEW TOP RECENT REMITTANCES
        View SPECIFIC REMITTANCES
        GET TODAYS TOTAL
        SUBMIT TO REMITTANCES
    - NOTIFICATION
        GET NOTIFICATION
    - SETTINGS
        CHANGE PASSWORD
        CHANGE PIN CODE



        

*/
?>











