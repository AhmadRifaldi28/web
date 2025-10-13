<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('user_id')) {
            $this->load->model('User_model');
            $this->user = $this->User_model->get_by_id($this->session->userdata('user_id'));
        } else {
            $this->user = null;
        }
    }

    protected function auth_required() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    protected function require_role($role) {
        $this->auth_required();
        if (!$this->user || $this->user->role !== $role) {
            show_error('Akses ditolak', 403);
        }
    }
}