<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
        $this->load->model('Kelas_model');
	}

	public function index()
	{
		$content = array(
			"body" => "admin/kelas",
            "script" => 'script/admin_kelas',
            'kelas' => $this->db->get('kelas')->result()
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/kelas",
                "script" => 'script/admin_kelas',
                'kelas' => $this->db->get('kelas')->result()
			);
			$this->load->view('template/theme', $content);
        } else {
          $nama_kelas = $this->input->post('nama_kelas');
    
          // Cek kelas tersedia
          if ($this->Kelas_model->cekKelasTersedia($nama_kelas)) {
            $this->session->set_flashdata('message','Nama Kelas Sudah Ada.');
          } else {
            // Data kelas valid, simpan ke database
            $data = array('nama_kelas' => $nama_kelas);
            if ($this->Kelas_model->simpanKelas($data)) {
                $this->session->set_flashdata('message','Kelas Berhasil disimpan.');
            } else {
                $this->session->set_flashdata('message','Kelas Gagal disimpan.');
            }
          }
          redirect(base_url('admin/kelas'));
        }
    }

    public function update() {
        // Set aturan validasi
        $this->form_validation->set_rules('id', 'ID Kelas', 'required');
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/kelas",
                "script" => 'script/admin_kelas',
                'kelas' => $this->db->get('kelas')->result()
			);
			$this->load->view('template/theme', $content);
        } else {
            $id = $this->input->post('id');
            $nama_kelas = $this->input->post('nama_kelas');

            // Cek kelas tersedia
            if ($this->Kelas_model->cekKelasTersedia($nama_kelas)) {
                // Cek jika kelas dengan nama_kelas tersebut adalah kelas yang sedang diubah
                $kelas = $this->Kelas_model->getKelasById($id);
                if ($kelas && $kelas->nama_kelas == $nama_kelas) {
                    // Data kelas valid, update ke database
                    $data = array('nama_kelas' => $nama_kelas);
                    if ($this->Kelas_model->updateKelas($id, $data)) {
                        $this->session->set_flashdata('message','Kelas Berhasil diubah.');
                    } else {
                        $this->session->set_flashdata('message','Kelas Gagal diubah.');
                    }
                } else {
                    $this->session->set_flashdata('message','Kelas Gagal diubah.');
                }
            } else {
                // Data kelas valid, update ke database
                $data = array('nama_kelas' => $nama_kelas);
                if ($this->Kelas_model->updateKelas($id, $data)) {
                    $this->session->set_flashdata('message','Kelas Berhasil diubah.');
                } else {
                    $this->session->set_flashdata('message','Kelas Gagal diubah.');
                }
            }
            redirect(base_url('admin/kelas'));
        }
    }

    public function destroy($id) {
        // Cek apakah kelas terkait dengan siswa
        if ($this->Kelas_model->cekKelasTerkait($id)) {
            $this->session->set_flashdata('message','Kelas Gagal dihapus. Karena terdapat siswa yang terhubung ke kelas tersebut.');
        } else {
            // Hapus kelas dari tabel kelas
            $this->Kelas_model->hapusKelas($id);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message','Kelas Berhasil dihapus.');
            } else {
                $this->session->set_flashdata('message','Kelas Gagal dihapus.');
            }
        }
        redirect(base_url('admin/kelas'));
    }
}
