<?php
class Notifications_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read(){
        $result = $this->db
            ->select('*')
            ->from('tbl_notifications')
            ->order_by('Timestamp', 'DESC') 
            ->get()
            ->result();
        return ($result) ? $result : [];
    }

    public function read_by_id($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_notifications')
            ->where('Notification_ID ', $params['Id'])
            ->get()
            ->row();
        return ($result) ? $result : null;
    }

    public function create($params){
        $data = [
            'Creator_Account_Address' => $params['Creator_Account_Address'],
            'Level' => $params['Level'],
            'Title ' => $params['Title'],
            'Content ' => $params['Content'],
        ];
        $this->db->insert('tbl_notifications', $data);
        $result = $this->db->insert_id();
        return ($result) ? TRUE : FALSE;
    }
}
