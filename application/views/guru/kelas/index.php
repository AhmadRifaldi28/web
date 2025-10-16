<link href="<?= base_url('assets/css/simple-datatables.css') ?>" rel="stylesheet">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?= $title; ?></h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kelasModal">+ Tambah Kelas</button>
  </div>

  <table class="table table-bordered" id="kelasTable">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Nama Kelas</th>
        <th>Kode Kelas</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach($kelas as $k): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $k->nama_kelas; ?></td>
        <td><span><?= $k->kode_kelas; ?></span></td>
        <td><?= $k->deskripsi; ?></td>
        <td>
          <a href="<?= base_url('guru/kelas/detail/'.$k->id); ?>" class="btn btn-sm btn-info">Detail</a>
          <button class="btn btn-sm btn-warning edit-btn" 
            data-id="<?= $k->id; ?>" 
            data-nama="<?= $k->nama_kelas; ?>" 
            data-deskripsi="<?= $k->deskripsi; ?>">Edit</button>
          <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $k->id; ?>">Hapus</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="kelasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="kelasForm">
        <div class="modal-header">
          <h5 class="modal-title">Tambah/Edit Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="kelasId" name="id">
          <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/simple-datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>

<script>
$(document).ready(function() {
  // Inisialisasi datatable
  const dataTable = new simpleDatatables.DataTable("#kelasTable");

  //  Fungsi refresh tabel via AJAX tanpa reload halaman
  function refreshTable() {
    $.get("<?= base_url('guru/kelas') ?>", function(response) {
      const tbody = $(response).find("#kelasTable tbody").html();
      $("#kelasTable tbody").html(tbody);
      dataTable.refresh();
      attachEvents(); // re-bind event tombol edit & delete
    });
  }

  //  Reset form saat modal ditutup
  $('#kelasModal').on('hidden.bs.modal', function() {
    $('#kelasForm')[0].reset();         // kosongkan semua input
    $('#kelasId').val('');              // hapus id edit
    $('#kelasModal .modal-title').text('Tambah Kelas'); // reset judul modal
  });

  //  Tambah/Edit data (AJAX)
  $('#kelasForm').submit(function(e) {
    e.preventDefault();
    const id = $('#kelasId').val();
    const url = id ? '<?= base_url("guru/kelas/update/") ?>' + id 
                   : '<?= base_url("guru/kelas/store") ?>';

    $.post(url, $(this).serialize(), function() {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: id ? 'Data kelas diperbarui!' : 'Data kelas ditambahkan!'
      });
      $('#kelasModal').modal('hide');
      refreshTable();
    });
  });

  //  Event handler edit & delete (harus dibind ulang setiap refresh)
  function attachEvents() {
    //  Edit button
    $('.edit-btn').off('click').on('click', function() {
      $('#kelasId').val($(this).data('id'));
      $('#nama_kelas').val($(this).data('nama'));
      $('#deskripsi').val($(this).data('deskripsi'));
      $('#kelasModal .modal-title').text('Edit Kelas'); // ubah judul modal
      $('#kelasModal').modal('show');
    });

    //  Delete button
    $('.delete-btn').off('click').on('click', function() {
      const id = $(this).data('id');
      Swal.fire({
        title: 'Hapus data ini?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!'
      }).then(result => {
        if (result.isConfirmed) {
          $.get('<?= base_url("guru/kelas/destroy/") ?>' + id, function() {
            Swal.fire('Dihapus!', 'Data kelas berhasil dihapus.', 'success');
            refreshTable();
          });
        }
      });
    });
  }

  //  Tombol "Tambah Kelas" (ubah judul modal otomatis)
  $('[data-bs-target="#kelasModal"]').on('click', function() {
    $('#kelasForm')[0].reset();
    $('#kelasId').val('');
    $('#kelasModal .modal-title').text('Tambah Kelas');
  });

  attachEvents(); // panggil saat pertama kali load
});
</script>


