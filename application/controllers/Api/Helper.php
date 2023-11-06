<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Helper extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->helper('string');
                $this->load->library(['form_validation']);
        }

        public function Process() {

                $clientIP = $this->input->ip_address();

                $response =  ['Success' => True, 'Target' => null, 'Parameters' => $clientIP, 'Response' => ''];

                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
}