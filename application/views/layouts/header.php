<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
  <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">


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

</head>

<body class="index-page">
  <!-- Header -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="<?= base_url('dashboard/siswa') ?>" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Learner</h1>
      </a>

      <?php 
        $segment1 = $this->uri->segment(1); // contoh: guru
        $segment2 = $this->uri->segment(2); // contoh: forum
        $currentPath = $segment1 . '/' . $segment2; // hasil: guru/forum
        ?>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="<?= base_url('dashboard/guru') ?>" class="<?= ($currentPath == 'dashboard/guru') ? 'active' : '' ?>">Home</a></li>
            <li><a href="<?= base_url('materi') ?>" class="<?= ($segment1 == 'materi') ? 'active' : '' ?>">Materi</a></li>
            <li><a href="<?= base_url('guru/kuis') ?>" class="<?= ($currentPath == 'guru/kuis' || $currentPath == 'siswa/kuis') ? 'active' : '' ?>">Kuis</a></li>
            <li><a href="<?= base_url('guru/forum') ?>" class="<?= ($currentPath == 'guru/forum' || $currentPath == 'siswa/forum') ? 'active' : '' ?>">Forum</a></li>
            <li><a href="<?= base_url('guru/kelas') ?>" class="<?= ($currentPath == 'guru/kelas' || $currentPath == 'siswa/kelas') ? 'active' : '' ?>">Kelas</a></li>
            <li><a href="<?= base_url('guru/siswa') ?>" class="<?= ($currentPath == 'guru/siswa' || $currentPath == 'siswa/siswa') ? 'active' : '' ?>">Siswa</a></li>
            <li><a href="<?= base_url('auth/logout') ?>">Logout</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>
    </header>

    <main class="main">
