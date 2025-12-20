<style>
/* ===== TABLE RESPONSIVE PBL ===== */
#rekapTable {
  min-width: 720px !important;
}

.table-responsive {
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch;
}

#rekapTable thead th {
  background: #e0efff !important;
}

/* Responsive Styles */
@media (max-width: 768px) {
  #rekapTable thead th{
    position: sticky;
    top: 0;
    z-index: 2;
  }
}

@media (max-width: 576px) {
  #rekapTable td { white-space: nowrap; }
}

</style>
<div class="container-fluid">
  <div class="pagetitle mb-3">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url($url_name . '/dashboard/class_detail/' . $class_id) ?>">
            PBL
          </a>
        </li>
        <li class="breadcrumb-item active">Refleksi & Evaluasi Akhir</li>
      </ol>
    </nav>
  </div>

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 4</a>
      <button class="btn btn-success disabled" disabled><i class="bi bi-check-circle"></i> Project Selesai</button>
  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
         value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0 card-title"><i class="bi bi-table me-1"></i> 
        <strong class="text-dark">Rekapitulasi Nilai Siswa</strong>
      </h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="rekapTable">
          <thead class="table-light">
            <tr>
              <th style="width:60px">No</th>
              <th>Nama Siswa</th>
              <th class="text-cente">Quiz & TTS</th>
              <th class="text-cente">Observasi</th>
              <th class="text-cente">Esai</th>
              <th class="text-cente fw-bold text-primary">Total Skor</th>
              <th width="12%" class="text-cente">Aksi</th>
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
      <form id="refleksiForm" autocomplete="off">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="refleksiModalLabel">Input Refleksi & Feedback</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="modalUserId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">
          
          <div class="mb-3">
            <label class="form-label fw-bold">Siswa:</label>
            <input type="text" class="form-control-plaintext" id="modalStudentName" readonly value="-">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="teacherReflection" class="form-label">Catatan Refleksi Guru</label>
              <textarea name="teacher_reflection" id="teacherReflection" class="form-control" rows="6" 
                placeholder="Tuliskan catatan refleksi mengenai performa siswa..."></textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label for="studentFeedback" class="form-label">Feedback untuk Siswa</label>
              <textarea name="student_feedback" id="studentFeedback" class="form-control" rows="6" 
                placeholder="Pesan yang akan dibaca oleh siswa..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Refleksi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  window.BASE_URL = "<?= base_url(); ?>";
  window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
  window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
  window.URL_NAME = '<?= $url_name; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/pbl_tahap5.js'); ?>"></script>