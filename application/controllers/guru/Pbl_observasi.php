<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_observasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // Pastikan helper login aktif
        $this->load->model('Pbl_observasi_model');
    }

    // Halaman Detail (Menampilkan List Upload Siswa)
    public function detail($slot_id = null)
    {
        if (!$slot_id) redirect('guru/pbl');

        $slot = $this->Pbl_observasi_model->get_slot_by_id($slot_id);
        if (!$slot) show_404();

        $data['title'] = 'Detail Observasi: ' . $slot->title;
        $data['slot'] = $slot;
        $data['class_id'] = $slot->class_id; // Untuk tombol kembali
        
        // Data user & role untuk view
        $data['user'] = $this->session->userdata();
        $data['url_name'] = 'guru'; // atau dinamis sesuai role
        $role_id = $this->session->userdata('role_id');
        // $data['is_admin_or_guru'] = ... (logika cek role Anda)
        $data['is_admin_or_guru'] = true; // Hardcode true karena ini controller Guru

        $this->load->view('templates/header', $data);
        $this->load->view('guru/pbl_observasi_detail', $data);
        $this->load->view('templates/footer');
    }

    // --- AJAX METHODS ---

    // Get Data untuk Tabel
    public function get_uploads($slot_id)
    {
        $data = $this->Pbl_observasi_model->get_uploads_by_slot($slot_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // Delete Upload
    public function delete_upload($id = null)
    {
        if ($id) {
            $this->Pbl_observasi_model->delete_upload($id);
            $response = ['status' => 'success', 'message' => 'File observasi berhasil dihapus.'];
        } else {
            $response = ['status' => 'error', 'message' => 'ID tidak valid.'];
        }
        
        // CSRF Hash refresh
        $response['csrf_hash'] = $this->security->get_csrf_hash();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}

/* End of file Pbl_observasi.php */
/* Location: ./application/controllers/Guru/Pbl_observasi.php */