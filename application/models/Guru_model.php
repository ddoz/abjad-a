<?php
class Guru_model extends CI_Model {
    
    public function getGuru() {
        $this->db->from('guru');
        return $this->db->get()->result();
    }

    public function simpanGuru($data) {
        return $this->db->insert('guru', $data);
    }

    public function getGuruByNip($nip) {
        $this->db->where('nip', $nip);
        $query = $this->db->get('guru');
        return $query->row();
    }

    public function updateGuru($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('guru', $data);
    }

    public function hapusGuru($id) {
        $this->db->where('id', $id);
        $this->db->delete('guru');
        return $this->db->affected_rows() > 0;
    }
}