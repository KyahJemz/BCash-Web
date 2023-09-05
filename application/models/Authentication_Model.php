<?php
class Authentication_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

public function sanitize($value) {
        if ($value === null) {
                return null; // Return null if the value is null
        }
        $value = $this->db->escape_str($value);
        // $value = $this->input->xss_clean($value);
        return $value;
}

public function authenticate($AccountAddress,$AuthToken){
        if (empty($AccountAddress) || empty($AuthToken)) {
                return FALSE;
        } else {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if ($AuthToken === $tbl_authentications->AuthToken) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
}


public function generateNewAuth($AccountAddress,$IpAddress,$Device,$Location){
        $existingAccount = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);

        $type = empty($existingAccount) ? "new" : "old"; // IF HAS RECORDS OR NONE

        if ($this->Authorization_Model->setAuthorization($type, $AccountAddress, $IpAddress, $Device, $Location)) {
                return TRUE; 
        } else {
                return FALSE; 
        }
}

public function generateOTP($AccountAddress) {
        $OTP = $this->Authorization_Model->setOTP($AccountAddress);
        if (empty($OTP)){
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

public function getAccountsByAddress($AccountAddress) {
        $tbl_webaccounts = $this->Login_Model->get_tbl_webaccounts_by_address($AccountAddress);
        if ($tbl_webaccounts) {
                return $tbl_webaccounts;
        }
        
        $tbl_usersaccount = $this->Login_Model->get_tbl_usersaccount_by_address($AccountAddress);
        if ($tbl_usersaccount){
                return $tbl_usersaccount;
        }

        $tbl_guardiansaccount = $this->Login_Model->get_tbl_guardiansaccount_by_address($AccountAddress);
        if ($tbl_guardiansaccount){
                return $tbl_guardiansaccount;
        }

        return FALSE;
}

public function validateAuthToken($AccountAddress, $AuthToken) {
        if (empty($AccountAddress) || empty($AuthToken)) {
                return FALSE;
        } else {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
                if ($AuthToken === $tbl_authentications->AuthToken) {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
}

public function validateOTP($AccountAddress, $OTP) {
        $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
        log_message('debug', $OTP . ' === ' . $tbl_authentications->OtpCode);
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
        $tbl_webaccounts = $this->Login_Model->get_tbl_webaccounts_by_address($AccountAddress);
        if ($tbl_webaccounts) {
                $this->Authorization_Model->updateWebsPIN($AccountAddress, $PIN);
                return TRUE;
        }
        
        $tbl_usersaccount = $this->Login_Model->get_tbl_usersaccount_by_address($AccountAddress);
        if ($tbl_usersaccount){
                $this->Authorization_Model->updateUsersPIN($AccountAddress, $PIN);
                return TRUE;
        }

        $tbl_guardiansaccount = $this->Login_Model->get_tbl_guardiansaccount_by_address($AccountAddress);
        if ($tbl_guardiansaccount){
                $this->Authorization_Model->updateParentsPIN($AccountAddress, $PIN);
                return TRUE;
        }

        return FALSE;
}

public function validateClient($AccountAddress, $IpAddress, $Device, $Location) {
        $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($AccountAddress);
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

public function validateAccountIfOnline($AccountAddress) {
        $result = $this->getAccountsByAddress($AccountAddress);
        if ($result && $result->IsAccountActive === 1) {
                return  TRUE;
        } else {
                return  FALSE;
        }
}

public function validateIfNewAccountLogin($AccountAddress,$IpAddress,$Device,$Location) {
        $result = $this->Authorization_Model->get_tbl_loginhistory_by_data($AccountAddress,$IpAddress,$Device,$Location);
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
}