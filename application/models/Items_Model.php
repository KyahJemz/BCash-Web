<?php
class Items_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create($params){
        $data = [
            'ItemCategory' => $params['ItemCategory'],
            'MerchantsCategory_Id' => $params['MerchantsCategory_Id'],
            'Name' => $params['Name'],
            'Price' => $params['Price'],
            'Image' => $params['Image'],
            'ModifiedTimestamp' => $params['ModifiedTimestamp']
        ];
        $this->db->insert('tbl_merchantitems', $data);
    }

    public function validate_item_ownership($params){
        $this->db
            ->select('*')
            ->from('tbl_merchantitems')
            ->where('MerchantItems_Id',$params['MerchantItems_Id'])
            ->where('MerchantsCategory_Id',$params['MerchantsCategory_Id']);

        $result = $this->db->get()->result();
        return $result;
    }

    public function get_item_by_Id($params){
        $this->db
            ->select('*')
            ->from('tbl_merchantitems')
            ->where('MerchantItems_Id',$params['MerchantItems_Id']);

        $result = $this->db->get()->row();
        return $result;
    }

    public function read_by_merchant_category($params){
        $this->db
            ->select('*')
            ->from('tbl_merchantitems')
            ->where('MerchantsCategory_Id',$params['MerchantsCategory_Id'])
            ->where('IsActive','1');

        $result = $this->db->get()->result();

        return $result;
    }

    public function deactivate_item($params){
        $data = [
            'IsActive' => 0,
        ];
        $this->db->where('MerchantItems_Id', $params['MerchantItems_Id']);
        $this->db->update('tbl_merchantitems', $data);
        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_ItemCategory($params){
        $data = [
            'ItemCategory' => $params['ItemCategory'],
        ];
        $this->db->where('MerchantItems_Id', $params['MerchantItems_Id']);
        $this->db->update('tbl_merchantitems', $data);
        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_Name($params){
        $data = [
            'Name' => $params['Name'],
        ];
        $this->db->where('MerchantItems_Id', $params['MerchantItems_Id']);
        $this->db->update('tbl_merchantitems', $data);
        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_Price($params){
        $data = [
            'Price' => $params['Price'],
        ];
        $this->db->where('MerchantItems_Id', $params['MerchantItems_Id']);
        $this->db->update('tbl_merchantitems', $data);
        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_Image($params){
        $data = [
            'Image' => $params['Image'],
        ];
        $this->db->where('MerchantItems_Id', $params['MerchantItems_Id']);
        $this->db->update('tbl_merchantitems', $data);
        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }

    public function update_ModifiedTimestamp($params){
        $data = [
            'ModifiedTimestamp' => $params['ModifiedTimestamp'],
        ];
        $this->db->where('MerchantItems_Id', $params['MerchantItems_Id']);
        $this->db->update('tbl_merchantitems', $data);
        
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE ;
    }





   
}
