<div class="container py-4">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
			<p class="text-muted mb-0">Kelola hasil observasi yang diunggah siswa.</p>
		</div>
		<a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id) ?>" class="btn btn-secondary">
			<i class="bi bi-arrow-left"></i> Kembali
		</a>
	</div>

	<div class="card shadow-sm mb-4 border-4">
			<h5 class="card-title text-primary">Instruksi:</h5>
			<p class="card-text"><?= nl2br(htmlspecialchars($slot->description)); ?></p>
	</div>

	<div class="card shadow-sm">
		<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Upload Siswa</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="uploadsTable" width="100%" cellspacing="0">
					<thead class="table-light">
						<tr>
							<th style="width: 5%;">No</th>
							<th>Nama Siswa</th>
							<th>Keterangan</th>
							<th>File</th>
							<th>Waktu Upload</th>
							<th style="width: 10%;">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
<input type="hidden" id="slotIdHidden" value="<?= $slot->id; ?>">

<script>
	window.BASE_URL = "<?= base_url(); ?>";
	window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
	window.URL_NAME = "<?= $url_name; ?>";
	window.SLOT_ID = "<?= $slot->id; ?>";
</script>

<script type="module" src="<?= base_url('assets/js/pbl_observasi_detail.js'); ?>"></script>