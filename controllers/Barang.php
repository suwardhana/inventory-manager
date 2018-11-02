<?php

class Barang extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $user = array(
      'username'  => 'dhana',
      'user' => true,
      'hak_akses'=>'1'
    );
    $this->session->set_userdata($user);
    $this->load->model('aset_m');
    $this->load->model('peminjaman_m');

  }
  public function index() {
    $this->ceklogin();
    $this->load->view('design/header');
    $this->load->view('barang/index');
    $this->load->view('design/footer');

  }
  public function harga() {
   $this->load->model('ajaxform/qry_ajaxform');
   $data['tabel'] = $this->qry_ajaxform->select_data();
   $this->load->view('design/header');
   $this->load->view('barang/harga',$data);
   $this->load->view('design/footer');

 }
 public function aset()
 {
  if ($this->POST('tambah')) {
    $this->data['entry'] = [
      'tanggal'                => $this->POST('tanggal'),
      'aset_toko'              => $this->POST('aset_toko'),
      'tabungan'               => $this->POST('tabungan'),
      'perabotan_alat'         => $this->POST('perabotan_alat'),
      'lainnya'                => $this->POST('lainnya'),
      'piutang'                => $this->POST('piutang'),
      'hutang'                 => $this->POST('hutang'),
      'keterangan'             => $this->POST('keterangan')
    ];
    $this->aset_m->insert($this->data['entry']);
    $this->flashmsg('Data Berhasil di Tambahkan','success');
    redirect('barang/aset');
    exit;
  }
  if ($this->POST('delete') && $this->POST('id')) {
    $this->aset_m->delete($this->POST('id'));
    $this->flashmsg('Data Berhasil di hapus','success');
    exit;
  }
  $this->data['aset'] = $this->aset_m->get();
  $this->data['content']  = 'aset/aset';
  $this->template($this->data,'home');
}
public function peminjaman()
{
  if ($this->POST('edit')) {
    $this->data['entry'] = [
      'nama'                           => $this->POST('nama'),
      'tanggal_pinjam'                 => $this->POST('tanggal_pinjam'),
      'tanggal_kembali'                => $this->POST('tanggal_kembali'),
      'keterangan'                     => nl2br($this->POST('keterangan')),
      'tanggal_bayar'                  => $this->POST('tanggal_bayar'),
      'pic'                            => $this->POST('pic'),
      'barang'                         => nl2br($this->POST('barang')),
      'bayar'                          => $this->POST('bayar')
    ];
    $this->peminjaman_m->update($this->POST('id_peminjaman'),$this->data['entry']);
    $this->flashmsg('Data Berhasil di edit','success');
    redirect('barang/peminjaman');
    exit;
  }
  if ($this->POST('tambah')) {
    $this->data['entry'] = [
      'nama'                           => $this->POST('nama'),
      'tanggal_pinjam'                 => $this->POST('tanggal_pinjam'),
      'tanggal_kembali'                => $this->POST('tanggal_kembali'),
      'keterangan'                     => nl2br($this->POST('keterangan')),
      'tanggal_bayar'                  => $this->POST('tanggal_bayar'),
      'pic'                            => $this->POST('pic'),
      'barang'                         => nl2br($this->POST('barang')),
      'bayar'                          => $this->POST('bayar')
    ];
    $this->peminjaman_m->insert($this->data['entry']);
    $this->flashmsg('Data Berhasil di Tambahkan','success');
    redirect('barang/peminjaman');
    exit;
  }
  if ($this->POST('delete') && $this->POST('id')) {
    $this->peminjaman_m->delete($this->POST('id'));
    $this->flashmsg('Data Berhasil di hapus','success');
    exit;
  }
  if ($this->POST('get') && $this->POST('id')) {
      echo json_encode($this->peminjaman_m->get_row("id_peminjaman = ".$this->POST('id').""));
      exit;
    }
  $this->data['peminjaman'] = $this->peminjaman_m->get();
  $this->data['content']  = 'barang/peminjaman';
  $this->template($this->data,'home');
}
function ceklogin()
{
  if($this->session->userdata('user')==true)
  {
    return true;
  }
  else{
    redirect('login');
  }
}
function ispegawai()
{
  if($this->session->userdata('hak_akses')==0)
  {
    return true;
  }
  else{
    return false;
  }
}

public function insert_barang()
{
 $this->load->model('barang_model');
 $result=$this->barang_model->insert_barang();
 if($result)
 {
  $this->session->set_flashdata('msg','barang Added Successfully');
  redirect('ajaxform');
}
else
{
  $this->session->set_flashdata('Msg','Invoice Adding Failed ');
  redirect('ajaxform');
}
}
public function barang_reports($id)
{
 $this->db->where('status',1);
 $this->db->where('id_barang',$id);
 $data['invoice']=$this->db->get('history_item')->result();
 $this->db->where('status',1);
 $this->db->where('id_barang',$id);
 $data['barang']=$this->db->get('item_details')->result();
 $data['ispegawai']=$this->ispegawai();
 $this->load->view('design/header',$data);
 $this->load->view('barang/barang_reports');
 $this->load->view('design/footer');
}
public function filter_date($bulan,$tahun)
{
        //$this->ceklogin();
  $this->load->model('barang_model');
  $data['invoice']=$this->barang_model->get_date($bulan,$tahun);
  $data['bulan']=$bulan;
  $data['tahun']=$tahun;
  $this->load->view('design/header');
  $this->load->view('barang/filter_date',$data);
  $this->load->view('design/footer');
  if($this->input->post('filter_date'))
  {
    $this->session->set_flashdata('msg','Data Barang Laku bulan '.$bulan." tahun".$tahun);
    $bulan= $this->input->post('bulan');
    $tahun= $this->input->post('tahun');

    redirect('barang/filter_date/'.$bulan."/".$tahun);

  }
}
public function delete_hbarang()
{
 if($this->ispegawai()){
   redirect('ajaxform');
 }
 $this->db->where('id',$_POST['id']);
 $this->db->update('history_item',array('status'=>0));
 $result=($this->db->affected_rows()!=1)?false:true;
 if($result)
 {
  $this->session->set_flashdata('msg1','Invoice deleted Successfully');
  redirect('ajaxform');
}
else
{
  $this->session->set_flashdata('Msg1','Invoice delete Failed ');
  redirect('ajaxform');
}
}
public function upload2($id, $tag_name = 'userfile')
{
  if ($_FILES[$tag_name])
  {
    $upload_path = realpath(APPPATH . '../assets/img/barang/');
    @unlink($upload_path . '/' . $id . '.jpg');
    $config = [
      'file_name'         => $id . '.jpg',
      'allowed_types'     => 'jpg|png|bmp|jpeg',
      'upload_path'       => $upload_path
    ];
    $this->load->library('upload');
    $this->upload->initialize($config);
    return $this->upload->do_upload($tag_name);
  }
  return FALSE;
}
}

