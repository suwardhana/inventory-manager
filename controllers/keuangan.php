<?php

class Keuangan extends MY_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }
    
    public function index() {
  //       $this->ceklogin();
  //       $crud = new grocery_CRUD();
		// $this->grocery_crud->set_theme('datatables');
  //       $this->grocery_crud->set_table('uang_keluar2');
  //       $output = $this->grocery_crud->render();
  //       $this->_example_output($output);
        // $this->ceklogin();
        // $this->db->where('status',1);
        // $data['agen']=$this->db->get('agen')->result();
        // $data['ispegawai']=$this->ispegawai();
        // $this->load->view('design/header',$data);
        // $this->load->view('agen/list');
        // $this->load->view('design/footer');
        $this->report();
    }
    // public function _example_output($output = null)
    // {
    //     $this->load->view('design/header');
    //     $this->load->view('keuangan/index.php',(array)$output);
    //     $this->load->view('design/footer');
    
    // }

    public function insert()
    {
    	$data=array(
    		'jenis_keluar'=>$_POST['jenis_keluar'],
         'status'=>1
         );

    	$query = $this->db->insert('jenis_keluar',$data);
      if($query)
        {redirect('keuangan/daftar_pengeluaran');}
    else echo "gagal";		
}
public function insert2()
{
    $bulan = date('m',strtotime($_POST['tanggal']));
    $tahun = date('Y',strtotime($_POST['tanggal']));
    
    $data=array(
      'jenis'=>$_POST['jenis_keluar'],
      'keterangan'=>$_POST['keterangan'],
      'tanggal'=>$_POST['tanggal'],
      'jumlah'=>$_POST['jumlah'],
      'bulan'=>$bulan,
      'tahun'=>$tahun,
      'status'=>1

      );

    $query = $this->db->insert('uang_keluar2',$data);
    if($query)
        {redirect('keuangan/');}
    else echo "gagal";		
}

public function report() {
    $this->ceklogin();
        //echo $month;
    if($this->input->post('filter_date'))
    {
        $this->session->set_flashdata('msg','Data keuangan bulan '.$bulan." tahun".$tahun);
        $bulan= $this->input->post('bulan');
        $tahun= $this->input->post('tahun');
        $jenis= $this->input->post('jenis');
        
        redirect('keuangan/report/'.$jenis."/".$bulan."/".$tahun);

    }
    $id = $this->uri->segment(3, 0);
    $month = $this->uri->segment(4, 0);
    $tahun = $this->uri->segment(5, 0);
    if (($id==null)||($month==null)||($tahun==null)) {
        
        $id='all';
        $month=0;
        $tahun=0;
    }
    $this->db->where('uang_keluar2.status',1);if ($month!=0) {$this->db->where('bulan',$month);}   if ($tahun!=0) {$this->db->where('tahun',$tahun);}       $this->db->join('jenis_keluar', 'uang_keluar2.jenis = jenis_keluar.id_jenis');if ($id!='all') {$this->db->where('jenis',$id);}
    $data['isi']=$this->db->get('uang_keluar2')->result();
    $this->db->where('uang_keluar2.status',1);if ($month!=0) {$this->db->where('bulan',$month);}   if ($tahun!=0) {$this->db->where('tahun',$tahun);}       $this->db->join('jenis_keluar', 'uang_keluar2.jenis = jenis_keluar.id_jenis');if ($id!='all') {$this->db->where('jenis',$id);}
    $data['jumlah']=$this->db->select_sum('jumlah')->get('uang_keluar2')->row();
    $data['jenis']=$this->db->where('status',1)->get('jenis_keluar')->result();
    $data['ispegawai']=$this->ispegawai();
    

    $this->load->view('design/header',$data);
    $this->load->view('keuangan/keuangan_report');
    $this->load->view('design/footer');
}
public function update($id) {
  //       $this->ceklogin();
		// $this->db->where('idcatatbahan',$id);
		// $data['isi']=$this->db->get('bahan_keluar')->result();
  //       $this->load->view('design/header');
  //       $this->load->view('bahan/bahan_update',$data);
  //       $this->load->view('design/footer');
}
public function delete()
{
   $id = $_POST['id'];
   $this->db->update('jenis_keluar',array('status'=>0),array('id_jenis' => $id));
   $result=($this->db->affected_rows()!=1)?false:true;
   if($result)
   {
      $this->session->set_flashdata('msg1','data deleted Successfully');
      redirect('keuangan/daftar_pengeluaran');
  }
  else
  {
      $this->session->set_flashdata('Msg1','data delete Failed ');
      redirect('keuangan/daftar_pengeluaran');
  }
}public function delete2()
{
    $id = $_POST['id'];
    $this->db->update('uang_keluar2',array('status'=>0),array('id' => $id));
    $result=($this->db->affected_rows()!=1)?false:true;
    if($result)
    {
        $this->session->set_flashdata('msg1','data deleted Successfully');
        redirect('keuangan/report');
    }
    else
    {
        $this->session->set_flashdata('Msg1','data delete Failed ');
        redirect('keuangan/report');
    }
}
public function daftar_pengeluaran()
{
  $this->db->where('status',1);
  $data['jenis_keluar']=$this->db->get('jenis_keluar')->result();
  $data['ispegawai']=$this->ispegawai();
  $this->load->view('design/header',$data);
  $this->load->view('keuangan/list');
  $this->load->view('design/footer');
}
public function tambah_pengeluaran()
{
   $this->load->view('design/header');
   $this->load->view('keuangan/insert');
   $this->load->view('design/footer');
}
public function pengeluaran_baru()
{
  $this->db->where('status',1);
  $data['jenis_keluar']=$this->db->get('jenis_keluar')->result();
  $this->load->view('design/header',$data);
  $this->load->view('keuangan/new_keuangan');
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
}

