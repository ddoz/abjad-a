<?php
class Wali_model extends CI_Model {
    
    public function getWali() {
        $this->db->from('wali_murid');
        return $this->db->get()->result();
    }

    public function simpanWali($data) {
        return $this->db->insert('wali_murid', $data);
    }

    public function getWaliByNik($nik) {
        $this->db->where('nik', $nik);
        $query = $this->db->get('wali_murid');
        return $query->row();
    }

    public function updateWali($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('wali_murid', $data);
    }

    public function hapusWali($id) {

        $this->db->where('id_wali',$id);
        $this->db->delete('wali_murid_detail');

        $this->db->where('id', $id);
        $this->db->delete('wali_murid');
        return $this->db->affected_rows() > 0;
    }
}