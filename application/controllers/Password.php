<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
	}

	public function index()
	{
		$content = array(
			"body" => "password",
            "script" => 'script/admin_kelas',
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->db->where("id_siswa", $this->session->userdata('user_related'));
            $konsultasi = $this->db->get('konsultasi')->result();
            $content = array(
				"body" => "password",
                "script" => 'script/admin_kelas',
			);
			$this->load->view('template/theme', $content);
        } else {
            $user = $this->db->get_where('users', array('id'=>$this->session->userdata('id')))->row();
            if(password_verify($this->input->post('password_lama'), $user->password)) {
                $this->db->where('id',$user->id);
                $this->db->update('users', array('password'=>password_hash($this->input->post('password_baru'), PASSWORD_BCRYPT)));
                $this->session->set_flashdata('message','Password Berhasil disimpan.');
            }else {
                $this->session->set_flashdata('message','Password Gagal disimpan.');
            }
          redirect(base_url('password'));
        }
    }

}
