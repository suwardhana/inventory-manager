<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qry_ajaxform extends CI_Model{

    protected $res = "";
    protected $stat = "";

    public function __construct() {
        parent::__construct();
    }
    
    public function select_data() {
        $this->db->where('status',1);
        $this->db->order_by("item_name","asc");
        $query = $this->db->get('item_details');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;
        }

    }
    public function select_data2($id) {
        $this->db->where('id_barang',$id);
        $query = $this->db->get('item_details');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;
        }

    }
    
    public function set_data() {
        $id = $this->input->post('id_barang');
        $this->db->where('id_barang', $id);
        $this->db->where('status',1);
        $query = $this->db->get('item_details');
        
        foreach ($query->result_array() as $row)
        {
            $res=array(
                'id_barang' => $row['id_barang'],
                'item_name' => $row['item_name'],
                'jumlahmin' => $row['jumlahmin'],
                'modal' => $row['modal'],
                'satuan' => $row['satuan'],
                'banyak' => $row['banyak'],
                'gambar' => $row['link_gambar'],
                'partai' => $row['partai'],
                'stok' => $row['jumlah']              
            );
        }
        return json_encode($res); 
    }
    
    public function submit() {
        try {

            $id=$this->input->post('id_barang');
            $stat=$this->input->post('stat');
            $data = array( 
                'date'=>date('d-m-Y'),
                'item_name' => $this->input->post('item_name'),
                'jumlah' => $this->input->post('stok'),
                'modal' => $this->input->post('modal'),
                'satuan' => $this->input->post('satuan'),
                'banyak' => $this->input->post('banyak'),
                'partai' => $this->input->post('partai'),
                'jumlahmin' => $this->input->post('jumlahmin'),
                'link_gambar' => $this->input->post('link_gambar'),
                'status'=>1                   
            );  

            if(empty($id)){
                $resl = $this->db->insert('item_details', $data);
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

                $this->db->where('id_barang', $id);
                $resl = $this->db->update('item_details', $data);
                if( ! $resl){
                    $err = $this->db->error();
                    $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                    $this->stat = "0";
                }else{
                    $this->res = "<label class=\"label label-success\">Data Updated</label>";
                    $this->stat = "1";
                }

            }elseif(!empty($id) && !empty($stat)){
                $this->db->where('id_barang', $id);
                $resl = $this->db->update('item_details',array('status'=>0));

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
}
