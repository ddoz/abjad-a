<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wali extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
        $this->load->model('Wali_model');
	}

	public function index()
	{
        
		$content = array(
			"body" => "admin/wali",
            "script" => 'script/admin_wali',
            'wali' => $this->Wali_model->getWali(),
            'siswa' => $this->db->get("siswa")->result(),
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {

        // Ambil data dari form
        $nik = $this->input->post('nik');
        $nama_wali = $this->input->post('nama_wali');
        $no_hp = $this->input->post('no_hp');
        $tanggal_lahir = $this->input->post('tanggal_lahir');

        // Validasi form
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('nama_wali', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('no_hp', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/wali",
                "script" => 'script/admin_wali',
                'wali' => $this->Wali_model->getWali()
			);
			$this->load->view('template/theme', $content);
        } else {
          
    
          // Cek kelas tersedia
          $wali = $this->Wali_model->getWaliByNik($nik);
          if ($wali) {
            $this->session->set_flashdata('message','NIK Sudah Ada.');
          } else {
           
            $data_wali = array(
                'nik' => $nik,
                'nama_wali' => $nama_wali,
                'no_hp' => $no_hp,
                'tanggal_lahir' => $tanggal_lahir
            );
            
            if ($this->Wali_model->simpanWali($data_wali)) {
                $this->db->insert("users", array(
                    "username" => $nik,
                    "nama" => $nama_wali,
                    "level" => "wali",
                    "user_related" => $this->db->insert_id(),
                    "password" => password_hash($tanggal_lahir, PASSWORD_BCRYPT)
                ));
                $this->session->set_flashdata('message','Wali Murid Berhasil disimpan.');
            } else {
                $this->session->set_flashdata('message','Wali Murid Gagal disimpan.');
            }

            
          }
          redirect(base_url('admin/wali'));
        }
    }

    public function update() {
        // Ambil data dari form
        $id = $this->input->post('id');
        $nik = $this->input->post('nik');
        $nama_wali = $this->input->post('nama_wali');
        $no_hp = $this->input->post('no_hp');
        $tanggal_lahir = $this->input->post('tanggal_lahir');

        // Validasi form
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('nama_wali', 'Nama Wali', 'required');
        $this->form_validation->set_rules('no_hp', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/wali",
                "script" => 'script/admin_wali',
                'wali' => $this->Wali_model->getWali()
			);
			$this->load->view('template/theme', $content);
        } else {
            $this->load->library('upload');
            // Data
            $data_wali = array(
                'nama_wali' => $nama_wali,
                'no_hp' => $no_hp,
                'tanggal_lahir' => $tanggal_lahir
            );

            if ($this->Wali_model->updateWali($id, $data_wali)) {
                $this->session->set_flashdata('message','Wali Murid Berhasil diubah.');
            } else {
                $this->session->set_flashdata('message','Wali Murid Gagal diubah.');
            }

            redirect(base_url('admin/wali'));
        }
    }

    public function destroy($id) {
        
        if ($this->Wali_model->hapusWali($id)) {
            $this->db->where("user_related",$id);
            $this->db->delete("users");
            $this->session->set_flashdata('message','Wali Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','Wali Gagal dihapus.');
        }
       
        redirect(base_url('admin/wali'));
    }

    public function siswa() {
        $id = $this->input->post('id_wali');
        $id_siswa = $this->input->post('id_siswa');
        if($this->db->get_where("wali_murid_detail",array('id_siswa'=>$id_siswa))->num_rows()>0) {
            $this->session->set_flashdata('message','Siswa Gagal ditambahkan, Sudah menjadi murid wali lainnya.');
        }else {
            $this->db->insert('wali_murid_detail', array("id_wali"=>$id,"id_siswa"=>$id_siswa));
            $this->session->set_flashdata('message','Siswa Berhasil ditambahkan.');
        }
        redirect(base_url('admin/wali'));
    }

    public function hapussiswa($id) {
        
        $this->db->where("id",$id);
        if ($this->db->delete('wali_murid_detail')) {
            $this->session->set_flashdata('message','Siswa Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','Siswa Gagal dihapus.');
        }
       
        redirect(base_url('admin/wali'));
    }
}
