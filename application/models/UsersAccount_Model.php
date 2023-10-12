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
            'PinCode ' => $PIN
        ];
        $this->db->where('UsersAccount_Address', $AccountAddress);
        $this->db->update('tbl_usersaccounts', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

}
