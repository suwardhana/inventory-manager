<?php

class Invoice_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'invoice_details';
		$this->data['primary_key']	= 'id';
	}
	
}