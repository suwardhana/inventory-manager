<?php

class Pegawai extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['id_role'] = $this->session->userdata('id_role');
		if (!isset($this->data['id_role']) or $this->data['id_role'] != 2)
		{
			redirect('logout');
			exit;
		}
		
		$this->load->model('user_m');
		$this->load->model('pengeluaran_m');
		$this->load->model('pegawai_m');
		$this->load->model('Transaksi_m');
	}

	public function index()
	{
		$this->data['content'] 	= 'data';
		$this->data['title'] = 'Home'.$this->title;
        $this->template($this->data);
	}

	public function pengeluaran()
	{
		if ($this->POST('tambah')) {
			$this->data['entry'] = [
				'nama'	=> $this->POST('nama'),
				'nominal'	=> $this->POST('nominal'),
				'keterangan'	=> $this->POST('ket'),
				'tanggal'	=> date('Y-m-d H:i:s'),
			];
			$this->pengeluaran_m->insert($this->data['entry']);
			$this->flashmsg('Data Berhasil di Tambahkan','success');
			redirect('pegawai/pengeluaran');
			exit;
		}
		if ($this->POST('edit')) {
			$this->data['entry'] = [
				'nama'	=> $this->POST('nama'),
				'nominal'	=> $this->POST('nominal'),
				'keterangan'	=> $this->POST('keterangan'),
			];
			$this->pengeluaran_m->update($this->POST('id'),$this->data['entry']);
			$this->flashmsg('Data Berhasil di edit','success');
			redirect('pegawai/pengeluaran');
			exit;
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->pengeluaran_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil di hapus','success');
			redirect('pegawai/pengeluaran');
			exit;
		}
		if ($this->POST('get') && $this->POST('id')) {
			echo json_encode($this->pengeluaran_m->get_row(['id_pengeluaran' => $this->POST('id')]));
			exit;
		}
		$this->data['pengeluaran']	= $this->pengeluaran_m->get();
		$this->data['content'] 	= 'pengeluaran';
		$this->data['title'] = 'Data Pengeluaran'.$this->title;
        $this->template($this->data);
	}

	public function transaksi()
	{
		if ($this->POST('insert'))
		{
			$this->data['entry'] = [
				"id_pegawai" => $this->session->userdata('username'),
				"tanggal" => $this->POST("tanggal"),
				"jenis_trx" => $this->POST("jenis_trx"),
				"nominal" => $this->POST("nominal"),
				"keterangan" => $this->POST("keterangan"),
			];
			$this->Transaksi_m->insert($this->data['entry']);
			redirect('pegawai/transaksi');
			exit;
		}
		
		if ($this->POST('delete') && $this->POST('id_transaksi'))
		{
			$this->Transaksi_m->delete($this->POST('id_transaksi'));
			exit;
		}
				
		if ($this->POST('edit') && $this->POST('edit_id_transaksi'))
		{
			$this->data['entry'] = [
				"tanggal" => $this->POST("tanggal"),
				"jenis_trx" => $this->POST("jenis_trx"),
				"nominal" => $this->POST("nominal"),
				"keterangan" => $this->POST("keterangan"),
			];
			$this->Transaksi_m->update($this->POST('edit_id_transaksi'), $this->data['entry']);
			redirect('pegawai/transaksi');
			exit;
		}

		if ($this->POST('get') && $this->POST('id_transaksi'))
		{
			$this->data['transaksi'] = $this->Transaksi_m->get_row(['id_transaksi' => $this->POST('id_transaksi')]);
			echo json_encode($this->data['transaksi']);
			exit;
		}
				
		$this->data['data']		= $this->Transaksi_m->get();
		$this->data['columns']	= ["tanggal","jenis_trx","nominal","keterangan",];
		$this->data['title'] 	= 'Title';
		$this->data['content'] 	= 'transaksi_all';
		$this->template($this->data);
	}


	public function detail_transaksi()
	{
		$this->data['id_transaksi'] = $this->uri->segment(3);
		if (!isset($this->data['id_transaksi']))
		{
			redirect('pegawai/transaksi');
			exit;
		}

		$this->data['columns']	= ["id_transaksi","id_pegawai","tanggal","jenis_trx","nominal","keterangan",];
		$this->data['data'] = $this->Transaksi_m->get_row(['id_transaksi' => $this->data['id_transaksi']]);
		$this->data['title'] 	= 'Title';
		$this->data['content'] 	= 'transaksi_detail';
		$this->template($this->data);
	}
}
