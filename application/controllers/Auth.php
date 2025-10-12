<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }

    // ==========================
    // 🔹 TAMPILAN HALAMAN LOGIN
    // ==========================
    public function login()
    {
        // Jika sudah login, arahkan sesuai role
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            if ($role == 'guru') {
                redirect('dashboard/guru');
            } else {
                redirect('dashboard/siswa');
            }
        }
        $this->load->view('auth/login');
    }

    // ==========================
    // 🔹 PROSES LOGIN
    // ==========================
    public function login_action()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            // Set session data
            $userdata = [
                'id'        => $user->id,
                'username'  => $user->username,
                'name'      => $user->name,
                'role'      => $user->role,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($userdata);

            // Redirect sesuai role
            if ($user->role == 'guru') {
                redirect('dashboard/guru');
            } else {
                redirect('dashboard/siswa');
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('auth/login');
        }
    }

    // ==========================
    // 🔹 TAMPILAN REGISTER
    // ==========================
    public function register()
    {
        $this->load->view('auth/register');
    }

    // ==========================
    // 🔹 PROSES REGISTER
    // ==========================
    public function register_action()
    {
        $data = [
            'name'     => $this->input->post('name', TRUE),
            'email'    => $this->input->post('email', TRUE),
            'username' => $this->input->post('username', TRUE),
            'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
            'role'     => $this->input->post('role', TRUE)
        ];

        // Cek username sudah digunakan
        $check = $this->User_model->get_by_username($data['username']);
        if ($check) {
            $this->session->set_flashdata('error', 'Username sudah digunakan!');
            redirect('auth/register');
        }

        $this->User_model->insert($data);
        $this->session->set_flashdata('success', 'Pendaftaran berhasil, silakan login.');
        redirect('auth/login');
    }

    // ==========================
    // 🔹 LOGOUT
    // ==========================
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    // ==========================
    // 🔹 MIDDLEWARE ROLE
    // ==========================
    public function cek_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function cek_role($role)
    {
        if ($this->session->userdata('role') != $role) {
            show_error('Akses ditolak: Anda tidak memiliki izin untuk halaman ini.', 403);
        }
    }
}
