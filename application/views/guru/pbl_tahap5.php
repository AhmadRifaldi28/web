<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 4</a>
    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>" class="btn btn-info">← Kembali ke Kelas</a>
  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
         value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <ul class="nav nav-tabs mb-3" id="pblTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="refleksi-tab" data-bs-toggle="tab" data-bs-target="#refleksi"
        type="button" role="tab">Refleksi Akhir</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tts-tab" data-bs-toggle="tab" data-bs-target="#tts"
        type="button" role="tab">TTS Penutup</button>
    </li>
  </ul>

  <div class="tab-content" id="pblTabContent">
    
    <div class="tab-pane fade show active" id="refleksi" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Refleksi Akhir</h5>
        <button class="btn btn-primary btn-sm" id="btnAddRefleksi">+ Tambah Refleksi</button>
      </div>
      <table class="table table-bordered table-hover" id="refleksiTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Deskripsi/Instruksi</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="tts" role="tabpanel">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar TTS Penutup</h5>
        <button class="btn btn-primary btn-sm" id="btnAddTtsPenutup">+ Tambah TTS</button>
      </div>
      <table class="table table-bordered table-hover" id="ttsPenutupTable">
        <thead class="table-light">
          <tr><th>No</th><th>Judul</th><th>Ukuran Grid</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    
  </div>
</div>

<div class="modal fade" id="refleksiModal" tabindex="-1" aria-labelledby="refleksiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="refleksiForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="refleksiModalLabel">Form Refleksi Akhir</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="refleksiId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">
          
          <div class="mb-3">
            <label for="refleksiTitle" class="form-label">Judul Refleksi</label>
            <input type="text" name="title" id="refleksiTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="refleksiDescription" class="form-label">Deskripsi / Instruksi</label>
            <textarea name="description" id="refleksiDescription" class="form-control" rows="5"></textarea>
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

<div class="modal fade" id="ttsPenutupModal" tabindex="-1" aria-labelledby="ttsPenutupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <form id="ttsPenutupForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title mb-0" id="ttsPenutupModalLabel">Form TTS Penutup</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="ttsPenutupId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">

          <div class="mb-3">
            <label for="ttsPenutupTitle" class="form-label">Judul TTS</label>
            <input type="text" name="title" id="ttsPenutupTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="ttsPenutupGridData" class="form-label">Ukuran Grid (misal: 15)</label>
            <input type="number" name="grid_data" id="ttsPenutupGridData" class="form-control" placeholder="15" required>
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
<script type="module" src="<?= base_url('assets/js/pbl_tahap5.js'); ?>"></script>