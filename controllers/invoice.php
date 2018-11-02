<?php

class Invoice extends MY_Controller{
 public function __construct() {
  parent::__construct();
  $this->load->helper('form');
  $this->load->library('table');
  $this->load->model('invoice_m');
  $this->load->model('invoice_model');


}
public function index() {
  $this->ceklogin();
  $this->load->view('design/header');
  $this->load->view('invoice/index');
  $this->load->view('design/footer');
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

public function insert_invoice()
{
 $this->load->model('invoice_model');
 $result=$this->invoice_model->insert_invoice();
 if($result)
 {
  $this->session->set_flashdata('msg','Invoice Added Successfully');
  redirect('invoice/invoice_reports');
}
else
{
  $this->session->set_flashdata('Msg','Invoice Adding Failed ');
  redirect('invoice');
}
}
public function invoice_reports()
{
  if($this->input->post('filter_date'))
  {
    $this->session->set_flashdata('msg','Data invoice bulan '.$bulan." tahun".$tahun);
    $bulan= $this->input->post('bulan');
    $tahun= $this->input->post('tahun');

    redirect('invoice/filter_date/'.$bulan."/".$tahun);
  }
  if ($this->POST('delete') && $this->POST('id')) {
    $this->data['entry'] = [
      'status' => 0
    ];
    $this->invoice_m->update($this->POST('id'),$this->data['entry']);
    $this->flashmsg('Data Berhasil di hapus','success');
    redirect('invoice/invoice_reports');
    exit;
  }
  if ($this->POST('get') && $this->POST('id')) {
    echo json_encode($this->invoice_m->get_row("id = ".$this->POST('id').""));
    exit;
  }
  $this->data['ispegawai']=$this->ispegawai();

  $this->data['invoice'] = $this->invoice_m->get("status = 1");
  $this->data['content']  = 'invoice/invoice_reports';
  $this->template($this->data,'home');
}

public function filter_date($bulan,$tahun)
{
        //$this->ceklogin();
  if($this->input->post('filter_date'))
  {
    $this->session->set_flashdata('msg','Data invoice bulan '.$bulan." tahun".$tahun);
    $bulan= $this->input->post('bulan');
    $tahun= $this->input->post('tahun');

    redirect('invoice/filter_date/'.$bulan."/".$tahun);
  }
  if ($this->POST('delete') && $this->POST('id')) {
    $this->data['entry'] = [
      'status' => 0
    ];
    $this->invoice_m->update($this->POST('id'),$this->data['entry']);
    $this->flashmsg('Data Berhasil di hapus','success');
    redirect('invoice/invoice_reports');
    exit;
  }
  if ($this->POST('get') && $this->POST('id')) {
    echo json_encode($this->invoice_m->get_row("id = ".$this->POST('id').""));
    exit;
  }
  $this->data['ispegawai']=$this->ispegawai();

  $this->data['invoice'] = $this->invoice_model->get_date($bulan,$tahun);
  $this->data['omset'] = $this->invoice_model->get_omset($bulan,$tahun);
  $this->data['content']  = 'invoice/filter_date';
  $this->template($this->data,'home');
}
public function delete_invoice()
{
 $this->db->where('id',$_POST['id']);
 $this->db->update('invoice_details',array('status'=>0));
 $result=($this->db->affected_rows()!=1)?false:true;
 if($result)
 {
  $this->session->set_flashdata('msg1','Invoice deleted Successfully');
  redirect('invoice/invoice_reports');
}
else
{
  $this->session->set_flashdata('Msg1','Invoice delete Failed ');
  redirect('invoice/invoice_reports');
}
}
public function lunas($id)
{
  $data = explode('-',$id);
  $this->db->where('id',$data[0]);
  $this->db->update('invoice_details',array('dp'=>$data[1]));
  $result=($this->db->affected_rows()!=1)?false:true;
  if($result)
  {
    $this->session->set_flashdata('msg1','data edited Successfully');
    redirect('invoice/invoice_reports');
  }
  else
  {
    $this->session->set_flashdata('Msg1','edit data Failed ');
    redirect('invoice/invoice_reports');
  }
}
}

