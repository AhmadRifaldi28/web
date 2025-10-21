<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forum_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Forum_model');
        $this->load->model('Komentar_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    // Menampilkan daftar forum dari guru
    public function index()
    {
        $data['forum'] = $this->Forum_model->get_all_forum();
        $this->load->view('layouts/header', $data);
        $this->load->view('siswa/forum_siswa/index', $data);
    }

    // Menampilkan detail forum dan komentar
    public function detail($id)
    {
        $data['forum'] = $this->Forum_model->get_by_id($id);
        $data['komentar'] = $this->Komentar_model->get_by_forum($id);
        $this->load->view('siswa/forum_siswa/detail', $data);
    }

    // Tambah komentar siswa
    public function tambah_komentar()
    {
        // var_dump($this->session->userdata('user_id'));
        // die();

        $data = [
            'forum_id' => $this->input->post('forum_id'),
            'user_id' => $this->session->userdata('user_id'),
            'isi_komentar' => $this->input->post('isi_komentar'),
            'tanggal' => date('Y-m-d H:i:s')
        ];

        $this->Komentar_model->insert($data);
        redirect('siswa/forum_siswa/detail/' . $this->input->post('forum_id'));
    }

    // Hapus komentar (hanya jika milik sendiri)
    public function hapus_komentar($id)
    {
        $komentar = $this->Komentar_model->get_by_id($id);
        $user_id = $this->session->userdata('user_id');

        if ($komentar && $komentar->user_id == $user_id) {
            $this->Komentar_model->delete($id);
            $this->session->set_flashdata('success', 'Komentar berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus komentar ini.');
        }

        redirect('siswa/forum_siswa/detail/' . $komentar->forum_id);
    }
}
