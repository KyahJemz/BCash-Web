<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whitelist_Actions {

       protected $CI;

       public function __construct() {
              $this->CI =& get_instance();
              $this->CI->load->database();
              $this->CI->load->library('form_validation');
              $this->CI->load->model([
                     'Functions_Model',
              ]);
       }

       public function Verify($params){
              
       }


}