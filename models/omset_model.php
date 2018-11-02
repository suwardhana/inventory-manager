<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Omset_model extends CI_Model{
	public function insert_omset(){
		//$sel_omset = $this->get_sel_omset();

		$bulan=$this->input->post('bulan',true);
		$tahun=$this->input->post('tahun',true);
		$t_omset=$this->input->post('t_omset',true);
		$date_omset=$tahun."-".$bulan."-01";
		$data=array('date_omset'=>$date_omset,'t_omset'=>$t_omset);
		$this->db->insert('t_omset',$data);
	}
	function get_omset()
	{
		$this->db->order_by('date_omset','desc');
		return $this->db->get('t_omset')->result();
	}
	function delete_omset()
	{
		$id_omset = $this->input->post('id_omset');
		$this->db->where('id_omset',$id_omset);
		$this->db->delete('t_omset');
	}
	function get_sel_omset()
	{
		$bulan=$this->input->post('bulan');
		$tahun=$this->input->post('tahun');
		$date_omset=$tahun."-".$bulan."-01";
		$this->db->where('date_omset',$date_omset);
		return $this->db->get('t_omset')->row();
	}
}
?>