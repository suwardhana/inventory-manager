<?php

class Bahan extends MY_Controller{
   
    public function index() {
        $this->ceklogin();
        $this->load->view('design/header');
        $this->load->view('bahan/index');
        $this->load->view('design/footer');
    }
	 function ceklogin()
{
        if($this->session->userdata('user')==TRUE)
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
    		'tujuan'=>$_POST['nama'],
    		'tanggal'=>$_POST['tanggal'],
    		'alamat'=>$_POST['alamat'],
			'nama_hasil'=>implode(',',$_POST['hasil']),
    		'banyak'=>implode(',',$_POST['banyak']),
			'estimasi'=>implode(',',$_POST['estimasi']),
    		'status'=>1
    		);

    	$query = $this->db->insert('bahan_keluar',$data);
		if($query)
{redirect('bahan/report');}
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
	
    
	public function report() {
        $this->ceklogin();
		$this->db->order_by("idcatatbahan desc");
		$this->db->where('status',1);
		$data['isi']=$this->db->get('bahan_keluar')->result();
		$data['ispegawai']=$this->ispegawai();
        $this->load->view('design/header');
        $this->load->view('bahan/bahanbaku_report',$data);
        $this->load->view('design/footer');
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
    	$this->db->update('bahan_keluar',array('status'=>0),array('idcatatbahan' => $id));
    	$result=($this->db->affected_rows()!=1)?false:true;
    	if($result)
    	{
    		$this->session->set_flashdata('msg1','Invoice deleted Successfully');
    		redirect('bahan/report');
    	}
    	else
    	{
    		$this->session->set_flashdata('Msg1','Invoice delete Failed ');
    		redirect('bahan/report');
    	}
    }
}

