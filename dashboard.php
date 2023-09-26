<?php

session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('login dulu dong');
            document.location.href = 'index.php';
          </script>";
    exit;
}

// membatasi halaman sesuai user login
if ($_SESSION["level"] != "super-admin" and $_SESSION["level"] != "admin") {
    echo "<script>
            alert('Perhatian anda tidak punya hak akses');
            window.history.back(); 
          </script>";
    exit;
  } 

$title = 'Data Akun';

include 'layout/header.php';

?>

<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
<section class="content">
  <div class="container-fluid">
      <div class="card">
          <div class="card-body">
          <!-- Jumbotron -->
<div class="jumbotron">
    <h1 class="display-7">Selamat Datang di Web Absensi</h1>
    <p class="lead">Kami membantu Anda mengelola rekap absensi dengan mudah.</p>
    <hr class="my-4">
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="absensi-akun.php" role="button">Lihat Rekap Absensi</a>
    </p>
</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include 'layout/footer.php'; ?>
