<?php
class UsersAccount_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create($UsersAccount_Address, $Email, $EmailId, $Firstname, $Lastname) {
        $data = [
            'UsersAccount_Address' => $PIN,
            'ActorCategory_Id' => '5',
            'Email ' => $PIN,
            'EmailId ' => $PIN,
            'Firstname ' => $PIN,
            'Lastname ' => $PIN,
        ];
        $this->db->insert('tbl_usersaccount', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function update($params) {
        $data = [
            'Email ' => $params['Email'],
            'EmailId ' => $params['EmailId'],
            'Firstname ' => $params['Firstname'],
            'Lastname ' => $params['Lastname'],
            'IsAccountActive' => $params['IsAccountActive'],
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersaccounts', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function read_by_address($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersaccount')
            ->where('UsersAccount_Address ', $params['Account_Address'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read(){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersaccount')
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_all_with_view_columns($params){
        $this->db
            ->select('
                Account.UsersAccount_Address as UsersAccount_Address,
                Account.Firstname as Firstname,
                Account.Lastname as Lastname,
                Account.Email as Email,
                Campus.Name as Campus,
                Actor.Name as ActorCategory,
                Account.IsAccountActive as IsAccountActive,
                Data.CanDoTransfers as CanDoTransfers,
                Data.SchoolPersonalId as SchoolPersonalId,
                Data.CanDoTransactions as CanDoTransactions,
                Data.CanUseCard as CanUseCard,
                Data.CanModifySettings as CanModifySettings,
                Data.IsTransactionAutoConfirm as IsTransactionAutoConfirm,
                Data.DateRegistered as DateRegistered,
                Data.GuardianAccount_Address as GuardianAccount_Address,
            ')
            ->from('tbl_usersaccount as Account')
            ->join('tbl_usersdata as Data', 'Account.UsersAccount_Address = Data.UsersAccount_Address', 'left')
            ->join('tbl_campus as Campus', 'Account.Campus_Id = Campus.Campus_Id', 'left')
            ->join('tbl_actorcategory as Actor', 'Account.ActorCategory_Id = Actor.ActorCategory_Id', 'left')
            ->where('Account.Campus_Id', $params['Campus_Id']);

        if (!empty($params['AccountAddress'])) {
            $this->db->like('Account.UsersAccount_Address', $params['AccountAddress']);
        }

        if (!empty($params['SchoolPersonalId'])) {
            $this->db->like('Data.SchoolPersonalId', $params['SchoolPersonalId']);
        }

        if (!empty($params['Email'])) {
            $this->db->like('Account.Email', $params['Email']);
        }
    
        if (!empty($params['Name'])) {
            $this->db->group_start()
                ->like('Account.Firstname', $params['Name'])
                ->or_like('Account.Lastname', $params['Name'])
                ->or_like('Guardian.Firstname', $params['Name'])
                ->or_like('Guardian.Lastname', $params['Name'])
            ->group_end();
        }

        if ($params['Status'] === 'Active' || $params['Status'] === 'Inactive') {
            $Status = ($params['Status'] === 'Active') ? '1' : '0';
            $this->db->where('Account.IsAccountActive', $Status);
        }

        $result = $this->db->get()->result();

        return ($result) ? $result : [] ;
    }

    public function read_by_emailid($EmailId){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersaccount')
            ->where('EmailId ', $EmailId)
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
            'PinCode' => $PIN
        ];
        $this->db->where('UsersAccount_Address', $AccountAddress);
        $this->db->update('tbl_usersaccount', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    

    public function update_Email($params) {
        $data = [
            'Email' => $params['Email']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_Firstname($params) {
        $data = [
            'Firstname' => $params['Firstname']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_Lastname($params) {
        $data = [
            'Lastname' => $params['Lastname']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_IsAccountActive($params) {
        $data = [
            'IsAccountActive' => (int)$params['IsAccountActive']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

}
