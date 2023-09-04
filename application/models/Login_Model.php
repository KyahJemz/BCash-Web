<?php
class Login_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    // public function update(){
    //     $text = "12345";
    //     $hashed_text = password_hash($text, PASSWORD_BCRYPT);

    //     $this->db->set('Password', $hashed_text);
    //     $this->db->where('WebAccounts_Address', 'ACC000000000000'); // Replace 'id' with your condition
    //     $this->db->update('tbl_webaccounts');

    // }

    public function get_tbl_webaccounts_by_address($Account_Address) {
        $this->db->select('*');
        $this->db->from('tbl_webaccounts');
        $this->db->where('WebAccounts_Address', $Account_Address);
        $result = $this->db->get();
        return $result->row();
    }

    public function get_tbl_usersaccount_by_address($Account_Address) {
        $this->db->select('*');
        $this->db->from('tbl_usersaccount');
        $this->db->where('UsersAccount_Address', $Account_Address);
        $result = $this->db->get();
        return $result->row();
    }

    public function get_tbl_guardiansaccount_by_address($Account_Address) {
        $this->db->select('*');
        $this->db->from('tbl_guardianaccount');
        $this->db->where('GuardianAccount_Address ', $Account_Address);
        $result = $this->db->get();
        return $result->row();
    }

    public function get_tbl_webaccounts_by_username($Username) {
        $this->db->select('*');
        $this->db->from('tbl_webaccounts');
        $this->db->where('Username', $Username);
        $result = $this->db->get();
        return $result->row();
    }
}
