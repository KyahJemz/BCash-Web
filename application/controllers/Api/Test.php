<?php

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_Model');
    }

    public function index(){
        
        // $user_ip = $_SERVER['REMOTE_ADDR'];
        // $user_device = $_SERVER['HTTP_USER_AGENT'];
        // $user_location = null;

        // $pattern = '/\((.*?)\)/';
        // if (preg_match($pattern, $user_device, $matches)) {
        //     $user_device = $matches[1];
        // } else {
        //     $user_device = "Unknown";
        // }

        // $this->session->set_userdata('user_ip', $user_ip);
        // $this->session->set_userdata('user_device', $user_device);
        // $this->session->set_userdata('user_location', $user_location);





        // echo "<br>================<br>";
        // $user_data = $this->Login_Model->get_user_by_id("ADM000000000000");
        // echo ($user_data->Username);
        // echo "<br>================<br>";
        // echo $this->Login_Model->verifyLogin("merchantadmin", "12345");
        // echo "<br>================<br>";
    } 


  
        
}