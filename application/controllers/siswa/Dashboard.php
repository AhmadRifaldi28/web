<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		$data['title'] = 'Dashboard Siswa';
		$data['user'] = $this->session->userdata();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('dashboard/siswa', $data);
		$this->load->view('templates/footer');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Siswa/Dashboard.php */