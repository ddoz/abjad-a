<?php

function isLogin() {
    $CI =& get_instance();
    return ($CI->session->userdata('username')==null)?false:true;
}