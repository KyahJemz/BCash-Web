<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Notifications_Model',
              ]);
       }

       public function Add_Notifications($Account,$requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Title', 'Title', 'trim|required|max_length[255]');
              $this->CI->form_validation->set_rules('Content', 'Content', 'trim|required');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Notification_ID' => null,'Response' => ''. $validationErrors];
              }

              $Title = $this->CI->Functions_Model->sanitize($requestPostBody['Title']);
              $Content = $this->CI->Functions_Model->sanitize($requestPostBody['Content']);
              
              if ($this->CI->Notifications_Model->Create(array(
                     'Creator_Account_Address' => $Account->WebAccounts_Address,
                     'Title' => $Title,
                     'Content' => $Content,
              ))) {
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Task' => 'Created notification ['.$Title.'].',
                     ));
              }

              $Notifications = $this->CI->Notifications_Model->read();
  
              return ['Success' => True,'Target' => null,'Parameters' => $Notifications,'Response' => 'Notification added successfully.'];
         }



       public function Delete_Notifications($Account,$requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('Notification_ID', 'Notification_ID', 'trim|required');
       
              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Notification_ID' => null,'Response' => ''. $validationErrors];
              }

              $Notification_ID = $this->CI->Functions_Model->sanitize($requestPostBody['Notification_ID']);
              
              if ($this->CI->Notifications_Model->Delete(array(
                     'Notification_ID' => $Notification_ID,
              ))) {
                     $this->CI->ActivityLogs_Model->create(array(
                            'Account_Address' => $Account->WebAccounts_Address,
                            'Task' => 'Deleted notification ['.$Notification_ID.'].',
                     ));
              }
  
              return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Deleted '.$Notification_ID];
         }
  


/* 
-- ---------------------
   VIEW MY NOTIFICATIONS
   - all actors
-- ---------------------
*/  
       public function View_My_Notifications() {

            $Notifications = $this->CI->Notifications_Model->read();

            return ['Success' => True,'Target' => null,'Parameters' => $Notifications,'Response' => ''];
       }



/* 
-- ---------------------
   VIEW MY NOTIFICATIONS DETAILS
   - all actors
-- ---------------------
*/  
       public function View_My_Notifications_Details($requestPostBody) {

              $this->CI->form_validation->set_data($requestPostBody);

              $this->CI->form_validation->set_rules('NotificationId', 'NotificationId', 'trim|required|number');

              if ($this->CI->form_validation->run() === FALSE) {
                     $validationErrors = validation_errors();
                     return ['Success' => False,'Target' => null,'Parameters' => null,'Response' => ''. $validationErrors];
              }

              $NotificationId = $this->CI->Functions_Model->sanitize($requestPostBody['NotificationId']);

              $NotificationsDetails = $this->CI->Notifications_Model->read_by_id(array(
                     'Id' => $NotificationId,
              ));
              
              return ['Success' => True,'Target' => null,'Parameters' => $NotificationsDetails,'Response' => ''];
         }
     

}