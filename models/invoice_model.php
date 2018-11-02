<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model{

	Public function insert_invoice()
	{
		$item_name=implode(',',$_POST['item']);
		$idbarang=implode(',',$_POST['idbarang']);
		$rate=implode(',',$_POST['rate']);
		$quantity=implode(',',$_POST['quantity']);
		$amount=implode(',',$_POST['amount']);
		$nofaktur = $this->autoFaktur();
		$panjang = sizeof($_POST['item']);
		for($i=0;$i<$panjang;$i++)
		{
			$data2=array(
				'id_barang'=>$_POST['idbarang'][$i],
				'tanggal'=>date('Y-m-d'),
				'masuk'=>0,
				'status'=>1,
				'jumlah'=>$_POST['quantity'][$i],    		
			);

			$this->db->insert('history_item',$data2);
			$this->kurangiBarang($_POST['idbarang'][$i],$_POST['quantity'][$i]);
			$modal[$i]=$this->modal($_POST['idbarang'][$i]);
		}
		$modal2 = implode(',',$modal);
		$data=array(
			'customer_name'=>$_POST['nama'],
			'keterangan'=>$_POST['keterangan'],
			'date'=>date('Y-m-d'),
			'name'=>$item_name,
			'idbarang'=>implode(',',$_POST['idbarang']),
			'rate'=>$rate,
			'modal'=>$modal2,
			'quantity'=>$quantity,
			'amount'=>$amount,
			'dp'=>$_POST['sub_total'],
			'grand_total'=>$_POST['grand_total'],
			'kontak'=>$_POST['kontak'],
			'faktur'=>$nofaktur,
			'status'=>1,
			'pic'=>$_SESSION["username"]
		);

		$this->db->insert('invoice_details',$data);
		
		

		
		return($this->db->affected_rows()!=1)?false:true;

	}
	function kurangiBarang($id,$jumItem){
		if($id != null){
			$query=$this->db->query("select id_barang,jumlah from item_details where id_barang='$id'");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$stok=$data->jumlah-$jumItem;
					$this->db->query("update item_details set jumlah='$stok' where id_barang='$id'");
				}
			}
		}	
	}
	function modal($id){
		if($id != null){
			$query=$this->db->query("select id_barang,modal from item_details where id_barang='$id'");
			foreach ($query->result() as $data) {
				$modal=$data->modal;
				return $modal;
			}
		}
		else return null;		
	}
	function autoFaktur(){
		$month = date('m');
		$query=$this->db->query("select id as jumlah from invoice_details where MONTH(date) = '$month'");
		$max=$query->num_rows()+1;
		$max2=str_pad($max,3,'0',STR_PAD_LEFT);
		$menus= ('J-'.date('dmY').'-'.$max2);
		return $menus;
	}
	public function get_date($bulan,$tahun)
	{

		$this->db->where('status',1);
		$this->db->where('MONTH(date)',$bulan,FALSE);
		$this->db->where('YEAR(date)',$tahun,FALSE);
		return $this->db->get('invoice_details')->result();

	}
	public function get_omset($bulan,$tahun)
	{

		$this->db->where('MONTH(date_omset)',$bulan,FALSE);
		$this->db->where('YEAR(date_omset)',$tahun,FALSE);
		return $this->db->get('t_omset')->row();
	}
}