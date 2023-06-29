<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url());
		}
	}

	public function index()
	{
		$month = date("m");
		$pelanggaran = $this->db->get_where('monitoring',array("pelanggaran"=>"1","MONTH(tanggal_pelanggaran)"=>$month))->num_rows();
		$akademik = $this->db->get_where('monitoring',array("pelanggaran"=>"0","prestasi"=>"Akademik","MONTH(tanggal_pelanggaran)"=>$month))->num_rows();
		$nonAkademik = $this->db->get_where('monitoring',array("pelanggaran"=>"0","prestasi"=>"Non Akademik","MONTH(tanggal_pelanggaran)"=>$month))->num_rows();
		$content = array(
			"body" => "admin/dashboard",
            "script" => 'script/admin_dashboard',
			'pelanggaran' => $pelanggaran,
			'akademik' => $akademik,
			'nonAkademik' => $nonAkademik,
		);
		$this->load->view('template/theme', $content);
	}
}
