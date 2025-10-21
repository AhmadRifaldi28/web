<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tugas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tugas_model');
        $this->load->helper(['url', 'form']);
    }

    // Menampilkan daftar tugas
    public function index()
    {
        $data['tugas'] = $this->Tugas_model->get_all_tugas();
        $this->load->view('layouts/header', $data);
        $this->load->view('siswa/tugas/index', $data);
    }

    // Form upload tugas siswa
    public function upload($tugas_id)
    {
        $siswa_id = 1; // ⚠️ Ubah dengan session siswa aktif
        $data['tugas'] = $this->Tugas_model->get_tugas($tugas_id);
        $data['pengumpulan'] = $this->Tugas_model->cek_pengumpulan($tugas_id, $siswa_id);

        if ($this->input->post()) {
            $config['upload_path'] = './uploads/tugas/';
            $config['allowed_types'] = 'pdf|doc|docx|jpg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $file_data = $this->upload->data();
                $insert = [
                    'tugas_id' => $tugas_id,
                    'siswa_id' => $siswa_id,
                    'file' => $file_data['file_name']
                ];
                $this->Tugas_model->insert_pengumpulan($insert);
                $data['success'] = "Tugas berhasil dikumpulkan!";
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('siswa/tugas/upload', $data);
    }
}
