<?php

class Omset extends MY_Controller{
	public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('table');
    	 $this->load->model('omset_model');
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
   public function index(){
        $this->ceklogin();
        $this->load->model('omset_model');
        $data['data']=$this->omset_model->get_omset();
        $this->load->view('design/header');
        $this->load->view('omset/home_omset',$data);
        $this->load->view('design/footer');
    	if($this->input->post('submit'))
    	{
    		$sel_omset=$this->omset_model->get_sel_omset();
	   		if($sel_omset->date_omset=='')
	   		{
	   			$this->omset_model->insert_omset();
	    		$this->session->set_flashdata('msg','<div class="alert alert-success">Omset Added Successfully</div>');
	    		redirect('omset');
	   		}
	   		else{
	   			$this->session->set_flashdata('msg','<div class="alert alert-danger">Date from was Exist</div>');
		    	redirect('omset');	
	   		}    	
    	}
    }

   	public function delete_omset()
   	{
		$this->omset_model->delete_omset();
		$this->session->set_flashdata('msg','<div class="alert alert-success">Omset Delete Row Successfully</div>');
    	redirect('omset');
   	}
 
}
?>