<?php
class Whitelist_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function verify($params){
        return $this->db
            ->select('*')
            ->from('tbl_whitelist')
            ->where('Account_Address', $params['AccountAddress'])
            ->where('Whitelisted_Address', $params['WhitelistedAddress'])
            ->get()
            ->row();
    }

    public function read_by_address($params){
        return $this->db
            ->select('
                whitelist.*,
                account.Firstname,
                account.Lastname
            ')
            ->from('tbl_whitelist as whitelist')
            ->where('whitelist.Account_Address', $params['AccountAddress'])
            ->join('tbl_usersaccount as account', 'whitelist.Whitelisted_Address = account.UsersAccount_Address', 'left')
            ->order_by('whitelist.Timestamp', 'DESC')
            ->get()
            ->result();
    }

    public function delete_by_address($params){
        $this->db->where('Account_Address', $params['Account_Address']);
        $this->db->where('Whitelisted_Address', $params['Whitelisted_Address']);
        $this->db->delete('tbl_whitelist');

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function create($params){
        $data = [
            'Account_Address' => $params['Account_Address'],
            'Whitelisted_Address' => $params['Whitelisted_Address']
        ];
        $this->db->insert('tbl_whitelist', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }




}
