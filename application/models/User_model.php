<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    // ==============================
    // 🔹 Ambil semua data user
    // ==============================
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    // ==============================
    // 🔹 Ambil user berdasarkan ID
    // ==============================
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // ==============================
    // 🔹 Ambil user berdasarkan username
    // ==============================
    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }

    // ==============================
    // 🔹 Tambah user baru (REGISTER)
    // ==============================
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // ==============================
    // 🔹 Update data user
    // ==============================
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // ==============================
    // 🔹 Hapus user
    // ==============================
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // ==============================
    // 🔹 Cek login (opsional)
    // ==============================
    public function check_login($username, $password)
    {
        $user = $this->get_by_username($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
