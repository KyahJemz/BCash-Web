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
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
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
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function delete_specific($AccountAddress,$IpAddress,$Location,$Device) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->where('IpAddress', $IpAddress);
        $this->db->where('Location', $Location);
        $this->db->where('Device', $Device);
        $this->db->delete('tbl_authentications');
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function delete($AccountAddress) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->delete('tbl_authentications');
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function create($AccountAddress,$IpAddress,$Location,$Device,$LastOnline){
        $data = [
            'Account_Address' => $AccountAddress,
            'IpAddress' => $IpAddress,
            'Location' => $Location,
            'Device' => $Device,
            'LastOnline' => $LastOnline
        ];
        $this->db->insert('tbl_loginhistory', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function update_isblocked_by_address($AccountAddress,$Value){
        $data = [
            'IsBlocked' => $Value,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_loginhistory', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }
    
    public function update_lastonline_by_address($AccountAddress, $DateTime) {
        $data = [
            'LastOnline' => $DateTime,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_loginhistory', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }


}
