<style>
  .table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch; /* smooth scroll di iOS */
}

.table-responsive::-webkit-scrollbar {
  height: 8px;
}

.table-responsive::-webkit-scrollbar-thumb {
  background-color: #d1d1d1;
  border-radius: 10px;
}

.table-responsive:hover::-webkit-scrollbar-thumb {
  background-color: #999;
}

</style>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <h3 class="mb-2">Kelola Forum Diskusi</h3>
    <div class="d-flex align-items-center">
      <input type="text" id="searchForum" class="form-control me-2" placeholder="Cari forum atau nama guru..." style="width:250px;">
      <button class="btn btn-primary" id="btnTambah">
        <i class="bi bi-plus-circle"></i> Tambah Forum
      </button>
    </div>
  </div>

  <!-- Modern Table -->
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover" id="tabelForum">
          <thead class="table-light border-bottom">
            <tr>
              <th width="5%">#</th>
              <th>Judul</th>
              <th>Dibuat oleh</th>
              <th>Tanggal</th>
              <th width="15%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody id="forumList">
            <?php $no = 1; foreach($forum as $f): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="fw-semibold"><?= htmlentities($f->judul); ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlentities($f->nama_guru); ?></span></td>
                <td><?= date('d M Y H:i', strtotime($f->tanggal)); ?></td>
                <td class="text-center">
                  <a href="<?= base_url('guru/forum/thread/'.$f->id) ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-chat-text"></i> Buka
                  </a>
                  <button class="btn btn-warning btn-sm btnEdit m-2 m-lg-0" data-id="<?= $f->id ?>" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="btn btn-danger btn-sm btnHapus" data-id="<?= $f->id ?>" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForum" tabindex="-1">
  <div class="modal-dialog">
    <form id="formForum" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-chat-text"></i> Tambah Forum</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">

        <div class="mb-3">
          <label>Judul Forum</label>
          <input type="text" name="judul" id="judul" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>


<!-- jQuery & Bootstrap -->
<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>

<script>
$(function(){
  let delayTimer;

  $('#searchForum').on('keyup', function(){
    clearTimeout(delayTimer);
    const keyword = $(this).val();

    delayTimer = setTimeout(() => {
      $.ajax({
        url: '<?= base_url("guru/forum") ?>',
        type: 'GET',
        data: {q: keyword},
        dataType: 'json',
        success: function(res){
          let html = '';
          if (res.length > 0) {
            let no = 1;
            res.forEach(f => {
              html += `
                <tr>
                  <td>${no++}</td>
                  <td>${f.judul}</td>
                  <td>${f.nama_guru ?? 'Tidak diketahui'}</td>
                  <td>${f.tanggal}</td>
                  <td>
                    <a href="<?= base_url('guru/forum/thread/') ?>${f.id}" class="btn btn-outline-primary btn-sm">
                      <i class="bi bi-chat-left-text"></i> Buka
                    </a>
                    <button class="btn btn-warning btn-sm btnEdit" data-id="${f.id}">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btnHapus" data-id="${f.id}">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>`;
            });
          } else {
            html = `
              <tr><td colspan="5" class="text-center text-muted py-3">
                <i class="bi bi-search"></i> Tidak ada hasil ditemukan
              </td></tr>`;
          }
          $('#forumList').html(html);
        },
        error: function(){
          console.error('Gagal memuat hasil pencarian');
        }
      });
    }, 1200); // delay 0.4 detik setelah user berhenti mengetik
  });
});
</script>


<script>
$(document).ready(function(){
  const modalEl = document.getElementById('modalForum');
  const modal = new bootstrap.Modal(modalEl);

  let csrfName = $('meta[name="csrf-name"]').attr('content');
  let csrfHash = $('meta[name="csrf-hash"]').attr('content');

  // Tambah Forum
  $('#btnTambah').on('click', function(){
    $('#formForum')[0].reset();
    $('#id').val('');
    $('.modal-title').html('<i class="bi bi-chat-text"></i> Tambah Forum');
    modal.show();
  });

  // Delegated event: Edit Forum
  $(document).on('click', '.btnEdit', function(){
    const id = $(this).data('id');
    $.ajax({
      url: '<?= base_url("guru/forum/get_forum/") ?>' + id,
      type: 'GET',
      dataType: 'json',
      success: function(res){
        if (res) {
          $('#id').val(res.id);
          $('#judul').val(res.judul);
          $('#materi_id').val(res.materi_id);
          $('.modal-title').html('<i class="bi bi-pencil-square"></i> Edit Forum');
          modal.show();
        } else {
          Swal.fire('Oops!', 'Data forum tidak ditemukan!', 'warning');
        }
      },
      error: function(){
        Swal.fire('Gagal', 'Tidak dapat mengambil data forum.', 'error');
      }
    });
  });

  // Simpan Forum (Tambah/Edit)
  $('#formForum').on('submit', function(e){
    e.preventDefault();
    const formData = $(this).serializeArray();
    formData.push({ name: csrfName, value: csrfHash });

    $.ajax({
      url: '<?= base_url("guru/forum/save") ?>',
      type: 'POST',
      data: $.param(formData),
      dataType: 'json',
      success: function(res){
        Swal.close();
        if(res.status === 'success'){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: res.message,
            timer: 1500,
            showConfirmButton: false
          });
          modal.hide();

          // Refresh tabel tanpa reload
          $('#tabelForum').load(location.href + " #tabelForum>*", "");
        } else {
          Swal.fire('Gagal', res.message || 'Gagal menyimpan data.', 'error');
        }

        if(res.csrfName && res.csrfHash){
          csrfName = res.csrfName;
          csrfHash = res.csrfHash;
        }
      },
      error: function(){
        Swal.fire('Gagal', 'Terjadi kesalahan koneksi atau token CSRF.', 'error');
      }
    });
  });

  // Hapus Forum
  $(document).on('click', '.btnHapus', function(){
    const id = $(this).data('id');

    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data forum akan dihapus permanen!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
    }).then((result) => {
      if(result.isConfirmed){
        $.ajax({
          url: '<?= base_url("guru/forum/delete/") ?>' + id,
          type: 'POST',
          data: {[csrfName]: csrfHash},
          dataType: 'json',
          success: function(res){
            Swal.fire({
              icon: res.status === 'success' ? 'success' : 'error',
              title: res.message,
              timer: 1500,
              showConfirmButton: false
            });

            if(res.status === 'success'){
              $('#tabelForum').load(location.href + " #tabelForum>*", "");
            }

            if(res.csrfName && res.csrfHash){
              csrfName = res.csrfHash;
              csrfHash = res.csrfHash;
            }
          },
          error: function(){
            Swal.fire('Gagal', 'Tidak dapat menghapus data. Token mungkin expired.', 'error');
          }
        });
      }
    });
  });
});
</script>


<script src="<?= base_url('assets/js/csrf.js'); ?>"></script>