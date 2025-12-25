import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const CURRENT_CLASS_ID = window.CURRENT_CLASS_ID || null;

  if (!CURRENT_CLASS_ID) return;

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: csrfEl ? csrfEl.value : ''
  };

  /**
   * HELPER: Fungsi Generate Tombol Aksi
   * Digunakan oleh kedua tabel (Rekap & Refleksi) agar tombolnya konsisten.
   */
  const generateActionButtons = (student) => {
    // Cek status data
    const teacherRef = student.teacher_reflection || '';
    const feedback = student.student_feedback || '';
    const isFilled = teacherRef !== '' || feedback !== '';
    const isLocked = parseInt(student.is_locked) === 1;

    // 1. Logic Tombol Lock (Gembok)
    let lockBtn = '';
    if (isFilled) {
      if (isLocked) {
        // Jika Terkunci (Published) -> Merah (Unlock)
        lockBtn = `
          <button type="button" class="btn btn-sm btn-outline-danger btn-lock" 
            title="Batalkan Publikasi" data-id="${student.user_id}" data-status="0">
            <i class="bi bi-unlock-fill"></i>
          </button>`;
      } else {
        // Jika Draft -> Hijau (Lock)
        lockBtn = `
          <button type="button" class="btn btn-sm btn-outline-success btn-lock" 
             title="Publikasikan Nilai" data-id="${student.user_id}" data-status="1">
             <i class="bi bi-lock-fill"></i>
          </button>`;
      }
    } else {
      // Disable jika belum isi
      lockBtn = `<button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-lock"></i></button>`;
    }

    // 2. Logic Tombol Input/Edit
    const btnClass = isFilled ? 'btn-warning' : 'btn-primary';
    const btnText = isFilled ? 'Edit' : 'Input';
    const icon = isFilled ? 'bi-pencil-square' : 'bi-plus-lg';

    // Gabungkan tombol
    return `
      <div class="btn-group" role="group">
          <button type="button" class="btn btn-sm ${btnClass} btn-edit" 
            data-id="${student.user_id}" 
            data-name="${student.student_name}"
            data-reflection="${teacherRef}"
            data-feedback="${feedback}">
            <i class="bi ${icon}"></i> ${btnText}
          </button>
          ${lockBtn}
      </div>
    `;
  };

  /**
   * HELPER: Fungsi Populate Form Modal
   * Digunakan kedua tabel untuk mengisi modal saat tombol diklik
   */
  const commonFormPopulator = (form, data) => {
    form.querySelector('#modalUserId').value = data.id;
    form.querySelector('#modalStudentName').value = data.name;
    form.querySelector('[name="teacher_reflection"]').value = data.reflection || '';
    form.querySelector('[name="student_feedback"]').value = data.feedback || '';
  };


  // ============================================================
  // HANDLER 1: TABEL REKAP NILAI (Sekarang ada Aksinya)
  // ============================================================
  const rekapConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Rekap Nilai',
    tableId: 'rekapTable',      
    tableParentSelector: '.card-body', 
    
    // PENTING: Ubah ke false agar CrudHandler mengaktifkan listener tombol edit
    readOnly: false, 

    // Tambahkan Config Modal agar tombol di tabel atas bisa buka modal
    modalId: 'refleksiModal',
    formId: 'refleksiForm',
    modalLabelId: 'refleksiModalLabel',

    btnAddId: null, // Tidak ada tombol tambah global
    csrf: csrfConfig,

    urls: {
      load: `guru/pbl/get_student_recap/${CURRENT_CLASS_ID}`,
      save: `guru/pbl/save_reflection`, // URL Save diperlukan
      delete: null
    },

    modalTitles: { edit: 'Input Refleksi Guru' },

    dataMapper: (student, index) => {
      const quiz = parseFloat(student.quiz_score) || 0;
      const tts = parseFloat(student.tts_score) || 0;
      const obs = parseFloat(student.obs_score) || 0;
      const essay = parseFloat(student.essay_score) || 0;
      const finalScore = (quiz + tts + obs + essay) / 4;

      return [
        index + 1,
        `<span class="fw-bold">${student.student_name}</span>`,
        quiz.toFixed(0),
        tts.toFixed(0),
        obs.toFixed(0),
        essay.toFixed(0),
        `<span class="badge bg-primary fs-6">${finalScore.toFixed(2)}</span>`,
        // KOLOM 8: AKSI (Panggil helper)
        generateActionButtons(student)
      ];
    },

    formPopulator: commonFormPopulator
  };

  // Jalankan Handler Tabel Rekap
  new CrudHandler(rekapConfig).init();


  // ============================================================
  // HANDLER 2: TABEL REFLEKSI & UMPAN BALIK
  // ============================================================
  const refleksiConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Refleksi',
    
    modalId: 'refleksiModal',
    formId: 'refleksiForm',
    modalLabelId: 'refleksiModalLabel',
    
    tableId: 'reflectionTable', 
    tableParentSelector: '.reflectionContainer', 
    
    btnAddId: null, 
    csrf: csrfConfig,
    
    urls: {
      load: `guru/pbl/get_student_recap/${CURRENT_CLASS_ID}`, 
      save: `guru/pbl/save_reflection`,
      delete: null
    },

    modalTitles: { edit: 'Input Refleksi Guru' },

    dataMapper: (student, index) => {
      const teacherRef = student.teacher_reflection || '';
      const feedback = student.student_feedback || '';
      const isLocked = parseInt(student.is_locked) === 1;

      const displayRef = teacherRef ? teacherRef.substring(0, 30) + '...' : '-';
      const displayFeed = feedback ? feedback.substring(0, 30) + '...' : '-';
      
      const statusBadge = isLocked 
        ? '<span class="badge bg-success">Published</span>' 
        : '<span class="badge bg-secondary">Draft</span>';

      return [
        index + 1,
        `<div><span class="fw-bold">${student.student_name}</span> <br> ${statusBadge}</div>`,
        displayRef,
        displayFeed,
        // KOLOM AKSI (Panggil helper)
        generateActionButtons(student)
      ];
    },

    formPopulator: commonFormPopulator
  };

  // Jalankan Handler Tabel Refleksi
  new CrudHandler(refleksiConfig).init();


  // ============================================================
  // EVENT LISTENER GLOBAL UNTUK TOMBOL LOCK (GEMBOK)
  // ============================================================
  // Kita pasang di document agar bisa menangkap klik dari Tabel Atas & Bawah
  document.addEventListener('click', async (e) => {
      const btn = e.target.closest('.btn-lock');
      if (!btn) return; // Jika bukan tombol lock, abaikan

      const userId = btn.dataset.id;
      const status = btn.dataset.status; 
      const actionText = status === '1' ? 'Publikasikan Nilai' : 'Tarik Kembali Nilai';

      // Konfirmasi SweetAlert
      const confirm = await Swal.fire({
          title: 'Konfirmasi',
          text: `Apakah Anda yakin ingin ${actionText} untuk siswa ini?`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya, Lakukan',
          cancelButtonText: 'Batal'
      });

      if (confirm.isConfirmed) {
          try {
              const formData = new FormData();
              formData.append('class_id', CURRENT_CLASS_ID);
              formData.append('user_id', userId);
              formData.append('status', status);
              formData.append(window.CSRF_TOKEN_NAME, document.querySelector(`input[name="${window.CSRF_TOKEN_NAME}"]`).value);

              const response = await fetch(`${window.BASE_URL}guru/pbl/toggle_lock`, {
                  method: 'POST',
                  body: formData
              });

              const result = await response.json();

              // Update CSRF Token di halaman
              if (result.csrf_hash) {
                  document.querySelectorAll(`input[name="${window.CSRF_TOKEN_NAME}"]`).forEach(el => el.value = result.csrf_hash);
                  csrfConfig.tokenHash = result.csrf_hash;
              }

              if (result.status === 'success') {
                  Swal.fire('Berhasil', result.message, 'success').then(() => {
                    location.reload(); // Reload untuk update tampilan kedua tabel
                  });
              } else {
                  Swal.fire('Gagal', result.message, 'error');
              }

          } catch (error) {
              console.error(error);
              Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
          }
      }
  });

});