<?php
session_start();


// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda perlu login untuk memasuki halaman');
            document.location.href = 'login.php';
        </script>";
    exit;
}

$title = 'Detail Absensi';

include 'layout/header.php';

// Ambil parameter ID dari URL
$id_user = $_GET['id_user'];


// Query basis data untuk mengambil data absensi berdasarkan ID
$query_absen = select("SELECT * FROM data_absen WHERE id_user = $id_user");

// Query basis data untuk mengambil nama akun
$query_nama = select("SELECT nama FROM akun WHERE id_akun = $id_user");
$nama_akun = $query_nama[0]['nama'];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Absensi - <?php echo $nama_akun; ?></h3>
                </div>
                <div class="card-body">
                    <?php if (empty($query_absen)) : ?>
                        <p>Tidak ada data absensi yang ditemukan untuk akun ini.</p>
                    <?php else : ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Status Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Status Jam Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($query_absen as $key => $absen) : ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $absen['id_tgl']; ?></td>
                                        <td><?php echo $absen['jam_msk']; ?></td>
                                        <td><?php echo $absen['st_jam_msk']; ?></td>
                                        <td><?php echo $absen['jam_klr']; ?></td>
                                        <td><?php echo $absen['st_jam_klr']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>
