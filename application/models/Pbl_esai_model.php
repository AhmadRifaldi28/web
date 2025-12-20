<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_esai_model extends CI_Model
{
	private $table_essays = 'pbl_solution_essays';
	private $table_submissions = 'pbl_essay_submissions';
	private $table_questions = 'pbl_essay_questions';
	private $table_students = 'students';
	private $table_users = 'users';

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
   * Mengambil daftar seluruh siswa dalam kelas beserta status pengumpulannya
   * Logic: Ambil data Student -> Join User (untuk nama) -> Left Join Submission
   */
  public function get_class_students_with_submission($class_id, $essay_id)
  {
	  // Select kolom yang dibutuhkan
	  $this->db->select('
      std.user_id as student_user_id,
      u.name as student_name,
      u.image as student_image,
      sub.id as submission_id,
      sub.submission_content,
      sub.grade,
      sub.feedback,
      sub.created_at as submitted_at
	  ');

	  // Dari tabel students (filter by class)
	  $this->db->from($this->table_students . ' as std');
	  
	  // Join ke Users untuk dapat Nama
	  $this->db->join($this->table_users . ' as u', 'std.user_id = u.id');

	  // LEFT Join ke Submissions untuk cek apakah sudah mengumpulkan
	  // Kondisi join ganda: user_id sama DAN essay_id sesuai
	  $this->db->join($this->table_submissions . ' as sub', 'sub.user_id = std.user_id AND sub.essay_id = "' . $essay_id . '"', 'left');

	  $this->db->where('std.class_id', $class_id);
	  $this->db->where('u.role_id !=', '1'); // Pastikan bukan admin/guru (opsional, tergantung role id siswa)
	  
	  return $this->db->get()->result();
  }

	/**
	 * Mengambil semua jawaban siswa, di-join dengan nama
	 */
	public function get_submissions($essay_id)
	{
		$this->db->select('s.*, u.name as student_name');
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

	/* FUNGSI UNTUK PERTANYAAN ESAI */

	/**
	 * Mengambil semua pertanyaan esai untuk suatu esai
	 */
	public function get_questions($essay_id)
	{
		return $this->db->where('essay_id', $essay_id)
			->order_by('question_number', 'ASC')
			->get($this->table_questions)
			->result();
	}

	/**
	 * Menyimpan (Create/Update) pertanyaan esai
	 */
	public function save_question($data, $id = null)
	{
		// Cek apakah ada ID (untuk Update)
		if ($id) {
			$this->db->where('id', $id);
			return $this->db->update($this->table_questions, $data);
		} else {
			// Jika tidak ada ID (untuk Create), buat ID baru
			$data['id'] = generate_ulid();
			return $this->db->insert($this->table_questions, $data);
		}
	}

	/**
	 * Menghapus pertanyaan esai
	 */
	public function delete_question($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table_questions);
	}

		/* FUNGSI BARU UNTUK SISWA (SUBMISSION) */

	/**
	 * Mengambil jawaban siswa untuk esai tertentu
	 */
	public function get_student_submission($essay_id, $user_id)
	{
		return $this->db->where('essay_id', $essay_id)
			->where('user_id', $user_id)
			->get($this->table_submissions)
			->row();
	}

	/**
	 * Menyimpan atau memperbarui jawaban siswa
	 */
	public function save_student_submission($essay_id, $user_id, $content, $submission_id = null)
	{
		$data = [
			'essay_id' => $essay_id,
			'user_id' => $user_id,
			'submission_content' => $content,
		];

		if ($submission_id) {
			// Update
			$this->db->where('id', $submission_id);
			return $this->db->update($this->table_submissions, $data);
		} else {
			// Insert baru
			$data['id'] = generate_ulid();
			return $this->db->insert($this->table_submissions, $data);
		}
	}

}