<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validation_Library {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
    }

    public function validate_username($username) {
        $this->CI->form_validation->set_rules('username', 'Username', 'required|min_length[5]');
        return $this->CI->form_validation->run();
    }

    public function validate_email($email) {
        $this->CI->form_validation->set_rules('email', 'Email', 'required|valid_email');
        return $this->CI->form_validation->run();
    }
}