<!DOCTYPE html>
<html>

<head>
    <title>Forum Diskusi Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light p-4">

    <div class="container">
        <h3 class="mb-4 text-center mt-5">Forum Diskusi</h3>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Guru</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($forum as $f): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($f->judul); ?></td>
                        <td><?= htmlspecialchars($f->nama_guru); ?></td>
                        <td><?= $f->tanggal; ?></td>
                        <td><a href="<?= base_url('siswa/forum_siswa/detail/' . $f->id); ?>" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>