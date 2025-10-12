<div class="container mt-4">
    <h3 class="mb-3">Daftar Materi</h3>

    <?php if ($this->session->userdata('role') == 'guru'): ?>
        <a href="<?= site_url('materi/create'); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Materi
        </a>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($materi as $m): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $m->judul; ?></h5>
                        <p class="card-text"><?= $m->deskripsi, 15; ?></p>
                        <a href="<?= site_url('materi/view/' . $m->id); ?>" class="btn btn-outline-primary mt-auto">Lihat Materi</a>
                    </div>
                    <?php if ($this->session->userdata('role') == 'guru'): ?>
                        <div class="card-footer">
                            <a href="<?= site_url('materi/edit/' . $m->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= site_url('materi/delete/' . $m->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus materi ini?')">Hapus</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>