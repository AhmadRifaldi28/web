<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_refleksi_akhir_model extends CI_Model
{
	private $table_reflections = 'pbl_final_reflections';
	private $table_prompts = 'pbl_reflection_prompts';

	/**
	 * Mengambil detail aktivitas refleksi utama
	 */
	public function get_reflection_details($reflection_id)
	{
		return $this->db->where('id', $reflection_id)
			->get($this->table_reflections)
			->row();
	}

	/**
	 * Mengambil semua prompt/pertanyaan untuk satu refleksi
	 */
	public function get_prompts($reflection_id)
	{
		return $this->db->where('reflection_id', $reflection_id)
			->order_by('created_at', 'ASC')
			->get($this->table_prompts)
			->result();
	}

	/**
	 * Menyimpan prompt baru
	 */
	public function insert_prompt($data)
	{
		return $this->db->insert($this->table_prompts, $data);
	}

	/**
	 * Memperbarui prompt
	 */
	public function update_prompt($id, $data)
	{
		return $this->db->where('id', $id)->update($this->table_prompts, $data);
	}

	/**
	 * Menghapus prompt
	 */
	public function delete_prompt($id)
	{
		return $this->db->where('id', $id)->delete($this->table_prompts);
	}
}

/* End of file Pbl_refleksi_akhir_model.php */
/* Location: ./application/models/Pbl_refleksi_akhir_model.php */