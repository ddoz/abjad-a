<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
	}

	public function index()
	{
        $this->db->where("id_siswa", $this->session->userdata('user_related'));
        $monitoring = $this->db->get('monitoring')->result();

		if($this->session->userdata('level')=='wali'){
            $this->db->where("id_wali", $this->session->userdata('user_related'));
            $siswa = $this->db->get('wali_murid_detail')->result();
            $arrSiswa = [];
            foreach($siswa as $s) {
                $arrSiswa[] = $s->id_siswa;
            }
            $this->db->select("monitoring.*,siswa.nama_siswa,kelas.nama_kelas");
			$this->db->from('monitoring');
			$this->db->join('siswa','siswa.id=monitoring.id_siswa');
			$this->db->join('kelas','kelas.id=siswa.kelas_id');
            $this->db->where_in('siswa.id',$arrSiswa);
            $monitoring = $this->db->get()->result();
        }
		$content = array(
			"body" => "monitoring",
            "script" => 'script/admin_kelas',
            'monitoring' => $monitoring
		);
		$this->load->view('template/theme', $content);
	}

}
