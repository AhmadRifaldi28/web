import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {
    
    const ESSAY_ID = document.getElementById('currentEssayId').value;
    const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
    
    const csrfConfig = {
        tokenName: window.CSRF_TOKEN_NAME,
        tokenHash: csrfEl ? csrfEl.value : ''
    };

    // ==========================================
    // 1. INSTANCE CRUD: DAFTAR PERTANYAAN
    // ==========================================
    const questionConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Soal',
        modalId: 'questionModal',
        formId: 'questionForm',
        modalLabelId: 'questionModalLabel',
        hiddenIdField: 'questionId',
        tableId: 'questionTable',
        btnAddId: 'btnAddQuestion',
        // PERBAIKAN: Selector lebih spesifik sesuai ID di HTML baru
        tableParentSelector: '#questionTableContainer', 
        csrf: csrfConfig,
        urls: {
            load: `guru/pbl_esai/get_questions_json/${ESSAY_ID}`,
            save: `guru/pbl_esai/save_question`,
            delete: (id) => `guru/pbl_esai/delete_question/${id}`
        },
        deleteMethod: 'POST',
        modalTitles: { add: 'Tambah Soal Baru', edit: 'Edit Soal' },
        deleteNameField: 'text',

        dataMapper: (q, i) => {
            const shortText = q.question_text.length > 50 ? q.question_text.substring(0, 50) + '...' : q.question_text;
            
            const btns = `
                <button class="btn btn-sm btn-warning btn-edit" 
                    data-id="${q.id}" 
                    data-question_number="${q.question_number}" 
                    data-question_text="${q.question_text}" 
                    data-weight="${q.weight}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete" 
                    data-id="${q.id}" 
                    data-title="No. ${q.question_number}">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            return [q.question_number, shortText, q.weight, btns];
        },

        formPopulator: (form, data) => {
            form.querySelector('#questionId').value = data.id;
            form.querySelector('#qNum').value = data.question_number;
            form.querySelector('#qText').value = data.question_text;
            form.querySelector('#qWeight').value = data.weight;
        }
    };

    // ==========================================
    // 2. INSTANCE CRUD: PENILAIAN (GRADING)
    // ==========================================
    
    const gradingConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'Nilai',
        modalId: 'gradeModal',
        formId: 'gradeForm',
        // PERBAIKAN: Menambahkan ID Label agar tidak error null properti
        modalLabelId: 'gradeModalLabel', 
        tableId: 'gradingTable',
        // PERBAIKAN: Menambahkan Parent Selector agar klik terdeteksi
        tableParentSelector: '#gradingTableContainer',
        
        csrf: csrfConfig,
        urls: {
            load: `guru/pbl_esai/get_grading_json/${ESSAY_ID}`,
            save: `guru/pbl_esai/save_grade`,
            delete: null 
        },
        modalTitles: { edit: 'Berikan Penilaian' }, // Default title

        dataMapper: (s, i) => {
            let statusBadge = '<span class="badge bg-secondary">Belum Mengumpulkan</span>';
            let dateText = '-';
            let gradeText = '-';
            let btnClass = 'btn-secondary disabled';
            let btnIcon = 'bi-x-circle';
            let btnText = 'Belum Ada';
            let isDisabled = 'disabled';

            if (s.submission_id) {
                statusBadge = '<span class="badge bg-success">Sudah Mengumpulkan</span>';
                dateText = new Date(s.submitted_at).toLocaleString('id-ID');
                gradeText = s.grade !== null ? `<span class="fw-bold text-primary">${s.grade}</span>` : '<span class="text-danger">Belum Dinilai</span>';
                btnClass = 'btn-success btn-edit'; 
                btnIcon = 'bi-pencil-square';
                btnText = 'Nilai';
                isDisabled = '';
            }

            // Encode content agar aman di atribut HTML
            const safeContent = s.submission_content ? encodeURIComponent(s.submission_content) : '';

            const actionBtn = `
                <button class="btn btn-sm ${btnClass}" ${isDisabled}
                    data-id="${s.submission_id}" 
                    data-student_name="${s.student_name}"
                    data-content="${safeContent}"
                    data-grade="${s.grade || ''}"
                    data-feedback="${s.feedback || ''}">
                    <i class="bi ${btnIcon}"></i> ${btnText}
                </button>
            `;

            return [i + 1, s.student_name, statusBadge, dateText, gradeText, actionBtn];
        },

        formPopulator: (form, data) => {
            form.querySelector('#submissionId').value = data.id; 
            
            // Update Judul Modal secara manual lewat JS jika ingin dinamis
            const labelEl = document.getElementById('gradeModalLabel');
            if(labelEl) labelEl.textContent = `Penilaian: ${data.student_name}`;

            const content = data.content ? decodeURIComponent(data.content) : '-';
            document.getElementById('studentAnswerContent').innerHTML = content.replace(/\n/g, '<br>');

            form.querySelector('#gradeInput').value = data.grade;
            form.querySelector('#feedbackInput').value = data.feedback;
        }
    };

    // Inisialisasi Keduanya
    new CrudHandler(questionConfig).init();
    new CrudHandler(gradingConfig).init();
});