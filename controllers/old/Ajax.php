<?php

class Ajax extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['id_role'] = $this->session->userdata('id_role');
		if (!isset($this->data['id_role']))
		{
			redirect('logout');
			exit;
		}
	}

	public function index()
	{
		echo "404";
	}
	public function autocomplete()
	{
		$item_name=$this->input->post('name');
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->like('nama_barang',$item_name);
		$this->db->where('status',1);
		$query = $this->db->get();
		$result = $query->result();
		$name       =  array();
		foreach ($result as $d) {
			$json_array             = array();
			$json_array['value']    = $d->nama_barang;
			$json_array['label']    = $d->nama_barang;
			$name[]             = $json_array;
		}
		echo json_encode($name);
	}
	public function get_id_barang()
	{
		$item_name=$this->input->post('name');

		$this->db->select('id_barang');
		$this->db->from('barang');
		$this->db->where('nama_barang',$item_name);
		$this->db->where('status',1);
		$query = $this->db->get();
		$result = $query->result();

		foreach ($result as $d) {
			$data['id_barang']    = $d->id_barang;      
		}
		echo json_encode($data);
	}
	public function tescode()
	{
		// $a = $this->barang_m->adjust_modal(1,40011,3);
		// print_r($a);
	}
}
