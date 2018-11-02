<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang_model extends CI_Model{

	Public function insert_barang()
	{
		$panjang = sizeof($_POST['item']);
		for($i=0;$i<$panjang;$i++)
		{
			$data=array(
    		'id_barang'=>$_POST['idbarang'][$i],
    		'tanggal'=>date('Y-m-d'),
    		'masuk'=>1,
			'status'=>1,
    		'jumlah'=>$_POST['quantity'][$i],    		
    		);

			$this->db->insert('history_item',$data);
			$this->tambahBarang($_POST['idbarang'][$i],$_POST['quantity'][$i]);
			
		}
				
    	return($this->db->affected_rows()!=1)?false:true;

	}
	function tambahBarang($id,$jumItem){
	if($id != null){
		$query=$this->db->query("select id_barang,jumlah from item_details where id_barang='$id'");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$stok=$data->jumlah+$jumItem;
					$this->db->query("update item_details set jumlah='$stok' where id_barang='$id'");
				}
			}
		}	
	}
	public function get_date($bulan,$tahun)
    {
       
       $this->db->where('history_item.status',1);
       $this->db->where('MONTH(tanggal)',$bulan,FALSE);
       $this->db->where('YEAR(tanggal)',$tahun,FALSE);
	   $this->db->select('history_item.id_barang,SUM(history_item.jumlah) AS laku,item_details.item_name AS nama, item_details.id_barang, SUM(history_item.jumlah)*item_details.modal as omset');
	   $this->db->where('history_item.masuk',0);
	   $this->db->group_by('history_item.id_barang');
	   $this->db->join('item_details','history_item.id_barang = item_details.id_barang');
	   $this->db->order_by('laku','desc');
        return $this->db->get('history_item')->result();
        
    }
    
	
}