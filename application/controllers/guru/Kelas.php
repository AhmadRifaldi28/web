<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KelasModel');
        $this->load->model('SiswaModel');
    }

    public function index()
    {
        // Ambil id guru dari session
        $guru_id = $this->session->userdata('user_id');

        $data['kelas'] = $this->KelasModel->get_all_by_guru($guru_id);
        $data['title'] = 'Manajemen Kelas';

        $this->load->view('layouts/header', $data);
        $this->load->view('guru/kelas/index', $data);
        $this->load->view('layouts/footer');
    }

    public function store()
    {
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas', true),
            'kode_kelas' => strtoupper(substr(md5(time()), 0, 6)),
            'deskripsi'  => $this->input->post('deskripsi', true),
            'guru_id'    => $this->session->userdata('user_id'),
        ];
        $this->KelasModel->insert($data);
        echo json_encode(['status' => 'success']);
    }

    public function update($id)
    {
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas', true),
            'deskripsi'  => $this->input->post('deskripsi', true),
        ];
        $this->KelasModel->update($id, $data);
        echo json_encode(['status' => 'updated']);
    }

    public function destroy($id)
    {
        $this->KelasModel->delete($id);
        echo json_encode(['status' => 'deleted']);
    }

    public function detail($id)
    {
        $data['kelas'] = $this->KelasModel->get_by_id($id);
        $data['anggota'] = $this->KelasModel->get_siswa_by_kelas($id);
        $data['title'] = 'Detail Kelas - ' . $data['kelas']->nama_kelas;

        // Ambil daftar siswa (role = 'siswa') untuk dropdown
        $data['siswa_list'] = $this->db->get_where('users', ['role' => 'siswa'])->result();
        $data['jumlah'] = count($data['anggota']);

        $this->load->view('layouts/header', $data);
        $this->load->view('guru/kelas/detail', $data);
        $this->load->view('layouts/footer');
    }

    // AJAX: ambil jumlah siswa dalam kelas
    public function count_siswa($kelas_id)
    {
        $this->db->where('kelas_id', $kelas_id);
        $count = $this->db->count_all_results('siswa_kelas');
        echo json_encode(['jumlah' => $count]);
    }


    // AJAX: tambah siswa
    public function add_siswa()
    {
        $kelas_id = $this->input->post('kelas_id');
        $siswa_id = $this->input->post('siswa_id');

        if ($this->KelasModel->is_siswa_exists($kelas_id, $siswa_id)) {
            echo json_encode(['status' => 'exists']);
            return;
        }

        $this->KelasModel->add_siswa($kelas_id, $siswa_id);
        echo json_encode(['status' => 'success']);
    }

    // AJAX: hapus siswa
    public function remove_siswa($rel_id)
    {
        $this->KelasModel->remove_siswa($rel_id);
        echo json_encode(['status' => 'deleted']);
    }

    
}
