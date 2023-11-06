<?php
class Whitelist_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_email($params){
        return $this->db
            ->select('*')
            ->from('tbl_schoolid')
            ->where('Email ', $params['Email'])
            ->get()
            ->row();
    }

    public function verify($params){
        return $this->db
            ->select('*')
            ->from('tbl_whitelist')
            ->where('Account_Address ', $params['AccountAddress'])
            ->where('Whitelisted_Address ', $params['WhitelistedAddress'])
            ->get()
            ->row();
    }

}
