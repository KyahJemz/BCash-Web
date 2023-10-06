<?php
class Functions_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
    }

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// GENERAL FUNCTIONS 
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$

        public function sanitize($value) {
                if ($value === null) {
                        return null;
                }
                $value = $this->db->escape_str($value);
                // $value = $this->input->xss_clean($value);
                return $value;
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

        function generate_random_alphanumeric($length) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
            
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, strlen($characters) - 1)];
                }
            
                return $randomString;
            }

        public function create_unique_address($initials) {

                do {
                        $random_string = $this->generate_random_alphanumeric(13);

                        $address_exists = $this->getAccountsByAddress($initials . $random_string);

                        if ($address_exists === NULL) {
                                $address_exists = true;
                        } else {
                                $address_exists = false;
                        }

                    } while ($address_exists);
                
                return $initials . $random_string;
        }

        public function create_unique_transaction_address() {

                $datePart = date('YmdHis');  // Format: YYYYMMDDHHMMSS
                $randomString = $this->generate_random_alphanumeric(20 - strlen($datePart));
            
                // Combine the date part and the random string to form the unique address
                $uniqueAddress = $datePart . $randomString;
            
                return substr($uniqueAddress, 0, 20);  // Trim to 20 characters
        }

        
        public function getAccountsByAddress($AccountAddress) {
                $tbl_webaccounts = $this->WebAccounts_Model->read_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        return $tbl_webaccounts;
                }
                
                $tbl_usersaccount = $this->UsersAccount_Model->read_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        return $tbl_usersaccount;
                }

                $tbl_guardiansaccount = $this->GuardianAccount_Model->read_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        return $tbl_guardiansaccount;
                }

                return FALSE;
        }

                
                return $initials . $random_string;
        }

        
        public function getAccountsByAddress($AccountAddress) {
                $tbl_webaccounts = $this->WebAccounts_Model->read_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        return $tbl_webaccounts;
                }
                
                $tbl_usersaccount = $this->UsersAccount_Model->read_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        return $tbl_usersaccount;
                }

                $tbl_guardiansaccount = $this->GuardianAccount_Model->read_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        return $tbl_guardiansaccount;
                }

                return FALSE;
        }

        public function getActorType($AccountAddress) {
                $tbl_webaccounts = $this->WebAccounts_Model->read_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        return 'Web';
                }
                
                $tbl_usersaccount = $this->UsersAccount_Model->read_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        return 'Mobile';
                }

                $tbl_guardiansaccount = $this->GuardianAccount_Model->read_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        return 'Mobile';
                }

                return 'Invalid';
        }

        public function setLogout($AccountAddress) {
                $this->db->where('Account_Address', $AccountAddress);
                $this->db->delete('tbl_authentications');
        }

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// ALL API VALIDATION FUNCTIONS 
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

        public function validateRequest($AccountAddress, $AuthToken, $IpAddress, $Device, $Location, $Version) {

                // $validateVersion = $this->validateVersion($AccountAddress,$Version);
                // if (!($validateVersion['success'])) {
                //         return ['success' => FALSE, 'intent' => 'login', 'response' => $validateVersion['response']];
                // }

                $validateAuthToken = $this->validateAuthToken($AccountAddress, $AuthToken);
                if (!($validateAuthToken)) {
                        return [
                                'Success' => FALSE, 
                                'Target' => 'login', 
                                'Parameters' => null,
                                'Response' => 'Invalid token'
                        ];
                }

                $validateClient = $this->validateClient($AccountAddress, $IpAddress, $Device, $Location);
                if (!($validateClient)){
                        return [
                                'Success' => False,
                                'Target' => 'Login',
                                'Parameters' => null,
                                'Response' => 'Invalid client'
                        ];
                }

                return [
                        'Success' => True, 
                        'Target' => null,
                        'Parameters' => null,
                        'Response' => 'Validation Success'
                ];
        }


// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// VALIDATION FUNCTIONS 
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 

        public function validateVersion($AccountAddress,$ClientVersion){
                $IsMaintenance = $this->Configurations_Model->IsMaintenance()[0];
                if ($IsMaintenance['success']) {
                        return ['success' => FALSE, 'response' => "Server in maintenance, ".$IsMaintenance['response']];
                } else {

                        $category = $this->getActorType($AccountAddress);

                        if ($category === 'Web') {
                                $Version = $this->Configurations_Model->ValidateWebVersion($ClientVersion);
                                if (($Version['success'])){
                                        return ['success' => TRUE, 'response' => $Version['response']];
                                } else {
                                        return ['success' => FALSE, 'response' => $Version['response']];
                                }

                        } else if ($category === 'Mobile') {
                                $Version = $this->Configurations_Model->ValidateMobileVersion($ClientVersion);
                                if (($Version['success'])){
                                        return ['success' => TRUE, 'response' => $Version['response']];
                                } else {
                                        return ['success' => FALSE, 'response' => $Version['response']];
                                }

                        } else {
                                return ['success' => FALSE, 'response' => 'INVALID!'];
                        }
                }
        }

        public function validateAuthToken($AccountAddress, $AuthToken) {
                if (empty($AccountAddress) || empty($AuthToken)) {
                        return FALSE;
                } else {
                        $tbl_authentications = $this->Authentications_Model->read_by_address($AccountAddress);
                        if ($this->get_current_timestamp() <= $tbl_authentications->AuthExpirationTime) {
                                if ($AuthToken === $tbl_authentications->AuthToken) {
                                        return TRUE;
                                } else {
                                        return FALSE;
                                }
                        } else {
                                return FALSE;
                        }
                }
        }

        public function validateClient($AccountAddress, $IpAddress, $Device, $Location) {
                $tbl_authentications = $this->Authentications_Model->read_by_address($AccountAddress);
                if (
                        $tbl_authentications && 
                        $IpAddress === $tbl_authentications->IpAddress &&
                        $Device === $tbl_authentications->Device &&
                        $Location === $tbl_authentications->Location
                ) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        public function validateAccountIfEnabled($AccountAddress) {
                $Account = $this->getAccountsByAddress($AccountAddress);
                if ($Account && $Account->IsAccountActive === '1') {
                        return  TRUE;
                } else {
                        return  FALSE;
                }
        }



// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// LOGIN FUNCTIONS 
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$   

        public function generateNewAuth($AccountAddress,$IpAddress,$Device,$Location){
                $existingAccount = $this->Authentications_Model->read_by_address($AccountAddress);

                $type = empty($existingAccount) ? "new" : "old"; // IF HAS RECORDS OR NONE

                $text = random_string('alnum', 10);
                $newAuthToken = password_hash($text, PASSWORD_BCRYPT);
                $newAuthTokenCreationTime = $this->get_current_timestamp();
                $newAuthTokenExpirationTime = $this->get_current_timestamp_add($newAuthTokenCreationTime);
                
                $data = [
                        'Account_Address' => $AccountAddress,
                        'AuthToken' => $newAuthToken,
                        'AuthCreationTime' => $newAuthTokenCreationTime,
                        'AuthExpirationTime' => $newAuthTokenExpirationTime,
                        'IpAddress' => $IpAddress,
                        'Device' => $Device,
                        'Location' => $Location
                ];  

                if ($type === "old") { 
                        $this->db->where('Account_Address', $AccountAddress);
                        $this->db->update('tbl_authentications', $data);
                } elseif ($type === "new") { 
                        $this->db->insert('tbl_authentications', $data);
                }
                return TRUE;
        }

        public function generateOTP($AccountAddress) {
                $OTP = $this->Authentications_Model->update_otp($AccountAddress);
                if ($OTP){
                        return FALSE;
                } else {
                        $receiver = $this->getAccountsByAddress($AccountAddress)->Email;
                        // if ($this->sendMmail($receiver,$OTP)){
                        //         return TRUE;
                        // } else {
                        //         return FALSE;
                        // }
                }
        }

        public function validateOTP($AccountAddress, $OTP) {
                $tbl_authentications = $this->Authentications_Model->read_by_address($AccountAddress);
                if ($OTP === $tbl_authentications->OtpCode) {
                        $cretionTime = strtotime($tbl_authentications->OtpCreationTime); // First timestamp
                        $expirationTime = strtotime($tbl_authentications->OtpExpirationTime); // Second timestamp
                        if ($cretionTime <= $expirationTime) {
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        public function validatePIN($AccountAddress, $PIN) {
                $Account = $this->getAccountsByAddress($AccountAddress);
                if ($PIN === $Account->PinCode) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        public function validateNewPIN($AccountAddress) {
                $Account = $this->getAccountsByAddress($AccountAddress);
                if (empty($Account->PinCode)) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        public function updatePIN($AccountAddress, $PIN) {
                $tbl_webaccounts = $this->WebAccounts_Model->read_by_address($AccountAddress);
                if ($tbl_webaccounts) {
                        $this->WebAccounts_Model->update_pin($AccountAddress, $PIN);
                        return TRUE;
                }
                
                $tbl_usersaccount = $this->UsersAccount_Model->read_by_address($AccountAddress);
                if ($tbl_usersaccount){
                        $this->UsersAccount_Model->update_pin($AccountAddress, $PIN);
                        return TRUE;
                }

                $tbl_guardiansaccount = $this->GuardianAccount_Model->read_by_address($AccountAddress);
                if ($tbl_guardiansaccount){
                        $this->GuardianAccount_Model->update_pin($AccountAddress, $PIN);
                        return TRUE;
                }

                return FALSE;
        }

        public function validateAccountIfOnline($AccountAddress) {
                $result = $this->getAccountsByAddress($AccountAddress);
                if ($result && $result->IsAccountActive === 1) {
                        return  TRUE;
                } else {
                        return  FALSE;
                }
        }

        public function validateIfNewAccountLogin($AccountAddress,$IpAddress,$Device,$Location) {
                $result = $this->LoginHistory_Model->read_by_specific($AccountAddress,$IpAddress,$Device,$Location);
                if ($result) {
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

        public function validateIfAccountHasPINCode($AccountAddress) {
                $result = $this->getAccountsByAddress($AccountAddress);
                if ($result && !($result->PinCode === null || $result->PinCode === '')){
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// TRANSACTIONS FUNCTIONS 
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$   






}
