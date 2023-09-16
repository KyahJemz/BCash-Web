<?php
class Configurations_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //
    // FUNCTIONS
    //

    public function IsMaintenance() {
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'IsMaintenance')
            ->get()
            ->row();
        if ($result->Value === 'FALSE') {
            return ['success' => FALSE, 'response' => 'The server is currently running normally.'];
        } else if ($result->Value === 'TRUE') {
            return ['success' => TRUE, 'response' => 'The server is currently undergoing maintenance. ' . $result->Description];
        } else {
            return ['success' => TRUE, 'response' => 'The server is temporarily unreachable. Please try again later.'];
        }
    }

    public function ValidateMobileVersion($Version) {
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'MobileVersion')
            ->get()
            ->row();    
    
        if ($result->Value === $Version) {
            return ['success' => TRUE, 'response' => 'The version is up to date.'];
        } else if ($result->Value === 'TRUE') {
            return ['success' => TRUE, 'response' => 'The version is not supported.'];
        } else {
            return ['success' => TRUE, 'response' => 'The server is unreachable at the moment.'];
        }
    }

    public function ValidateWebVersion($Version){
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->where('Title', 'WebVersion')
            ->get()
            ->row();    

        if ($result->Value === $Version) {
            return ['success' => TRUE, 'response' => 'The version is up to date.'];
        } else if ($result->Value === 'TRUE') {
            return ['success' => TRUE, 'response' => 'The version is not supported.'];
        } else {
            return ['success' => TRUE, 'response' => 'The server is unreachable at the moment.'];
        }
    }

    //
    // DATABASE
    //

    public function read() {
        $result = $this->db
            ->select('*')
            ->from('tbl_configurations')
            ->get();
        if ($result->num_rows() > 0) {
            return [TRUE, $result->result()];
        } else {
            return [FALSE];
        }
    }
}
