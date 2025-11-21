<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_esai_model extends CI_Model
{
	private $table_essays = 'pbl_solution_essays';
	private $table_submissions = 'pbl_essay_submissions';
	private $table_users = 'users'; // Asumsi tabel users

	/**
	 * Mengambil detail Esai utama
	 */
	public function get_essay_details($essay_id)
	{
		return $this->db->where('id', $essay_id)
			->get($this->table_essays)
			->row();
	}

	/**
	 * Mengambil semua jawaban siswa, di-join dengan nama
	 */
	public function get_submissions($essay_id)
	{
		$this->db->select('s.*, u.name as student_name'); // Asumsi 'name' di tabel users
		$this->db->from($this->table_submissions . ' as s');
		$this->db->join($this->table_users . ' as u', 's.user_id = u.id', 'left');
		$this->db->where('s.essay_id', $essay_id);
		$this->db->order_by('s.created_at', 'ASC');
		return $this->db->get()->result();
	}

	/**
	 * Menyimpan (Update) nilai dan feedback dari guru
	 */
	public function save_feedback($submission_id, $data)
	{
		$this->db->where('id', $submission_id);
		return $this->db->update($this->table_submissions, $data);
	}
}