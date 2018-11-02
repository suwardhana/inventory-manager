<?php

class Sales extends MY_Controller
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
		
		// $this->load->model('user_m');
		$this->load->model('faktur_m');
		$this->load->model('pembelian_m');
		$this->load->model('piutang_m');
		$this->load->model('barang_m');
		$this->load->model('suplier_m');
		$this->load->model('customer_m');
		$this->load->model('history_barang_m');
		$this->load->model('harga_suplier_m');
	}

	public function index()
	{
		$this->data['content'] 	= 'sales/home';
		$this->data['dc'] = $this->faktur_m->homechart();
		$this->data['title'] = 'Home'.$this->title;
		$this->template($this->data,'home');
	}
	public function laporan_penjualan()
	{
		if ($this->input->get()) {
			$this->data['faktur'] = $this->faktur_m->get_join_detail($this->input->GET('bulan'),$this->input->GET('tahun'));
			$this->data['keuntungan'] = $this->faktur_m->get_keuntungan($this->input->GET('bulan'),$this->input->GET('tahun'));
			$this->data['keterangan'] = "Data Bulan : ".$_GET['bulan']." Tahun : ".$_GET['tahun'];
		}
		else{
			$this->data['faktur'] = $this->faktur_m->get_join_detail();
			$this->data['keterangan'] = "Seluruh Data";
			$this->data['keuntungan'] = $this->faktur_m->get_keuntungan();			
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->faktur_m->delete($this->POST('id'));
			$id = $this->POST('id');
			$this->faktur_m->delete_detail("id_faktur = '$id'");
			$this->flashmsg('Data Berhasil di hapus','success');
			redirect('sales/laporan_penjualan');
			exit;
		}
		$this->data['content'] 	= 'sales/transaksi_all';
		$this->data['title'] = 'Laporan Penjualan'.$this->title;
		$this->template($this->data,'home');
	}
	public function laporan_pembelian()
	{
		if ($this->POST('get') && $this->POST('id')) {
			echo json_encode($this->pembelian_m->get_row(['id_pembelian' => $this->POST('id')]));
			exit;
		}
		if ($this->POST('edit')) {
			$this->data['entry'] = [
				'sisa_bayar'	=> $this->POST('sisa_bayar'),
				'jatuh_tempo'	=> date("Y-m-d", strtotime($this->POST('jatuh_tempo'))),
				'last_edit'	=> date('Y-m-d')
			];
			$this->pembelian_m->update($this->POST('id_pembelian'),$this->data['entry']);
			$this->flashmsg('Data Berhasil di edit','success');
			redirect('sales/laporan_pembelian');
			exit;
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->pembelian_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil di hapus','success');
			exit;
		}
		$this->data['pembelian'] = $this->pembelian_m->get_join_detail();
		$this->data['content'] 	= 'sales/pembelian_all';
		$this->data['title'] = 'Laporan Pembelian'.$this->title;
		$this->template($this->data,'home');
	}
	public function detail_faktur($id)
	{
		$this->data['detailfaktur'] = $this->faktur_m->getdetail($id);
		//print_r($this->data['detailfaktur']);
		$this->data['content'] 	= 'sales/detailfaktur';
		$this->data['title'] = 'Laporan Penjualan'.$this->title;
		$this->template($this->data,'home');
	}
	public function detail_beli($id)
	{
		$this->data['detailbeli'] = $this->pembelian_m->getdetail($id);
		//print_r($this->data['detailfaktur']);
		$this->data['content'] 	= 'sales/detailbeli';
		$this->data['title'] = 'Laporan Pembelian'.$this->title;
		$this->template($this->data,'home');
	}
	public function laporan_barang()
	{
		if ($this->POST('tambah')) {
			$this->data['entry'] = [
				'nama_barang'	=> $this->POST('nama'),
				'jumlah_stok'	=> $this->POST('jumlah'),
				'id_suplier' => $this->POST('id_suplier'),
				'modal' => $this->POST('modal'),
				'last_edit'	=> date('Y-m-d'),
				'status'	=> 1
			];
			$this->barang_m->insert($this->data['entry']);
			$id_barang = $this->barang_m->get_last_row("nama_barang = '".$this->POST('nama')."'")->id_barang;
			$this->data['history'] = [
				'id_barang'	=> $id_barang,
				'tanggal'	=> date('Y-m-d'),
				'masuk'	=> 1,
				'jumlah'	=> $this->POST('jumlah')
			];
			$this->history_barang_m->insert($this->data['history']);
			$this->flashmsg('Data Berhasil di Tambahkan','success');
			redirect('sales/laporan_barang');
			exit;
		}
		if ($this->POST('edit')) {
			$this->data['entry'] = [
				'jumlah_stok'	=> $this->POST('jumlah_stok'),
				'modal'	=> $this->POST('modal'),
				'last_edit'	=> date('Y-m-d')
			];
			$this->barang_m->update($this->POST('id_barang'),$this->data['entry']);
			$this->flashmsg('Data Berhasil di edit','success');
			redirect('sales/laporan_barang');
			exit;
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->barang_m->delete2($this->POST('id'));
			$this->flashmsg('Data Berhasil di hapus','success');
			redirect('sales/laporan_barang');
			exit;
		}
		if ($this->POST('get') && $this->POST('id')) {
			echo json_encode($this->barang_m->get_barang($this->POST('id')));
			exit;
		}
		$this->data['suplier'] = $this->suplier_m->get_by_order('nama_suplier', 'asc');
		$join = ['suplier'];
		$jcond = ['barang.id_suplier=suplier.id_suplier'];
		$this->data['barang'] = $this->barang_m->getbarangsuplier($join,$jcond);
		$this->data['content'] 	= 'sales/barang_all';
		$this->data['title'] = 'Laporan Barang'.$this->title;
		$this->template($this->data,'home');
	}
	public function history_barang()
	{
		$id = $this->input->GET('id');
		if ($this->POST('delete') && $this->POST('id')) {
			$this->history_barang_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil dihapus','success');
			exit;
		}
		$this->data['barang'] = $this->barang_m->get_row("id_barang = ".$id."");

		$this->data['history'] = $this->history_barang_m->get("id_barang = ".$id."");
		$this->data['id'] = $id;
		$this->data['content'] 	= 'sales/history';
		$this->data['title'] = 'Laporan Barang '.$this->title;
		$this->template($this->data,'home');
	}
	public function history_customer()
	{
		$id = $this->input->GET('id');
		if ($this->POST('delete') && $this->POST('id')) {
			$this->history_barang_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil dihapus','success');
			exit;
		}
		$this->data['customer'] = $this->customer_m->get_row("id_customer = ".$id."");
		$this->data['faktur'] = $this->faktur_m->get_join_detail_customer($id);
		// $this->data['faktur'] = $this->faktur_m->get("id_customer = ".$id."");
		$this->data['id'] = $id;
		$this->data['content'] 	= 'sales/history_customer';
		$this->data['title'] = 'History '.$this->title;
		$this->template($this->data,'home');
	}
	public function create_invoice()
	{
		if ($this->POST('invoice')) {
			$banyak = sizeof($this->POST('item'));
			if ((in_array(null, $this->POST('id_barang'))) || (in_array(null, $this->POST('jumlah')))){
				$this->flashmsg('<strong>Gagal</strong>, Periksa kembali inputan anda','warning');
				redirect('sales/create_invoice');
				exit;
			}
			
			$kode_faktur = $this->faktur_m->autoFaktur();
			$temppembeli = explode('-', $this->POST('pembeli'));
			$this->data['faktur'] = [
				'nama_pembeli'	=> $temppembeli[1],
				'id_customer'	=> $temppembeli[0],
				'kode_faktur'	=> $kode_faktur,
				'total'	=> $this->POST('grand_total'),
				'tanggal'	=> date('Y-m-d'),
				'jatuh_tempo'	=> date("Y-m-d", strtotime($this->POST('jatuh_tempo'))),
				'pic'	=> $this->session->userdata('nama'),
				'status'	=> 1
			];
			$this->faktur_m->insert($this->data['faktur']);
			$idfak = $this->faktur_m->get_last_row("kode_faktur='$kode_faktur'")->id_faktur;
			for ($i=0; $i < $banyak; $i++) { 
				$modal = $this->barang_m->get_modal($this->POST('id_barang')[$i]);
				$laba = $this->POST('amount')[$i] - ($this->POST('jumlah')[$i] * $modal) ;
				$id_barang = $this->POST('id_barang')[$i];
				$jumlah = $this->POST('jumlah')[$i];
				$this->data['detail'] = [
					'id_faktur'	=> $idfak,
					'id_barang'	=> $this->POST('id_barang')[$i],
					'jumlah'	=> $this->POST('jumlah')[$i],
					'modal'	=> $modal,
					'jual'	=> $this->POST('harga')[$i],
					'laba'	=> $laba
				];
				$this->faktur_m->insert_detail_faktur($this->data['detail']);
				$this->barang_m->kurangiBarang($id_barang,$jumlah);
				$infobrg = $this->barang_m->get_row("id_barang = '$id_barang'");
				$stok_tercatat = $infobrg->jumlah_stok;
				//print_r($stok_tercatat);
				$this->data['history'] = [
					'id_barang'	=> $this->POST('id_barang')[$i],
					'tanggal'	=> date('Y-m-d'),
					'stok_tercatat'	=> $stok_tercatat,
					'harga'	=> $this->POST('harga')[$i],
					'nama'	=> $this->POST('nama_pembeli'),
					'masuk'	=> 0,
					'jumlah'	=> $this->POST('jumlah')[$i]
				];
				$this->history_barang_m->insert($this->data['history']);
			}
			$this->flashmsg('Data Berhasil di input','success');
			redirect('sales/laporan_penjualan');
			exit;
		}
		else {
			$this->data['createinvoice'] 	= TRUE;
			$this->data['customer'] = $this->customer_m->get_by_order('nama_customer','asc');
			$this->data['content'] 	= 'sales/create_invoice';
			$this->data['title'] = 'Buat Faktur'.$this->title;
			$this->template($this->data,'home');
		}
		
	}
	public function pembelian()
	{
		if ($this->POST('pembelian')) {

			if (!$this->pembelian_m->required_input(['nama_suplier','kode_faktur'])) 
			{
				$this->flashmsg('Data harus lengkap','warning');
				redirect('sales/pembelian');
				exit;
			}

			$banyak = sizeof($this->POST('item'));
			if ((in_array(null, $this->POST('id_barang'))) || (in_array(null, $this->POST('jumlah')))){
				$this->flashmsg('<strong>Gagal</strong>, Periksa kembali inputan anda','warning');
				redirect('sales/pembelian');
				exit;
			}
			$kode_faktur = $this->POST('kode_faktur');
			if ($this->POST('jenispembayaran')=='1') {
				$sisa_bayar = $this->POST('sisa_bayar');
				$jatuh_tempo = date("Y-m-d", strtotime($this->POST('jatuh_tempo')));
				$status_lunas = '0';
			}
			if ($this->POST('jenispembayaran')=='2') {
				$sisa_bayar = 0;
				$jatuh_tempo = date("Y-m-d");
				$status_lunas = '1';
			}
			$this->data['faktur'] = [
				'nama_suplier'	=> $this->POST('nama_suplier'),
				'kode_faktur'	=> $this->POST('kode_faktur'),
				'total'			=> $this->POST('grand_total'),
				'tgl_nota'		=> date("Y-m-d", strtotime($this->POST('tgl_nota'))),
				'sisa_bayar'	=> $sisa_bayar,
				'jatuh_tempo'	=> $jatuh_tempo,
				'status_lunas'	=> $status_lunas,
				'last_edit' 	=> date("Y-m-d")
			];
			$this->pembelian_m->insert($this->data['faktur']);
			$idpembelian = $this->pembelian_m->get_last_row("kode_faktur='$kode_faktur'")->id_pembelian;
			for ($i=0; $i < $banyak; $i++) { 
				$id_barang = $this->POST('id_barang')[$i];
				$jumlah = $this->POST('jumlah')[$i];
				$harga = $this->POST('harga')[$i];
				$this->data['detail'] = [
					'id_pembelian'	=> $idpembelian,
					'id_barang'	=> $this->POST('id_barang')[$i],
					'jumlah'	=> $this->POST('jumlah')[$i],
					'harga'	=> $this->POST('harga')[$i]
				];
				$this->pembelian_m->insert_detail_beli($this->data['detail']);
				$this->barang_m->tambahBarang($id_barang,$jumlah);
				$stok_tercatat = $this->barang_m->get_row("id_barang = '$id_barang'")->jumlah_stok;
				$this->barang_m->adjust_modal($id_barang,$harga,$jumlah);
				$this->data['history'] = [
					'id_barang'	=> $this->POST('id_barang')[$i],
					'nama'	=> $this->POST('nama_suplier'),
					'tanggal'	=> date('Y-m-d'),
					'stok_tercatat'	=> $stok_tercatat,
					'harga'	=> $this->POST('harga')[$i],
					'masuk'	=> 1,
					'jumlah'	=> $this->POST('jumlah')[$i]
				];
				$this->history_barang_m->insert($this->data['history']);
			}
			$this->flashmsg('Data Berhasil di input','success');
			redirect('sales/pembelian');
			exit;
		}
		else {
			$this->data['pembelian'] 	= TRUE;
			$this->data['suplier'] 	= $this->suplier_m->get_by_order('nama_suplier','asc');
			$this->data['content'] 	= 'sales/pembelian';
			$this->data['title'] = 'Pembelian'.$this->title;
			$this->template($this->data,'home');
		}
		
	}
	public function customer()
	{
		if ($this->POST('tambah')) {
			$this->data['entry'] = [
				'nama_customer'	=> $this->POST('nama_customer'),
				'kontak'	=> $this->POST('kontak'),
				'last_edit' => date("Y-m-d")
			];
			$this->customer_m->insert($this->data['entry']);
			$this->flashmsg('Data Berhasil di Tambahkan','success');
			redirect('sales/customer');
			exit;
		}
		if ($this->POST('edit')) {
			$this->data['entry'] = [
				'nama_customer'	=> $this->POST('nama_customer'),
				'kontak' => $this->POST('kontak'),
				'last_edit'	=> date('Y-m-d')
			];
			$this->customer_m->update($this->POST('id_customer'),$this->data['entry']);
			$this->flashmsg('Data Berhasil di edit','success');
			redirect('sales/customer');
			exit;
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->customer_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil di hapus','success');
			exit;
		}
		if ($this->POST('get') && $this->POST('id')) {
			echo json_encode($this->customer_m->get_row("id_customer = ".$this->POST('id').""));
			exit;
		}
		
		$this->data['customer'] = $this->customer_m->get();
		$this->data['content'] 	= 'sales/customer';
		$this->data['title'] = 'Data Customer'.$this->title;
		$this->template($this->data,'home');
	}
	public function suplier()
	{
		if ($this->POST('tambah')) {
			$this->data['entry'] = [
				'nama_toko'	=> $this->POST('nama_toko'),
				'tgl_piutang'	=> date("Y-m-d", strtotime($this->POST('tgl_piutang'))),
				'total'	=> $this->POST('total'),
				'kontak'	=> $this->POST('kontak'),
				'status_lunas'	=> $this->POST('status_lunas'),
				'jatuh_tempo' => date("Y-m-d", strtotime($this->POST('jatuh_tempo'))),
				'last_edit' => date("Y-m-d")
			];
			$this->piutang_m->insert($this->data['entry']);
			$this->flashmsg('Data Berhasil di Tambahkan','success');
			redirect('sales/piutang');
			exit;
		}
		if ($this->POST('edit')) {
			$this->data['entry'] = [
				'total'	=> $this->POST('total'),
				'jatuh_tempo' => date("Y-m-d", strtotime($this->POST('jatuh_tempo'))),
				'last_edit'	=> date('Y-m-d')
			];
			$this->piutang_m->update($this->POST('id_piutang'),$this->data['entry']);
			$this->flashmsg('Data Berhasil di edit','success');
			redirect('sales/piutang');
			exit;
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->piutang_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil di hapus','success');
			exit;
		}
		if ($this->POST('get') && $this->POST('id')) {
			echo json_encode($this->piutang_m->get_row("id_piutang = ".$this->POST('id').""));
			exit;
		}
		
		$this->data['piutang'] = $this->piutang_m->get();
		$this->data['content'] 	= 'sales/piutang';
		$this->data['title'] = 'Laporan Piutang'.$this->title;
		$this->template($this->data,'home');
	}
	public function piutang()
	{
		if ($this->POST('tambah')) {
			$this->data['entry'] = [
				'nama_toko'	=> $this->POST('nama_toko'),
				'tgl_piutang'	=> date("Y-m-d", strtotime($this->POST('tgl_piutang'))),
				'total'	=> $this->POST('total'),
				'kontak'	=> $this->POST('kontak'),
				'status_lunas'	=> $this->POST('status_lunas'),
				'jatuh_tempo' => date("Y-m-d", strtotime($this->POST('jatuh_tempo'))),
				'last_edit' => date("Y-m-d")
			];
			$this->piutang_m->insert($this->data['entry']);
			$this->flashmsg('Data Berhasil di Tambahkan','success');
			redirect('sales/piutang');
			exit;
		}
		if ($this->POST('edit')) {
			$this->data['entry'] = [
				'total'	=> $this->POST('total'),
				'jatuh_tempo' => date("Y-m-d", strtotime($this->POST('jatuh_tempo'))),
				'last_edit'	=> date('Y-m-d')
			];
			$this->piutang_m->update($this->POST('id_piutang'),$this->data['entry']);
			$this->flashmsg('Data Berhasil di edit','success');
			redirect('sales/piutang');
			exit;
		}
		if ($this->POST('delete') && $this->POST('id')) {
			$this->piutang_m->delete($this->POST('id'));
			$this->flashmsg('Data Berhasil di hapus','success');
			exit;
		}
		if ($this->POST('get') && $this->POST('id')) {
			echo json_encode($this->piutang_m->get_row("id_piutang = ".$this->POST('id').""));
			exit;
		}
		
		$this->data['piutang'] = $this->piutang_m->get();
		$this->data['content'] 	= 'sales/piutang';
		$this->data['title'] = 'Laporan Piutang'.$this->title;
		$this->template($this->data,'home');
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
