import CrudHandler from './crud_handler.js';

document.addEventListener('DOMContentLoaded', () => {

    const csrfEl = document.querySelector('input[name="' + window.CSRF_TOKEN_NAME + '"]');
    const SLOT_ID = window.SLOT_ID;

    if (!SLOT_ID) {
        console.error('SLOT ID tidak ditemukan.');
        return;
    }

    const csrfConfig = {
        tokenName: window.CSRF_TOKEN_NAME,
        tokenHash: csrfEl ? csrfEl.value : ''
    };

    // Konfigurasi CRUD untuk Daftar Upload
    const uploadConfig = {
        baseUrl: window.BASE_URL,
        entityName: 'File Observasi',
        
        // CLEAN CODE FIX:
        // Set false agar event listener Delete dipasang.
        // Karena CrudHandler sudah diperbaiki, kita tidak perlu menyediakan dummy modal/form.
        readOnly: false, 
        
        tableId: 'uploadsTable',
        tableParentSelector: '.card-body', 
        
        csrf: csrfConfig,
        urls: {
            load: `guru/pbl_observasi/get_uploads/${SLOT_ID}`,
            delete: (id) => `guru/pbl_observasi/delete_upload/${id}`
        },
        deleteMethod: 'POST', 
        deleteNameField: 'student_name', 

        // Mapper data dari JSON ke Tabel HTML
        dataMapper: (item, i) => {
            const uploadDate = new Date(item.created_at).toLocaleString('id-ID', {
                dateStyle: 'medium',
                timeStyle: 'short'
            });

            const fileUrl = `${window.BASE_URL}uploads/observasi/${item.file_name}`;
            const fileBtn = `
                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-info text-white">
                    <i class="bi bi-download"></i> Unduh
                </a>
            `;

            // Tombol Hapus (Akan berfungsi sekarang karena readOnly: false)
            const deleteBtn = `
                <button class="btn btn-sm btn-danger btn-delete" 
                    data-id="${item.id}" 
                    data-student_name="${item.student_name} - ${item.original_name}">
                    <i class="bi bi-trash"></i>
                </button>
            `;

            return [
                i + 1,
                `<strong>${item.student_name}</strong>`,
                item.description || '-',
                fileBtn,
                uploadDate,
                deleteBtn
            ];
        },

        // Parameter ini bisa dikosongkan/dibuang karena tidak ada Create/Update
        formPopulator: () => {}, 
        onAdd: () => {}
    };

    const handler = new CrudHandler(uploadConfig);
    handler.init();
});