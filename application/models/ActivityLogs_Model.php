<?php
class ActivityLogs_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_id($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->where('ActivityLogs_Id ', $params['Id'])
            ->get()
            ->row();
        return ($result) ? $result : FALSE;
    }

    public function read_by_address($params){
        $page = isset($params['PageNumber']) ? (int)$params['PageNumber'] : 1; 
        $results_per_page = isset($params['ResultsPerPage']) ? (int)$params['ResultsPerPage'] : 50;
        $offset = ($page - 1) * $results_per_page;

        $result = $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->where('Account_Address', $params['Account_Address'])
            ->limit($results_per_page, $offset)
            ->get();

        return ($result) ? $result : FALSE;
    }

    public function read_by_target_address($params){
        $page = isset($params['PageNumber']) ? (int)$params['PageNumber'] : 1; 
        $results_per_page = isset($params['ResultsPerPage']) ? (int)$params['ResultsPerPage'] : 50;
        $offset = ($page - 1) * $results_per_page;

        $result = $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->where('Target_Account_Address', $params['Target_Account_Address'])
            ->limit($results_per_page, $offset)
            ->get();

        return ($result) ? $result : FALSE;
    }

    // public function read_by_merchant($params){

    //     $Actor = $params['MerchantsCategory_Id']; 

    //     $page = isset($params['PageNumber']) ? (int)$params['PageNumber'] : 1; 
    //     $results_per_page = isset($params['ResultsPerPage']) ? (int)$params['ResultsPerPage'] : 50;
    //     $offset = ($page - 1) * $results_per_page;

    //     $result = $this->db
    //         ->select('*')
    //         ->from('tbl_activitylogs')
    //         ->where('Account_Address', $params['Account_Address'])
    //         ->limit($results_per_page, $offset)
    //         ->get();

    //     return ($result) ? $result : FALSE;
    // }

    public function read_all($params) {
        $page = isset($params['PageNumber']) ? (int)$params['PageNumber'] : 1; 
        $results_per_page = isset($params['ResultsPerPage']) ? (int)$params['ResultsPerPage'] : 50;
        $offset = ($page - 1) * $results_per_page;
    
        $result = $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->limit($results_per_page, $offset)
            ->get();
    
        return ($result) ? $result : FALSE;
    }

    public function create($params){
        $data = [
            'Account_Address' => $params['Account_Address'],
            'Target_Account_Address' => $params['Target_Account_Address'],
            'Action' => $params['Action'],
            'Task' => $params['Task'],
        ];
        $this->db->insert('tbl_activitylogs', $data);
        $result = $this->db->insert_id();
        return ($result) ? $result : FALSE;
    }
}
