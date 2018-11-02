<?php

class Harga_suplier_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'harga_suplier';
		$this->data['primary_key']	= 'id_harga_suplier';
	}
}
