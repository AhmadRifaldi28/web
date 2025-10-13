<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Materi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Materi_model');
        $this->load->library(['form_validation', 'upload']);
    }

    // =======================
    // HALAMAN DAFTAR MATERI
    // =======================
    public function index()
    {
        $q = $this->input->get('q'); // kata kunci pencarian

        if (!empty($q)) {
            $this->db->like('judul', $q);
            $this->db->or_like('deskripsi', $q);
        }

        $data['materi'] = $this->db->get('materi')->result();

        $role = $this->session->userdata('role');
        // Jika siswa
        $this->load->view('layouts/header', $data);
        $this->load->view('siswa/materi/index', $data);
    }

    // =======================
    // DETAIL MATERI
    // =======================
    public function view($id)
    {
        $data['materi'] = $this->Materi_model->get($id);
        if (!$data['materi']) show_404();

        $role = $this->session->userdata('role');
        // siswa hanya lihat & download
        $this->load->view('layouts/header', $data);
        $this->load->view('siswa/materi/view', $data);
    }
}
