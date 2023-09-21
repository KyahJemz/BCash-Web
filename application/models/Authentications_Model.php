<?php
class Authentications_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model([
            'Functions_Model'
        ]);
    }

    public function read_by_address($AccountAddress){
        $result = $this->db
            ->select('*')
            ->from('tbl_authentications')
            ->where('Account_Address ', $AccountAddress)
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function create($AccountAddress,$IpAddress,$Location,$Device){
        $data = [
            'Account_Address' => $AccountAddress,
            'IpAddress' => $IpAddress,
            'Location' => $Location,
            'Device' => $Device
        ];
        $this->db->insert('tbl_authentications', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }

    public function update_auth($AccountAddress,$AuthToken,$AuthExpirationTime,$AuthCreationTime){
        $data = [
            'AuthToken' => $AuthToken,
            'AuthExpirationTime' => $AuthExpirationTime,
            'AuthCreationTime' => $AuthCreationTime,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_authentications', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function update_otp($AccountAddress){
        $newOTP = random_string('numeric', 6);
        $newOTPCreationTime = $this->Functions_Model->get_current_timestamp();
        $newOTPExpirationTime = $this->Functions_Model->get_current_timestamp_add($newOTPCreationTime);

        $data = [
            'OtpCode' => $newOTP,
            'OtpCreationTime' => $newOTPCreationTime,
            'OtpExpirationTime' => $newOTPExpirationTime,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_authentications', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function update($AccountAddress,$IpAddress,$Location,$Device){
        $data = [
            'IpAddress' => $IpAddress,
            'Location' => $Location,
            'Device' => $Device,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_authentications', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function delete($AccountAddress) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->delete('tbl_authentications');
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;
    }

    public function Update_Auth_Session($AccountAddress,$AuthExpirationTime) {
        $data = [
            'AuthExpirationTime' => $AuthExpirationTime,
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_authentications', $data);
        $result = $this->db->affected_rows();
        return ($result > 0) ? TRUE : FALSE;

    }









}