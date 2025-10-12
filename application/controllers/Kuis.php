<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuis extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(['Kuis_model','Soal_model','Jawaban_model']);
        $this->load->library('form_validation');
    }

    public function index(){
        $this->auth_required();
        $data['kuis'] = $this->Kuis_model->all();
        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/sidebar',$data);
        $this->load->view('kuis/index',$data);
        $this->load->view('layouts/footer',$data);
    }

    public function create(){
        $this->require_role('teacher');
        $this->form_validation->set_rules('judul','Judul','required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layouts/header');
            $this->load->view('layouts/sidebar');
            $this->load->view('kuis/form');
            $this->load->view('layouts/footer');
            return;
        }
        $kuis_id = $this->Kuis_model->insert([
            'judul' => $this->input->post('judul',true),
            'deskripsi' => $this->input->post('deskripsi'),
            'created_by' => $this->session->userdata('user_id')
        ]);
        // Insert soal: expect arrays 'pertanyaan[]','pil_a[]' ... 'jawaban_benar[]'
        $pertanyaan = $this->input->post('pertanyaan', true);
        if ($pertanyaan && is_array($pertanyaan)) {
            for ($i=0; $i<count($pertanyaan); $i++) {
                $soal = [
                    'kuis_id' => $kuis_id,
                    'pertanyaan' => $pertanyaan[$i],
                    'pilihan_a' => $this->input->post('pilihan_a')[$i] ?? null,
                    'pilihan_b' => $this->input->post('pilihan_b')[$i] ?? null,
                    'pilihan_c' => $this->input->post('pilihan_c')[$i] ?? null,
                    'pilihan_d' => $this->input->post('pilihan_d')[$i] ?? null,
                    'jawaban_benar' => $this->input->post('jawaban_benar')[$i] ?? 'A'
                ];
                $this->Soal_model->insert($soal);
            }
        }
        $this->session->set_flashdata('success','Kuis dibuat');
        redirect('kuis');
    }

    public function take($id){
        $this->require_role('student');
        $data['kuis'] = $this->Kuis_model->get($id);
        $data['soal'] = $this->Soal_model->get_by_kuis($id);
        if (!$data['kuis']) show_404();
        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/sidebar',$data);
        $this->load->view('kuis/take',$data);
        $this->load->view('layouts/footer',$data);
    }

    public function submit($kuis_id){
        $this->require_role('student');
        $jawaban = $this->input->post('answer', true); // expect array soal_id => pilihan
        $soal = $this->Soal_model->get_by_kuis($kuis_id);
        $total = count($soal);
        $benar = 0;
        foreach ($soal as $s) {
            $given = isset($jawaban[$s->id]) ? $jawaban[$s->id] : null;
            if ($given && strtoupper($given) === strtoupper($s->jawaban_benar)) $benar++;
        }
        $skor = ($total > 0) ? intval(($benar / $total) * 100) : 0;
        $this->Jawaban_model->save_result([
            'siswa_id' => $this->session->userdata('user_id'),
            'kuis_id' => $kuis_id,
            'skor' => $skor
        ]);
        $this->session->set_flashdata('success','Kuis selesai. Skor: '.$skor);
        redirect('kuis/result/'.$kuis_id);
    }

    public function result($kuis_id){
        $this->auth_required();
        $data['results'] = $this->Jawaban_model->results_by_kuis($kuis_id);
        $data['kuis'] = $this->Kuis_model->get($kuis_id);
        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/sidebar',$data);
        $this->load->view('kuis/result',$data);
        $this->load->view('layouts/footer',$data);
    }
}