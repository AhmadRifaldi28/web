<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SiswaModel');
    }

    public function index()
    {
        // $data['kelas'] = $this->KelasModel->get_by_id($kelas_id);
        $data['siswa'] = $this->SiswaModel->get_all();
        $data['title'] = 'Daftar Siswa ';

        $this->load->view('layouts/header', $data);
        $this->load->view('guru/siswa/index', $data);
        $this->load->view('layouts/footer');
    }

    public function get($id) {
        echo json_encode($this->SiswaModel->get_by_id($id));
    }

    public function save() {
        $id = $this->input->post('id');
        $username = trim($this->input->post('username'));
        $email = trim($this->input->post('email'));

        // Cek duplikat username/email
        if (!$this->SiswaModel->is_unique('username', $username, $id)) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan!']);
            return;
        }
        if (!$this->SiswaModel->is_unique('email', $email, $id)) {
            echo json_encode(['status' => 'error', 'message' => 'Email sudah digunakan!']);
            return;
        }

        $data = [
            'username' => $username,
            'email'    => $email,
            'name'     => trim($this->input->post('name')),
            'role'     => 'siswa',
        ];

        if (!$id) { // CREATE
            $data['password'] = password_hash('password', PASSWORD_DEFAULT);
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->SiswaModel->insert($data);
            $message = 'Siswa berhasil ditambahkan!';
        } else { // UPDATE
            $this->SiswaModel->update($id, $data);
            $message = 'Data siswa berhasil diperbarui!';
        }

        echo json_encode(['status' => 'success', 'message' => $message]);
    }

    public function delete($id) {
        $this->SiswaModel->delete($id);
        echo json_encode(['status' => 'success', 'message' => 'Siswa berhasil dihapus.']);
    }
}
