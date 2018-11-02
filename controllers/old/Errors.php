<?php

class Errors extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Error'.$this->title;
		$this->load->view('errors/error404');
	}
}
