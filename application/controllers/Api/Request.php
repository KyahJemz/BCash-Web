<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Request extends CI_Controller {

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

    private $AuthorizationToken;
    private $AccountAddress;
    private $ClientVersion;
    private $IpAddress;
    private $Device;
    private $Location;
    private $Intent;

    private $Account;
    private $ActorCategory;

    public function Process() {

        $headers = $this->input->request_headers();

                foreach ($headers as $header => $value) {
                        log_message('debug', $header . ': ' . $value);
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $body = file_get_contents('php://input');
                        log_message('debug', 'Request Body: ' . $body);
                }

        $this->AuthorizationToken = $this->Functions_Model->sanitize($this->input->get_request_header('Authorization', TRUE));
        $this->AccountAddress = $this->Functions_Model->sanitize($this->input->get_request_header('AccountAddress', TRUE));
        $this->ClientVersion = $this->Functions_Model->sanitize($this->input->get_request_header('ClientVersion', TRUE));
        $this->IpAddress = $this->Functions_Model->sanitize($this->input->get_request_header('IpAddress', TRUE));
        $this->Device = $this->Functions_Model->sanitize($this->input->get_request_header('Device', TRUE));
        $this->Location = $this->Functions_Model->sanitize($this->input->get_request_header('Location', TRUE));
        $this->Intent = $this->Functions_Model->sanitize($this->input->get_request_header('Intent', TRUE));


        $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
        
        $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

        $ValidateHeaders = $this->ValidateHeaders();

        if ($ValidateHeaders['Success']) {

            $this->Account = $this->Functions_Model->getAccountsByAddress($this->AccountAddress);

            $this->ActorCategory = $this->ActorCategory_Model->read_by_Id($this->Account->ActorCategory_Id);

            $FileName = null;

            switch ($this->ActorCategory) {
                case 'Administrator':
                    $response = $this->Administrator_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'Accounting':
                    $response = $this->Accounting_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'Merchant Admin':
                    $response = $this->MerchantAdmin_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'Merchant Staff':
                    $response = $this->MerchantStaff_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody, $FileName);
                    break;
                case 'User':
                    $response = $this->User_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'Guest':
                    $response = $this->Guest_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'Guardian':
                    $response = $this->Guardian_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                default:
                    $response = [
                        'Success' => False,
                        'Target' => 'Login',
                        'Parameters' => null,
                        'Response' => 'Invalid'
                    ]; 
            }
        } else {
            $response = $ValidateHeaders; 
        }

        $data = json_encode($response);
        log_message('debug','Return : '.$data);
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function ValidateHeaders(){
        log_message('debug', '--VALIDATING--');
        // Empty Headers
        if (empty($this->IpAddress) || empty($this->Device) || empty($this->Location) || empty($this->ClientVersion) || empty($this->Intent)) {
            return ['Success' => False,'Target' => 'Login','Parameters' => null,'Response' => 'Invalid Headers']; 
        } 
        // Invalid Login
        if (empty($this->AccountAddress) || empty($this->AuthorizationToken)) {
            return ['Success' => False,'Target' => 'Login','Parameters' => null,'Response' => 'Login Required!']; 
        }
        // Validation Of Account
        $validated = $this->Functions_Model->validateRequest($this->AccountAddress, $this->AuthorizationToken, $this->IpAddress, $this->Device, $this->Location, $this->ClientVersion);
        if ($validated['Success']) {
            return ['Success' => True,'Target' => null,'Parameters' => null,'Response' => 'Success']; 
        } else {
            return $validated;
        }
        // Validation Failed 
    }
}