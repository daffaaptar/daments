<?php
session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda perlu login untuk memasuki halaman');
            document.location.href = 'index.php';
          </script>";
    exit;
}

$title = 'Detail Absensi';

// membatasi halaman sesuai user login
if ($_SESSION["level"] != "super-admin") {
    echo "<script>
            alert('Perhatian anda tidak punya hak akses');
            window.history.back();
          </script>";
    exit;
}

include 'layout/header.php';

// Ambil parameter ID dari URL
$id_user = $_GET['id_user'];

// Query basis data untuk mengambil data absensi berdasarkan ID
$query_absen = select("
    SELECT
        data_absen.id_absen,
        tanggal.nama_tgl AS tanggal,
        bulan.nama_bln AS bulan,
        hari.nama_hri AS hari,
        data_absen.jam_msk,
        data_absen.jam_klr,
        data_absen.keterangan
    FROM
        data_absen
    JOIN tanggal ON data_absen.id_tgl = tanggal.id_tgl
    JOIN bulan ON data_absen.id_bln = bulan.id_bln
    JOIN hari ON data_absen.id_hri = hari.id_hri
    WHERE
        data_absen.id_user = $id_user
");

// Check if there are any rows returned
if (empty($query_absen)) {
  
} else {
    // Query basis data untuk mengambil nama akun
    $query_nama = select("SELECT nama FROM akun WHERE id_akun = $id_user ");
    $nama_akun = $query_nama[0]['nama'];
}
?>
<style>
    h2 {
    margin-top: 20px; /* Sesuaikan dengan ukuran yang Anda inginkan */
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="margin-top: 5px;">Detail Absensi - <?php echo $nama_akun; ?></h3>
                    <a href="exportxl.php?id_user=<?php echo $id_user; ?>" class="btn btn-danger float-right">Export to Excel</a>
                </div>
                <div class="card-body">
                    <?php if (empty($query_absen)) : ?>
                        <p>Tidak ada data absensi yang ditemukan untuk akun ini.</p>
                    <?php else : ?>
                        <?php
                        $bulan_sebelumnya = ''; // Inisialisasi variabel untuk menyimpan bulan sebelumnya
                        $nomor_urut = 1; // Inisialisasi nomor urut

                        foreach ($query_absen as $key => $absen) :
                            // Mengambil bulan dari tanggal
                            $bulan_saat_ini = $absen['bulan'];

                            // Memeriksa apakah bulan berbeda dari bulan sebelumnya
                            if ($bulan_saat_ini != $bulan_sebelumnya) :
                                // Jika bulan berbeda, buat tabel baru dan tampilkan judul bulan
                                if ($key > 0) {
                                    echo '</tbody></table>'; // Menutup tabel sebelumnya
                                }
                                echo "<h2>$bulan_saat_ini</h2>";
                                $nomor_urut = 1; // Mengatur ulang nomor urut ketika bulan berubah
                        ?>
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
                            <?php endif; ?>
                            <tr>
                                <td><?php echo $nomor_urut; ?></td>
                                <td><?php
                                    $date = "$absen[hari], $absen[tanggal] $absen[bulan] " . date("Y");
                                    echo $date; ?></td>

                                <td><?php echo $absen['jam_msk']; ?></td>
                                <td><?php echo $absen['jam_klr']; ?></td>
                                <td>
                                    <?php
                                    $jam_masuk = DateTime::createFromFormat('H:i', $absen['jam_msk']);
                                    $jam_keluar = DateTime::createFromFormat('H:i', $absen['jam_klr']);

                                    if ($jam_masuk && $jam_keluar) {
                                        $selisih_waktu = $jam_masuk->diff($jam_keluar);
                                        echo $selisih_waktu->format('%H jam %i menit');
                                    } else {
                                        echo "<strong>Format waktu tidak valid</strong>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $absen['keterangan']; ?></td>
                            </tr>
                            <?php
                            // Menyimpan bulan saat ini ke bulan sebelumnya untuk perbandingan berikutnya
                            $bulan_sebelumnya = $bulan_saat_ini;
                            $nomor_urut++; // Tingkatkan nomor urut
                        endforeach;

                        // Tutup tabel terakhir
                        echo '</tbody></table><br>';
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>
