<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url($url_name . '/pbl/tahap2/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 2</a>
    <a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id); ?>" 
    class="btn btn-outline-primary mt-3">
      <i class="bi bi-list-task"></i> Lanjut ke Tahap 4 – Pengembangan Solusi
    </a>
  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
         value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <ul class="nav nav-tabs mb-3" id="pblTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="observasi-tab" data-bs-toggle="tab" data-bs-target="#observasi"
        type="button" role="tab">Ruang Observasi</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="diskusi-tab" data-bs-toggle="tab" data-bs-target="#diskusi"
        type="button" role="tab">Forum Diskusi</button>
    </li>
  </ul>

  <div class="tab-content" id="pblTabContent">
    
    <!-- Tab 1: Ruang Observasi -->
    <div class="tab-pane fade show active" id="observasi" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Ruang Upload Observasi</h5>
        <button class="btn btn-primary btn-sm" id="btnAddObservasi">+ Tambah Ruang</button>
      </div>
      <table class="table table-bordered table-hover" id="observasiTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Deskripsi</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <!-- Tab 2: Forum Diskusi -->
    <div class="tab-pane fade" id="diskusi" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Topik Diskusi</h5>
        <button class="btn btn-primary btn-sm" id="btnAddDiskusi">+ Tambah Topik</button>
      </div>
      <table class="table table-bordered table-hover" id="diskusiTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Deskripsi Singkat</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    
  </div>
</div>

<!-- Modal 1: Observasi -->
<div class="modal fade" id="observasiModal" tabindex="-1" aria-labelledby="observasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="observasiForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="observasiModalLabel">Form Ruang Observasi</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="observasiId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">
          
          <div class="mb-3">
            <label for="observasiTitle" class="form-label">Judul Ruang Observasi</label>
            <input type="text" name="title" id="observasiTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="observasiDescription" class="form-label">Deskripsi / Instruksi</label>
            <textarea name="description" id="observasiDescription" class="form-control" rows="3"></textarea>
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

<!-- Modal 2: Diskusi -->
<div class="modal fade" id="diskusiModal" tabindex="-1" aria-labelledby="diskusiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="diskusiForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="diskusiModalLabel">Form Topik Diskusi</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="diskusiId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">

          <div class="mb-3">
            <label for="diskusiTitle" class="form-label">Judul Topik Diskusi</label>
            <input type="text" name="title" id="diskusiTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="diskusiDescription" class="form-label">Deskripsi / Pancingan Diskusi</label>
            <textarea name="description" id="diskusiDescription" class="form-control" rows="3"></textarea>
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
<script type="module" src="<?= base_url('assets/js/pbl_tahap3.js'); ?>"></script>