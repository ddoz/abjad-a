<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
        $this->load->model('User_model');
	}

	public function index()
	{
		$content = array(
			"body" => "admin/user",
            "script" => 'script/admin_kelas',
            'user' => $this->User_model->getUser()
		);
		$this->load->view('template/theme', $content);
	}

    public function destroy($id) {
      
        $this->User_model->hapusUser($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message','User Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','User Gagal dihapus.');
        }
      
        redirect(base_url('admin/user'));
    }

    public function reset($id) {

        if ($this->User_model->resetPassword($id)) {
            $this->session->set_flashdata('message','User Berhasil direset password menjadi : SMPALHUDA');
        } else {
            $this->session->set_flashdata('message','User Gagal direset password.');
        }
      
        redirect(base_url('admin/user'));
    }
}
