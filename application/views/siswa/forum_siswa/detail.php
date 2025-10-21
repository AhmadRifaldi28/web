<!DOCTYPE html>
<html>

<head>
    <title><?= $forum->judul; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light p-4">

    <div class="container">
        <h3><?= $forum->judul; ?></h3>
        <p class="text-muted">Dibuat oleh: <?= $forum->nama_guru; ?> | <?= $forum->tanggal; ?></p>
        <hr>

        <h5>Komentar:</h5>
        <?php if (!empty($komentar)): ?>
            <?php foreach ($komentar as $k): ?>
                <div class="card mb-2">
                    <div class="card-body">
                        <strong><?= $k->nama_user; ?></strong>
                        <p><?= nl2br(htmlspecialchars($k->isi_komentar)); ?></p>
                        <small class="text-muted"><?= $k->tanggal; ?></small>

                        <?php if ($this->session->userdata('user_id') == $k->user_id): ?>
                            <a href="<?= base_url('siswa/forum_siswa/hapus_komentar/' . $k->id); ?>"
                                class="btn btn-sm btn-danger float-end"
                                onclick="return confirm('Yakin ingin menghapus komentar ini?')">Hapus</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada komentar.</p>
        <?php endif; ?>

        <hr>
        <form action="<?= base_url('siswa/forum_siswa/tambah_komentar'); ?>" method="POST">
            <input type="hidden" name="forum_id" value="<?= $forum->id; ?>">
            <div class="mb-3">
                <textarea name="isi_komentar" class="form-control" placeholder="Tulis komentar..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
    </div>

</body>

</html>