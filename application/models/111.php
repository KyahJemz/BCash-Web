<?php
class Authorization_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function setLogout($AccountAddress) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->delete('tbl_authentications');
    }

    public function updateWebsPIN($AccountAddress,$PIN) {
        $data = [
            'PinCode ' => $PIN
        ];
        $this->db->where('WebAccounts_Address', $AccountAddress);
        $this->db->update('tbl_webaccounts', $data);

        // if ($this->db->affected_rows() === 1) {
        //     return TRUE;
        // } else {
        //     return FALSE;
        // }
    }

    public function updateUsersPIN($AccountAddress,$PIN) {
        $data = [
            'PinCode ' => $PIN
        ];
        $this->db->where('UsersAccount_Address', $AccountAddress);
        $this->db->update('tbl_usersaccount', $data);

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateParentsPIN($AccountAddress,$PIN) {
        $data = [
            'PinCode ' => $PIN
        ];
        $this->db->where('GuardianAccount_Address', $AccountAddress);
        $this->db->update('tbl_guardianaccount', $data);

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }




}
