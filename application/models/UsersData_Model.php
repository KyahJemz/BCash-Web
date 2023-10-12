<?php
class UsersData_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create($UsersAccount_Address) {
        // $data = [
        //     'UsersAccount_Address' => $UsersAccount_Address,
        // ];
        // $this->db->insert('tbl_usersdata', $data);
        // $result = $this->db->insert_id();
        // return ($result) ? TRUE : FALSE;
    }

    public function update_by_admin($params) {
        $data = [
            'Campus_Id' => $params['Campus_Id'],
            'SchoolPersonalId ' => $params['SchoolPersonalId'],
            'CanDoTransfers ' => $params['CanDoTransfers'],
            'CanDoTransactions ' => $params['CanDoTransactions'],
            'CanUseCard ' => $params['CanUseCard'],
            'CanModifySettings ' => $params['CanModifySettings'],
            'IsPurchaseAutoConfirm' => $params['IsPurchaseAutoConfirm'],
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
            'CanDoTransfers ' => $params['CanDoTransfers'],
            'CanDoTransactions ' => $params['CanDoTransactions'],
            'CanUseCard ' => $params['CanUseCard'],
            'CanModifySettings ' => $params['CanModifySettings'],
            'IsPurchaseAutoConfirm' => $params['IsPurchaseAutoConfirm'],
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
            'CanDoTransfers ' => $params['CanDoTransfers'],
            'CanDoTransactions ' => $params['CanDoTransactions'],
            'CanUseCard ' => $params['CanUseCard'],
            'IsPurchaseAutoConfirm' => $params['IsPurchaseAutoConfirm'],
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

    public function update_user_balance($params){
        $data = [
            'Balance ' => $params['Balance'],
        ];
        $this->db->where('UsersAccount_Address', $params['Account_Address']);
        $this->db->update('tbl_usersdata', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }



}
