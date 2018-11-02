<?php

class Pembelian_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'pembelian';
		$this->data['primary_key']	= 'id_pembelian';
	}
	public function insert_detail_beli($data)
	{
		return $this->db->insert('detail_beli', $data);
	}
	public function getdetail($id = '')
	{
		$this->db->select('nama_barang, jumlah, modal, jual, laba');
		$this->db->join('barang','barang.id_barang=detail_beli.id_barang');
		$this->db->where('id_pembelian',$id);
		$a = $this->db->get('detail_beli');
		return $a->result();
	}
	public function get_join_detail()
	{
		$query = "SELECT pembelian.*, 
		(select group_concat(barang.nama_barang) 
		from detail_beli 
		left join barang 
		on barang.id_barang=detail_beli.id_barang
		where detail_beli.id_pembelian=pembelian.id_pembelian
		) as nama_barang,
		(select group_concat(detail_beli.jumlah) 
		from 
		detail_beli 
		where detail_beli.id_pembelian=pembelian.id_pembelian
		) as jumlah,
		(select group_concat(detail_beli.harga) 
		from 
		detail_beli 
		where detail_beli.id_pembelian=pembelian.id_pembelian
		) as harga
		FROM pembelian
		order by tgl_nota desc ";
		return $this->db->query($query)->result();
	}
}
