<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

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
        $kelas = $this->input->get('kelas');
		$content = array(
			"body" => "admin/siswa",
            "script" => 'script/admin_siswa',
            'siswa' => $this->Siswa_model->getSiswaFilter($kelas),
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
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = 500;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto'))
            {
                $this->session->set_flashdata('message','Siswa Gagal disimpan. Periksa Kembali ukuran dan tipe gambar.');
            }else {
                // Data siswa
                $image_data = $this->upload->data();
                $imgdata = file_get_contents($image_data['full_path']);
                $file_encode=base64_encode($imgdata);

                $data_siswa = array(
                    'nisn' => $nisn,
                    'nama_siswa' => $nama_siswa,
                    'kelas_id' => $kelas,
                    'tanggal_lahir' => $tanggal_lahir,
                    "foto"=>$file_encode,
                    "tipe_berkas"=>$this->upload->data('file_type')
                );

                
                if ($this->Siswa_model->simpanSiswa($data_siswa)) {
                    $this->db->insert("users", array(
                        "username" => $nisn,
                        "nama" => $nama_siswa,
                        "level" => "siswa",
                        "user_related" => $this->db->insert_id(),
                        "password" => password_hash($tanggal_lahir, PASSWORD_BCRYPT)
                    ));
                    $this->session->set_flashdata('message','Siswa Berhasil disimpan.');
                } else {
                    $this->session->set_flashdata('message','Siswa Gagal disimpan.');
                }
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
				"body" => "admin/siswa",
                "script" => 'script/admin_siswa',
                'siswa' => $this->Siswa_model->getSiswa(),
                'daftarKelas' => $this->Kelas_model->getKelas()
			);
			$this->load->view('template/theme', $content);
        } else {
            $siswa = $this->Siswa_model->getSiswaByNisnExceptId($nisn, $id);
            if ($siswa) {            
                $this->session->set_flashdata('message','Siswa Gagal diubah. NISN sudah terdaftar.');                 
            } else {
                // Data siswa
                $data_siswa = array(
                    'nama_siswa' => $nama_siswa,
                    'kelas_id' => $kelas,
                    'tanggal_lahir' => $tanggal_lahir
                );

                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 500;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $this->load->library('upload', $config);

                if(is_uploaded_file($_FILES['foto']['tmp_name'])) {
                    if ($this->upload->do_upload('foto')){
                        $image_data = $this->upload->data();
                        $imgdata = file_get_contents($image_data['full_path']);
                        $file_encode=base64_encode($imgdata);
                        $data_siswa['foto'] = $file_encode;
                        $data_siswa['tipe_berkas'] = $this->upload->data('file_type');
                    }
                }

                
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
                $this->db->where("user_related",$id);
                $this->db->delete("users");
                $this->session->set_flashdata('message','Siswa Berhasil dihapus.');
            } else {
                $this->session->set_flashdata('message','Siswa Gagal dihapus.');
            }
        }
        redirect(base_url('admin/siswa'));
    }
}
