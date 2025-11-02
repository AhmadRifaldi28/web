<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('KelasModel');
        $this->load->library('upload');
    }

    /* ==================== CRUD KELAS ==================== */
    public function index()
    {
        $data['title'] = 'Manajemen Kelas';
        $data['kelas'] = $this->KelasModel->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/kelas/index', $data);
        $this->load->view('templates/footer');
    }

    public function add_kelas()
    {
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas'),
            'kode_kelas' => $this->input->post('kode_kelas'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'guru_id'    => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->KelasModel->insert_kelas($data);
        echo json_encode(['status' => 'success']);
    }

    public function update_kelas()
    {
        $id = $this->input->post('id');
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas'),
            'kode_kelas' => $this->input->post('kode_kelas'),
            'deskripsi'  => $this->input->post('deskripsi')
        ];
        $this->KelasModel->update_kelas($id, $data);
        echo json_encode(['status' => 'updated']);
    }

    public function delete_kelas($id)
    {
        $this->KelasModel->delete_kelas($id);
        echo json_encode(['status' => 'deleted']);
    }

    /* ==================== DETAIL KELAS ==================== */
    public function detail($id)
    {
        $data['kelas'] = $this->KelasModel->get_by_id($id);
        $data['siswa'] = $this->KelasModel->get_siswa_by_kelas($id);
        $data['materi'] = $this->KelasModel->get_materi_by_kelas($id);
        $data['siswa_list'] = $this->db->get_where('user', ['role_id' => 2])->result();
        $data['title'] = 'Detail Kelas - ' . $data['kelas']->nama_kelas;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/kelas/detail', $data);
        $this->load->view('templates/footer');
    }

    /* ==================== AJAX SISWA ==================== */
    public function add_siswa()
    {
        $status = $this->KelasModel->add_siswa(
            $this->input->post('kelas_id'),
            $this->input->post('siswa_id')
        );
        echo json_encode(['status' => $status]);
    }

    public function remove_siswa($id)
    {
        $this->KelasModel->remove_siswa($id);
        echo json_encode(['status' => 'deleted']);
    }

    /* ==================== AJAX MATERI ==================== */
    public function add_materi()
    {
        $file_path = null;
        if (!empty($_FILES['file']['name'])) {
            $config['upload_path']   = './uploads/materi/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png|mp4|doc|docx|zip';
            $config['max_size']      = 20000;
            $config['encrypt_name']  = TRUE;

            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $file_path = 'uploads/materi/' . $uploadData['file_name'];
            }
        }

        $data = [
            'kelas_id'   => $this->input->post('kelas_id'),
            'judul'      => $this->input->post('judul'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'file_path'  => $file_path,
            'created_by' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->KelasModel->insert_materi($data);
        echo json_encode(['status' => 'success']);
    }

    public function delete_materi($id)
    {
        $this->KelasModel->delete_materi($id);
        echo json_encode(['status' => 'deleted']);
    }
}
