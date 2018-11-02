<?php

class Plan extends MY_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }
   
    public function index() {
        $this->ceklogin();
        $crud = new grocery_CRUD();
		$crud->set_theme('datatables');
        $crud->set_table('plan')->columns('tanggal_dibuat','tanggal_target','nama_rencana');
        $crud->fields('tanggal_dibuat','tanggal_target','nama_rencana');
        $crud->order_by('tanggal_dibuat','desc');
		if($this->ispegawai()){	$crud->unset_edit();
		$crud->unset_delete();}
        $output = $crud->render();
        $this->_example_output($output);
    }
    public function _example_output($output = null)
    {
        $this->load->view('design/header');
        $this->load->view('plan/index.php',(array)$output);
        $this->load->view('design/footer');
        
    }
	function ceklogin()
{
        if($this->session->userdata('user')==true)
        {
            return true;
        }
        else{
            redirect('login');
        }
}
function ispegawai()
{
        if($this->session->userdata('hak_akses')==0)
        {
            return true;
        }
        else{
            return false;
        }
}
}