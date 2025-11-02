<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends CI_Model
{
    private $table = 'kelas';
    private $siswa_table = 'siswa_kelas';
    private $materi_table = 'materi_kelas';

    /* ==================== KELAS ==================== */
    public function get_all()
    {
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_kelas($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_kelas($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete_kelas($id)
    {
        // Hapus juga relasi siswa dan materi
        $this->db->delete($this->siswa_table, ['kelas_id' => $id]);
        $this->db->delete($this->materi_table, ['kelas_id' => $id]);
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /* ==================== SISWA ==================== */
    public function get_siswa_by_kelas($kelas_id)
    {
        $this->db->select('siswa_kelas.id, user.id AS siswa_id, user.name, user.username, user.email');
        $this->db->from($this->siswa_table);
        $this->db->join('user', 'user.id = siswa_kelas.siswa_id');
        $this->db->where('siswa_kelas.kelas_id', $kelas_id);
        return $this->db->get()->result();
    }

    public function add_siswa($kelas_id, $siswa_id)
    {
        $exists = $this->db->get_where($this->siswa_table, [
            'kelas_id' => $kelas_id,
            'siswa_id' => $siswa_id
        ])->num_rows();
        if ($exists > 0) return 'exists';

        $this->db->insert($this->siswa_table, [
            'kelas_id' => $kelas_id,
            'siswa_id' => $siswa_id,
            'joined_at' => date('Y-m-d H:i:s')
        ]);
        return 'success';
    }

    public function remove_siswa($id)
    {
        return $this->db->delete($this->siswa_table, ['id' => $id]);
    }

    /* ==================== MATERI ==================== */
    public function get_materi_by_kelas($kelas_id)
    {
        return $this->db->order_by('created_at', 'DESC')
            ->get_where($this->materi_table, ['kelas_id' => $kelas_id])
            ->result();
    }

    public function insert_materi($data)
    {
        $this->db->insert($this->materi_table, $data);
        return $this->db->insert_id();
    }

    public function update_materi($id, $data)
    {
        return $this->db->where('id', $id)->update($this->materi_table, $data);
    }

    public function delete_materi($id)
    {
        $materi = $this->db->get_where($this->materi_table, ['id' => $id])->row();
        if ($materi && !empty($materi->file_path) && file_exists(FCPATH . $materi->file_path)) {
            unlink(FCPATH . $materi->file_path);
        }
        return $this->db->delete($this->materi_table, ['id' => $id]);
    }
}
