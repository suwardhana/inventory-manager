<?php

class Barang_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'barang';
		$this->data['primary_key']	= 'id_barang';
	}
	// public function get_barang()
	// {
	// 	$query = " SELECT barang.id_barang, barang.nama_barang, jumlah_stok, suplier.nama_suplier as suplier, harga_suplier.modal as modal, id_harga_suplier FROM `barang` join harga_suplier on harga_suplier.id_barang=barang.id_barang join suplier on harga_suplier.id_suplier=suplier.id_suplier order by barang.id_barang";
	// 	$hasil = $this->db->query($query);
	// 	return $hasil->result();
	// }
	public function get_barang($id_barang)
	{
		$query = " SELECT barang.id_barang, barang.nama_barang, jumlah_stok, suplier.nama_suplier as nama_suplier, modal FROM `barang` join suplier on barang.id_suplier=suplier.id_suplier where barang.id_barang=$id_barang";
		$hasil = $this->db->query($query);
		return $hasil->row();
	}
	public function get_modal($id_barang)
	{
		$query = " SELECT modal FROM barang where id_barang=".$id_barang."
		";
		$hasil = $this->db->query($query);
		return $hasil->row()->modal;
	}
	public function kurangiBarang($id_barang,$jumItem){
		if($id_barang != null){
			$query=$this->db->query("select jumlah_stok as jumlah from barang where id_barang='$id_barang'")->row();
			$stok = $query->jumlah - $jumItem;
			$cond = [ 'jumlah_stok' => $stok];
			$this->update($id_barang, $cond);
		}	
	}
	public function tambahBarang($id_barang,$jumItem){
		if($id_barang != null){
			$query=$this->db->query("select jumlah_stok as jumlah from barang where id_barang='$id_barang'")->row();
			$stok = $query->jumlah + $jumItem;
			$cond = [ 'jumlah_stok' => $stok];
			$this->update($id_barang, $cond);
		}	
	}
	public function getbarangsuplier($tables, $jcond)
	{
		$this->db->select('id_barang, nama_suplier, nama_barang, modal, jumlah_stok, barang.modal_before, barang.last_edit');
		for ($i = 0; $i < count($tables); $i++)
			$this->db->join($tables[$i], $jcond[$i]);
		$this->db->where('status','1');
		return $this->db->get($this->data['table_name'])->result();
	}
	public function adjust_modal($id_barang,$harga,$jumlah_masuk)
	{
		$barang = $this->get_row("id_barang = '$id_barang'");
		$modal = $barang->modal;
		$stok = $barang->jumlah_stok;
		if($modal!=$harga)
		{
			$this->data['entry'] = [
				'modal'	=> (($modal*$stok)+($harga*$jumlah_masuk))/$stok+$jumlah_masuk,
				'modal_before' => $modal,
				'last_edit'	=> date('Y-m-d')
			];
			$this->update($id_barang,$this->data['entry']);
		}
	}
}
