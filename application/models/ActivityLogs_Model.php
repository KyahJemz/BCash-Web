<?php
class ActivityLogs_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_id($params){
        return $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->where('ActivityLogs_Id ', $params['Id'])
            ->get()
            ->row();
    }

    public function read_by_address($params){
        return $this->db
            ->select('
                logs.*,
            ')
            ->from('tbl_activitylogs as logs')
            ->group_start()
                ->where('logs.Target_Account_Address', $params['Account_Address'])
                ->or_where('logs.Account_Address', $params['Account_Address'])
            ->group_end()
            ->order_by('logs.Timestamp', 'DESC')
            ->get()
            ->result();
    }

    public function read_by_address_bulk($params){
        return $this->db
            ->select('
                logs.*,
            ')
            ->from('tbl_activitylogs as logs')
            ->group_start()
                ->where_in('logs.Target_Account_Address', $params['Account_Address'])
                ->or_where_in('logs.Account_Address', $params['Account_Address'])
            ->group_end()
            ->order_by('logs.Timestamp', 'DESC')
            ->get()
            ->result();
    }

    public function read_by_target_address($params){
        return $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->where('Target_Account_Address', $params['Target_Account_Address'])
            ->get()
            ->result();
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
        return $this->db
            ->select('*')
            ->from('tbl_activitylogs')
            ->get();
    }

    public function create($params){
        $data = [
            'Account_Address' => $params['Account_Address'],
            'Target_Account_Address' => $params['Target_Account_Address'],
            'Action' => $params['Action'],
            'Task' => $params['Task'],
        ];
        $this->db->insert('tbl_activitylogs', $data);
        return $this->db->insert_id();
    }
}
