<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_tts_model extends CI_Model
{
	private $table_tts = 'pbl_tts';
	private $table_questions = 'pbl_tts_questions';

	public function get_tts_by_id($id)
	{
		return $this->db->where('id', $id)->get($this->table_tts)->row();
	}

	public function get_tts_questions_by_id($id)
	{
		return $this->db->where('id', $id)->get($this->table_questions)->row();
	}

	public function get_questions($tts_id)
	{
		return $this->db->where('tts_id', $tts_id)
		->order_by('number', 'ASC')
		->get($this->table_questions)
		->result();
	}

	public function insert_question($data)
	{
		return $this->db->insert($this->table_questions, $data);
	}

	public function update_question($id, $data)
	{
		return $this->db->where('id', $id)->update($this->table_questions, $data);
	}

	public function delete_question($id)
	{
		return $this->db->where('id', $id)->delete($this->table_questions);
	}

	public function check_duplicate_number($tts_id, $number, $direction, $id = null)
	{
		$this->db->where('tts_id', $tts_id);
		$this->db->where('number', $number);
		$this->db->where('direction', $direction);

		// Jika $id disediakan (mode edit), abaikan ID ini dari pengecekan
		if ($id) {
			$this->db->where('id !=', $id);
		}

		$query = $this->db->get($this->table_questions);
		return $query->num_rows() > 0; // return true jika duplikat DITEMUKAN
	}

	// --- [FUNGSI BARU] ---
	/**
	 * Cek duplikat (koordinat + arah), abaikan ID soal saat ini
	 * @param string $tts_id
	 * @param int $start_x
	 * @param int $start_y
	 * @param string $direction
	 * @param string|null $id ID soal yang sedang diedit (untuk diabaikan)
	 * @return bool TRUE jika duplikat ditemukan
	 */
	public function check_duplicate_coordinate($tts_id, $start_x, $start_y, $direction, $id = null)
	{
		$this->db->where('tts_id', $tts_id);
		$this->db->where('start_x', $start_x);
		$this->db->where('start_y', $start_y);
		$this->db->where('direction', $direction); // Kunci validasi Anda ada di sini

		// Jika $id disediakan (mode edit), abaikan ID ini dari pengecekan
		if ($id) {
			$this->db->where('id !=', $id);
		}

		$query = $this->db->get($this->table_questions);
		return $query->num_rows() > 0; // return true jika duplikat DITEMUKAN
	}

	/**
	 * Membangun grid virtual dan memeriksa tabrakan huruf.
	 * @param string $tts_id ID TTS
	 * @param string|null $new_question_id ID soal yg diedit (null jika soal baru)
	 * @param string $new_answer Jawaban dari soal baru/diedit
	 * @param int $start_x
	 * @param int $start_y
	 * @param string $direction
	 * @return array ['valid' => bool, 'message' => string]
	 */
	public function validate_answer_placement($tts_id, $new_question_id, $new_answer, $start_x, $start_y, $direction)
	{
		// 1. Dapatkan SEMUA soal lain di TTS ini
		$this->db->where('tts_id', $tts_id);
		if ($new_question_id) {
			// Jika ini mode EDIT, kecualikan soal ini dari pengecekan
			$this->db->where('id !=', $new_question_id);
		}
		$existing_questions = $this->db->get($this->table_questions)->result();

		// 2. Bangun Peta Grid Virtual
		//    Kunci = "x,y", Nilai = "HURUF"
		$grid_map = [];
		foreach ($existing_questions as $q) {
			$x = (int)$q->start_x;
			$y = (int)$q->start_y;
			$answer_letters = str_split($q->answer);

			foreach ($answer_letters as $i => $letter) {
				$current_x = $x;
				$current_y = $y;

				if ($q->direction == 'across') {
					$current_x += $i;
				} else { // 'down'
					$current_y += $i;
				}
				
				$coord_key = $current_x . ',' . $current_y;
				
				// (Opsional: Cek tabrakan di data yang sudah ada, tapi kita fokus ke data baru)
				// if (isset($grid_map[$coord_key]) && $grid_map[$coord_key] != $letter) {
				// 	// Ada data korup di database, tapi itu di luar skop validasi ini
				// }
				$grid_map[$coord_key] = $letter;
			}
		}

		// 3. Validasi Jawaban Baru di Peta Grid
		$new_answer_letters = str_split($new_answer);
		foreach ($new_answer_letters as $i => $new_letter) {
			$current_x = (int)$start_x;
			$current_y = (int)$start_y;

			if ($direction == 'across') {
				$current_x += $i;
			} else { // 'down'
				$current_y += $i;
			}

			$coord_key = $current_x . ',' . $current_y;

			// Cek apakah sel ini sudah terisi di peta
			if (isset($grid_map[$coord_key])) {
				$existing_letter = $grid_map[$coord_key];
				
				// Jika sudah terisi DAN hurufnya tidak sama, maka terjadi tabrakan!
				if ($existing_letter != $new_letter) {
					// INI ADALAH TABRAKAN (Contoh: 'M' menimpa 'L')
					return [
						'valid' => false,
						'message' => 'Jawaban Anda bertabrakan di sel (' . $current_x . ',' . $current_y . '). Huruf "<strong>' . $new_letter . '</strong>" akan menimpa huruf "<strong>' . $existing_letter . '</strong>" yang sudah ada.'
					];
				}
			}
			// Jika sel kosong, atau jika hurufnya sama (persimpangan),
			// maka validasi lolos untuk sel ini. Lanjut ke huruf berikutnya.
		}

		// 4. Jika semua huruf lolos tanpa tabrakan
		return ['valid' => true, 'message' => ''];
	}
	
}


/* End of file Pbl_tts_model.php */
/* Location: ./application/models/Pbl_tts_model.php */