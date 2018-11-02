<?php

class Kemampuan_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'kemampuan';
		$this->data['primary_key']	= 'id';
	}
	
}