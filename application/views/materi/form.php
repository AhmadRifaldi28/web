<div class="container mt-4">
    <h3><?= isset($materi) ? 'Edit Materi' : 'Tambah Materi'; ?></h3>
    <form action="<?= isset($materi->id) ? site_url('materi/update/' . $materi->id) : site_url('materi/simpan'); ?>"
        method="post"
        enctype="multipart/form-data">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= isset($materi) ? $materi->judul : set_value('judul'); ?>" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= isset($materi) ? $materi->deskripsi : set_value('deskripsi'); ?></textarea>
        </div>

        <div class="mb-3">
            <label>File (PDF, Gambar, Video)</label>
            <input type="file" name="file" class="form-control">
            <?php if (isset($materi) && $materi->file_path): ?>
                <small class="text-muted">File saat ini: <?= $materi->file_path; ?></small>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('materi'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>