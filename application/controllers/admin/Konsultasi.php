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
        
        $this->db->select("konsultasi.*,kelas.nama_kelas,siswa.nama_siswa,siswa.tipe_berkas,siswa.foto");
        $this->db->from('konsultasi');
        $this->db->join("siswa","siswa.id=konsultasi.id_siswa");
        $this->db->join("kelas","kelas.id=siswa.kelas_id");
        $konsultasi = $this->db->get()->result();
		$content = array(
			"body" => "admin/konsultasi",
            "script" => 'script/admin_siswa',
            'konsultasi' => $konsultasi
		);
		$this->load->view('template/theme', $content);
	}

    public function update() {
        // Ambil data dari form
        $id = $this->input->post('id');
        $jawaban = $this->input->post('jawaban');

        // Validasi form
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('jawaban', 'Jawaban', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->db->select("konsultasi.*,kelas.nama_kelas,siswa.nama_siswa,siswa.tipe_berkas,siswa.foto");
            $this->db->from('konsultasi');
            $this->db->join("siswa","siswa.id=konsultasi.id_siswa");
            $this->db->join("kelas","kelas.id=siswa.kelas_id");
            $konsultasi = $this->db->get()->result();
            $content = array(
                "body" => "admin/konsultasi",
                "script" => 'script/admin_siswa',
                'konsultasi' => $konsultasi
            );
			$this->load->view('template/theme', $content);
        } else {
                $up = array(
                    'jawaban' => $jawaban
                );
                $this->db->where('id',$id);
                if ($this->db->update("konsultasi", $up)) {
                    $this->session->set_flashdata('message','Konsultasi Berhasil dijawab.');
                } else {
                    $this->session->set_flashdata('message','Konsultasi Gagal dijawab.');
                }
            redirect(base_url('admin/konsultasi'));
        }
    }

    public function destroy($id) {
        $this->db->where('id',$id);
        if ($this->db->delete('konsultasi')) {
            $this->session->set_flashdata('message','Keluhan Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','Keluhan Gagal dihapus.');
        }
        redirect(base_url('admin/konsultasi'));
    }
}
