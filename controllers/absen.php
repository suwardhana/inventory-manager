<?php

class Absen extends MY_Controller
{
	public function __construct() {
    parent::__construct();
    $this->load->helper('form');
    $this->load->library('table');
    $this->load->model('absen_model');
    $this->load->model('kemampuan_m');

  }
  function admin()
  {
    if($this->session->userdata('hak_akses')==1)
    {
      return true;
    }
    else{
      redirect('home');
    }

  }

  public function submit() {
    $this->load->model('absen_model');
    $res = $this->absen_model->submit();
    echo $res;
  }
  public function get_tgl_akhir_bulan($b){

    $tgl = 1;
    if($b=='01'||$b=='03'||$b=='05'||$b=='07'||$b=='08'||$b=='10'||$b=='12')
    {
      $tgl='31';
    }
    if($b=='04'||$b=='06'||$b=='09'||$b=='11')
    {
      $tgl='30';
    }
    if($b=='02')
    {
      $tgl='28';
    }
    return $tgl;
  }
  public function index(){
    $this->admin();
    $this->db->order_by("nama");
    $this->db->where('status',1);
		//$this->db->order_by('nama');
    $data['tabel']=$this->db->get('absen')->result();
    $data['tabel2']=$this->db->get('pegawai')->result();
    $data['content'] = 'absen/index-absen';
    $this->template($data);


  }
  public function insert_peg() {

    $this->load->view('design/header');
    $this->load->view('absen/insert-peg');
    $this->load->view('design/footer');
  }
  public function new_peg()
  {
   $this->load->model('absen_model');
   $result=$this->absen_model->insert_peg();
   if($result)
   {
    $this->session->set_flashdata('msg','Pegawai Added Successfully');
    redirect('absen');
  }
  else
  {
    $this->session->set_flashdata('Msg','Pegawai Adding Failed ');
    redirect('absen');
  }
}

public function delpeg($id)
{
  $this->db->where('idpegawai',$id);
  $this->db->delete('pegawai');
  redirect('absen');
}
public function kemampuan()
{
  if ($this->POST('edit')) {
    $this->data['entry'] = [
      'nama'                           => $this->POST('nama'),
      'komunikasi'                     => $this->POST('komunikasi'),
      'packing'                        => $this->POST('packing'),
      'inisiatif'                      => $this->POST('inisiatif'),
      'kedisiplinan'                    => $this->POST('kedisiplinan'),
      'tanggal'                        => $this->POST('tanggal_catat'),
      'keterangan'                     => $this->POST('keterangan')

    ];
    $this->kemampuan_m->update($this->POST('id'),$this->data['entry']);
    $this->flashmsg('Data Berhasil di edit','success');
    redirect('absen/kemampuan');
    exit;
  }
  if ($this->POST('tambah')) {
    $this->data['entry'] = [
      'nama'                           => $this->POST('nama'),
      'komunikasi'                     => $this->POST('komunikasi'),
      'packing'                        => $this->POST('packing'),
      'tanggal'                        => $this->POST('tanggal_catat'),
      'inisiatif'                      => $this->POST('inisiatif'),
      'kedisiplinan'                   => $this->POST('kedisiplinan'),
      'keterangan'                     => $this->POST('keterangan')
    ];
    $this->kemampuan_m->insert($this->data['entry']);
    $this->flashmsg('Data Berhasil di Tambahkan','success');
    redirect('absen/kemampuan');
    exit;
  }
  if ($this->POST('delete') && $this->POST('id')) {
    $this->kemampuan_m->delete($this->POST('id'));
    $this->flashmsg('Data Berhasil di hapus','success');
    exit;
  }
  if ($this->POST('get') && $this->POST('id')) {
    echo json_encode($this->kemampuan_m->get_row("id = ".$this->POST('id').""));
    exit;
  }
  $this->data['kemampuan'] = $this->kemampuan_m->get();
  $this->data['content']  = 'absen/kemampuan';
  $this->template($this->data,'home');
}

}
?>