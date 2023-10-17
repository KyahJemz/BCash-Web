<?php
class WebAccounts_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_address($AccountAdress){
        $result = $this->db
            ->select('*')
            ->from('tbl_webaccounts')
            ->where('WebAccounts_Address ', $AccountAdress)
            ->get()
            ->row();    
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_by_username($Username){
        $result = $this->db
            ->select('*')
            ->from('tbl_webaccounts')
            ->where('Username ', $Username)
            ->get()
            ->row();    
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function update_pin($AccountAddress,$PIN) {
        $data = [
            'PinCode ' => $PIN
        ];
        $this->db->where('WebAccounts_Address', $AccountAddress);
        $this->db->update('tbl_webaccounts', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function update_password($AccountAddress, $Password) {
        $hashed_password = password_hash($Password, PASSWORD_BCRYPT);
        $data = [
            'Password ' => $hashed_password
        ];
        $this->db->where('WebAccounts_Address', $AccountAddress);
        $this->db->update('tbl_webaccounts', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }




    public function update_email($params) {
        $data = [
            'Email ' => $params['Email']
        ];
        $this->db->where('WebAccounts_Address', $params['Account_Address']);
        $this->db->update('tbl_webaccounts', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_firstname($params) {
        $data = [
            'Firstname ' => $params['Firstname']
        ];
        $this->db->where('WebAccounts_Address', $params['Account_Address']);
        $this->db->update('tbl_webaccounts', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_lastname($params) {
        $data = [
            'Lastname ' => $params['Lastname']
        ];
        $this->db->where('WebAccounts_Address', $params['Account_Address']);
        $this->db->update('tbl_webaccounts', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_IsAccountActive($params) {
        $data = [
            'IsAccountActive' => (int)$params['IsAccountActive']
        ];
        $this->db->where('WebAccounts_Address', $params['Account_Address']);
        $this->db->update('tbl_webaccounts', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }



    // public function update_pin($params) {
    //     $data = [
    //         'PinCode ' => $params['PinCode']
    //     ];
    //     $this->db->where('WebAccounts_Address', $params['AccountAddress']);
    //     $this->db->update('tbl_webaccounts', $data);

    //     return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    // }

    public function read_adm_act_with_filters($params) {
        $this->db
        ->select('
            Account.WebAccounts_Address as WebAccounts_Address,
            Account.Firstname as Firstname,
            Account.Lastname as Lastname,
            Account.Email as Email,
            Campus.Name as Campus,
            Actor.Name as ActorCategory,
            Account.IsAccountActive as IsAccountActive,
            Account.DateRegistered as DateRegistered
        ')
        ->from('tbl_webaccounts as Account')
        ->join('tbl_campus as Campus', 'Account.Campus_Id = Campus.Campus_Id', 'left')
        ->join('tbl_actorcategory as Actor', 'Account.ActorCategory_Id = Actor.ActorCategory_Id', 'left')
        ->where('Account.Campus_Id', $params['Campus_Id']);

        if (!empty($params['AccountAddress'])) {
            $this->db->like('Account.WebAccounts_Address', $params['AccountAddress']);
        }

        if ($params['Target'] === 'ACT') {
            $this->db->like('Account.WebAccounts_Address', 'ACT', 'after');
        } else if ($params['Target'] === 'ADM') {
            $this->db->like('Account.WebAccounts_Address', 'ADM', 'after');
        } else {
            $this->db->like('Account.WebAccounts_Address', 'X', 'after');
        }

        if (!empty($params['Email'])) {
            $this->db->like('Account.Email', $params['Email']);
        }
    
        if (!empty($params['Name'])) {
            $this->db->group_start()
                ->like('Account.Firstname', $params['Name'])
                ->or_like('Account.Lastname', $params['Name'])
            ->group_end();
        }

        if ($params['Status'] === 'Active' || $params['Status'] === 'Inactive') {
            $Status = ($params['Status'] === 'Active') ? '1' : '0';
            $this->db->where('Account.IsAccountActive', $Status);
        }

        $result = $this->db->get()->result();

        return ($result) ? $result : [] ;
    }

    public function read_mta_mts_with_filters($params) {
        $this->db
        ->select('
            Account.WebAccounts_Address as WebAccounts_Address,
            Account.Firstname as Firstname,
            Account.Lastname as Lastname,
            Account.Email as Email,
            Campus.Name as Campus,
            Actor.Name as ActorCategory,
            Account.IsAccountActive as IsAccountActive,
            category.ShopName as ShopName,
            Account.DateRegistered as DateRegistered
        ')
        ->from('tbl_webaccounts as Account')
        ->join('tbl_campus as Campus', 'Account.Campus_Id = Campus.Campus_Id', 'left')
        ->join('tbl_actorcategory as Actor', 'Account.ActorCategory_Id = Actor.ActorCategory_Id', 'left')
        ->join('tbl_merchants as merchants', 'Account.WebAccounts_Address = merchants.WebAccounts_Address', 'left')
        ->join('tbl_merchantscategory as category', 'merchants.MerchantsCategory_Id = category.MerchantsCategory_Id', 'left')
        ->where('Account.Campus_Id', $params['Campus_Id']);

        if (!empty($params['AccountAddress'])) {
            $this->db->like('Account.WebAccounts_Address', $params['AccountAddress']);
        }

        if ($params['Target'] === 'MTS') {
            $this->db->like('Account.WebAccounts_Address', 'MTS', 'after');
        } else if ($params['Target'] === 'MTA') {
            $this->db->like('Account.WebAccounts_Address', 'MTA', 'after');
        } else {
            $this->db->like('Account.WebAccounts_Address', 'X', 'after');
        }

        if (!empty($params['Email'])) {
            $this->db->like('Account.Email', $params['Email']);
        }

        if (!empty($params['MerchantCategory'])) {
            $this->db->like('category.ShopName', $params['MerchantCategory']);
        }
    
        if (!empty($params['Name'])) {
            $this->db->group_start()
                ->like('Account.Firstname', $params['Name'])
                ->or_like('Account.Lastname', $params['Name'])
            ->group_end();
        }

        if ($params['Status'] === 'Active' || $params['Status'] === 'Inactive') {
            $Status = ($params['Status'] === 'Active') ? '1' : '0';
            $this->db->where('Account.IsAccountActive', $Status);
        }

        $result = $this->db->get()->result();

        return ($result) ? $result : [] ;
    }

























    // public function uploadPass() {
    //     $hashed_password = password_hash("12345", PASSWORD_BCRYPT);
    
    //     $addresses = ['ADM000000000000', 'ACT000000000000', 'MTA000000000000', 'MTS000000000000'];
    
    //     $data = [
    //         'Password' => $hashed_password
    //     ];
    
    //     // Use or_where_in to match multiple values for 'WebAccounts_Address'
    //     $this->db->where_in('WebAccounts_Address', $addresses);
    //     $this->db->update('tbl_webaccounts', $data);
    
    //     return $this->db->affected_rows() > 0;
    // }


}
