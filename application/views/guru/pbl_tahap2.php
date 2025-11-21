<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url($url_name . '/pbl/index/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 1</a>
    <a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id); ?>" 
    class="btn btn-outline-primary mt-3">
      <i class="bi bi-list-task"></i> Lanjut ke Tahap 3 – Penyelidikan Mandiri & Kelompok
    </a>
  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
         value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <ul class="nav nav-tabs mb-3" id="pblTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz"
        type="button" role="tab">Kuis</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tts-tab" data-bs-toggle="tab" data-bs-target="#tts"
        type="button" role="tab">Teka-Teki Silang</button>
    </li>
  </ul>

  <div class="tab-content" id="pblTabContent">
    <div class="tab-pane fade show active" id="quiz" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Kuis</h5>
        <button class="btn btn-primary btn-sm" id="btnAddQuiz">+ Tambah Kuis</button>
      </div>
      <table class="table table-bordered" id="quizTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Deskripsi</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="tts" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Teka-Teki Silang</h5>
        <button class="btn btn-primary btn-sm" id="btnAddTts">+ Tambah TTS</button>
      </div>
      <table class="table table-bordered" id="ttsTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Grid</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="quizForm" autocomplete="off">
        
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="quizModalLabel">Form Kuis</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="quizId">
          <input type="hidden" name="class_id" id="quizClassId" value="<?= $class_id; ?>">
          
          <div class="mb-3">
            <label for="quizTitle" class="form-label">Judul Kuis</label>
            <input type="text" name="title" id="quizTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="quizDescription" class="form-label">Deskripsi</label>
            <textarea name="description" id="quizDescription" class="form-control" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ttsModal" tabindex="-1" aria-labelledby="ttsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="ttsForm" autocomplete="off">
        
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="ttsModalLabel">Form Teka-Teki Silang</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="ttsId">
          <input type="hidden" name="class_id" id="ttsClassId" value="<?= $class_id; ?>">

          <div class="mb-3">
            <label for="ttsTitle" class="form-label">Judul TTS</label>
            <input type="text" name="title" id="ttsTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="ttsGridData" class="form-label">Data Grid</label>
            <input type="number" name="grid_data" id="ttsGridData" class="form-control">
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        
      </form>
    </div>
  </div>
</div>


<script>
  window.BASE_URL = "<?= base_url(); ?>";
  window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
  window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
  window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
  window.URL_NAME = '<?= $url_name; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/pbl_tahap2.js'); ?>"></script>