<?php
class Kelas_model extends CI_Model {
    public function getKelas() {
        return $this->db->get('kelas')->result();
    }
    public function cekKelasTersedia($nama_kelas) {
        $this->db->where('nama_kelas', $nama_kelas);
        $query = $this->db->get('kelas');
        return $query->num_rows() > 0;
    }

    public function simpanKelas($data) {
        $this->db->insert('kelas', $data);
        return $this->db->affected_rows() > 0;
    }

    public function getKelasById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('kelas');
        return $query->row();
    }

    public function updateKelas($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('kelas', $data);
        return $this->db->affected_rows() > 0;
    }

    public function cekKelasTerkait($id) {
        $this->db->where('kelas_id', $id);
        $query = $this->db->get('siswa');
        return $query->num_rows() > 0;
    }

    public function hapusKelas($id) {
        $this->db->where('id', $id);
        $this->db->delete('kelas');
        return $this->db->affected_rows() > 0;
    }
}