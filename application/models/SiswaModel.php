<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiswaModel extends CI_Model {
    private $table = 'users';

    public function get_all() {
        return $this->db->where('role', 'siswa')
                        ->order_by('created_at', 'DESC')
                        ->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id, 'role' => 'siswa'])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id, 'role' => 'siswa']);
    }

    public function is_unique($field, $value, $exclude_id = null) {
        $this->db->where($field, $value)->where('role', 'siswa');
        if ($exclude_id) $this->db->where('id !=', $exclude_id);
        return $this->db->get($this->table)->num_rows() === 0;
    }
}
