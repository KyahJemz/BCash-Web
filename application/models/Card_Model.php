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


    public function read($params){
        $this->db
            ->select('
                card.*,
                account.Firstname as Firstname,
                account.Lastname as Lastname
            ')
            ->from('tbl_card as card')
            ->join('tbl_usersaccount as account', 'card.UsersAccount_Address = account.UsersAccount_Address', 'left')
            ->where('card.Campus_Id', $params['Campus_Id']);

        if ($params['Card_Address']) {
            $this->db->like('Card_Address',$params['Card_Address']);
        }

        if ($params['Account_Address']) {
            $this->db->like('UsersAccount_Address',$params['Account_Address']);
        }

        if ($params['Status'] !== 'All') {
            $this->db->where('IsActive',$params['Status']);
        }

        $result = $this->db
            ->get()
            ->result();
        return ($result) ? $result : false;
    }

    public function create($params){
        $data = [
            'Card_Address' => $params['Card_Address'],
            'UsersAccount_Address' => $params['UsersAccount_Address'],
            'IsActive' => $params['IsActive'],
            'Campus_Id' => $params['Campus_Id'],
            'Notes' => $params['Notes'],
        ];
        $this->db->insert('tbl_card', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function delete($params){
        $this->db
            ->where('Card_Address', $params['Card_Address'])
            ->delete('tbl_card');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_UsersAccountAddress($params){
        $data = [
            'UsersAccount_Address' => $params['UsersAccount_Address'],
        ];
        $this->db->where('Card_Address', $params['Card_Address']);
        $this->db->update('tbl_card', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_IsActive($params){
        $data = [
            'IsActive' => $params['IsActive'],
        ];
        $this->db->where('Card_Address', $params['Card_Address']);
        $this->db->update('tbl_card', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_Notes($params){
        $data = [
            'Notes' => $params['Notes'],
        ];
        $this->db->where('Card_Address', $params['Card_Address']);
        $this->db->update('tbl_card', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }
}
