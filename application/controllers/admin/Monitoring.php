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
        $this->load->model('Monitoring_model');
        $this->load->model('Kelas_model');
	}

	public function index()
	{
        $kelas = $this->input->get('kelas');
        $this->db->select("monitoring.*,siswa.nama_siswa,kelas.nama_kelas");
        $this->db->from('monitoring');
        $this->db->join('siswa','siswa.id=monitoring.id_siswa');
        $this->db->join('kelas','kelas.id=siswa.kelas_id');
        if($kelas != "") {
            $this->db->where("siswa.kelas_id",$kelas);
        }
        $data = $this->db->get()->result();
		$content = array(
			"body" => "admin/monitoring",
            "script" => 'script/admin_siswa',
            'monitoring' => $data,
            'siswa' => $this->Siswa_model->getSiswa(),
            'daftarKelas' => $this->Kelas_model->getKelas()
		);
		$this->load->view('template/theme', $content);
	}

    public function store() {

        // Menetapkan aturan validasi
        $this->form_validation->set_rules('status', 'Pilih Jenis Monitoring', 'required');
        $this->form_validation->set_rules('point', 'Point', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required');

        if ($this->form_validation->run() == FALSE) {
            $content = array(
				"body" => "admin/monitoring",
                "script" => 'script/admin_siswa',
                'siswa' => $this->Siswa_model->getSiswa()
			);
			$this->load->view('template/theme', $content);
        } else {
          
            // Jika validasi berhasil, simpan data ke database
            $status = $this->input->post('status');
            $point = $this->input->post('point');
            $keterangan = $this->input->post('keterangan');
            $id_siswa = $this->input->post('id_siswa');
            $tanggal = $this->input->post('tanggal_pelanggaran');

            $insert = array(
                "point" => $point,
                "keterangan" => $keterangan,
                "id_siswa" => $id_siswa,
                "tanggal_pelanggaran" => $tanggal,
            );

            if($status == "Pelanggaran") {
                $insert['pelanggaran'] = "1";
            }else {
                $insert['pelanggaran'] = "0";
                $insert['prestasi'] = $status;
            }
          
            $this->Monitoring_model->saveData($insert);
            $this->session->set_flashdata('message','Monitoring Berhasil disimpan.');
           
          redirect(base_url('admin/monitoring'));
        }
    }

    public function destroy($id) {
        $this->db->where('id',$id);
        if ($this->db->delete('monitoring')) {
            $this->session->set_flashdata('message','Monitoring Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('message','Monitoring Gagal dihapus.');
        }

        redirect(base_url('admin/monitoring'));
    }
}
