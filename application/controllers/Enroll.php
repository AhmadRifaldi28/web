<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enroll extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Pastikan user login (opsional)
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('auth/login');
        // }

        $this->load->view('layouts/header');
        $this->load->view('enroll/index'); // View utama untuk halaman Enroll
        $this->load->view('layouts/footer');
    }
}
