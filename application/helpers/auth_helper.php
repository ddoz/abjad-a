<?php

function isLogin() {
    $CI =& get_instance();
    return ($CI->session->userdata('username')==null)?false:true;
}

function profilSiswa() {
    $CI =& get_instance();
    $CI->db->where("id",$CI->session->userdata('user_related'));
    return $CI->db->get("siswa")->row();
}

function profilGuru() {
    $CI =& get_instance();
    $CI->db->where("id",$CI->session->userdata('user_related'));
    return $CI->db->get("guru")->row();
}