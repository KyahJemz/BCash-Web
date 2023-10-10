<?php

class Request extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->load->model([
            'ActorCategory_Model', 
            'Functions_Model',
        ]);
        $this->load->library('Actor/Accounting_Actor', NULL, 'Accounting_Actor');
        $this->load->library('Actor/Administrator_Actor', NULL, 'Administrator_Actor');
        $this->load->library('Actor/Guest_Actor', NULL, 'Guest_Actor');
        $this->load->library('Actor/MerchantAdmin_Actor', NULL, 'MerchantAdmin_Actor');
        $this->load->library('Actor/MerchantStaff_Actor', NULL, 'MerchantStaff_Actor');
        $this->load->library('Actor/ParentsGuardian_Actor', NULL, 'ParentsGuardian_Actor');
        $this->load->library('Actor/User_Actor', NULL, 'User_Actor');
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

        $ValidateHeaders = $this->ValidateHeaders();

        if ($ValidateHeaders['Success']) {

            $this->Account = $this->Functions_Model->getAccountsByAddress($this->AccountAddress);

            $this->ActorCategory = $this->ActorCategory_Model->read_by_Id($this->Account->ActorCategory_Id);

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
                    $response = $this->MerchantStaff_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'User':
                    $response = $this->User_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
                case 'Guest':
                    $response = $this->Guest_Actor->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
                    break;
<<<<<<< HEAD
                case 'Guardian':
                    $response = $this->Guardians->Process($this->Account, $this->ActorCategory, $this->Intent, $requestPostBody);
=======
                case 'Parents/Guardian':
                    $response = $this->Guardians();
>>>>>>> 69e4b173af6dba75ad8aa00ba08e6fc112308a47
                    break;
                default:
                    $response = [
                        'Success' => False,
                        'Target' => 'Login',
                        'Parameters' => null,
                        'Response' => 'Invalid'
                    ]; 
                    break;
            }
        } else {
            $response = $ValidateHeaders; 
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function ValidateHeaders(){
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
        }
        // Validation Failed
<<<<<<< HEAD
        return ['Success' => False,'Target' => 'Login','Parameters' => null,'Response' => 'Validation Failed!' ];
=======
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

            case 'View Fund Remittance':
                $response = null;
                break;

            case 'View Specific Fund Remittance':
                $response = null;
                break;

            case 'Update Specific Fund Remittance':
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
            
    
>>>>>>> 69e4b173af6dba75ad8aa00ba08e6fc112308a47
    }
}