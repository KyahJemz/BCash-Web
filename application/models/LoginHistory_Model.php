<?php
class LoginHistory_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_address($AccountAddress){
        $result = $this->db
            ->select('*')
            ->from('tbl_loginhistory')
            ->where('Account_Address', $AccountAddress)
            ->get()
            ->result();
        return $result;
    }

    public function read_by_specific($AccountAddress,$IpAddress,$Device,$Location){
        $result = $this->db
            ->select('*')
            ->from('tbl_loginhistory')
            ->where('Account_Address', $AccountAddress)
            ->where('IpAddress', $IpAddress)
            ->where('Device', $Device)
            ->where('Location', $Location)
            ->get()
            ->row();
        return $result;
    }

    public function delete_specific($AccountAddress,$IpAddress,$Device,$Location) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->where('IpAddress', $IpAddress);
        $this->db->where('Location', $Location);
        $this->db->where('Device', $Device);
        $this->db->delete('tbl_loginhistory');
        $result = $this->db->affected_rows();
        return $this->db->last_query();
    }

    public function delete($AccountAddress) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->delete('tbl_loginhistory');
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function create($AccountAddress,$IpAddress,$Location,$Device){
        $data = [
            'Account_Address' => $AccountAddress,
            'IpAddress' => $IpAddress,
            'Location' => $Location,
            'Device' => $Device,
        ];
        $this->db->insert('tbl_loginhistory', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function update_isblocked($AccountAddress,$IpAddress,$Location,$Device,$Value){
        $data = [
            'IsBlocked' => $Value,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->where('IpAddress', $IpAddress);
        $this->db->where('Location', $Location);
        $this->db->where('Device', $Device);
        $this->db->update('tbl_loginhistory', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

}

