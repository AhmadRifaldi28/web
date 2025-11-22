<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbl_kuis_model extends CI_Model
{
    private $table_quizzes = 'pbl_quizzes';
    private $table_questions = 'pbl_quiz_questions';
    private $table_results = 'pbl_quiz_results';

    public function get_quiz_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table_quizzes)->row();
    }

    // Mengambil pertanyaan (tanpa kunci jawaban agar tidak bocor di inspect element)
    public function get_questions_for_student($quiz_id)
    {
        $this->db->select('id, quiz_id, question_text, option_a, option_b, option_c, option_d');
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('RAND()'); // Acak urutan soal
        return $this->db->get($this->table_questions)->result();
    }

    // Cek apakah siswa sudah mengerjakan
    public function check_submission($quiz_id, $user_id)
    {
        return $this->db->where('quiz_id', $quiz_id)
            ->where('user_id', $user_id)
            ->get($this->table_results)
            ->row();
    }

    // Proses Penilaian
    public function submit_answers($quiz_id, $user_id, $answers)
    {
        // 1. Ambil Kunci Jawaban dari DB
        $questions = $this->db->where('quiz_id', $quiz_id)->get($this->table_questions)->result();
        
        $score = 0;
        $correct_count = 0;
        $total_questions = count($questions);

        // 2. Hitung Nilai
        foreach ($questions as $q) {
            // Cek apakah jawaban siswa untuk soal ID ini ada dan benar
            if (isset($answers[$q->id]) && $answers[$q->id] == $q->correct_answer) {
                $correct_count++;
            }
        }

        if ($total_questions > 0) {
            $score = ($correct_count / $total_questions) * 100;
        }

        // 3. Simpan Hasil
        $data = [
            'id' => generate_ulid(), // Asumsi helper ulid tersedia
            'quiz_id' => $quiz_id,
            'user_id' => $user_id,
            'score' => round($score),
            'total_correct' => $correct_count,
            'total_questions' => $total_questions
        ];

        $this->db->insert($this->table_results, $data);
        return $data;
    }
}

/* End of file Pbl_kuis_model.php */
/* Location: ./application/models/Pbl_kuis_model.php */