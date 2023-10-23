<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'ActivityLogs_Model',
              ]);
       }


}