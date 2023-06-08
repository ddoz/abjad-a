<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if($this->session->userdata('username')!=null) {
			redirect(base_url()."dashboard");
		}
	 }

	public function index()
	{
		$content = array(
			"body" => "login"
		);
		$this->load->view('template/theme', $content);
	}

	public function proses() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
   
        if ($this->form_validation->run() == FALSE){
            $content = array(
				"body" => "login"
			);
			$this->load->view('template/theme', $content);
        }else{
           $post = $this->input->post();

		   $user = $this->db->get_where("users", array("username"=>$post['username']));
		   if($user->num_rows()>0) {
				$dataUser = $user->row();
				if(password_verify($post['password'], $dataUser->password)) {
					$this->session->set_userdata(
						array(
							"username"=>$dataUser->username,
							"nama" => $dataUser->nama,
							"level" => $dataUser->level
						)
					);
					redirect(base_url()."dashboard");
				}else {
					$this->session->set_flashdata('message','Login Gagal. Username atau Password Salah');
					redirect(base_url()."login");
				}
		   }else {
			$this->session->set_flashdata('message','Login Gagal. Username atau Password Salah');
			redirect(base_url()."login");
		   }
        }
	}
}
