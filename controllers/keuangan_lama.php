<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Keuangan extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }
   
    public function index() {
        $this->ceklogin();
        $crud = new grocery_CRUD();
		$this->grocery_crud->set_theme('datatables');
        $this->grocery_crud->set_table('uang_keluar2');
        $output = $this->grocery_crud->render();
        $this->_example_output($output);
    }
    public function _example_output($output = null)
    {
        $this->load->view('design/header');
        $this->load->view('keuangan/index.php',(array)$output);
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
    	$data=array(
    		'jenis'=>$_POST['jenis_keluar'],
			'keterangan'=>$_POST['keterangan'],
			'tanggal'=>$_POST['tanggal'],
			'jumlah'=>$_POST['jumlah']
    		);

    	$query = $this->db->insert('uang_keluar2',$data);
		if($query)
{redirect('keuangan/');}
else echo "gagal";		
    }
	public function update2()
    {
    	$data=array(
    		'tglsampai'=>$_POST['tglsampai'],
    		'jumlahjadi'=>implode(',',$_POST['jumlah']),
    		'sisa'=>implode(',',$_POST['sisa']),
			);
			$id = $_POST['id'];

    	$query = $this->db->update('bahan_keluar', $data, array('idcatatbahan' => $id));
		
		if($query)
{redirect('bahan/report');}
else echo "gagal";		
    }
	
    
	public function report($id) {
        $this->ceklogin();
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
        $crud->set_table('uang_keluar2');
		if($id!='all'){$crud->where('jenis',$id);}
		//$crud->where('bulan',$bulan);
		//$crud->where('tahun',$tahun);
		$crud->columns('keterangan','jumlah','tanggal');
		$crud->fields('keterangan','jumlah','tanggal');
        $output = $crud->render();
        $this->_example_output($output);
    }
	public function update($id) {
        $this->ceklogin();
		$this->db->where('idcatatbahan',$id);
		$data['isi']=$this->db->get('bahan_keluar')->result();
        $this->load->view('design/header');
        $this->load->view('bahan/bahan_update',$data);
        $this->load->view('design/footer');
    }
	 public function delete()
    {
    	$id = $_POST['id'];
    	$this->db->update('jenis_keluar',array('status'=>0),array('id' => $id));
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
}

