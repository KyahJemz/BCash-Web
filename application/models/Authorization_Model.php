<?php
class Authorization_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // WEB APPLICATION


    function generateToken (){
        $text = random_string('alnum', 10);
        $token = password_hash($text, PASSWORD_BCRYPT);
        return $token;
    }

    function generateOTP(){
        $text = random_string('numeric', 6);
        return $text;
    }

    public function get_current_timestamp (){
        //return $this->db->query("SELECT NOW() AS current_time")->row()->current_time;
        return date('Y-m-d H:i:s');
    }

    public function get_tbl_loginhistory_by_address($Account_Address) {
        return $this->db
            ->select('*')
            ->from('tbl_loginhistory')
            ->where('Account_Address', $Account_Address)
            ->get()->row();
    }

    public function get_tbl_authentications_by_address($Account_Address) {
        return $this->db
            ->select('*')
            ->from('tbl_authentications')
            ->where('Account_Address', $Account_Address)
            ->get()->row();
    }

    public function get_webactor_category($Account_Address) {
        return $this->db
            ->select('tbl_actorcategory.Name')
            ->from('tbl_webaccounts')
            ->join('tbl_actorcategory', 'tbl_actorcategory.ActorCategory_Id = tbl_webaccounts.ActorCategory_Id')
            ->where('tbl_webaccounts.WebAccounts_Address', $Account_Address)
            ->get()->row()->Name;
    }

    public function get_tbl_loginhistory_by_data($Account_Address,$IpAddress,$Device,$Location) {
        return $this->db
            ->select('*')
            ->from('tbl_loginhistory')
            ->where('Account_Address', $Account_Address)
            ->where('IpAddress', $IpAddress)
            ->where('Device', $Device)
            ->where('Location', $Location)
            ->get()->row();
    }


// check if account is enabled
// check if has pin code
// chech if record existed in login history for new login   



    public function setOTP() {

    }

    public function setAuthorization(){
        
    }

    public function setLoginHistory(){
        
    }

    public function updateLastLogin(){
        
    }




    public function initialize_login($Account_Address,$IpAddress,$Device,$Location){
        $status = "";
        $current_timestamp = $this->get_current_timestamp();
        try {
            $this->db->trans_start(); 

            $tbl_loginhistory = $this->get_tbl_loginhistory_by_data($Account_Address,$IpAddress,$Device,$Location);
            if ($tbl_loginhistory) {
                if ($tbl_loginhistory->IsBlocked === '1') {
                    $status = "Access Blocked";
                } else {
                    $tbl_authentications = $this->get_tbl_authentications_by_address($Account_Address);
                    if ($tbl_authentications){
                        $data = [
                            'AuthToken' => $this->generateToken(),
                            'AuthExpirationTime' => NULL,
                            'AuthCreationTime' => $current_timestamp,
                            'IpAddress' => $IpAddress,
                            'Location' => $Location,
                            'Device' => $Device,
                            'IsOnline' => 1
                        ];
                        $this->db->where('Account_Address', $Account_Address);
                        $this->db->update('tbl_authentications', $data);
                    } else {
                        $data = [
                            'Account_Address' => $Account_Address,
                            'AuthToken' => $this->generateToken(),
                            'AuthExpirationTime' => NULL,
                            'AuthCreationTime' => $current_timestamp,
                            'IpAddress' => $IpAddress,
                            'Location' => $Location,
                            'Device' => $Device,
                            'IsOnline' => 1
                        ];
                        $this->db->insert('tbl_authentications', $data);
                    }
                    $status = "Successful";
                }
            } else {

                $tbl_authentications = $this->get_tbl_authentications_by_address($Account_Address);
                if ($tbl_authentications){
                    $data = [
                        'OtpCode' => $this->generateOTP(),
                        'OtpExpirationTime' => NULL,
                        'OtpCreationTime' => $current_timestamp,
                        'IpAddress' => $IpAddress,
                        'Location' => $Location,
                        'Device' => $Device,
                        'IsOnline' => 0
                    ];
                    $this->db->where('Account_Address', $Account_Address);
                    $this->db->update('tbl_authentications', $data);
                } else {
                    $data = [
                        'Account_Address' => $Account_Address,
                        'OtpCode' => $this->generateOTP(),
                        'OtpExpirationTime' => NULL,
                        'OtpCreationTime' => $current_timestamp,
                        'IpAddress' => $IpAddress,
                        'Location' => $Location,
                        'Device' => $Device,
                        'IsOnline' => 0
                    ];
                    $this->db->insert('tbl_authentications', $data);
                }
                $status =  "OTP Required";
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed. Rollback.');
            } else {
                $this->db->trans_complete();
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $status = "Failed";
        }
        return $status;
    }
    

    // API 









}
