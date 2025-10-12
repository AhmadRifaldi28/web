<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Platform Edukasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    /* Opsional: Menambahkan sedikit gaya untuk body */
    body {
      background-color: #f0f2f5;
    }
  </style>
</head>

<body>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-4 p-sm-5">

            <div class="text-center mb-4">
              <img src="https://via.placeholder.com/100" alt="Logo Edukasi" class="mb-3" style="width: 100px;">
              <h3 class="fw-bold">Selamat Datang 👋</h3>
              <p class="text-muted"> AYO Lanjutkan perjalanan belajarmu hari ini.</p>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                  <?= $this->session->flashdata('error'); ?>
                </div>
              </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/login_action'); ?>" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username atau Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                  <input type="text" class="form-control" id="username" name="username" placeholder="cth: nama.siswa" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary w-100 mt-2 fw-bold">Masuk</button>
            </form>

            <div class="text-center mt-4">
              <p class="text-muted">Belum punya akun? <a href="<?= site_url('auth/register'); ?>" class="fw-bold text-decoration-none">Daftar sekarang</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>