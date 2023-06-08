<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct(); 	
		$this->load->library('form_validation');
		if(!isLogin()) {
			redirect(base_url()."dashboard");
		}
	}

	public function index()
	{
		$content = array(
			"body" => "admin/dashboard",
            "script" => 'script/admin_dashboard'
		);
		$this->load->view('template/theme', $content);
	}
}
