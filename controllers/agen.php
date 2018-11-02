<?php

class Agen extends MY_Controller{

    public function index() {
       $this->ceklogin();
       $this->db->where('status',1);
       $data['agen']=$this->db->get('agen')->result();
       $data['ispegawai']=$this->ispegawai();
       $data['content'] = 'agen/list';
       $this->template($data);
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
public function invoice_agen($id) {
  $this->db->where('id',$id);
  $data['agen']=$this->db->get('agen')->result();
  $data['ispegawai']=$this->ispegawai();
  $this->load->view('design/header');
  $this->load->view('agen/invoice',$data);
  $this->load->view('design/footer');
}
public function insert_agen() {

    $this->load->view('design/header');
    $this->load->view('agen/insert');
    $this->load->view('design/footer');
}

public function insert_invoice()
{
   $this->load->model('agen_model');
   $result=$this->agen_model->insert_invoice();
   if($result)
   {
      $this->session->set_flashdata('msg','Invoice Added Successfully');
      redirect('agen');
  }
  else
  {
      $this->session->set_flashdata('Msg','Invoice Adding Failed ');
      redirect('agen');
  }
}
public function new_agen()
{
   $this->load->model('agen_model');
   $result=$this->agen_model->insert_agen();
   if($result)
   {
      $this->session->set_flashdata('msg','agen Added Successfully');
      redirect('agen');
  }
  else
  {
      $this->session->set_flashdata('Msg','agen Adding Failed ');
      redirect('agen');
  }
}
public function invoice_reports($id)
{
   $this->db->where('status',1);
   $this->db->where('id_agen',$id);
   $data['invoice']=$this->db->get('agen_details')->result();
   $this->db->where('id',$id);
   $data['agen']=$this->db->get('agen')->result();
   $data['ispegawai']=$this->ispegawai();
   $this->load->view('design/header',$data);
   $this->load->view('agen/agen_reports');
   $this->load->view('design/footer');
}
public function delete_agen()
{
   $this->db->where('id',$_POST['id']);
   $this->db->update('agen',array('status'=>0));
   $result=($this->db->affected_rows()!=1)?false:true;
   if($result)
   {
      $this->session->set_flashdata('msg1','agen deleted Successfully');
      redirect('agen');
  }
  else
  {
      $this->session->set_flashdata('Msg1','agen delete Failed ');
      redirect('agen');
  }
}
public function delete_invoice()
{
   $this->db->where('id',$_POST['id']);
   $this->db->update('agen_details',array('status'=>0));
   $result=($this->db->affected_rows()!=1)?false:true;
   if($result)
   {
      $this->session->set_flashdata('msg1','agen deleted Successfully');
      redirect('agen');
  }
  else
  {
      $this->session->set_flashdata('Msg1','agen delete Failed ');
      redirect('agen');
  }
}
}

