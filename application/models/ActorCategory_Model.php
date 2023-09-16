<?php
class ActorCategory_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_address($Id){
        $result = $this->db
            ->select('*')
            ->from('tbl_actorcategory')
            ->where('ActorCategory_Id ', $Id)
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }
}
