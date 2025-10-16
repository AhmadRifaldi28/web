<link href="<?= base_url('assets/css/simple-datatables.css') ?>" rel="stylesheet">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Kelola Data Siswa</h4>
    <button class="btn btn-primary" id="btnTambah"><i class="bi bi-plus-lg"></i> Tambah</button>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle" id="tabelSiswa">
      <thead class="bg-light">
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Email</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach($siswa as $s): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlentities($s->name) ?></td>
            <td><?= htmlentities($s->username) ?></td>
            <td><?= htmlentities($s->email) ?></td>
            <td><?= date('d M Y', strtotime($s->created_at)) ?></td>
            <td>
              <button class="btn btn-warning btn-sm btnEdit" data-id="<?= $s->id ?>"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-danger btn-sm btnHapus" data-id="<?= $s->id ?>"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalSiswa" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formSiswa">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control" name="name" id="name" required>
          </div>
          <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" name="username" id="username" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/simple-datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
$(function(){
  const dataTable = new simpleDatatables.DataTable("#tabelSiswa");
  const modal = new bootstrap.Modal('#modalSiswa');

  // Tambah
  $('#btnTambah').click(() => {
    $('#formSiswa')[0].reset();
    $('#id').val('');
    $('.modal-title').text('Tambah Siswa');
    modal.show();
  });

  // Edit
  $(document).on('click', '.btnEdit', function(){
    const id = $(this).data('id');
    $.getJSON('<?= base_url("guru/siswa/get/") ?>' + id, function(data){
      $('#id').val(data.id);
      $('#name').val(data.name);
      $('#username').val(data.username);
      $('#email').val(data.email);
      $('.modal-title').text('Edit Siswa');
      modal.show();
    });
  });

  // Simpan
  $('#formSiswa').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: '<?= base_url("guru/siswa/save") ?>',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res){
        Swal.fire({
          icon: res.status === 'success' ? 'success' : 'error',
          title: res.message,
          showConfirmButton: false,
          timer: 1500
        });
        if(res.status === 'success') {
          modal.hide();
          $('#tabelSiswa').load(location.href + " #tabelSiswa>*", "");
        }
      }
    });
  });

  // Hapus
  $(document).on('click', '.btnHapus', function(){
    const id = $(this).data('id');
    Swal.fire({
      icon: 'warning',
      title: 'Hapus siswa ini?',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(result => {
      if(result.isConfirmed){
        $.post('<?= base_url("guru/siswa/delete/") ?>' + id, function(res){
          const data = JSON.parse(res);
          Swal.fire({
            icon: data.status === 'success' ? 'success' : 'error',
            title: data.message,
            timer: 1500,
            showConfirmButton: false
          });
          $('#tabelSiswa').load(location.href + " #tabelSiswa>*", "");
        });
      }
    });
  });
});
</script>
