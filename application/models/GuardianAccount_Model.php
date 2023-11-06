<?php
class GuardianAccount_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create($params){
        $data = [
            'GuardianAccount_Address ' => $params['Account_Address'],
            'UsersAccount_Address '=> $params['UsersAccount_Address'],
            'ActorCategory_Id '=> $params['ActorCategory_Id'],
            'Email'=> $params['Email'],
            'Firstname'=> $params['Firstname'],
            'Lastname'=> $params['Lastname'],
            'Campus_Id '=> $params['Campus_Id'],
        ];
        $this->db->insert('tbl_guardianaccount', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function read_by_address($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_guardianaccount')
            ->where('GuardianAccount_Address ', $params['Account_Address'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_by_emailid($EmailId){
        $result = $this->db
            ->select('*')
            ->from('tbl_guardianaccount')
            ->where('EmailId ', $EmailId)
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_by_email($Email){
        $result = $this->db
            ->select('*')
            ->from('tbl_guardianaccount')
            ->where('Email ', $Email)
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }


    public function update_Email($params) {
        $data = [
            'Email' => $params['Email']
        ];
        $this->db->where('GuardianAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_guardianaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_Firstname($params) {
        $data = [
            'Firstname' => $params['Firstname']
        ];
        $this->db->where('GuardianAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_guardianaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_Lastname($params) {
        $data = [
            'Lastname' => $params['Lastname']
        ];
        $this->db->where('GuardianAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_guardianaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    
    public function update_IsAccountActive($params) {
        $data = [
            'IsAccountActive' => (int)$params['IsAccountActive']
        ];
        $this->db->where('GuardianAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_guardianaccount', $data);
        log_message('debug',  '=== ETESTETST');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_UserAccountAddress($params) {
        $data = [
            'UsersAccount_Address' => $params['UserAccountAddress']
        ];
        $this->db->where('GuardianAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_guardianaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_PinCode($params) {
        $data = [
            'PinCode' => $params['PinCode']
        ];
        $this->db->where('GuardianAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_guardianaccount', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    

    


    public function read_gdn_with_filters($params) {
        $this->db
        ->select('
            Account.GuardianAccount_Address as GuardianAccount_Address,
            Account.Firstname as Firstname,
            Account.Lastname as Lastname,
            Account.Email as Email,
            Campus.Name as Campus,
            Actor.Name as ActorCategory,
            Account.IsAccountActive as IsAccountActive,
            Account.DateRegistered as DateRegistered,
            Account.UsersAccount_Address as UsersAccount_Address
        ')
        ->from('tbl_guardianaccount as Account')
        ->join('tbl_campus as Campus', 'Account.Campus_Id = Campus.Campus_Id', 'left')
        ->join('tbl_actorcategory as Actor', 'Account.ActorCategory_Id = Actor.ActorCategory_Id', 'left')
        ->where('Account.Campus_Id', $params['Campus_Id']);

        if (!empty($params['AccountAddress'])) {
            $this->db->like('Account.GuardianAccount_Address', $params['AccountAddress']);
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


}
