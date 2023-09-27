<?php
session_start();

// Memeriksa apakah pengguna sudah login atau belum
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda perlu login untuk mengakses halaman ini');
            document.location.href = 'index.php';
          </script>";
    exit;
}

$title = 'Detail Aktivitas';

// Memeriksa level pengguna
if ($_SESSION["level"] != "super-admin") {
    echo "<script>
            alert('Anda tidak memiliki hak akses untuk mengakses halaman ini');
            window.history.back();
          </script>";
    exit;
}

include 'layout/header.php';

// Fungsi untuk mengonversi tanggal dari format YYYY-MM-DD ke tanggal bulan tahun
function convertDateFormat($date) {
    $tanggal = date_create($date); // Membuat objek tanggal dari string
    return date_format($tanggal, "d F Y"); // Mengonversi ke format tanggal bulan tahun
}

// Ambil id_akun dari URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $query_nama = select("SELECT nama FROM akun WHERE id_akun = $id_user");

    if ($query_nama) {
        $nama_akun = $query_nama[0]['nama'];

        // Query SQL untuk mengambil detail aktivitas berdasarkan id_akun
        $query = "SELECT * FROM overtime WHERE id_lembur = $id_user ORDER BY tanggal";
        $result = mysqli_query($db, $query);
?>

<!-- Content Wrapper. Contains page content --> 
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="nav-icon fas fa-user"></i> Detail Aktivitas</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Header (Page header) --> 
    <section class="content"> 
        <div class="container-fluid"> 
            <div class="card"> 
                <div class="card-body"> 
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php
                    $bulan_sebelumnya = ''; // Inisialisasi variabel untuk menyimpan bulan sebelumnya
                    $no = 1; // Inisialisasi nomor urut
                    ?>
                    <h2>Lembur -  <?php echo $nama_akun; ?></h2>
                    <?php
                    while ($data = mysqli_fetch_assoc($result)) :
                        $tanggal = $data['tanggal'];
                        $bulan_saat_ini = date('F Y', strtotime($tanggal)); // Mengambil bulan dari tanggal
                        
                        // Memeriksa apakah bulan berbeda dari bulan sebelumnya
                        if ($bulan_saat_ini != $bulan_sebelumnya) :
                            // Jika bulan berbeda, buat tabel baru dan tampilkan judul bulan
                            if ($bulan_sebelumnya != '') {
                                echo '</tbody></table><br>'; // Menutup tabel sebelumnya
                                $no = 1; // Mengatur nomor urut kembali ke 1
                            }
                    ?>
                            <h2><?php echo $bulan_saat_ini; ?></h2>
                            <table class="table table-bordered table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">No</th>
                                        <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                                        <th style="text-align: center; vertical-align: middle;">Datang</th>
                                        <th style="text-align: center; vertical-align: middle;">Pulang</th>
                                        <th style="text-align: center; vertical-align: middle;">Durasi + Lembur</th>
                                        <th style="text-align: center; vertical-align: middle;">Agenda</th>
                                        <th style="text-align: center; vertical-align: middle;">Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php
                            $bulan_sebelumnya = $bulan_saat_ini; // Simpan bulan saat ini sebagai bulan sebelumnya
                        endif;
                    ?>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;"><?php echo $no++; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?php echo convertDateFormat($tanggal); ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?php echo substr($data['datang'], 0, 5); ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?php echo substr($data['pulang'], 0, 5); ?></td>
                            <td style="text-align: center; vertical-align: middle;">
                            <?php 
                                $jam_masuk = DateTime::createFromFormat('H:i:s', $data['datang']);
                                $jam_keluar = DateTime::createFromFormat('H:i:s', $data['pulang']);
                                
                                if ($jam_masuk && $jam_keluar) {
                                    $selisih_waktu = $jam_masuk->diff($jam_keluar);
                                    $jam = $selisih_waktu->format('%h');
                                    $menit = $selisih_waktu->format('%i');
                                    $total_menit = ($jam * 60) + $menit;
                                    
                                    if ($total_menit > 480) { // Lebih dari 8 jam (8 jam * 60 menit)
                                        $lebih_jam = floor($total_menit / 60) - 8;
                                        $sisanya_menit = $total_menit % 60;
                                        echo "8 jam + $lebih_jam jam $sisanya_menit menit";
                                    } else {
                                        echo $selisih_waktu->format('%h jam %i menit');
                                    }
                                } else {
                                    echo "<strong>Format waktu tidak valid</strong>";
                                }
                                ?>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"><?php echo $data['agenda']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?php echo $data['nota']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                    </table>
                <?php else : ?>
                    <p>Tidak ada data Lembur yang ditemukan untuk akun ini.</p>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    }
} else {
    echo "<script>
            alert('ID aktivitas tidak valid');
            window.location='absensi-akun.php';
          </script>";
    exit;
}
?>

<?php include 'layout/footer.php'; ?>
