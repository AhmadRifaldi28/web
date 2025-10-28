<div class="row">
	<div class="col-lg-12">

		<?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

		<?= $this->session->flashdata('message'); ?>

		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<button class="btn btn-primary" id="btnAddMenu">
					<i class="fas fa-plus"></i> Tambah Menu
				</button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="menuTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th style="width: 10%;">No</th>
								<th>Menu</th>
								<th style="width: 20%;">Aksi</th>
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

<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="menuModalLabel">Tambah Menu</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="menuForm">
				<div class="modal-body">
					<input type="hidden" name="id" id="menuId">
					<div class="mb-3">
						<label for="menuName" class="form-label">Nama Menu</label>
						<input type="text" class="form-control" id="menuName" name="menu" required>
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
    // Pastikan skrip berjalan setelah DOM sepenuhnya dimuat
    document.addEventListener("DOMContentLoaded", () => {

    	const base_url = '<?= base_url() ?>';
        let dataTable; // Variabel untuk menyimpan instance simple-datatable
        
        // Referensi elemen modal dan form
        const menuModalEl = document.getElementById('menuModal');
        const menuModal = new bootstrap.Modal(menuModalEl);
        const menuForm = document.getElementById('menuForm');
        const menuModalLabel = document.getElementById('menuModalLabel');
        const menuId = document.getElementById('menuId');
        const menuName = document.getElementById('menuName');
        
        // === PERBAIKAN: Referensi ke elemen statis (induk tabel) ===
        const tableParent = document.querySelector('.card-body');

        /**
         * Inisialisasi simple-datatables
         */
         const initDataTable = () => {
            // Hancurkan tabel lama jika ada (untuk reload)
            if (dataTable) {
            	dataTable.destroy();
            }
            // Inisialisasi tabel baru
            dataTable = new simpleDatatables.DataTable("#menuTable", {
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
         * Fungsi untuk memuat data menu dari controller
         * dan me-render-nya ke dalam tabel.
         */
         const loadMenuData = async () => {
         	try {
         		const response = await fetch(`${base_url}menu/getMenuList`);
         		if (!response.ok) {
         			throw new Error('Network response was not ok');
         		}
         		const menuList = await response.json();

                // Format data untuk simple-datatables
                const data = menuList.map((menu, index) => {
                	return [
                        index + 1, // Nomor urut
                        menu.menu, // Nama Menu
                        // Tombol Aksi
                        `
                        <button class="btn btn-warning btn-sm btn-edit" 
                        data-id="${menu.id}" 
                        data-menu="${menu.menu}">
                        <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" 
                        data-id="${menu.id}"
                        data-menu="${menu.menu}">
                        <i class="fas fa-trash"></i> Hapus
                        </button>
                        `
                        ];
                      });

                // Inisialisasi tabel (atau hancurkan dan buat ulang)
                initDataTable();

                // Masukkan data baru ke tabel
                if (data.length > 0) {
                	dataTable.insert({ data: data });
                }

              } catch (error) {
              	console.error('Failed to load menu data:', error);
              	Swal.fire('Error', 'Gagal memuat data menu.', 'error');
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

        // --- 1. CREATE ---
        // Tampilkan modal untuk tambah data baru
        document.getElementById('btnAddMenu').addEventListener('click', () => {
            menuForm.reset(); // Kosongkan form
            menuId.value = ''; // Pastikan ID kosong
            menuModalLabel.textContent = 'Tambah Menu';
            menuModal.show();
          });

        // --- 3. SAVE (CREATE & UPDATE) ---
        // Kirim data (tambah/edit) saat form disubmit
        menuForm.addEventListener('submit', async (e) => {
        	e.preventDefault();

        	const formData = new FormData(menuForm);

        	try {
        		const response = await fetch(`${base_url}menu/saveMenu`, {
        			method: 'POST',
        			body: formData
        		});

        		const result = await response.json();

        		if (result.status === 'success') {
        			menuModal.hide();
        			showToast('success', result.message);
                    await loadMenuData(); // Reload data tabel
                  } else {
                    // Tampilkan error di dalam modal atau sebagai alert
                    Swal.fire('Gagal!', result.message, 'error');
                  }

                } catch (error) {
                	console.error('Failed to save menu:', error);
                	Swal.fire('Error', 'Terjadi kesalahan saat menyimpan.', 'error');
                }
              });

        
        // === PERBAIKAN: Event listener dipindahkan ke '.card-body' ===
        // --- 2. UPDATE (SHOW MODAL) & 4. DELETE (with Confirmation) ---
        // Menggunakan event delegation pada elemen induk statis
        tableParent.addEventListener('click', (e) => {

            // Cek apakah tombol EDIT yang diklik
            const btnEdit = e.target.closest('.btn-edit');
            if (btnEdit) {
            	menuId.value = btnEdit.dataset.id;
            	menuName.value = btnEdit.dataset.menu;
            	menuModalLabel.textContent = 'Edit Menu';
            	menuModal.show();
                return; // Hentikan eksekusi
              }

            // Cek apakah tombol DELETE yang diklik
            const btnDelete = e.target.closest('.btn-delete');
            if (btnDelete) {
            	const id = btnDelete.dataset.id;
            	const menu = btnDelete.dataset.menu;

            	Swal.fire({
            		title: 'Anda Yakin?',
            		text: `Menu "${menu}" akan dihapus secara permanen!`,
            		icon: 'warning',
            		showCancelButton: true,
            		confirmButtonColor: '#d33',
            		cancelButtonColor: '#3085d6',
            		confirmButtonText: 'Ya, hapus!',
            		cancelButtonText: 'Batal'
            	}).then((result) => {
            		if (result.isConfirmed) {
                        // Jika dikonfirmasi, panggil fungsi delete
                        deleteMenu(id);
                      }
                    });
                return; // Hentikan eksekusi
              }
            });


        /**
         * Fungsi untuk mengeksekusi penghapusan data
         */
         const deleteMenu = async (id) => {
         	try {
                // Controller Anda menggunakan ID dari URI segment
                const response = await fetch(`${base_url}menu/deleteMenu/${id}`, {
                    method: 'DELETE' // atau 'POST'/'GET' jika server tidak mengizinkan DELETE
                  });
                
                const result = await response.json();

                if (result.status === 'success') {
                	showToast('success', result.message);
                    await loadMenuData(); // Reload data tabel
                  } else {
                  	Swal.fire('Gagal!', result.message, 'error');
                  }

                } catch (error) {
                	console.error('Failed to delete menu:', error);
                	Swal.fire('Error', 'Terjadi kesalahan saat menghapus.', 'error');
                }
              };

        // --- Muat Data Awal ---
        // Panggil fungsi untuk memuat data saat halaman pertama kali dibuka
        loadMenuData();
      });
    </script>