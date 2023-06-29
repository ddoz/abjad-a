<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$content = array(
			"body" => "home"
		);
		$this->load->view('template/theme', $content);
	}

	public function qrsaya($id) {
		$this->db->from('siswa');
		$this->db->join("kelas","kelas.id=siswa.kelas_id");
		$this->db->where("siswa.id", $this->session->userdata('user_related'));
        $siswa = $this->db->get()->row();
		$content = array(
			"body" => "qrdetail",
			'siswa' => $siswa
		);
		$this->load->view('template/theme', $content);
	}
}
