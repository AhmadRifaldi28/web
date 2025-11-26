import CrudHandler from '../crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    // Ambil elemen token untuk update nanti (bukan untuk submit awal)
    const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
    const QUIZ_ID = window.QUIZ_ID;

    if (!QUIZ_ID) return;

    const csrfConfig = {
        tokenName: window.CSRF_TOKEN_NAME,
        tokenHash: csrfEl ? csrfEl.value : ''
    };

    // --- Konfigurasi CrudHandler untuk Load Soal ---
    const config = {
        baseUrl: window.BASE_URL,
        entityName: 'Soal',
        readOnly: true,         
        tableId: 'questionsTable',
        tableParentSelector: '#questionsTableContainer',
        
        csrf: csrfConfig,
        urls: {
            load: `siswa/pbl_kuis/get_questions/${QUIZ_ID}`,
            save: ``, 
            delete: ``
        },
        
        dataMapper: (q, i) => {
            const num = i + 1;
            
            const html = `
                <div class="question-card">
                    <h5 class="mb-3">${num}. ${q.question_text}</h5>
                    
                    <div class="options-group">
                        <input class="form-check-input" type="radio" name="answers[${q.id}]" id="q${q.id}_A" value="A">
                        <label class="option-label" for="q${q.id}_A">
                            <strong>A.</strong> ${q.option_a}
                        </label>

                        <input class="form-check-input" type="radio" name="answers[${q.id}]" id="q${q.id}_B" value="B">
                        <label class="option-label" for="q${q.id}_B">
                            <strong>B.</strong> ${q.option_b}
                        </label>

                        <input class="form-check-input" type="radio" name="answers[${q.id}]" id="q${q.id}_C" value="C">
                        <label class="option-label" for="q${q.id}_C">
                            <strong>C.</strong> ${q.option_c}
                        </label>

                        <input class="form-check-input" type="radio" name="answers[${q.id}]" id="q${q.id}_D" value="D">
                        <label class="option-label" for="q${q.id}_D">
                            <strong>D.</strong> ${q.option_d}
                        </label>
                    </div>
                </div>
            `;
            return [html];
        }
    };

    const handler = new CrudHandler(config);
    handler.init();

    // --- Logika Submit Manual ---
    const form = document.getElementById('quizSubmissionForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Kirim Jawaban?',
                text: "Pastikan Anda sudah menjawab semua soal. Aksi ini tidak dapat dibatalkan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitQuizData();
                }
            });
        });
    }

    function submitQuizData() {
        // [PERBAIKAN]
        // new FormData(form) akan otomatis mengambil <input type="hidden"> CSRF 
        // yang sudah kita tambahkan di View. Tidak perlu append manual.
        const formData = new FormData(form);
        
        // Tambahkan Quiz ID manual
        formData.append('quiz_id', QUIZ_ID);

        fetch(`${window.BASE_URL}siswa/pbl_kuis/submit_quiz`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Update token CSRF global di DOM jika server mengirim hash baru
            if (data.csrf_hash) {
                document.querySelectorAll(`input[name="${window.CSRF_TOKEN_NAME}"]`).forEach(el => el.value = data.csrf_hash);
            }

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'Lihat Hasil'
                }).then(() => {
                    window.location.reload(); 
                });
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
        });
    }
});