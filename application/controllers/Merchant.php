<?php

class Merchant extends CI_Controller {

        public function index($page = 'merchant')
        {
                $config['base_url'] = 'http://localhost/';

                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                {
                        show_404();
                }

                $data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('templates/merchant_header', $data);
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/merchant_footer', $data);
        
        }
}