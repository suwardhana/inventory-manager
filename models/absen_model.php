<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absen_model extends CI_Model{

	
    public function get_all_absen()
    {
        return $this->db->get('absen')->result();
    }
    public function get_absen()
    {

        $date=date('Y-m-d');
        $this->db->where('date_absen',$date);
        return $this->db->get('absen')->row();
    }
    
    public function submit() {
        try {
         
            $id=$this->input->post('id_absen');
            $stat=$this->input->post('stat');
            $data = array( 
                'date'=>$this->input->post('tanggal'),
                    //'idpegawai' => $this->input->post('idpegawai'),
                'nama' => $this->input->post('nama'),
                'keterangan' => $this->input->post('keterangan'),
                'status'=>1					
            );  

            if(empty($id)){
                $resl = $this->db->insert('absen', $data);
                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                    $this->stat = "0";
                }else{
                    $this->res = "<label class=\"label label-success\">Date Inserted Successfully</label>";
                    $this->stat = "1";
                }
                
            }
            elseif(!empty($id) && empty($stat))
            {

                $this->db->where('id_absen', $id);
                $resl = $this->db->update('absen', $data);
                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                    $this->stat = "0";
                }else{
                    $this->res = "<label class=\"label label-success\">Data Updated</label>";
                    $this->stat = "1";
                }

            }elseif(!empty($id) && $stat=='delete'){
                $this->db->where('id_absen', $id);
                $resl = $this->db->update('absen',array('status'=>0));

                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = "Error : ". $this->apps->err_code($err['message']);
                    $this->stat = "0";
                }else{
                    $this->res = "Data deleted!";
                    $this->stat = "1";
                }
                
            }else{
                $this->res = "<label class=\"label label-danger\">Failed</label>";
                $this->stat = "0";
            }

        }
        catch (Exception $e) {            
            $this->res = "<label class=\"label label-danger\">".$e->getMessage()."</label>";
            $this->stat = "0";
        }
        
        $arr = array(
            'stat' => $this->stat, 
            'msg' => $this->res,
        );
        
        return  json_encode($arr);
    }

    public function get_absen_harini()
    {
        $date=date("Y-m-d");
        $this->db->where('date_absen',$date);
        return $this->db->get('absen')->row();
    }
    public function get_absen_by_month($b)
    {
        $this->db->where('MONTH(date_absen)',$b,FALSE);
        return $this->db->get('absen')->result();
    }
    Public function insert_peg()
    {
      
    	$data=array(
         'nama'=>$_POST['nama'],
         'kontak'=>$_POST['kontak']
     );

    	$this->db->insert('pegawai',$data);
    	return($this->db->affected_rows()!=1)?false:true;

    }
}