<?php

class Login extends CI_Controller {

        public function view($page = 'login')
        {
                $config['base_url'] = 'http://localhost/';

                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                {
                        show_404();
                }

                $data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('templates/login_header', $data);
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/login_footer', $data);
        

        }
}