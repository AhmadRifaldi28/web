<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url($url_name . '/pbl/tahap3/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 3</a>
    <a href="<?= base_url($url_name . '/pbl/tahap5/' . $class_id); ?>" 
    class="btn btn-outline-primary mt-3">
      <i class="bi bi-list-task"></i> Lanjut ke Tahap 5 – Refleksi & Evaluasi Akhir
    </a>
  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
         value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <ul class="nav nav-tabs mb-3" id="pblTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="solusi-tab" data-bs-toggle="tab" data-bs-target="#solusi"
        type="button" role="tab">Aktivitas Esai Solusi</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="evaluasi-tab" data-bs-toggle="tab" data-bs-target="#evaluasi"
        type="button" role="tab">Kuis Evaluasi</button>
    </li>
  </ul>

  <div class="tab-content" id="pblTabContent">
    
    <!-- Tab 1: Aktivitas Esai Solusi -->
    <div class="tab-pane fade show active" id="solusi" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Aktivitas Esai</h5>
        <button class="btn btn-primary btn-sm" id="btnAddEsai">+ Tambah Esai</button>
      </div>
      <table class="table table-bordered table-hover" id="esaiTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Deskripsi/Instruksi</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <!-- Tab 2: Kuis Evaluasi -->
    <div class="tab-pane fade" id="evaluasi" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Kuis Evaluasi</h5>
        <button class="btn btn-primary btn-sm" id="btnAddKuisEvaluasi">+ Tambah Kuis</button>
      </div>
      <table class="table table-bordered table-hover" id="kuisEvaluasiTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Deskripsi Singkat</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    
  </div>
</div>

<!-- Modal 1: Esai Solusi -->
<div class="modal fade" id="esaiModal" tabindex="-1" aria-labelledby="esaiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="esaiForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="esaiModalLabel">Form Aktivitas Esai</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="esaiId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">
          
          <div class="mb-3">
            <label for="esaiTitle" class="form-label">Judul Aktivitas Esai</label>
            <input type="text" name="title" id="esaiTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="esaiDescription" class="form-label">Deskripsi / Instruksi Esai</label>
            <textarea name="description" id="esaiDescription" class="form-control" rows="5"></textarea>
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

<!-- Modal 2: Kuis Evaluasi -->
<div class="modal fade" id="evaluasiModal" tabindex="-1" aria-labelledby="evaluasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="evaluasiForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="evaluasiModalLabel">Form Kuis Evaluasi</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="evaluasiId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">

          <div class="mb-3">
            <label for="evaluasiTitle" class="form-label">Judul Kuis Evaluasi</label>
            <input type="text" name="title" id="evaluasiTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="evaluasiDescription" class="form-label">Deskripsi Singkat</label>
            <textarea name="description" id="evaluasiDescription" class="form-control" rows="3"></textarea>
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
<script type="module" src="<?= base_url('assets/js/pbl_tahap4.js'); ?>"></script>