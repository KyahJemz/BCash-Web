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

    public function get_current_timestamp_add($currentTimestamp) {
        $unixCurrentTimestamp = strtotime($currentTimestamp);
        if ($unixCurrentTimestamp === false) {
            return false;
        }
        $newunixTimestamp = $unixCurrentTimestamp + (5 * 60); // 5 minutes in seconds
        $formattedTime = date('Y-m-d H:i:s', $newunixTimestamp);
        return $formattedTime;
    }

    public function get_tbl_actorcategory_by_id($ActorCategory_Id) {
        $result = $this->db
            ->select('*')
            ->from('tbl_actorcategory')
            ->where('ActorCategory_Id', $ActorCategory_Id)
            ->get()->row();
        if ($result !== null) {
            return $result;
        } else {
            return null;
        }
    }

    public function get_tbl_loginhistory_by_address($Account_Address) {
        return $this->db
            ->select('*')
            ->from('uniqueloginhistory')
            ->where('Account_Address', $Account_Address)
            ->get()->row();
    }

    public function get_tbl_authentications_by_address($Account_Address) {
        $result = $this->db
            ->select('*')
            ->from('tbl_authentications')
            ->where('Account_Address', $Account_Address)
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
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
        if ($IpAddress === null || $Device === null || $Location === null) {
            return $this->db
                ->select('*')
                ->from('tbl_loginhistory')
                ->where('Account_Address', $Account_Address)
                ->get()->row();
        } else {
            return $this->db
                ->select('*')
                ->from('tbl_loginhistory')
                ->where('Account_Address', $Account_Address)
                ->where('IpAddress', $IpAddress)
                ->where('Device', $Device)
                ->where('Location', $Location)
                ->get()->row();
        }
    }
        
    public function setUserAccount() { // THIS WILL SETUP NEW CREATED USER ACCOUNTS IN MOBILE EVEN GUEST
            
    }

    public function setOTP($AccountAddress) { // WILL CREATE OTP
        $newOTP = $this->generateOTP();
        $newOTPCreationTime = $this->get_current_timestamp();
        $newOTPExpirationTime = $this->get_current_timestamp_add($newOTPCreationTime);
    
        $data = [
            'OtpCode' => $newOTP,
            'OtpCreationTime' => $newOTPCreationTime,
            'OtpExpirationTime' => $newOTPExpirationTime,
        ];
    
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->update('tbl_authentications', $data);
    
        if ($this->db->affected_rows() === 1) {
            return $newOTP;
        } else {
            return null;
        }
    }

    public function setAuthorization($type, $AccountAddress, $IpAddress, $Device, $Location) {

        if ($type !== "old" && $type !== "new") {
            return FALSE; // Invalid $type
        }

        $newAuthToken = $this->generateToken();
        $newAuthTokenCreationTime = $this->get_current_timestamp();
        $newAuthTokenExpirationTime = $this->get_current_timestamp_add($newAuthTokenCreationTime);
        $data = [
            'AuthToken' => $newAuthToken,
            'AuthCreationTime' => $newAuthTokenCreationTime,
            'AuthExpirationTime' => $newAuthTokenExpirationTime,
            'IpAddress' => $IpAddress,
            'Device' => $Device,
            'Location' => $Location
        ];

        if ($type === "old") { // Update an existing record
            $this->db->where('Account_Address', $AccountAddress);
            $this->db->update('tbl_authentications', $data);
        } elseif ($type === "new") { // Insert a new record
            $this->db->insert('table_name', $data);
        }
        return TRUE;
    }

    public function setLogout($AccountAddress) {
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->delete('tbl_authentications');
    }
    public function setLoginHistory($AccountAddress,$IpAddress,$Device,$Location){ 
        $data = [
            'Account_Address ' => $AccountAddress,
            'IpAddress' => $IpAddress,
            'Device' => $Device,
            'Location' => $Location,
            'LastOnline' => $this->get_current_timestamp()
        ];
        $this->db->insert('tbl_loginhistory', $data);
        return TRUE;
    }

    public function updateLoginHistory($AccountAddress,$IpAddress,$Device,$Location){ 
        $data = [
            'Account_Address ' => $AccountAddress,
            'IpAddress' => $IpAddress,
            'Device' => $Device,
            'Location' => $Location,
            'LastOnline' => $this->get_current_timestamp()
        ];
        $this->db->where('Account_Address', $AccountAddress);
        $this->db->where('IpAddress', $IpAddress);
        $this->db->where('Device', $Device);
        $this->db->where('Location', $Location);
        $this->db->update('tbl_loginhistory', $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
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

    public function updateLastLogin(){ //UPDATE LAST LOGIN OF ANY USER
        
    }




    

    // API 









}
