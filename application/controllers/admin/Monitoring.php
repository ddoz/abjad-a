<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
        $this->load->model('Siswa_model');
        $this->load->model('Kelas_model');
	}

	public function index()
	{
        
		$content = array(
			"body" => "admin/monitoring",
            "script" => 'script/admin_siswa',
            'siswa' => $this->Siswa_model->getSiswa(),
            'daftarKelas' => $this->Kelas_model->getKelas()
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {

        // Ambil data dari form
        $nisn = $this->input->post('nisn');
        $nama_siswa = $this->input->post('nama_siswa');
        $kelas = $this->input->post('kelas_id');
        $tanggal_lahir = $this->input->post('tanggal_lahir');

        // Validasi form
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/siswa",
                "script" => 'script/admin_siswa',
                'siswa' => $this->Siswa_model->getSiswa(),
                'daftarKelas' => $this->Kelas_model->getKelas()
			);
			$this->load->view('template/theme', $content);
        } else {
          
    
          // Cek kelas tersedia
          $siswa = $this->Siswa_model->getSiswaByNisn($nisn);
          if ($siswa) {
            $this->session->set_flashdata('message','NISN Sudah Ada.');
          } else {
            // Data kelas valid, simpan ke database
            // Data siswa
            $data_siswa = array(
                'nisn' => $nisn,
                'nama_siswa' => $nama_siswa,
                'kelas_id' => $kelas,
                'tanggal_lahir' => $tanggal_lahir
            );
            if ($this->Siswa_model->simpanSiswa($data_siswa)) {
                $this->session->set_flashdata('message','Siswa Berhasil disimpan.');
            } else {
                $this->session->set_flashdata('message','Siswa Gagal disimpan.');
            }
          }
          redirect(base_url('admin/siswa'));
        }
    }

    public function update() {
        // Ambil data dari form
        $id = $this->input->post('id');
        $nisn = $this->input->post('nisn');
        $nama_siswa = $this->input->post('nama_siswa');
        $kelas = $this->input->post('kelas_id');
        $tanggal_lahir = $this->input->post('tanggal_lahir');

        // Validasi form
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/kelas",
                "script" => 'script/admin_kelas',
                'kelas' => $this->db->get('kelas')->result()
			);
			$this->load->view('template/theme', $content);
        } else {
            $siswa = $this->Siswa_model->getSiswaByNisnExceptId($nisn, $id);
            if ($siswa) {            
                $this->session->set_flashdata('message','Kelas Gagal diubah. NISN sudah terdaftar.');                 
            } else {
                // Data siswa
                $data_siswa = array(
                    'nisn' => $nisn,
                    'nama_siswa' => $nama_siswa,
                    'kelas_id' => $kelas,
                    'tanggal_lahir' => $tanggal_lahir
                );
                if ($this->Siswa_model->updateSiswa($id, $data_siswa)) {
                    $this->session->set_flashdata('message','Siswa Berhasil diubah.');
                } else {
                    $this->session->set_flashdata('message','Siswa Gagal diubah.');
                }
            }
            redirect(base_url('admin/siswa'));
        }
    }

    public function destroy($id) {
        // Cek apakah ID siswa ada di tabel monitoring atau konsultasi
        $isInMonitoring = $this->Siswa_model->isIdInMonitoring($id);
        $isInKonsultasi = $this->Siswa_model->isIdInKonsultasi($id);
        if ($isInMonitoring || $isInKonsultasi) {
            $this->session->set_flashdata('message','Siswa Gagal dihapus. Karena terdapat siswa yang terhubung ke monitoring atau konsultasi.');
        } else {
            if ($this->Siswa_model->hapusSiswa($id)) {
                $this->session->set_flashdata('message','Siswa Berhasil dihapus.');
            } else {
                $this->session->set_flashdata('message','Siswa Gagal dihapus.');
            }
        }
        redirect(base_url('admin/siswa'));
    }
}
