<?php
class Card_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function update_account($params) {
        $data = [
            'UsersAccount_Address ' => $params['Account_Address'],
        ];
        $this->db->where('Card_Address', $params['Card_Address']);
        $this->db->update('tbl_card', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function read_by_CardAddress($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_card')
            ->where('Card_Address ', $params['Card_Address'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return false; 
        }
    }
}
