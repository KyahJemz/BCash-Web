<?php
class UsersData_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create($params) {
        $data = [
            'UsersAccount_Address' => $params['Account_Address'],
            'SchoolPersonalId'=> $params['SchoolPersonalId'],
            'CanDoTransfers'=> (INT) $params['CanDoTransfers'],
            'CanDoTransactions'=> (INT) $params['CanDoTransactions'],
            'CanUseCard'=> (INT) $params['CanUseCard'],
            'CanModifySettings'=> (INT) $params['CanModifySettings'],
            'IsTransactionAutoConfirm'=> (INT) $params['IsTransactionAutoConfirm'],
        ];
        $this->db->insert('tbl_usersdata', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function update_by_admin($params) {
        $data = [
            'Campus_Id' => $params['Campus_Id'],
            'SchoolPersonalId' => $params['SchoolPersonalId'],
            'CanDoTransfers' => (int)$params['CanDoTransfers'],
            'CanDoTransactions' => (int)$params['CanDoTransactions'],
            'CanUseCard' => (int)$params['CanUseCard'],
            'CanModifySettings' =>(int) $params['CanModifySettings'],
            'IsTransactionAutoConfirm' =>(int) $params['IsTransactionAutoConfirm'],
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function update_by_users($params) {
        $data = [
            'CanDoTransfers' => (int)$params['CanDoTransfers'],
            'CanDoTransactions' => (int)$params['CanDoTransactions'],
            'CanUseCard' => (int)$params['CanUseCard'],
            'CanModifySettings' => (int)$params['CanModifySettings'],
            'IsTransactionAutoConfirm' => (int)$params['IsTransactionAutoConfirm'],
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function update_by_guardian($params) {
        $data = [
            'CanDoTransfers' => (int)$params['CanDoTransfers'],
            'CanDoTransactions' => (int)$params['CanDoTransactions'],
            'CanUseCard' => (int)$params['CanUseCard'],
            'CanModifySettings' => (int)$params['CanModifySettings'],
            'IsTransactionAutoConfirm' => (int)$params['IsTransactionAutoConfirm'],
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function read_by_address($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersdata')
            ->where('UsersAccount_Address ', $params['Account_Address'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_by_SchoolPersonalId($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersdata')
            ->where('SchoolPersonalId ', $params['SchoolPersonalId'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return false; 
        }
    }

     public function read_by_id($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersdata')
            ->where('SchoolPersonalId ', $params['SchoolPersonalId'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function update_user_balance($params){
        $data = [
            'Balance' => $params['Balance'],
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }



    
    public function update_SchoolPersonalId($params) {
        $data = [
            'SchoolPersonalId' => (int)$params['SchoolPersonalId']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_CanDoTransfers($params) {
        $data = [
            'CanDoTransfers' => (int)$params['CanDoTransfers']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_CanDoTransactions($params) {
        $data = [
            'CanDoTransactions' => (int)$params['CanDoTransactions']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_CanUseCard($params) {
        $data = [
            'CanUseCard' => (int)$params['CanUseCard']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_CanModifySettings($params) {
        $data = [
            'CanModifySettings' => (int)$params['CanModifySettings']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_IsTransactionAutoConfirm($params) {
        $data = [
            'IsTransactionAutoConfirm' => (int)$params['IsTransactionAutoConfirm']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_GuardianAccountAddress($params) {
        $data = [
            'GuardianAccount_Address' => $params['GuardianAccountAddress']
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}
