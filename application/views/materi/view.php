<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-uppercase mb-0 text-primary">
            <?= strtoupper(htmlspecialchars($materi->judul)); ?>
        </h4>
        <a href="<?= site_url('materi'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <hr class="mt-2 mb-4">

    <!-- Card Detail -->
    <div class="card shadow border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-secondary mb-0">
                <i class="bi bi-journal-text me-2"></i> Detail Materi
            </h6>
            <small class="text-muted">
                <i class="bi bi-calendar3"></i>
                <?= date('d F Y, H:i', strtotime($materi->created_at)); ?>
            </small>
        </div>

        <div class="card-body p-4">

            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-secondary">Judul Materi</div>
                <div class="col-md-9"><?= htmlspecialchars($materi->judul); ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-secondary">Deskripsi</div>
                <div class="col-md-9"><?= nl2br(htmlspecialchars($materi->deskripsi)); ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-secondary">File Materi</div>
                <div class="col-md-9">
                    <?php if (!empty($materi->file_path)): ?>
                        <?php
                        $file_url = base_url($materi->file_path);
                        $ext = strtolower(pathinfo($materi->file_path, PATHINFO_EXTENSION));
                        $is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'mp4']);
                        ?>

                        <?php if ($is_image): ?>
                            <!-- Jika gambar, langsung download -->
                            <a href="<?= $file_url; ?>" download class="btn btn-success btn-sm">
                                <i class="bi bi-download"></i> Unduh Gambar
                            </a>
                        <?php else: ?>
                            <!-- Jika bukan gambar, tampilkan tombol lihat -->
                            <a href="<?= $file_url; ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Lihat File
                            </a>
                        <?php endif; ?>

                    <?php else: ?>
                        <em class="text-muted">Tidak ada file diunggah</em>
                    <?php endif; ?>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-secondary">Dibuat Oleh</div>
                <div class="col-md-9"><?= htmlspecialchars($materi->created_by ?? 'Admin'); ?></div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 fw-bold text-secondary">Tanggal Dibuat</div>
                <div class="col-md-9"><?= date('Y-m-d H:i:s', strtotime($materi->created_at)); ?></div>
            </div>

            <div class="text-end">
                <a href="<?= site_url('materi/edit/' . $materi->id); ?>" class="btn btn-warning btn-sm me-2">
                    <i class="bi bi-pencil"></i> Edit Materi
                </a>
                <a href="<?= site_url('materi'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Tambahkan sedikit CSS agar mirip dengan tampilan seperti gambar -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 10px;
    }

    .table th {
        background-color: #f1f3f5;
    }

    .fw-bold.text-primary {
        color: #0d6efd !important;
    }
</style>