<?php
class SchoolId_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_email($params){
        return $this->db
            ->select('*')
            ->from('tbl_schoolid')
            ->where('Email ', $params['Email'])
            ->get()
            ->row();
    }

}
