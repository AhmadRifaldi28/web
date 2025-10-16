<link href="<?= base_url('assets/css/simple-datatables.css') ?>" rel="stylesheet">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?= $title; ?></h4>
    <a href="<?= base_url('guru/kelas'); ?>" class="btn btn-secondary">← Kembali</a>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <h5><?= $kelas->nama_kelas; ?></h5>
      <p><strong>Kode Kelas:</strong> <span class="badge bg-primary"><?= $kelas->kode_kelas; ?></span></p>
      <p><?= $kelas->deskripsi; ?></p>
      <p>Jumlah Siswa: <span id="jumlah-siswa"><?= $jumlah; ?></span></p></p>
    </div>
  </div>

  <div class="d-flex justify-content-between mb-2">
    <h5>Daftar Siswa</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#siswaModal">+ Tambah Siswa</button>
  </div>

  <table class="table table-bordered" id="siswaTable">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Email</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="tbody-siswa">
      <?php $no=1; foreach($anggota as $a): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $a->name; ?></td>
        <td><?= $a->username; ?></td>
        <td><?= $a->email; ?></td>
        <td>
          <button class="btn btn-sm btn-danger delete-siswa" data-id="<?= $a->rel_id; ?>">Hapus</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="siswaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="siswaForm">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Siswa ke Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="kelas_id" value="<?= $kelas->id; ?>">
          <div class="mb-3">
            <label>Pilih Siswa</label>
            <select class="form-select" name="siswa_id" required>
              <option value="">-- Pilih Siswa --</option>
              <?php foreach($siswa_list as $s): ?>
              <option value="<?= $s->id; ?>"><?= $s->name; ?> (<?= $s->username; ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/simple-datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.js') ?>"></script>
<script>
$(document).ready(function(){
  const dataTable = new simpleDatatables.DataTable("#siswaTable");

  // Tambah siswa (AJAX)
  $('#siswaForm').submit(function(e){
    e.preventDefault();
    $.post('<?= base_url("guru/kelas/add_siswa"); ?>', $(this).serialize(), function(res){
      let data = JSON.parse(res);
      if(data.status === 'exists'){
        Swal.fire('Gagal', 'Siswa sudah terdaftar di kelas ini!', 'warning');
      } else if(data.status === 'success'){
        Swal.fire('Berhasil', 'Siswa berhasil ditambahkan!', 'success');
        $('#siswaModal').modal('hide');
        loadSiswa();
        updateJumlahSiswa();
      }
    });
  });

  // Hapus siswa (AJAX)
  $(document).on('click', '.delete-siswa', function(){
    let id = $(this).data('id');
    Swal.fire({
      title: 'Hapus siswa ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!'
    }).then(result=>{
      if(result.isConfirmed){
        $.get('<?= base_url("guru/kelas/remove_siswa/"); ?>'+id, function(){
          Swal.fire('Dihapus!', 'Data siswa dihapus.', 'success');
          loadSiswa();
          updateJumlahSiswa();
        });
      }
    });
  });

  // Reload tabel siswa tanpa reload halaman
  function loadSiswa(){
    $.get('<?= base_url("guru/kelas/detail/".$kelas->id); ?>', function(html){
      let tbody = $(html).find('#tbody-siswa').html();
      $('#tbody-siswa').html(tbody);
    });
  }
  // Update jumlah siswa (dinamis)
  function updateJumlahSiswa(){
    $.get('<?= base_url("guru/kelas/count_siswa/".$kelas->id); ?>', function(res){
      let data = JSON.parse(res);
      $('#jumlah-siswa').text(data.jumlah);
    });
  }
});
</script>
