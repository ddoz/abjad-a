<?php
class Siswa_model extends CI_Model {
    
    public function getSiswa() {
        $this->db->select('siswa.*,kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join("kelas",'kelas.id=siswa.kelas_id');
        return $this->db->get()->result();
    }

    public function getSiswaFilter($kelas = "") {
        $this->db->select('siswa.*,kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join("kelas",'kelas.id=siswa.kelas_id');
        if($kelas != "") {
            $this->db->where('siswa.kelas_id',$kelas);
        }
        return $this->db->get()->result();
    }

    public function simpanSiswa($data) {
        return $this->db->insert('siswa', $data);
    }

    public function getSiswaByNisn($nisn) {
        $this->db->where('nisn', $nisn);
        $query = $this->db->get('siswa');
        return $query->row();
    }

    public function getSiswaByNisnExceptId($nisn, $id) {
        $this->db->where('nisn', $nisn);
        $this->db->where('id !=', $id);
        $query = $this->db->get('siswa');
        return $query->row();
    }
    
    public function updateSiswa($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('siswa', $data);
    }

    public function isIdInMonitoring($id) {
        $this->db->where('id_siswa', $id);
        $query = $this->db->get('monitoring');
        return $query->num_rows() > 0;
    }
    
    public function isIdInKonsultasi($id) {
        $this->db->where('id_siswa', $id);
        $query = $this->db->get('konsultasi');
        return $query->num_rows() > 0;
    }
    
    public function hapusSiswa($id) {
        // Cek apakah ID siswa ada di tabel monitoring
        $this->db->where('id_siswa', $id);
        $query = $this->db->get('monitoring');
        $isInMonitoring = $query->num_rows() > 0;

        // Cek apakah ID siswa ada di tabel konsultasi
        $this->db->where('id_siswa', $id);
        $query = $this->db->get('konsultasi');
        $isInKonsultasi = $query->num_rows() > 0;

        if ($isInMonitoring || $isInKonsultasi) {
            return false; // Data siswa terkait dengan monitoring atau konsultasi, tidak dapat dihapus
        } else {
            $this->db->where('id', $id);
            $this->db->delete('siswa');
            return $this->db->affected_rows() > 0;
        }
    }
}