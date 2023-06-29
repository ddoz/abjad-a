<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_model extends CI_Model {

  public function saveData($data) {
    $this->db->insert('monitoring', $data); // Menyimpan data ke tabel monitoring
  }

}
