<?php

class Aset_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'p_aset';
		$this->data['primary_key']	= 'id';
	}
	
}