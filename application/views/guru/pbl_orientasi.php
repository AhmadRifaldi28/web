<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>" class="btn btn-secondary">
      ← Kembali ke Kelas
    </a>
    <a href="<?= base_url($url_name . '/pbl/tahap2/' . $class_id); ?>" 
    class="btn btn-outline-primary mt-3">
      <i class="bi bi-list-task"></i> Lanjut ke Tahap 2 – Organisasi Belajar
    </a>

  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
         value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-2">
        <h5>Daftar Skenario Masalah</h5>
        <?php if ($is_admin_or_guru): ?>
          <button class="btn btn-primary btn-sm" id="btnAddPbl">+ Tambah</button>
        <?php endif; ?>
      </div>

      <table class="table table-bordered" id="pblTable" style="width:100%">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Refleksi Awal</th>
            <th>File</th>
            <?php if ($is_admin_or_guru): ?>
              <th>Aksi</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<?php if ($is_admin_or_guru): ?>
<div class="modal fade" id="pblModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="pblForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="pblModalLabel">Tambah / Edit Skenario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="pblId" name="id">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" class="form-control" name="title" id="pblTitle" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Refleksi Awal</label>
            <textarea class="form-control" name="reflection" id="pblReflection" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Upload Materi (opsional)</label>
            <input type="file" class="form-control" name="file" id="pblFile">
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
<?php endif; ?>

<!-- VARIABEL GLOBAL -->
<script>
  window.BASE_URL = "<?= base_url(); ?>";
  window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
  window.IS_ADMIN_OR_GURU = <?= $is_admin_or_guru ? 'true' : 'false' ?>;
  window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
</script>

<!-- MODULAR SCRIPT -->
<script type="module" src="<?= base_url('assets/js/pbl_orientasi.js'); ?>"></script>