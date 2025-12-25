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

/* Styling agar tabel responsif */
#rekapTable, #reflectionTable { min-width: 800px !important; }

.table-responsive { overflow-x: auto !important; }
thead th { background: #e0efff !important; text-align: center; vertical-align: middle; }

</style>

<div class="container-fluid">
  <div class="pagetitle mb-3">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">PBL</a></li>
        <li class="breadcrumb-item active">Refleksi & Evaluasi Akhir</li>
      </ol>
    </nav>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= base_url($url_name . '/pbl/tahap4/' . $class_id) ?>" class="btn btn-secondary">← Kembali ke Tahap 4</a>
    <button class="btn btn-success disabled" disabled><i class="bi bi-check-circle"></i> Project Selesai</button>
  </div>

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" id="classIdHidden" value="<?= $class_id; ?>">

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0 card-title text-primary"><i class="bi bi-bar-chart-line me-1"></i> Rekap Nilai Siswa</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle" id="rekapTable">
          <thead class="table-light">
            <tr>
              <th width="5%">No</th>
              <th>Nama Siswa</th>
              <th>Quiz (Avg)</th>
              <th>TTS (Avg)</th>
              <th>Observasi</th>
              <th>Esai</th>
              <th class="fw-bold text-primary">Nilai Akhir</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card shadow-sm border-0 mb-4 reflectionContainer">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0 card-title text-success"><i class="bi bi-pencil-square me-1"></i> Refleksi & Umpan Balik</h5>
      <small class="text-muted">Silakan input refleksi guru dan feedback untuk siswa di sini.</small>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="reflectionTable">
          <thead class="table-light">
            <tr>
              <th width="5%">No</th>
              <th>Nama Siswa</th>
              <th>Refleksi Guru</th>
              <th>Umpan Balik Siswa</th>
              <th width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="refleksiModal" tabindex="-1" aria-labelledby="refleksiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form id="refleksiForm" autocomplete="off">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="refleksiModalLabel">Input Refleksi</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="modalUserId">
          <input type="hidden" name="class_id" value="<?= $class_id; ?>">
          
          <div class="mb-3">
            <label class="form-label fw-bold">Siswa:</label>
            <input type="text" class="form-control-plaintext border-bottom" id="modalStudentName" readonly value="-">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="teacherReflection" class="form-label fw-bold">Catatan Refleksi Guru</label>
              <textarea name="teacher_reflection" id="teacherReflection" class="form-control" rows="5" 
                placeholder="Catatan internal guru tentang siswa ini..."></textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label for="studentFeedback" class="form-label fw-bold">Umpan Balik (Dibaca Siswa)</label>
              <textarea name="student_feedback" id="studentFeedback" class="form-control" rows="5" 
                placeholder="Pesan semangat atau masukan untuk siswa..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  window.BASE_URL = "<?= base_url(); ?>";
  window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
  window.CURRENT_CLASS_ID = '<?= $class_id; ?>';
</script>
<script type="module" src="<?= base_url('assets/js/pbl_tahap5.js'); ?>"></script>