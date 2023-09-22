<?php

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->load->model('ActorCategory_Model');
        $this->load->model('Functions_Model');
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

    public function handleRequest() {

        $this->AuthorizationToken = $this->Functions_Model->sanitize($this->input->get_request_header('Authorization', TRUE));
        $this->AccountAddress = $this->Functions_Model->sanitize($this->input->get_request_header('AccountAddress', TRUE));
        $this->ClientVersion = $this->Functions_Model->sanitize($this->input->get_request_header('ClientVersion', TRUE));
        $this->IpAddress = $this->Functions_Model->sanitize($this->input->get_request_header('IpAddress', TRUE));
        $this->Device = $this->Functions_Model->sanitize($this->input->get_request_header('Device', TRUE));
        $this->Location = $this->Functions_Model->sanitize($this->input->get_request_header('Location', TRUE));
        $this->Intent = $this->Functions_Model->sanitize($this->input->get_request_header('Intent', TRUE));

        $requestPostBody = $this->input->raw_input_stream; // READ POST BODY
        $requestPostBody = json_decode($requestPostBody, TRUE); // DECODES

        $this->form_validation->set_data($requestPostBody);

        $ValidateHeaders = $this->ValidateHeaders();

        if ($ValidateHeaders['success']) {

            $this->Account = $this->Functions_Model->getAccountsByAddress($this->AccountAddress);

            $this->ActorCategory = $this->ActorCategory_Model->read_by_Id($this->Account->ActorCategory_Id);

            switch ($this->ActorCategory) {
                case 'Administrator':
                    $response = $this->Administrator();
                    break;
                case 'Accounting':
                    $response = $this->Accounting();
                    break;
                case 'Merchant Admin':
                    $response = $this->MerchantAdmin();
                    break;
                case 'Merchant Staff':
                    $response = $this->MerchantStaff();
                    break;
                case 'User':
                    $response = $this->Users();
                    break;
                case 'Guest':
                    $response = $this->Users();
                    break;
                case 'Parents/Guaridan':
                    $response = $this->Guardians();
                    break;
                default:
                    $response = $this->defaultAction();
                    break;
            }
        } else {
            $response = $ValidateHeaders; 
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function ValidateHeaders(){
        // Empty Headers
        if (empty($this->IpAddress) || empty($this->Device) || empty($this->Location) || empty($this->ClientVersion)) {
            return ['success' => FALSE, 'response' => 'Invalid Headers']; 
        } 
        // Invalid Login
        if (empty($this->AccountAddress) || empty($this->AuthorizationToken)) {
            return ['success' => FALSE, 'intent' => 'login', 'response' => 'Login Required']; 
        }
        // Validation Of Account
        $validated = $this->Functions_Model->validateRequest($this->AccountAddress, $this->AuthorizationToken, $this->IpAddress, $this->Device, $this->Location, $this->ClientVersion);
        if ($validated['success']) {
            return ['success' => TRUE, 'response' => 'success']; 
        }
        // Validation Failed
        return $validated; 
    }

    public function defaultAction() 
    {
            // can the variable $met read here?

    
    }

    public function Administrator()
    {
        switch ($this->Intent) {
            case 'View Transactions History':
                $response = null;
                break;

            case 'View Accounts':
                $response = null;
                break;

            case 'Update Account':
                $response = null;
                break;

            case 'View Settings':
                $response = null;
                break;

            case 'Update Settings':
                $response = null;
                break;

            case 'View Notifications':
                $response = null;
                break;

            case 'Set Notifications':
                $response = null;
                break;

            case 'View Configurations':
                $response = null;
                break;

            case 'Update Configurations':
                $response = null;
                break;

            case 'View Activity Logs':
                $response = null;
                break;

            case 'View Login History':
                $response = null;
                break;

            case 'Update Login History':
                $response = null;
                break;

            case 'Clear Login History':
                $response = null;
                break;

            case 'View Charts':
                $response = null;
                break;

            case 'Logout':
                $response = null;
                break;
                
            default:
                $response = ['success' => FALSE, 'response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }

    public function Accounting()
    {
        switch ($this->Intent) {
            case 'View Transactions History':
                $response = null;
                break;

            case 'View Accounts':
                $response = null;
                break;

            case 'Update Account':
                $response = null;
                break;

            case 'View Settings':
                $response = null;
                break;

            case 'Update Settings':
                $response = null;
                break;

            case 'View Notifications':
                $response = null;
                break;

            case 'View Activity Logs':
                $response = null;
                break;

            case 'View Login History':
                $response = null;
                break;

            case 'Update Login History':
                $response = null;
                break;

            case 'Clear Login History':
                $response = null;
                break;

            case 'View Charts':
                $response = null;
                break;

            case 'Make CashIn':
                $response = null;
                break;

            case 'View CashIn':
                $response = null;
                break;

            case 'View Receiver Details':
                $response = null;
                break;

            case 'View Fund Remitance':
                $response = null;
                break;

            case 'View Specific Fund Remitance':
                $response = null;
                break;

            case 'Update Specific Fund Remitance':
                $response = null;
                break;

            case 'Logout':
                $response = null;
                break;
                
            default:
                $response = ['success' => FALSE, 'response' => 'Invalid Intent or Not Permitted']; 
                break;
        }
        return $response;
    }

    public function MerchantAdmin()
    {
            
    
    }

    public function MerchantStaff()
    {
            
    
    }

    public function Users()
    {
            
    
    }

    public function Guardians()
    {
            
    
    }
}