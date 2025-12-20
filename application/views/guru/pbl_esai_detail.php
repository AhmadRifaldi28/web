<div class="container py-4">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<div>
			<a href="<?= base_url('guru/pbl/tahap4/' . $class_id); ?>" class="btn btn-outline-secondary btn-sm mb-2">
				<i class="bi bi-arrow-left"></i> Kembali ke Daftar Esai
			</a>
			<h3 class="fw-bold"><?= html_escape($essay->title); ?></h3>
			<p class="text-muted"><?= html_escape($essay->description); ?></p>
		</div>
	</div>

	<input type="hidden" id="currentEssayId" value="<?= $essay->id; ?>">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

	<div class="row">
		<div class="col-lg-12 mb-4">
			<div class="card shadow-sm border-0">
				<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0 text-primary"><i class="bi bi-question-circle"></i> Daftar Pertanyaan</h5>
					<button class="btn btn-primary btn-sm" id="btnAddQuestion">
						<i class="bi bi-plus-lg"></i> Tambah Soal
					</button>
				</div>
				<div class="card-body" id="questionTableContainer">
					<table class="table table-hover align-middle" id="questionTable">
						<thead class="table-light">
							<tr>
								<th width="5%">No</th>
								<th>Pertanyaan</th>
								<th width="10%">Bobot</th>
								<th width="15%">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="card shadow-sm border-0">
				<div class="card-header bg-white py-3">
					<h5 class="card-title mb-0 text-success"><i class="bi bi-people"></i> Jawaban & Nilai Siswa</h5>
				</div>
				<div class="card-body" id="gradingTableContainer">
					<table class="table table-bordered table-hover align-middle" id="gradingTable">
						<thead class="table-light">
							<tr>
								<th width="5%">No</th>
								<th>Nama Siswa</th>
								<th>Status</th>
								<th>Waktu Kirim</th>
								<th>Nilai</th>
								<th width="15%">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="questionForm">
				<div class="modal-header">
					<h5 class="modal-title" id="questionModalLabel">Form Soal</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="questionId">
					<input type="hidden" name="essay_id" value="<?= $essay->id; ?>">

					<div class="mb-3">
						<label class="form-label">Nomor Urut</label>
						<input type="number" name="question_number" id="qNum" class="form-control" value="1" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Teks Pertanyaan</label>
						<textarea name="question_text" id="qText" class="form-control" rows="3" required></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label">Bobot Nilai (Opsional)</label>
						<input type="number" name="weight" id="qWeight" class="form-control" value="100">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan Soal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="gradeForm">
				<div class="modal-header bg-success text-white">
					<h5 class="modal-title" id="gradeModalLabel">Penilaian: <span id="studentNameLabel"></span></h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="submission_id" id="submissionId">

					<div class="row">
						<div class="col-md-7 border-end">
							<h6 class="fw-bold">Jawaban Siswa:</h6>
							<div class="p-3 bg-light rounded" id="studentAnswerContent" style="min-height: 200px; max-height:400px; overflow-y:auto;">
							</div>
						</div>

						<div class="col-md-5">
							<h6 class="fw-bold">Feedback Guru:</h6>
							<div class="mb-3">
								<label class="form-label">Nilai (0-100)</label>
								<input type="number" name="grade" id="gradeInput" class="form-control" min="0" max="100" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Catatan / Feedback</label>
								<textarea name="feedback" id="feedbackInput" class="form-control" rows="5" placeholder="Berikan masukan..."></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-success">Simpan Nilai</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	window.BASE_URL = "<?= base_url(); ?>";
	window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
</script>
<script type="module" src="<?= base_url('assets/js/pbl_esai_detail.js'); ?>"></script>