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