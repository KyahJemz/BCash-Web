<?php
class WebAccounts_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_address($AccountAdress){
        $result = $this->db
            ->select('*')
            ->from('tbl_webaccounts')
            ->where('WebAccounts_Address ', $AccountAdress)
            ->get()
            ->row();    
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_by_username($Username){
        $result = $this->db
            ->select('*')
            ->from('tbl_webaccounts')
            ->where('Username ', $Username)
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
        $this->db->where('WebAccounts_Address', $AccountAddress);
        $this->db->update('tbl_webaccounts', $data);

        if ($this->db->affected_rows() > 0) {
             return TRUE;
        } else {
             return FALSE;
        }
    }

    public function uploadPass() {
        $hashed_password = password_hash("12345", PASSWORD_BCRYPT);
    
        $addresses = ['ADM000000000000', 'ACT000000000000', 'MTA000000000000', 'MTS000000000000'];
    
        $data = [
            'Password' => $hashed_password
        ];
    
        // Use or_where_in to match multiple values for 'WebAccounts_Address'
        $this->db->where_in('WebAccounts_Address', $addresses);
        $this->db->update('tbl_webaccounts', $data);
    
        return $this->db->affected_rows() > 0;
    }


    


    



}
