<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= isset($title) ? $title : 'Dashboard Siswa'; ?> - Learner</title>

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/favicon.png') ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Raleway:wght@400;500;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/aos/aos.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet">
  <style>
    /* Warna utama untuk navbar */
    .navbar-custom {
      background-color: rgb(100, 145, 241);
      padding: 5;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* Warna biru yang lembut dan profesional */
    }

    /* Mengubah warna teks logo dan link menjadi putih */
    .navbar-custom .logo h1,
    .navbar-custom .navmenu a,
    .navbar-custom .dropdown-toggle,
    .navbar-custom .mobile-nav-toggle {
      color: #ffffff;
    }

    /* Menghilangkan bayangan teks jika ada */
    .navbar-custom .logo h1 {
      text-shadow: none;
    }

    /* Mengganti warna default navbar atas */
    .navbar-custom {
      background-color: #ffffff;
      /* Navbar atas menjadi putih */
    }

    .navbar-custom .navbar-brand {
      font-weight: 700;
      color: #2c3e50;
    }

    /* Mengganti warna ikon hamburger */
    .navbar-custom .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(44, 62, 80, 0.7)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Styling untuk offcanvas/sidebar */
    .offcanvas {
      background-color: #2c3e50;
      /* Warna biru gelap yang modern */
    }

    /* Seksi Profil */
    .profile-section img {
      border: 3px solid #4e6a85;
    }

    .profile-section h6 {
      font-weight: 600;
      color: #fff;
    }

    /* Styling untuk item navigasi di dalam offcanvas */
    .offcanvas-nav .nav-item {
      margin-bottom: 0.5rem;
    }

    .offcanvas-nav .nav-link {
      display: flex;
      align-items: center;
      padding: 12px 15px;
      border-radius: 8px;
      color: #bdc3c7;
      /* Warna abu-abu terang untuk teks */
      transition: background-color 0.3s, color 0.3s;
    }

    .offcanvas-nav .nav-link:hover,
    .offcanvas-nav .nav-link.active {
      background-color: #34495e;
      /* Warna latar belakang saat aktif/hover */
      color: #ffffff;
      /* Teks menjadi putih */
    }

    .offcanvas-nav .nav-link i {
      font-size: 1.1rem;
    }

    /* Styling khusus untuk tombol logout */
    .logout-link:hover {
      background-color: #e74c3c !important;
      /* Warna merah saat hover */
      color: #ffffff !important;
    }
  </style>
</head>

<body class="index-page">

  <nav class="navbar fixed-top navbar-custom shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Learner</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAppNavbar" aria-controls="offcanvasAppNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasAppNavbar" aria-labelledby="offcanvasAppNavbarLabel">
        <div class="offcanvas-body">
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          <div class="profile-section text-center mb-4">
            <img src="https://via.placeholder.com/80" alt="Avatar" class="rounded-circle mb-2">
            <h6 class="mb-0">Nama Siswa</h6>
            <small class="text-white-50">Siswa</small>
          </div>
          <hr>

          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasAppNavbarLabel">Menu Navigasi</h5>
          </div>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 offcanvas-nav">
            <li class="nav-item">
              <a class="nav-link active" href="<?= base_url('dashboard/guru') ?>"><i class="bi bi-house-fill me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-person-circle me-2"></i>Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-journal-text me-2"></i>Materi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-chat-dots me-2"></i>Diskusi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-file-earmark-check me-2"></i>Tugas</a>
            </li>
            <li class="nav-item mt-4">
              <a class="nav-link logout-link" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <main class="main">