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
// Query basis data untuk mengambil data absensi berdasarkan ID
$query_absen = select("SELECT * FROM data_absen WHERE id_user = $id_user ");
$query_absen=$db->query("SELECT*FROM data_absen NATURAL LEFT JOIN bulan NATURAL JOIN hari NATURAL JOIN tanggal WHERE id_bln='$id_month' AND id_user='$id_user'");

// Query basis data untuk mengambil nama akun
$query_nama = select("SELECT nama FROM akun WHERE id_akun = $id_user ");
$nama_akun = $query_nama[0]['nama'];
//membuat durasi
$masuk = $query_absen['jam_msk'];
$keluar = $query_absen['jam_klr'];
$jam_masuk = DateTime::createFromFormat('H:i', $masuk);
$jam_keluar = DateTime::createFromFormat('H:i', $keluar);
                
    if ($masuk && $keluar) {
            $selisih_waktu = $masuk->diff($keluar);
            
    } else {
            $selisih_waktu = "<strong>Format waktu tidak valid</strong>";
            
    }

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
                        <table class="table table-bordered table-hover mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Durasi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($query_absen as $key => $absen) : ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $absen['id_tgl']; ?></td>
                                        <td><?php echo $absen['jam_msk']; ?></td>
                                        <td><?php echo $absen['jam_klr']; ?></td>
                                        <td><?php  ($selisih_waktu instanceof DateInterval ? $selisih_waktu->format('%H jam %i menit') : $selisih_waktu)  ?></td>
                                        <td><?php echo $absen['keterangan']; ?></td>
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
