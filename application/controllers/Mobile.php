<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mobile extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->helper('string');
                $this->load->library(['form_validation','session']);
        }

        public function index($page = 'mobile')
        {
                $config['base_url'] = base_url();

                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php')) {
                        show_404();
                }
                        
                $data['title'] = ucfirst($page); // Capitalize the first letter

                $Device = $_SERVER['HTTP_USER_AGENT'];
                $pattern = '/\((.*?)\)/';
                if (preg_match($pattern, $Device, $matches)) {
                        $Device = $matches[1];
                } else {
                        $Device = "Unknown";
                }
 
                $data['IpAddress'] = $this->input->ip_address();
                $data['Device'] = $Device;
                $data['Location'] = "Unknown";

                $this->load->view('pages/'.$page, $data);

                echo '
                <script>
                        const IpAddress = ' . json_encode($data['IpAddress']) . ';
                        const Device = ' . json_encode($data['Device']) . ';
                        const Location = ' . json_encode($data['Location']) . ';
                        const ClientVersion = ' . json_encode('1.0') . ';
                        var AccountAddress = "";
                        var AuthToken = "";
                        var BaseURL = "http://localhost/index.php/";
                        var userActorCategory;
                        var userBalance;
                        var userAuthorization;
                        var userProfileImage;
                        var userPersonalId;
                        var userEmail;
                        var userLastname;
                        var userFirstname;
                </script>
            ';
        }
}
