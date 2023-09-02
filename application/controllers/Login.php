<?php

class Login extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->model(['Login_Model', 'Authorization_Model']);
                $this->load->helper('string');
                $this->load->library(['form_validation','session']);
        }

        function displayAlert($type, $text) {
                $jsImport = base_url('assets/javascript/modules/alerts.js');
                echo "<script type='module'>
                    import { createAlert } from '{$jsImport}';
                    createAlert('{$type}', '{$text}');
                </script>";
            }

        function sanitize($value) {
                $value = $this->db->escape_str($value);
               // $value = $this->input->xss_clean($value);
                return $value;
        }

        function validate_client(){
                $IpAddress = $_SERVER['REMOTE_ADDR'];
                $Device = $_SERVER['HTTP_USER_AGENT'];
                $Location = "Unknown";

                $pattern = '/\((.*?)\)/';
                if (preg_match($pattern, $Device, $matches)) {
                        $Device = $matches[1];
                } else {
                        $Device = "Unknown";
                }

                $this->session->set_userdata('IpAddress', $IpAddress);
                $this->session->set_userdata('Device', $Device);
                $this->session->set_userdata('Location', $Location);
        }

        function is_account_active ($Account_Address) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($Account_Address);
                if ($tbl_authentications){
                        if ($tbl_authentications->IsOnline === 1) {
                                return TRUE;
                            } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function is_account_same_user ($Account_Address) {
                $tbl_authentications = $this->Authorization_Model->get_tbl_authentications_by_address($Account_Address);
                if ($tbl_authentications) {
                        if (
                                $this->session->userdata('IpAddress') === $tbl_authentications->IpAddress && 
                                $this->session->userdata('Device') === $tbl_authentications->Device && 
                                $this->session->userdata('Location') === $tbl_authentications->Location
                        ) {
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function is_account_enabled ($Account_Address) {
                $tbl_webaccounts = $this->Login_Model->get_tbl_webaccounts_by_address($Account_Address);
                if ($tbl_webaccounts) {
                        if ($tbl_webaccounts->IsAccountActive === '1'){
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
                        return FALSE;
                }
        }

        function check_user() {
                $this->validate_client();
                if ($this->session->userdata('Account_Address')) {
                        $accountAddress = $this->session->userdata('Account_Address');

                        $isEnabled = $this->is_account_enabled($accountAddress);
                        if ($isEnabled) {

                                $isActive = $this->is_account_active($accountAddress);
                                if ($isActive) {

                                        $isSameUser = $this->is_account_same_user($accountAddress);
                                        if($isSameUser){
                                                $this->switchControler($accountAddress);
                                        } else {
                                                $this->displayAlert("warning","Online in other device, Please logout!");
                                                return "Online in other account";
                                        }
                                } else {
                                        return "no online";
                                }
                        } else {
                                $this->displayAlert("danger","errrrrr");
                                return "not Enabled";
                        }
                } else {
                        return "no  session";
                }
        }




        function switchControler($accountAddress) {
                $actor = $this->Authorization_Model->get_webactor_category($accountAddress);
                $validRoles = ['Administrator', 'Accounting', 'Merchant Admin', 'Merchant Staff'];
                $actor = trim($actor);
                
                if (in_array($actor, $validRoles)) {
                    switch ($actor) {
                        case 'Administrator':
                            redirect('Administrator');
                            break;
                
                        case 'Accounting':
                            redirect('Accounting');
                            break;
                
                        case 'Merchant Admin':
                            redirect('MerchantAdmin');
                            break;
                
                        case 'Merchant Staff':
                            redirect('Merchant');
                            break;
                    }
                } else {
                    redirect('login');
                }
        }
        






        public function index($page = 'login')
        {
                $config['base_url'] = 'http://localhost/';

                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                        show_404();

                $data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('templates/login_header', $data);
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/login_footer', $data);

                $this->displayAlert("danger","Login blocked. Please contact system administrators!");

                $this->check_user();

        }

        
        public function validateLogin() {
                $this->form_validation->set_rules('bcash-username', 'Email', 'required');
                $this->form_validation->set_rules('bcash-password', 'Password', 'required');
            
                if ($this->form_validation->run() === FALSE) {
                        redirect('login');
                } else {
                        $username = $this->sanitize($this->input->post('bcash-username'));
                        $password = $this->sanitize($this->input->post('bcash-password'));

                        $validAccount = $this->Login_Model->get_tbl_webaccounts_by_username($username);

                        if ($validAccount) {
                                if (password_verify($password,$validAccount->Password)) {
                                        $this->session->set_userdata('Account_Address', $validAccount->WebAccounts_Address);
                                        $accountAddress = $this->session->userdata('Account_Address');
                                        $IpAddress = $this->session->userdata('IpAddress');
                                        $Device = $this->session->userdata('Device');
                                        $Location = $this->session->userdata('Location');

                                        $this->check_user();

                                        $result = $this->Authorization_Model->initialize_login($accountAddress,$IpAddress,$Device,$Location);
                                        echo $result;
                                        if ($result === "Successful"){
                                                $this->switchControler($accountAddress);
                                        } else if ($result === "OTP Required") {
                                                $this->switchControler("login");
                                        } else if ($result === "Access Blocked") {
                                                $this->switchControler("login");
                                        } else if ($result === "Failed") {
                                                $this->switchControler("login");
                                        } 

                                } else {
                                        redirect('login');
                                        echo ("wrong pass");
                                }
                        } else {
                                redirect('login');
                                echo ("no accounts");
                        }





                        


                        //echo "1132323213";
                        //('merchant');
                }
        }



        public function logout() {
       
        }
}