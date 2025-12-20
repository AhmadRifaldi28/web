<div class="container py-4">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id) ?>" class="btn btn-secondary">
			<i class="bi bi-arrow-left"></i> Kembali ke Tahap 4
		</a>
		<h4 class="fw-bold">Tahap 5: Refleksi & Feedback</h4>
	</div>

	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
	value="<?= $this->security->get_csrf_hash(); ?>">
	<input type="hidden" id="currentUserId" value="<?= $user['user_id']; ?>"> 
	<input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

	<div class="alert alert-info border-0 shadow-sm">
		<i class="bi bi-info-circle-fill me-2"></i>
		Halaman ini menampilkan rekapitulasi nilai Anda dari seluruh tahapan project. Klik tombol <strong>"Lihat Refleksi"</strong> pada nama Anda untuk melihat catatan dari Guru.
	</div>

	<div class="card shadow-sm border-0 mb-4">
		<div class="card-header bg-white py-3">
			<h5 class="mb-0 card-title"><i class="bi bi-trophy text-warning"></i> Rekapitulasi Nilai Kelas</h5>
		</div>
		<div class="card-body" id="rekapTableContainer">
			<div class="table-responsive">
				<table class="table table-hover align-middle" id="rekapTable">
					<thead class="table-light">
						<tr>
							<th width="5%">No</th>
							<th>Nama Siswa</th>
							<th class="text-center">Quiz & TTS</th>
							<th class="text-center">Observasi</th>
							<th class="text-center">Esai</th>
							<th class="text-center fw-bold text-primary">Total Skor</th>
							<th width="15%" class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="refleksiModal" tabindex="-1" aria-labelledby="refleksiModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content border-0 shadow-lg">
			<div class="modal-header bg-success text-white">
				<h5 class="modal-title" id="refleksiModalLabel">Refleksi & Feedback Guru</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-light">
				<form id="refleksiForm">
					<div class="mb-4">
						<h6 class="fw-bold text-secondary text-uppercase small">Catatan Refleksi Guru</h6>
						<div class="p-3 bg-white rounded border" id="viewTeacherReflection" style="min-height: 80px; white-space: pre-wrap;">- Belum ada catatan -</div>
					</div>

					<div class="mb-3">
						<h6 class="fw-bold text-secondary text-uppercase small">Feedback Personal Untuk Anda</h6>
						<div class="p-3 bg-white rounded border border-success" id="viewStudentFeedback" style="min-height: 80px; white-space: pre-wrap;">- Belum ada feedback -</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<script>
	window.BASE_URL = "<?= base_url(); ?>";
	window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
	window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
	window.URL_NAME = '<?= $url_name; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/siswa/pbl_tahap5.js'); ?>"></script>