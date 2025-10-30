<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TtsModel extends CI_Model
{

    // === CRUD untuk tabel TTS ===
    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get('tts')->result();
    }

    public function get($id)
    {
        return $this->db->get_where('tts', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('tts', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('tts', ['id' => $id]);
    }

    public function find($id)
    {
        return $this->db->get_where('tts', ['id' => $id])->row();
    }

    public function get_questions($tts_id)
    {
        return $this->db->where('tts_id', $tts_id)
            ->order_by('arah', 'ASC')
            ->order_by('nomor', 'ASC')
            ->get('tts_questions')->result();
    }

    public function insert_question($data)
    {
        return $this->db->insert('tts_questions', $data);
    }

    public function delete_question($id)
    {
        return $this->db->delete('tts_questions', ['id' => $id]);
    }

    // Auto nomor pertanyaan
    public function get_next_number($tts_id, $arah)
    {
        $this->db->select_max('nomor');
        $this->db->where(['tts_id' => $tts_id, 'arah' => $arah]);
        $row = $this->db->get('tts_questions')->row();
        return $row ? $row->nomor + 1 : 1;
    }

    // Mengambil nilai siswa
    // === Ambil seluruh nilai TTS semua siswa ===
    public function get_all_nilai()
    {
        $this->db->select('tts_answers.*, tts.judul, user.name as nama_siswa');
        $this->db->from('tts_answers');
        $this->db->join('tts', 'tts.id = tts_answers.tts_id', 'left');
        $this->db->join('user', 'user.id = tts_answers.user_id', 'left');
        $this->db->order_by('tts_answers.submitted_at', 'DESC');
        return $this->db->get()->result();
    }

    // === Ambil seluruh nilai berdasarkan satu TTS ===
    public function get_all_nilai_siswa($tts_id)
    {
        $this->db->select('tts_answers.*, user.name as nama_siswa');
        $this->db->from('tts_answers');
        $this->db->join('user', 'user.id = tts_answers.user_id', 'left');
        $this->db->where('tts_answers.tts_id', $tts_id);
        $this->db->order_by('tts_answers.skor', 'DESC');
        return $this->db->get()->result();
    }
}
