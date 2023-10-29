<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Items_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Items_Model',
                     'Merchants_Model',
                     'ActivityLogs_Model',
              ]);
       }

       public function Add_Item ($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('ItemName', 'ItemName', 'trim|required');
              $this->CI->form_validation->set_rules('ItemCost', 'ItemCost', 'trim|required|numeric');
              $this->CI->form_validation->set_rules('ItemCategory', 'ItemCategory', 'trim|required');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $ItemName = $this->CI->Functions_Model->sanitize($requestPostBody['ItemName']);
              $ItemCost = $this->CI->Functions_Model->sanitize($requestPostBody['ItemCost']);
              $ItemCategory = $this->CI->Functions_Model->sanitize($requestPostBody['ItemCategory']);
              $MerchantsCategory_Id = $this->CI->Merchants_Model->get_categoryId(array('Account_Address'=>$Account->WebAccounts_Address));
              $ModifiedTimestamp = '';

              $this->CI->db->trans_start(); 

                     $this->CI->Items_Model->create(array(
                            'ItemCategory' => $ItemCategory,
                            'MerchantsCategory_Id' => $MerchantsCategory_Id->MerchantsCategory_Id,
                            'Name' =>  $ItemName,
                            'Price' => $ItemCost,
                            'Image' => 'default.png',
                            'ModifiedTimestamp' => $ModifiedTimestamp,
                     ));

                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Target_Account_Address' => $Account->WebAccounts_Address,
                            'Action' => 'Add',
                            'Task' => 'Added new Item ['.$ItemName.'].',
                     ));

              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Item Uploaded!'];

       }

       public function Get_Items ($Account){

              $MerchantsCategory_Id = $this->CI->Merchants_Model->get_categoryId(array('Account_Address'=>$Account->WebAccounts_Address));

              $Items = $this->CI->Items_Model->read_by_merchant_category(array(
                     'MerchantsCategory_Id' => $MerchantsCategory_Id->MerchantsCategory_Id,
              ));

              return ['Success' => True,'Target' => null,'Parameters' => $Items,'Response' => ''];
       }

       public function Update_Item ($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('ItemId', 'ItemId', 'trim|required|numeric|max_length[6]');
              $this->CI->form_validation->set_rules('ItemName', 'ItemName', 'trim|required|max_length[50]');
              $this->CI->form_validation->set_rules('ItemCost', 'ItemCost', 'trim|required|numeric');
              $this->CI->form_validation->set_rules('ItemCategory', 'ItemCategory', 'trim|required|max_length[50]');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $ItemId = $this->CI->Functions_Model->sanitize($requestPostBody['ItemId']);
              $ItemName = $this->CI->Functions_Model->sanitize($requestPostBody['ItemName']);
              $ItemCost = $this->CI->Functions_Model->sanitize($requestPostBody['ItemCost']);
              $ItemCategory = $this->CI->Functions_Model->sanitize($requestPostBody['ItemCategory']);

              $item = $this->CI->Items_Model->get_item_by_Id(array('MerchantItems_Id'=>$ItemId));
              $Changes = 'Changes: ';

              $this->CI->db->trans_start(); 

                     if ($ItemName !== $item->Name){
                            $this->CI->Items_Model->update_Name(array(
                                   'Name' => $ItemName,
                                   'MerchantItems_Id' => $ItemId,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Target_Account_Address' => $Account->WebAccounts_Address,
                                   'Action' => 'Edit',
                                   'Task' => 'Updated ItemName from ['.$item->Name.'] to ['.$ItemName.'].',
                            ));
                            $Changes = $Changes . 'ItemName, ';
                     }

                     if ($ItemCost !== $item->Price){
                             $this->CI->Items_Model->update_Price(array(
                                   'Price' => $ItemCost,
                                   'MerchantItems_Id' => $ItemId,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Target_Account_Address' => $Account->WebAccounts_Address,
                                   'Action' => 'Edit',
                                   'Task' => 'Updated ItemCost from ['.$item->Price.'] to ['.$ItemCost.'].',
                            ));
                            $Changes = $Changes . 'ItemCost, ';
                     }

                     if ($ItemCategory !== $item->ItemCategory){
                            $this->CI->Items_Model->update_ItemCategory(array(
                                   'ItemCategory' => $ItemCategory,
                                   'MerchantItems_Id' => $ItemId,
                            ));
                            $this->CI->ActivityLogs_Model->create(array(
                                   'Account_Address' => $Account->WebAccounts_Address,
                                   'Target_Account_Address' => $Account->WebAccounts_Address,
                                   'Action' => 'Edit',
                                   'Task' => 'Updated ItemCategory from ['.$item->ItemCategory.'] to ['.$ItemCategory.'].',
                            ));
                            $Changes = $Changes . 'ItemCategory, ';
                     }
                    
              $this->CI->db->trans_complete(); 

              if ($this->CI->db->trans_status() === FALSE) {
                     $this->CI->db->trans_rollback();
                     $error = $this->CI->db->error();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $error];
              }

              if ($Changes === 'Changes: '){
                     $Changes = "No changes!";
              }

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => $Changes];
       }

       public function Deactivate_Item ($Account, $requestPostBody){

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('PinCode', 'PinCode', 'trim|required|numeric|max_length[6]');
              $this->CI->form_validation->set_rules('ItemId', 'ItemId', 'trim|required|numeric');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $PinCode = $this->CI->Functions_Model->sanitize($requestPostBody['PinCode']);
              $ItemId = $this->CI->Functions_Model->sanitize($requestPostBody['ItemId']);
              $MerchantsCategory_Id = $this->CI->Merchants_Model->get_categoryId(array('Account_Address'=>$Account->WebAccounts_Address))->MerchantsCategory_Id;

              if (!password_verify($PinCode,$Account->PinCode)) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Invalid PIN Code!'];
              }

              if (empty($this->CI->Items_Model->validate_item_ownership(array('MerchantItems_Id'=>$ItemId, 'MerchantsCategory_Id'=>$MerchantsCategory_Id)))) {
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => 'Not Your Item!'];
              }

              $this->CI->Items_Model->deactivate_item(array(
                     'MerchantItems_Id'=>$ItemId
              ));

              $this->CI->ActivityLogs_Model->create(array(
                     'Account_Address' => $Account->WebAccounts_Address,
                     'Target_Account_Address' => $Account->WebAccounts_Address,
                     'Action' => 'Delete',
                     'Task' => 'Deleted Item ['.$ItemId.'].',
              ));

              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Item successfully deactivated!'];
       }
}