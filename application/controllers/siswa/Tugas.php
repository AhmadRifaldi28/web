<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tugas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('TtsModel');
		$this->load->database();
	}

	public function index()
	{
		$data['title'] = 'Daftar Kuis TTS';
		$data['user'] = $this->session->userdata();
		$data['tts_list'] = $this->TtsModel->get_all();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('siswa/tts/index', $data);
		$this->load->view('templates/footer');
	}

	public function mulai($tts_id)
	{
		$data['tts'] = $this->TtsModel->get($tts_id);
		$data['questions'] = $this->TtsModel->get_questions($tts_id);

		if (!$data['tts']) show_404();

		$data['title'] = 'Kerjakan TTS: ' . $data['tts']->judul;
		$data['user'] = $this->session->userdata();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('siswa/tts/mulai', $data);
		$this->load->view('templates/footer');
	}

	public function submit_jawaban()
	{
		$user_id = $this->session->userdata('user_id'); // Pastikan sesuai session key kamu
		$tts_id = $this->input->post('tts_id');
		$jawaban_input = $this->input->post('jawaban'); // Bisa array atau JSON string

		// Jika jawaban dalam bentuk JSON string, decode dulu
		if (is_string($jawaban_input)) {
			$jawaban = json_decode($jawaban_input, true);
		} else {
			$jawaban = $jawaban_input;
		}

		if (!is_array($jawaban)) {
			$jawaban = [];
		}

		// Ambil semua pertanyaan TTS
		$questions = $this->TtsModel->get_questions($tts_id);

		// Hitung skor
		$skor = 0;
		foreach ($questions as $q) {
			$key = $q->nomor . '_' . strtolower($q->arah); // pastikan konsisten dengan form input
			if (isset($jawaban[$key])) {
				$jawaban_user = strtoupper(trim($jawaban[$key]));
				$jawaban_benar = strtoupper(trim($q->jawaban));
				if ($jawaban_user === $jawaban_benar) {
					$skor++;
				}
			}
		}

		// Simpan hasil
		$data_insert = [
			'tts_id' => $tts_id,
			'user_id' => $user_id,
			'jawaban_json' => json_encode($jawaban),
			'skor' => $skor,
			'submitted_at' => date('Y-m-d H:i:s')
		];

		// Cek apakah user sudah pernah submit sebelumnya
		$existing = $this->db->get_where('tts_answers', [
			'tts_id' => $tts_id,
			'user_id' => $user_id
		])->row();

		if ($existing) {
			// Update hasil lama
			$this->db->where('id', $existing->id)->update('tts_answers', $data_insert);
		} else {
			// Insert baru
			$this->db->insert('tts_answers', $data_insert);
		}

		redirect('siswa/Tugas/hasil/' . $tts_id);
	}


	public function hasil($tts_id)
	{
		$user_id = $this->session->userdata('user_id');
		$data['title'] = 'Hasil TTS';

		// Ambil hasil jawaban siswa
		$data['hasil'] = $this->db->get_where('tts_answers', [
			'tts_id' => $tts_id,
			'user_id' => $user_id
		])->row();

		// Ambil data TTS dan pertanyaan
		$data['tts'] = $this->TtsModel->get($tts_id);
		$data['questions'] = $this->TtsModel->get_questions($tts_id);

		// Jika hasil belum ada, arahkan ke halaman pengerjaan
		if (!$data['hasil']) {
			$this->session->set_flashdata('error', 'Belum ada hasil untuk TTS ini. Silakan kerjakan dulu.');
			redirect('siswa/Tugas/mulai/' . $tts_id);
			return;
		}

		// Decode jawaban siswa dari kolom jawaban_json
		$data['jawaban_siswa'] = json_decode($data['hasil']->jawaban_json, true);

		// Hitung jumlah jawaban benar untuk validasi (opsional)
		$skor_benar = 0;
		foreach ($data['questions'] as $q) {
			$key = $q->nomor . '_' . $q->arah;
			if (
				isset($data['jawaban_siswa'][$key]) &&
				strtoupper(trim($data['jawaban_siswa'][$key])) == strtoupper(trim($q->jawaban))
			) {
				$skor_benar++;
			}
		}

		// Simpan skor hasil validasi jika berbeda (opsional)
		if ($skor_benar != $data['hasil']->skor) {
			$this->db->where('id', $data['hasil']->id)
				->update('tts_answers', ['skor' => $skor_benar]);
			$data['hasil']->skor = $skor_benar;
		}

		// Load tampilan
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('siswa/tts/hasil', $data);
		$this->load->view('templates/footer');
	}
}
