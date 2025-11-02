<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Materi_model extends CI_Model
{
    private $table = 'materi';

    public function get($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function all()
    {
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    // Ambil semua materi berdasarkan kelas
    public function get_by_kelas($kelas_id)
    {
        return $this->db->order_by('tanggal', 'DESC')
            ->get_where($this->table, ['kelas_id' => $kelas_id])
            ->result();
    }

    // Ambil 1 materi by ID
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // Tambah materi baru
    public function add_materi($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Edit materi
    public function update_materi($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Hapus materi
    public function delete_materi($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
