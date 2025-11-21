<div class="container py-3">

  <!-- Header Halaman -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url('guru/pbl/tahap4/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 4</a>
  </div>

  <!-- Instruksi Esai -->
  <div class="card shadow-sm mb-3">
    <div class="card-header">
      <h5 class="mb-0">Instruksi Esai</h5>
    </div>
    <div class="card-body">
      <p class="fs-5"><?= nl2br(htmlspecialchars($essay->description, ENT_QUOTES, 'UTF-8')); ?></p>
    </div>
  </div>

  <!-- Tabel Jawaban Siswa -->
  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="mb-0">Jawaban Siswa</h5>
    </div>
    <div class="card-body" id="submissionsTableContainer">
      <table class="table table-hover" id="submissionsTable">
        <thead class="table-light">
          <tr>
            <th>Siswa</th>
            <th>Jawaban</th>
            <th>Nilai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Diisi oleh JavaScript -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Form Nilai/Feedback (Ini adalah Modal 'Edit') -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="feedbackForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="feedbackModalLabel">Beri Nilai & Feedback</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="submissionId">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                 value="<?= $this->security->get_csrf_hash(); ?>">
          
          <div class="mb-3">
            <label class="form-label">Jawaban Siswa:</label>
            <div class="card bg-light p-3" id="submissionContentPreview" style="max-height: 200px; overflow-y: auto;">
              <!-- Diisi oleh JS -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <label for="grade" class="form-label">Nilai (Angka)</label>
              <input type="number" name="grade" id="grade" class="form-control" min="0" max="100">
            </div>
            <div class="col-md-8">
              <label for="feedback" class="form-label">Feedback</label>
              <textarea name="feedback" id="feedback" class="form-control" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script Loader -->
<script>
  window.BASE_URL = "<?= base_url(); ?>";
  window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
  window.CURRENT_ESSAY_ID = "<?= $essay->id; ?>";
</script>
<script type="module" src="<?= base_url('assets/js/pbl_esai_detail.js'); ?>"></script>