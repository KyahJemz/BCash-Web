<?php

class Configurations_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function Update($params){
        $existingData = $this->db->get_where('tbl_configurations', ['Title' => $params['Title']])->row_array();

        if ($existingData) {
            if ($existingData['Value'] !== $params['Value'] || $existingData['Description'] !== $params['Description']) {
                $data = [
                    'Value' => $params['Value'],
                    'Description' => (empty($params['Description'])) ? null : $params['Description'],
                ];
                
                $this->db->where('Title', $params['Title']);
                $this->db->update('tbl_configurations', $data);

                return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function Read(){
        $this->db->select('
            Title,
            Value,
            Description
        ');
        $this->db->from('tbl_configurations');
        $result = $this->db->get()->result();

        return $result;
    }

    public function IsMaintenance() {
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'IsMaintenance')
            ->get()
            ->row();
        if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => 'The server is currently running normally.'];
        } else if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => 'The server is currently undergoing maintenance. ' . $result->Description];
        } else {
            return ['Success' => TRUE, 'Response' => 'The server is temporarily unreachable. Please try again later.'];
        }
    }

    public function AndroidAppVersion($Version) {
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'AndroidAppVersion')
            ->get()
            ->row();    
    
        if ($result->Value === $Version) {
            return ['Success' => TRUE, 'Response' => 'This version is up to date.'];
        } else if ($result->Value === 'TRUE') {
            return ['Success' => FALSE, 'Response' => 'The current version is '.$result->Value.', Please update your application.' ];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function WebAppVersion($Version){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'WebAppVersion')
            ->get()
            ->row();    

        if ($result->Value === $Version) {
            return ['Success' => TRUE, 'Response' => 'The version is up to date.'];
        } else if ($result->Value === 'TRUE') {
            return ['Success' => FALSE, 'Response' => 'The version is not supported.'];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function CanTransactions(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'Transactions')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function CanTransfers(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'Transfers')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function CanCashIn(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'CashIn')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function AccountingAccess(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'Accounting')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function MerchantAdminAccess(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'MerchantAdmin')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function MerchantStaffAccess(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'MerchantStaff')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function UserAccess(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'User')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function GuestAccess(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'Guest')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }

    public function GuardianAccess(){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'Guardian')
            ->get()
            ->row();    

        if ($result->Value === '1') {
            return ['Success' => TRUE, 'Response' => $result->Description];
        } else if ($result->Value === '0') {
            return ['Success' => FALSE, 'Response' => $result->Description];
        } else {
            return ['Success' => FALSE, 'Response' => 'The server is unreachable at the moment. Please try again later.'];
        }
    }
}
