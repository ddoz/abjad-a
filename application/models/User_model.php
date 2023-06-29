<?php
class User_model extends CI_Model {
    
    public function getUser() {
        return $this->db->get('users')->result();
    }

    public function hapusUser($id) {
        $user = $this->db->get('users')->row();

        if($$user->level == "siswa") {
            $this->db->where('id',$user->user_related);
            $this->db->delete('siswa');

            $this->db->where('id_siswa',$user->user_related);
            $this->db->delete('konsultasi');

            $this->db->where('id_siswa',$user->user_related);
            $this->db->delete('monitoring');

            $this->db->where('id_siswa',$user->user_related);
            $this->db->delete('wali_murid_detail');
        }
        if($user->level == 'guru') {
            $this->db->where('id',$user->user_related);
            $this->db->delete('guru');
        }
        if($user->level == 'wali') {
            $this->db->where('id',$user->user_related);
            $this->db->delete('wali_murid');
        }
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->num_rows() > 0;
    }

    public function resetPassword($id) {
        $this->db->where("id", $id);
        return $this->db->update("users", array(
            "password" => password_hash("SMPALHUDA", PASSWORD_BCRYPT)
        ));
    }

}