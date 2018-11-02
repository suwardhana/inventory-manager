<?php

class History_barang_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'history_barang';
		$this->data['primary_key']	= 'id_history';
	}
	
}
