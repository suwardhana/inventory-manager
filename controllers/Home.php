<?php

class Home extends MY_Controller{
 
    public function index() {
        
        $this->load->view('design/header');
        $this->load->view('home/index');
        $this->load->view('design/footer');

        // print_r($this->session->userdata);
    }
}
