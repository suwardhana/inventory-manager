<?php

class Faktur_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'faktur';
		$this->data['primary_key']	= 'id_faktur';
	}
	public function insert_detail_faktur($data)
	{
		return $this->db->insert('detail_faktur', $data);
	}
	public function get_join_detail($bulan = null,$tahun = null)
	{
		$query = "SELECT faktur.*, 
		(select group_concat(barang.nama_barang) 
		from detail_faktur 
		left join barang 
		on barang.id_barang=detail_faktur.id_barang
		where detail_faktur.id_faktur=faktur.id_faktur
		) as nama_barang,
		(select group_concat(detail_faktur.jumlah) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as jumlah,
		(select group_concat(detail_faktur.jual) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as jual,
		(select group_concat(detail_faktur.laba) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as laba,
		(select group_concat(detail_faktur.modal) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as modal
		FROM faktur";

		if (!is_null($bulan)) {
			$query .= " where MONTH(faktur.tanggal) = ".$bulan." AND YEAR(faktur.tanggal) = ".$tahun;
		}
		$query .= " order by tanggal desc";
		return $this->db->query($query)->result();
	}
	public function get_join_detail_customer($id_customer)
	{
		$query = "SELECT faktur.*, 
		(select group_concat(barang.nama_barang) 
		from detail_faktur 
		left join barang 
		on barang.id_barang=detail_faktur.id_barang
		where detail_faktur.id_faktur=faktur.id_faktur
		) as nama_barang,
		(select group_concat(detail_faktur.jumlah) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as jumlah,
		(select group_concat(detail_faktur.jual) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as jual,
		(select group_concat(detail_faktur.laba) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as laba,
		(select group_concat(detail_faktur.modal) 
		from 
		detail_faktur 
		where detail_faktur.id_faktur=faktur.id_faktur
		) as modal
		FROM faktur where id_customer=".$id_customer." ";

		$query .= " order by tanggal desc";
		return $this->db->query($query)->result();
	}
	public function get_keuntungan($bulan = null, $tahun = null)
	{
		$query = "SELECT 
		sum(detail_faktur.laba) totallaba, 
		sum(detail_faktur.modal) as totalmodal, 
		sum(detail_faktur.jual) as totaljual 
		FROM faktur 
		join detail_faktur on detail_faktur.id_faktur=faktur.id_faktur";
		if (!is_null($bulan)) {
			$query .= " where MONTH(faktur.tanggal) = ".$bulan." AND YEAR(faktur.tanggal) = ".$tahun;
		}
		return $this->db->query($query)->row();

	}
	public function getdetail($id = '')
	{
		$this->db->select('nama_barang, jumlah, detail_faktur.modal, jual, laba');
		$this->db->join('barang','barang.id_barang=detail_faktur.id_barang');
		$this->db->where('id_faktur',$id);
		$a = $this->db->get('detail_faktur');
		return $a->result();
	}
	function autoFaktur(){
		$month = date('m');
		$query=$this->db->query("select id_faktur as jumlah from faktur where MONTH(tanggal) = '$month'");
		$max=$query->num_rows()+1;
		$max2=str_pad($max,3,'0',STR_PAD_LEFT);
		$kode= ('J-'.date('dmY').'-'.$max2);
		return $kode;
	}
	public function delete_detail($cond)
	{
		$this->db->where($cond);
		return $this->db->delete('detail_faktur');
	}
	public function homechart()
	{
		//$query = $this->db->query('SELECT kota, tahun, bulan, cust_id, detail_transaksi.jumlah_item, detail_transaksi.id_jenis FROM '.$this->data['table_name'].' join detail_transaksi on transaksi.id_transaksi=detail_transaksi.id_transaksi where transaksi.tahun="'.$tahun.'"');
		$query3 = "SELECT
		SUM(IF(MONTH(tanggal) = 1, b.jual, 0)) AS Jan,
		SUM(IF(MONTH(tanggal) = 2, b.jual, 0)) AS Feb,
		SUM(IF(MONTH(tanggal) = 3, b.jual, 0)) AS Mar,
		SUM(IF(MONTH(tanggal) = 4, b.jual, 0)) AS Apr,
		SUM(IF(MONTH(tanggal) = 5, b.jual, 0)) AS May,
		SUM(IF(MONTH(tanggal) = 6, b.jual, 0)) AS Jun,
		SUM(IF(MONTH(tanggal) = 7, b.jual, 0)) AS Jul,
		SUM(IF(MONTH(tanggal) = 8, b.jual, 0)) AS Aug,
		SUM(IF(MONTH(tanggal) = 9, b.jual, 0)) AS Sep,
		SUM(IF(MONTH(tanggal) = 10, b.jual, 0)) AS Oct,
		SUM(IF(MONTH(tanggal) = 11, b.jual, 0)) AS Nov,
		SUM(IF(MONTH(tanggal) = 12, b.jual, 0)) AS 'Dec'
		FROM
		faktur a 
		join detail_faktur b on a.id_faktur=b.id_faktur";
		//echo $query3;
		$query = $this->db->query($query3);
		return $query->result();
	}
}
