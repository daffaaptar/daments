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

// tampil seluruh data
$data_akun = select("SELECT * FROM akun");
$data_user = select("SELECT * FROM data_absen");

// tampil data berdasarkan user login
$id_akun = $_SESSION['id_akun'];
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

// jika tombol tambah di tekan jalankan script berikut
if (isset($_POST['tambah'])) {
    // Validasi email jika sama
    $email = $_POST['email'];
    $existing_email = select("SELECT email FROM akun WHERE email = '$email'");
    if ($existing_email) {
        echo "<script>
                alert('Email sudah terdaftar. Gunakan email lain.');
                document.location.href = 'dataakun.php';
              </script>";
        exit;
    }

    // Validasi username jika sama
    $username = $_POST['username'];
    $existing_username = select("SELECT username FROM akun WHERE username = '$username'");
    if ($existing_username) {
        echo "<script>
                alert('Username sudah terdaftar. Gunakan username lain.');
                document.location.href = 'dataakun.php';
              </script>";
        exit;
    }

    // Lanjutkan dengan penambahan data akun jika email dan username valid
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Ditambahkan');
                document.location.href = 'dataakun.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Ditambahkan');
                document.location.href = 'dataakun.php';
              </script>";
    }
}
// Jika tombol ubah ditekan
if (isset($_POST['ubah'])) {
    // Ambil id_akun yang sedang diubah
    $id_akun = $_POST['id_akun'];

    // Ambil username yang baru dimasukkan oleh pengguna
    $new_username = $_POST['username'];

    // Cek apakah username yang baru dimasukkan sudah ada selain dari akun yang sedang diubah
    $existing_username = select("SELECT username FROM akun WHERE username = '$new_username' AND id_akun != $id_akun");

    if ($existing_username) {
        echo "<script>
                alert('Username sudah terdaftar. Gunakan username lain.');
                document.location.href = 'dataakun.php';
              </script>";
        exit;
    }

    // Lanjutkan dengan perubahan data akun jika username valid
    if (update_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Diubah');
                document.location.href = 'dataakun.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Diubah');
                document.location.href = 'dataakun.php';
              </script>";
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-1"><i class="fas fa-book"></i>Rekap Absensi</h1>
                </div><!-- /.col -->
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
  <table class="table table-bordered table-hover mt-3">
      <thead>
          <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Username</th>
              <th>Email</th>
              <th>Aksi</th>
          </tr>
      </thead>
            </div>
                    <tbody>
        <?php $no = 1; ?>
        <!-- tampil seluruh data -->
<?php foreach ($data_akun as $akun) : ?>
    <?php if ($akun['level'] == 'karyawan') : ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $akun['nama']; ?></td>
        <td><?= $akun['level']; ?></td>
        <td><?= $akun['username']; ?></td>
        <td><?= $akun['email']; ?></td>
        <td class="text-center">
            
        <a href="detail-absen.php?id_user=<?= $akun['id_akun']; ?>" class="btn btn-success mb-1" data-bs-toggle="tooltip" title="Rekap Absensi">
        <i class="fas fa-book"></i></a>
        <a href="detail-absen.php?id_user=<?= $akun['id_akun']; ?>" class="btn btn-warning mb-1" data-bs-toggle="tooltip" title="Overtime">
        <i class="fas fa-clock"></i></a>
        <a href="detail-activity.php?id_user=<?= $akun['id_akun']; ?>" class="btn btn-primary mb-1" data-bs-toggle="tooltip" title="Aktifitas">
        <i class="fas fa-user"></i></a>

        </td>
                </tr>
    <?php endif; ?>
<?php endforeach; ?>
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>


</div>
</div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Tambah Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

      <div class="modal-body">
          <form action="" method="post">
              <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" required>
              </div>

              <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" required>
              </div>

              <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" id="password" class="form-control" required minlength="6">
              </div>

              <div class="form-group">
                  <label for="level">Level</label>
                  <select name="level" id="level" class="form-control" required>
                      <option value="">-- Pilih Role --</option>
                      <option value="super-admin">Super Admin</option>
                      <option value="admin">Admin</option>
                      <option value="karyawan">Karyawan</option>
                  </select>
              </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
      </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah -->
<?php foreach ($data_akun as $akun) : ?>
    <div class="modal fade" id="modalUbah<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Ubah Akun</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
    <form action="" method="post">
        <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= $akun['nama']; ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= $akun['username']; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= $akun['email']; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password <small>(Masukkan password baru/lama)</small></label>
            <input type="password" name="password" id="password" class="form-control" required minlength="6">
        </div>
        <?php if ($_SESSION['level'] == 1) : ?>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" id="level" class="form-control" required>
                    <?php $level = $akun['level']; ?>
                    <option value="" <?= $level == '' ? 'selected' : null ?>>~~Pilih Role~~</option>
                    <option value="Super Admin" <?= $level == 'Super Admin' ? 'selected' : null ?>>Super Admin</option>
                    <option value="Admin" <?= $level == 'Admin' ? 'selected' : null ?>>Admin</option>
                    <option value="Karyawan" <?= $level == 'Karyawan' ? 'selected' : null ?>>Karyawan</option>
                </select>
            </div>
        <?php else : ?>
            <input type="hidden" name="level" value="<?= $akun['level']; ?>">
        <?php endif; ?>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
      </div>
      </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Hapus -->
<?php foreach ($data_akun as $akun) : ?>
    <div class="modal fade" id="modalHapus<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash-alt"></i> Hapus Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Yakin Ingin Menghapus Data Akun : <?= $akun['nama']; ?> .?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <a href="hapus-akun.php?id_akun=<?= $akun['id_akun']; ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php include 'layout/footer.php'; ?>
