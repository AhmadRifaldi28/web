<div class="row">
    <div class="col-lg-12">

        <?= $this->session->flashdata('message'); ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary" id="btnAddSubmenu">
                    <i class="fas fa-plus"></i> Tambah Submenu Baru
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="submenuTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Judul</th>
                                <th>Menu</th>
                                <th>Url</th>
                                <th>Ikon</th>
                                <th style="width: 10%;">Aktif</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="submenuModal" tabindex="-1" aria-labelledby="submenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submenuModalLabel">Tambah Submenu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submenuForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="submenuId">

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Submenu</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="menu_id" class="form-label">Menu Induk</label>
                        <select name="menu_id" id="menu_id" class="form-select" required>
                            <option value="">Pilih Menu...</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input type="text" class="form-control" id="url" name="url" required>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Ikon</label>
                        <input type="text" class="form-control" id="icon" name="icon" required>
                        <small class="form-text text-muted">Contoh: ri-add-line</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Aktif?
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const base_url = '<?= base_url() ?>';
        let dataTable; // Variabel untuk menyimpan instance simple-datatable

        // --- Referensi Elemen ---
        const submenuModalEl = document.getElementById('submenuModal');
        const submenuModal = new bootstrap.Modal(submenuModalEl);
        const submenuForm = document.getElementById('submenuForm');
        const submenuModalLabel = document.getElementById('submenuModalLabel');
        const submenuId = document.getElementById('submenuId');
        
        // Referensi Form Fields
        const title = document.getElementById('title');
        const menu_id = document.getElementById('menu_id');
        const url = document.getElementById('url');
        const icon = document.getElementById('icon');
        const is_active = document.getElementById('is_active');
        
        // Referensi Elemen Statis untuk Event Delegation
        const cardBody = document.querySelector('.card-body');
        const btnAddSubmenu = document.getElementById('btnAddSubmenu');

        /**
         * Inisialisasi simple-datatables
         */
        const initDataTable = () => {
             // Hancurkan tabel lama jika ada (untuk reload)
            if (dataTable) {
                dataTable.destroy();
            }
            // Inisialisasi tabel baru
            dataTable = new simpleDatatables.DataTable("#submenuTable", {
                searchable: true,
                fixedHeight: false,
                labels: {
                    placeholder: "Cari...",
                    perPage: "",
                    noRows: "Tidak ada data ditemukan",
                    noResults: "Tidak ada data ditemukan",
                    info: "Menampilkan {start} sampai {end} dari {rows} data",
                }
            });
        };
        
        /**
         * Fungsi untuk memuat data dari controller (getSubmenuList)
         * dan membangun tabel
         */
        const loadSubmenuData = async () => {
             try {
                const response = await fetch(`${base_url}menu/getSubmenuList`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const submenuList = await response.json();

                // Format data untuk simple-datatables
                const data = submenuList.map((sm, index) => {
                    const badge = sm.is_active == 1 
                        ? `<span class="badge bg-success">Aktif</span>` 
                        : `<span class="badge bg-danger">Nonaktif</span>`;

                    const buttons = `
                        <button class="btn btn-warning btn-sm btn-edit" 
                            data-id="${sm.id}" 
                            data-title="${sm.title}" 
                            data-menu-id="${sm.menu_id}" 
                            data-url="${sm.url}" 
                            data-icon="${sm.icon}" 
                            data-is-active="${sm.is_active}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" 
                            data-id="${sm.id}" 
                            data-title="${sm.title}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    `;
                    
                    return [
                        index + 1,
                        sm.title,
                        sm.menu_name,
                        sm.url,
                        sm.icon,
                        badge,
                        buttons
                    ];
                });

                // Inisialisasi tabel (atau hancurkan dan buat ulang)
                initDataTable();

                // Masukkan data baru ke tabel
                if (data.length > 0) {
                    dataTable.insert({ data: data });
                }

            } catch (error) {
                console.error('Failed to load submenu data:', error);
                Swal.fire('Error', 'Gagal memuat data submenu.', 'error');
            }
        };


        /**
         * Menampilkan Notifikasi Toast (SweetAlert2)
         */
        const showToast = (icon, title) => {
            Swal.fire({
                icon: icon,
                title: title,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        };

        // --- 1. CREATE (Tampilkan Modal) ---
        btnAddSubmenu.addEventListener('click', () => {
            submenuForm.reset(); // Kosongkan form
            submenuId.value = ''; // Pastikan ID kosong
            submenuModalLabel.textContent = 'Tambah Submenu Baru';
            is_active.checked = true; // Default aktif saat tambah baru
            submenuModal.show();
        });

        // --- 2. SAVE (Create & Update) ---
        submenuForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(submenuForm);
            
            try {
                const response = await fetch(`${base_url}menu/saveSubmenu`, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    submenuModal.hide();
                    showToast('success', result.message);
                    await loadSubmenuData(); // Panggil fungsi reload data JSON
                } else {
                    Swal.fire('Gagal!', result.message, 'error');
                }
            } catch (error) {
                console.error('Failed to save submenu:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data.', 'error');
            }
        });

        // --- 3. EDIT (Show Modal) & 4. DELETE (Confirmation) ---
        // Gunakan event delegation pada '.card-body' (induk tabel)
        cardBody.addEventListener('click', (e) => {
            
            // Tombol EDIT
            const btnEdit = e.target.closest('.btn-edit');
            if (btnEdit) {
                // Isi form modal dengan data-attributes
                submenuId.value = btnEdit.dataset.id;
                title.value = btnEdit.dataset.title;
                menu_id.value = btnEdit.dataset.menuId;
                url.value = btnEdit.dataset.url;
                icon.value = btnEdit.dataset.icon;
                is_active.checked = (btnEdit.dataset.isActive == 1); // Set checkbox
                
                submenuModalLabel.textContent = 'Edit Submenu';
                submenuModal.show();
                return;
            }

            // Tombol DELETE
            const btnDelete = e.target.closest('.btn-delete');
            if (btnDelete) {
                const id = btnDelete.dataset.id;
                const title = btnDelete.dataset.title;

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: `Submenu "${title}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteSubmenu(id);
                    }
                });
                return;
            }
        });

        /**
         * Fungsi untuk eksekusi delete via AJAX
         */
        const deleteSubmenu = async (id) => {
            try {
                // Controller mengharapkan ID di URI segment
                const response = await fetch(`${base_url}menu/deleteSubmenu/${id}`, {
                    method: 'POST' // Menggunakan POST
                });
                
                const result = await response.json();

                if (result.status === 'success') {
                    showToast('success', result.message);
                    await loadSubmenuData(); // Panggil fungsi reload data JSON
                } else {
                    Swal.fire('Gagal!', result.message, 'error');
                }
            } catch (error) {
                console.error('Failed to delete submenu:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menghapus.', 'error');
            }
        };


        // --- Inisialisasi Awal ---
        // Muat data saat halaman pertama kali dibuka
        loadSubmenuData();

    });
</script>