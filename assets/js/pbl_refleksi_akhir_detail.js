import CrudHandler from './crud_handler.js'; // Pastikan path ini benar

document.addEventListener('DOMContentLoaded', () => {

  const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
  const CURRENT_REFLECTION_ID = window.CURRENT_REFLECTION_ID;
  if (!CURRENT_REFLECTION_ID) return;

  const csrfConfig = {
    tokenName: window.CSRF_TOKEN_NAME,
    tokenHash: csrfEl ? csrfEl.value : ''
  };

  const config = {
    baseUrl: window.BASE_URL,
    entityName: 'Pertanyaan Refleksi',
    modalId: 'promptModal',
    formId: 'promptForm',
    modalLabelId: 'promptModalLabel',
    tableId: 'promptsTable',
    btnAddId: 'btnAddPrompt',
    hiddenIdField: 'promptId', // ID field di form modal
    tableParentSelector: '#promptsTableContainer', // Parent spesifik
    csrf: csrfConfig,
    urls: {
      load: `guru/pbl_refleksi_akhir/get_prompts/${CURRENT_REFLECTION_ID}`,
      save: `guru/pbl_refleksi_akhir/save_prompt`,
      delete: (id) => `guru/pbl_refleksi_akhir/delete_prompt/${id}`
    },
    deleteMethod: 'POST',
    modalTitles: {
      add: 'Tambah Pertanyaan Refleksi',
      edit: 'Edit Pertanyaan Refleksi'
    },
    deleteNameField: 'prompt', // data-prompt="..."

    /**
     * Memetakan data dari server ke format tabel simple-datatables
     */
    dataMapper: (p, i) => [
      i + 1,
      // Potong teks pertanyaan jika terlalu panjang
      p.prompt_text.length > 100 ? p.prompt_text.substring(0, 100) + '...' : p.prompt_text,
      `
        <button class="btn btn-sm btn-warning btn-edit"
          data-id="${p.id}"
          data-prompt_text="${p.prompt_text}">
          <i class="bi bi-pencil"></i>
        </button>
        <button class="btn btn-sm btn-danger btn-delete"
          data-id="${p.id}"
          data-prompt="${p.prompt_text.substring(0, 20)}...">
          <i class="bi bi-trash"></i>
        </button>
      `
    ],

    /**
     * Mengisi form modal saat tombol edit diklik
     */
    formPopulator: (form, data) => {
      form.querySelector('#promptId').value = data.id;
      form.querySelector('#prompt_text').value = data.prompt_text;
    },

    /**
     * Dijalankan saat tombol 'Tambah' diklik
     */
    onAdd: (form) => {
      form.reset();
      form.querySelector('#promptId').value = '';
    }
  };

  // Inisialisasi CrudHandler
  const handler = new CrudHandler(config);
  handler.init();

});