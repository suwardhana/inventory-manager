<?php

class Piutang_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'piutang';
		$this->data['primary_key']	= 'id_piutang';
	}
}
