<?php

class MerchantAdmin extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->helper('string');
                $this->load->helper('url');
                $this->load->library(['form_validation','session']);
                $this->load->model([
                        'Functions_Model',
                        'Authentications_Model',
                        'Merchants_Model'
                ]);
        }


        public function index($page = 'merchantadmin')
        {
                $config['base_url'] = 'http://localhost/index.php/';

                $requestPostBody = $this->input->raw_input_stream;
                
                if (empty($requestPostBody)) {
                        redirect('Login');
                        return;  
                }

                $this->form_validation->set_rules('AccountAddress', 'AccountAddress', 'trim|required|alpha_numeric|exact_length[15]');
                $this->form_validation->set_rules('AuthToken', 'AuthToken', 'trim|required');
                $this->form_validation->set_rules('IpAddress', 'IpAddress', 'trim|required');
                $this->form_validation->set_rules('Device', 'Device', 'trim|required');
                $this->form_validation->set_rules('Location', 'Location', 'trim|required');

                if ($this->form_validation->run() === FALSE) {
                        $validationErrors = validation_errors();
                        redirect('Login');
                        return;  
                }

                $AccountAddress = $this->Functions_Model->sanitize($this->input->post('AccountAddress'));
                $AuthToken = $this->Functions_Model->sanitize($this->input->post('AuthToken'));
                $IpAddress = $this->Functions_Model->sanitize($this->input->post('IpAddress'));
                $Device = $this->Functions_Model->sanitize($this->input->post('Device'));
                $Location = $this->Functions_Model->sanitize($this->input->post('Location'));

                $DeviceNew = $_SERVER['HTTP_USER_AGENT'];
                $pattern = '/\((.*?)\)/';
                if (preg_match($pattern, $DeviceNew, $matches)) {
                        $DeviceNew = $matches[1];
                } else {
                        $DeviceNew = "Unknown";
                }
 
                $data['IpAddress'] = $this->input->ip_address();
                $data['Device'] = $DeviceNew;
                $data['Location'] = "Unknown";
                $data['AccountAddress'] = "Unknown";
                $data['AuthToken'] = "Unknown";
                $data['BaseURL'] = "http://localhost/index.php/";

                if ($data['IpAddress'] != $IpAddress || $data['Location'] != $Location || $data['Device'] != $Device) {
                         redirect('Login/index');
                        return;  
                }

                $Validation = $this->Functions_Model->validateRequest($AccountAddress, $AuthToken, $IpAddress, $Device, $Location, "");

                if (!$Validation['Success']) {
                        redirect('Login/index');
                        return;  
                }

                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                {
                        show_404();
                }

                $this->load->view('pages/'.$page, $data);

                $Merchant = $this->Merchants_Model->read_merchant_by_address($AccountAddress);
                echo '
                        <script>
                                var AccountAddress = ' . json_encode($AccountAddress) . ';
                                var AuthToken = ' . json_encode($AuthToken) . ';
                                const IpAddress = ' . json_encode($data['IpAddress']) . ';
                                const Device = ' . json_encode($data['Device']) . ';
                                const Location = ' . json_encode($data['Location']) . ';
                                const BaseURL = ' . json_encode($data['BaseURL']) . ';
                                const MerchantCategoryId = ' . json_encode($Merchant->MerchantsCategory_Id) . ';
                        </script>
                ';
        }
}