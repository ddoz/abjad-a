<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
        $this->load->model('Guru_model');
	}

	public function index()
	{
        
		$content = array(
			"body" => "admin/guru",
            "script" => 'script/admin_guru',
            'guru' => $this->Guru_model->getGuru()
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {

        // Ambil data dari form
        $nip = $this->input->post('nip');
        $nama_guru = $this->input->post('nama_guru');
        $pendidikan_terakhir = $this->input->post('pendidikan_terakhir');
        $jurusan = $this->input->post('jurusan');
        $tanggal_lahir = $this->input->post('tanggal_lahir');

        // Validasi form
        $this->form_validation->set_rules('nip', 'NIP', 'required');
        $this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required');
        $this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/guru",
                "script" => 'script/admin_guru',
                'guru' => $this->Guru_model->getGuru()
			);
			$this->load->view('template/theme', $content);
        } else {
          
    
          // Cek kelas tersedia
          $guru = $this->Guru_model->getGuruByNip($nip);
          if ($guru) {
            $this->session->set_flashdata('message','NIP Sudah Ada.');
          } else {
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = 500;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto'))
            {
                $this->session->set_flashdata('message','Guru Gagal disimpan. Periksa Kembali ukuran dan tipe gambar.'.$this->upload->display_errors());
            }else {
                // Data Guru
                $image_data = $this->upload->data();
                $imgdata = file_get_contents($image_data['full_path']);
                $file_encode=base64_encode($imgdata);

                $data_guru = array(
                    'nip' => $nip,
                    'nama_guru' => $nama_guru,
                    'pendidikan_terakhir' => $pendidikan_terakhir,
                    'jurusan' => $jurusan,
                    'tanggal_lahir' => $tanggal_lahir,
                    "foto"=>$file_encode,
                    "tipe_berkas"=>$this->upload->data('file_type')
                );

                
                if ($this->Guru_model->simpanGuru($data_guru)) {
                    $this->db->insert("users", array(
                        "username" => $nip,
                        "nama" => $nama_guru,
                        "level" => "guru",
                        "user_related" => $this->db->insert_id(),
                        "password" => password_hash($tanggal_lahir, PASSWORD_BCRYPT)
                    ));
                    $this->session->set_flashdata('message','Guru Berhasil disimpan.');
                } else {
                    $this->session->set_flashdata('message','Guru Gagal disimpan.');
                }
            }
            
          }
          redirect(base_url('admin/guru'));
        }
    }

    public function update() {
        // Ambil data dari form
        $id = $this->input->post('id');
        $nip = $this->input->post('nip');
        $nama_guru = $this->input->post('nama_guru');
        $pendidikan_terakhir = $this->input->post('pendidikan_terakhir');
        $jurusan = $this->input->post('jurusan');
        $tanggal_lahir = $this->input->post('tanggal_lahir');

        // Validasi form
        $this->form_validation->set_rules('nip', 'NIP', 'required');
        $this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required');
        $this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/guru",
                "script" => 'script/admin_guru',
                'guru' => $this->db->get('guru')->result()
			);
			$this->load->view('template/theme', $content);
        } else {
            $this->load->library('upload');
            // Data 
            $data_guru = array(
                'nama_guru' => $nama_guru,
                'pendidikan_terakhir' => $pendidikan_terakhir,
                'jurusan' => $jurusan,
                'tanggal_lahir' => $tanggal_lahir,
                "tipe_berkas"=>$this->upload->data('file_type')
            );

            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = 500;
            $this->load->library('upload', $config);

            if(is_uploaded_file($_FILES['foto']['tmp_name'])) {
                if ($this->upload->do_upload('foto')){
                    $image_data = $this->upload->data();
                    $imgdata = file_get_contents($image_data['full_path']);
                    $file_encode=base64_encode($imgdata);
                    $data_guru['foto'] = $file_encode;
                    $data_guru['tipe_berkas'] = $this->upload->data('file_type');
                }
            }
            
            if ($this->Guru_model->updateGuru($id, $data_guru)) {
                $this->session->set_flashdata('message','Guru Berhasil diubah.');
            } else {
                $this->session->set_flashdata('message','Guru Gagal diubah.');
            }

            redirect(base_url('admin/guru'));
        }
    }

    public function destroy($id) {
        
        if ($this->Guru_model->hapusGuru($id)) {
            $this->db->where("user_related",$id);
            $this->db->delete("users");
            $this->session->set_flashdata('message','Guru Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','Guru Gagal dihapus.');
        }
       
        redirect(base_url('admin/guru'));
    }
}
