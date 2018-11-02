<?php

class Login extends MY_Controller{
   
    public function index() {
        
        $this->load->view('design/header');
        $this->load->view('login/index_login');
        $this->load->view('design/footer');
        if($this->input->post('submit'))
        {
            $username=$this->input->post('username',TRUE);
            $password=md5($this->input->post('password',TRUE));
			
            $this->db->where('username',$username);
            $this->db->where('password',$password);
            $query=$this->db->get('akun');
			
            if($query->num_rows()==1)
            {
                
                $row=$query->row();
                $user = array(
                       'username'  => $username,
                        'user' => TRUE,
                        'hak_akses'=>$row->hak_akses
                );
				$this->session->set_userdata($user);
                redirect('home');
                                    
            }
            else{
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger"><h5>Maaf, Username atau Password salah!</h5></div>');
                redirect('login');
            }  
        }
    }
    public function keluar()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
 }

