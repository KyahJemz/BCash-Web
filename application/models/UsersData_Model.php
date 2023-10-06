<?php
class UsersData_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create($UsersAccount_Address) {
        $data = [
            'UsersAccount_Address' => $UsersAccount_Address,
        ];
        $this->db->insert('tbl_usersdata', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function read_by_address($AccountAdress){
        $result = $this->db
            ->select('*')
            ->from('tbl_usersdata')
            ->where('UsersAccount_Address ', $AccountAdress)
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }


}
