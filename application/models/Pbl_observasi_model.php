<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_observasi_model extends CI_Model
{
	private $table_slots = 'pbl_observation_slots';
	private $table_uploads = 'pbl_observation_uploads';
  private $table_users = 'users'; // Sesuaikan dengan nama tabel user Anda

  // Ambil detail slot (judul & deskripsi tugas)
  public function get_slot_by_id($id)
  {
  	return $this->db->where('id', $id)->get($this->table_slots)->row();
  }

  // Ambil daftar upload siswa untuk slot tertentu
  public function get_uploads_by_slot($slot_id)
  {
    $this->db->select('u.*, users.name as student_name'); // Asumsi kolom nama di tabel users adalah 'name'
    $this->db->from($this->table_uploads . ' as u');
    $this->db->join($this->table_users . ' as users', 'u.user_id = users.id');
    $this->db->where('u.observation_slot_id', $slot_id);
    $this->db->order_by('u.created_at', 'DESC');
    return $this->db->get()->result();
  }

	// Ambil upload HANYA milik siswa yang login di slot tertentu
  public function get_uploads_by_slot_and_user($slot_id, $user_id)
  {
  	$this->db->select('*');
  	$this->db->from($this->table_uploads);
  	$this->db->where('observation_slot_id', $slot_id);
  	$this->db->where('user_id', $user_id);
  	$this->db->order_by('created_at', 'DESC');
  	return $this->db->get()->result();
  }

	// Simpan data file ke database
  public function insert_upload($data)
  {
  	return $this->db->insert($this->table_uploads, $data);
  }

	// Ambil satu file (untuk cek kepemilikan sebelum hapus)
  public function get_upload_by_id($id)
  {
  	return $this->db->where('id', $id)->get($this->table_uploads)->row();
  }

	// Hapus upload
  public function delete_upload($id)
  {
    // Ambil data file dulu untuk unlink
  	$file = $this->db->where('id', $id)->get($this->table_uploads)->row();

  	if ($file) {
        // Hapus file fisik jika ada
  		$file_path = FCPATH . 'uploads/observasi/' . $file->file_name;
  		if (file_exists($file_path)) {
  			unlink($file_path);
  		}

      // Hapus data di DB
  		return $this->db->where('id', $id)->delete($this->table_uploads);
  	}
  	return false;
  }
}

    /* End of file Pbl_observasi_model.php */
/* Location: ./application/models/Pbl_observasi_model.php */