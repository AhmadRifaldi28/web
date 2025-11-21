import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const IS_ADMIN_OR_GURU = window.IS_ADMIN_OR_GURU || false;
  const CURRENT_CLASS_ID = window.CURRENT_CLASS_ID || null;

  // Hapus tombol "Tambah" jika Murid
  if (!IS_ADMIN_OR_GURU) {
    ['btnAddEsai', 'btnAddKuisEvaluasi'].forEach(id => {
      const btn = document.getElementById(id);
      if (btn) btn.remove(); // Menghapus elemen dari DOM
    });
  }

  if (!CURRENT_CLASS_ID) {
    console.error('CLASS ID tidak ditemukan.');
    return;
  }

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: csrfEl ? csrfEl.value : ''
  };

  // --- Inisialisasi CRUD 1: Refleksi Akhir ---
  const refleksiConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Refleksi Akhir',
    modalId: 'refleksiModal',
    formId: 'refleksiForm',
    modalLabelId: 'refleksiModalLabel',
    hiddenIdField: 'refleksiId',
    tableId: 'refleksiTable',
    btnAddId: 'btnAddRefleksi',
    tableParentSelector: '#refleksi', // Parent tab
    csrf: csrfConfig,
    urls: {
      load: IS_ADMIN_OR_GURU ? `guru/pbl/get_reflections/${CURRENT_CLASS_ID}` : `siswa/pbl/get_reflections/${CURRENT_CLASS_ID}`,
      save: `guru/pbl/save_reflection`,
      delete: (id) => `guru/pbl/delete_reflection/${id}`
    },
    deleteMethod: 'POST',
    modalTitles: { add: 'Tambah Refleksi', edit: 'Edit Refleksi' },
    deleteNameField: 'title',

    dataMapper: (q, i) => {
      const detailBtn = `<a href="${window.BASE_URL}${window.URL_NAME}/pbl_refleksi_akhir/detail/${q.id}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a>`;
      
      const actionBtns = IS_ADMIN_OR_GURU ? `
        <button class="btn btn-sm btn-warning btn-edit" data-id="${q.id}" data-title="${q.title}" data-description="${q.description || ''}"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="${q.id}" data-title="${q.title}"><i class="bi bi-trash"></i></button>
      ` : '';

      return [i + 1, q.title, q.description || '-', detailBtn + actionBtns];
    },

    formPopulator: (form, data) => {
      form.querySelector('#refleksiId').value = data.id;
      form.querySelector('[name="title"]').value = data.title;
      form.querySelector('[name="description"]').value = data.description || '';
    }
  };

  // --- Inisialisasi CRUD 2: TTS Penutup ---
  const ttsConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'TTS Penutup',
    modalId: 'ttsPenutupModal',
    formId: 'ttsPenutupForm',
    modalLabelId: 'ttsPenutupModalLabel',
    hiddenIdField: 'ttsPenutupId',
    tableId: 'ttsPenutupTable',
    btnAddId: 'btnAddTtsPenutup',
    tableParentSelector: '#tts', // Parent tab
    csrf: csrfConfig,
    urls: {
      load: IS_ADMIN_OR_GURU ? `guru/pbl/get_closing_tts/${CURRENT_CLASS_ID}` : `siswa/pbl/get_closing_tts/${CURRENT_CLASS_ID}`,
      save: `guru/pbl/save_closing_tts`,
      delete: (id) => `guru/pbl/delete_closing_tts/${id}`
    },
    deleteMethod: 'POST',
    modalTitles: { add: 'Tambah TTS Penutup', edit: 'Edit TTS Penutup' },
    deleteNameField: 'title',

    dataMapper: (q, i) => {
      const detailBtn = `<a href="${window.BASE_URL}${window.URL_NAME}/pbl_ttsPenutup /detail/${q.id}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a>`;
      
      const actionBtns = IS_ADMIN_OR_GURU ? `
        <button class="btn btn-sm btn-warning btn-edit" data-id="${q.id}" data-title="${q.title}" data-description="${q.grid_data || ''}"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="${q.id}" data-title="${q.title}"><i class="bi bi-trash"></i></button>
      ` : '';

      return [i + 1, q.title, q.grid_data || '-', detailBtn + actionBtns];
    },

    formPopulator: (form, data) => {
      form.querySelector('#ttsPenutupId').value = data.id;
      form.querySelector('[name="title"]').value = data.title;
      form.querySelector('[name="grid_data"]').value = data.grid_data || '';
    }
  };

  // Inisialisasi kedua handler
  new CrudHandler(refleksiConfig).init();
  new CrudHandler(ttsConfig).init();
  
});