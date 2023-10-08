<?php
class MerchantItems_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read_by_id($params){
        $result = $this->db
            ->select('*')
            ->from('tbl_MerchantItems')
            ->where('MerchantItems_Id ', $params['ItemIds'])
            ->get()
            ->row();
        if ($result) {
            return $result;
        } else {
            return null; 
        }
    }

    public function read_all_by_id($params){
        $itemIds = $params['ItemId'];
        if (!empty($itemIds)) {
            $result = $this->db
                ->select('*')
                ->from('tbl_MerchantItems')
                ->where_in('MerchantItems_Id', $itemIds)
                ->get();
            return $result->result();
        }
        return null;
    }
}
