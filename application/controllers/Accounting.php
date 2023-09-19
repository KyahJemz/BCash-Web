<?php

class Accounting extends CI_Controller {

        public function index($page = 'accounting')
        {
                $config['base_url'] = 'http://localhost/index.php/';

                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                {
                        show_404();
                }

                $data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('pages/'.$page, $data);
        
        }
}