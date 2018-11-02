<?php

class Peminjaman_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'peminjaman';
		$this->data['primary_key']	= 'id_peminjaman';
	}
	
}