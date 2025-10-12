<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body {
      /* Ganti URL di bawah dengan link gambar Anda */
      background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070&auto=format&fit=crop');

      background-size: cover;
      /* Membuat gambar menutupi seluruh halaman */
      background-position: center;
      /* Posisi gambar di tengah */
      background-repeat: no-repeat;
      /* Mencegah gambar berulang */
      background-attachment: fixed;
      /* Membuat gambar tidak ikut scroll */
    }

    .password-toggle-icon {
      cursor: pointer;
    }
  </style>
</head>

<body>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-4 p-sm-5">

            <div class="text-center mb-4">
              <img src="https://via.placeholder.com/100" alt="Logo Edukasi" class="mb-3" style="width: 100px;">
              <h3 class="fw-bold">Mulai Petualangan Belajarmu! 🚀</h3>
              <p class="text-muted">Buat akun untuk mengakses semua materi pembelajaran.</p>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?= $this->session->flashdata('error'); ?></div>
              </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/register_action'); ?>" method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Buat username unik" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock"></i></span>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required>
                  <span class="input-group-text password-toggle-icon" id="togglePassword">
                    <i class="bi bi-eye-slash"></i>
                  </span>
                </div>
                <div class="progress mt-2" style="height: 5px;">
                  <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small id="password-strength-text" class="form-text"></small>
              </div>

              <div class="mb-3">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ketik ulang password Anda" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="role" class="form-label">Daftar Sebagai</label>
                <select name="role" id="role" class="form-select" required>
                  <option value="" disabled selected>-- Pilih Peran Anda --</option>
                  <option value="guru">Guru / Pengajar</option>
                  <option value="siswa">Siswa / Peserta Didik</option>
                </select>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                  Saya menyetujui <a href="#">Syarat & Ketentuan</a> yang berlaku.
                </label>
              </div>

              <button type="submit" class="btn btn-primary w-100 mt-2 fw-bold" id="register-btn" disabled>Buat Akun Saya</button>
            </form>

            <div class="text-center mt-4">
              <p class="text-muted">Sudah punya akun? <a href="<?= site_url('auth/login'); ?>" class="fw-bold text-decoration-none">Masuk di sini</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.querySelector('#togglePassword');
      const passwordInput = document.querySelector('#password');
      const passwordStrengthBar = document.querySelector('#password-strength-bar');
      const passwordStrengthText = document.querySelector('#password-strength-text');
      const termsCheck = document.querySelector('#termsCheck');
      const registerBtn = document.querySelector('#register-btn');

      // 1. Fungsi Tampilkan/Sembunyikan Password
      togglePassword.addEventListener('click', function(e) {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
      });

      // 2. Fungsi Cek Kekuatan Password
      passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        if (password.length >= 8) strength += 1;
        if (password.match(/[a-z]/)) strength += 1;
        if (password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

        let barClass = '';
        let text = '';
        let width = (strength / 5) * 100;

        switch (strength) {
          case 1:
          case 2:
            barClass = 'bg-danger';
            text = 'Lemah';
            break;
          case 3:
            barClass = 'bg-warning';
            text = 'Sedang';
            break;
          case 4:
          case 5:
            barClass = 'bg-success';
            text = 'Kuat';
            break;
          default:
            barClass = '';
            text = '';
        }
        passwordStrengthBar.className = 'progress-bar ' + barClass;
        passwordStrengthBar.style.width = width + '%';
        passwordStrengthText.textContent = 'Kekuatan: ' + text;
      });

      // 3. Fungsi Aktifkan Tombol Daftar setelah centang Syarat & Ketentuan
      termsCheck.addEventListener('change', function() {
        registerBtn.disabled = !this.checked;
      });
    });
  </script>
</body>

</html>