<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->library('form_validation');
                $this->load->model([
                'ActorCategory_Model', 
                'Functions_Model',
                ]);
                $this->load->library('Actors/Accounting_Actor', NULL, 'Accounting_Actor');
                $this->load->library('Actors/Administrator_Actor', NULL, 'Administrator_Actor');
                $this->load->library('Actors/Guest_Actor', NULL, 'Guest_Actor');
                $this->load->library('Actors/MerchantAdmin_Actor', NULL, 'MerchantAdmin_Actor');
                $this->load->library('Actors/MerchantStaff_Actor', NULL, 'MerchantStaff_Actor');
                $this->load->library('Actors/Guardian_Actor', NULL, 'Guardian_Actor');
                $this->load->library('Actors/User_Actor', NULL, 'User_Actor');
        }

        public function Process() {

                $clientIP = $this->input->ip_address();

                $response =  ['Success' => True, 'Target' => null, 'Parameters' => $clientIP, 'Response' => ''];

                $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
}