<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsultasi extends CI_Controller {

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
        $konsultasi = $this->db->get('konsultasi')->result();

        if($this->session->userdata('level')=='wali'){
            $this->db->where("id_wali", $this->session->userdata('user_related'));
            $siswa = $this->db->get('wali_murid_detail')->result();
            $arrSiswa = [];
            foreach($siswa as $s) {
                $arrSiswa[] = $s->id_siswa;
            }
            $this->db->select("konsultasi.*,kelas.nama_kelas,siswa.nama_siswa,siswa.tipe_berkas,siswa.foto");
            $this->db->from('konsultasi');
            $this->db->join("siswa","siswa.id=konsultasi.id_siswa");
            $this->db->join("kelas","kelas.id=siswa.kelas_id");
            $this->db->where_in('siswa.id',$arrSiswa);
            $konsultasi = $this->db->get()->result();
        }

		$content = array(
			"body" => "konsultasi",
            "script" => 'script/admin_kelas',
            'konsultasi' => $konsultasi
		);
		$this->load->view('template/theme', $content);
	}

    public function guru()
	{
        $konsultasi = $this->db->get('konsultasi')->result();
		$content = array(
			"body" => "konsultasi",
            "script" => 'script/admin_kelas',
            'konsultasi' => $konsultasi
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->db->where("id_siswa", $this->session->userdata('user_related'));
            $konsultasi = $this->db->get('konsultasi')->result();
            $content = array(
				"body" => "konsultasi",
                "script" => 'script/admin_kelas',
                'konsultasi' => $konsultasi
			);
			$this->load->view('template/theme', $content);
        } else {
          $keluhan = $this->input->post('keluhan');
            $data = array('keluhan' => $keluhan,'id_siswa'=>$this->session->userdata('user_related'));
            if ($this->db->insert('konsultasi',$data)) {
                $this->session->set_flashdata('message','Konsultasi Berhasil disimpan.');
            } else {
                $this->session->set_flashdata('message','Konsultasi Gagal disimpan.');
            }
          redirect(base_url('konsultasi'));
        }
    }

    public function destroy($id) {
        
        // Hapus konsultasi dari tabel konsultasi
        $this->db->where('id',$id);
        if ($this->db->delete('konsultasi')) {
            $this->session->set_flashdata('message','Konsultasi Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','Konsultasi Gagal dihapus.');
        }
        redirect(base_url('konsultasi'));
    }
}
