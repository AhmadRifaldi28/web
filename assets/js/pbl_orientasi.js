// assets/js/pbl_orientasi.js
import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

  const csrfTokenEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const classIdEl = document.getElementById('classIdHidden');
  const CURRENT_CLASS_ID = classIdEl ? classIdEl.value : null;

  if (!CURRENT_CLASS_ID) {
    console.error('CLASS ID tidak ditemukan. CRUD PBL dibatalkan.');
    return;
  }

  // Konfigurasi untuk Tahap 1 – Orientasi Masalah
  const pblConfig = {
    baseUrl: window.BASE_URL,
    entityName: 'Skenario Masalah',
    readOnly: !IS_ADMIN_OR_GURU,

    // DOM SELECTORS 
    modalId: 'pblModal',
    formId: 'pblForm',
    modalLabelId: 'pblModalLabel',
    hiddenIdField: 'pblId',
    tableId: 'pblTable',
    btnAddId: 'btnAddPbl',
    tableParentSelector: '.card-body',

    // CSRF CONFIG 
    csrf: {
      tokenName: window.CSRF_TOKEN_NAME,
      tokenHash: csrfTokenEl ? csrfTokenEl.value : ''
    },

    // API ENDPOINTS 
    urls: {
      load: window.IS_ADMIN_OR_GURU 
        ? `guru/pbl/get_data/${CURRENT_CLASS_ID}` 
        : `siswa/pbl/get_data/${CURRENT_CLASS_ID}`,
      save: `guru/pbl/save`,
      delete: (id) => `guru/pbl/delete/${id}`
    },
    deleteMethod: 'POST',

    // UI TEXTS 
    modalTitles: {
      add: 'Tambah Skenario Baru',
      edit: 'Edit Skenario Masalah'
    },
    deleteNameField: 'title',

    // RENDER TABLE ROW 
    dataMapper: (item, index) => {
      const fileLink = item.file_path
        ? `<a href="${window.BASE_URL}${item.file_path}" target="_blank">Lihat</a>`
        : '-';
      
      // Kolom dasar (untuk semua role)
      const rowData = [
        index + 1,
        item.title,
        item.reflection,
        fileLink,
      ];

      // (KONDISIONAL) Hanya tambahkan kolom Aksi jika role = admin/guru
      if (IS_ADMIN_OR_GURU) {
        rowData.push(`
          <button class="btn btn-sm btn-warning btn-edit"
          data-id="${item.id}"
          data-title="${item.title}"
          data-reflection="${item.reflection}">
          <i class="bi bi-pencil"></i>
        </button>
        <button class="btn btn-sm btn-danger btn-delete"
          data-id="${item.id}"
          data-title="${item.title}">
          <i class="bi bi-trash"></i>
        </button>
        `);
      }
      
      // Kembalikan 4 kolom (Siswa) atau 5 kolom (Admin/Guru)
      // Ini akan cocok dengan <thead> kondisional di PHP
      return rowData;
    },

    // POPULATE EDIT FORM 
    formPopulator: (form, data) => {
      form.querySelector('#pblId').value = data.id;
      form.querySelector('#pblTitle').value = data.title;
      form.querySelector('#pblReflection').value = data.reflection;
    },

    // RESET FORM ON ADD 
    onAdd: (form) => {
      form.reset();
      form.querySelector('input[name="class_id"]').value = CURRENT_CLASS_ID;
    }
  };

  // INIT CRUD HANDLER 
  const pblHandler = new CrudHandler(pblConfig);
  pblHandler.init();
});
