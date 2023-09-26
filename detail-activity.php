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

$title = 'Detail Absensi';

// Memeriksa level pengguna
if ($_SESSION["level"] != "super-admin") {
    echo "<script>
            alert('Anda tidak memiliki hak akses untuk mengakses halaman ini');
            window.history.back();
          </script>";
    exit;
}

include 'layout/header.php';

// Ambil id_akun dari URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Query SQL untuk mengambil detail aktivitas berdasarkan id_akun
    // Note: Anda perlu memiliki fungsi 'select' untuk menjalankan kueri SQL.
    // Dengan asumsi ini didefinisikan di tempat lain dalam kode Anda.
    $query_nama = select("SELECT nama FROM akun WHERE id_akun = $id_user");

    if ($query_nama) {
        $nama_akun = $query_nama[0]['nama'];
        
        // Query untuk mendapatkan detail aktivitas
        $query = "SELECT * FROM activity WHERE id_akun = $id_user";
        $result = mysqli_query($db, $query);

        if ($result) {
            $aktivitas = mysqli_fetch_assoc($result);
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
                            <?php if (empty($aktivitas)) : ?>
                                <p>Tidak ada data aktivitas yang ditemukan untuk akun ini.</p>
                            <?php else : ?>
                                <h2>Aktivitas - <?php echo $nama_akun; ?></h2>
                                <p>Tipe Aktivitas: <?php echo $aktivitas['tipe_activity']; ?></p>
                                <p>Nama Proyek: <?php echo $aktivitas['project_name']; ?></p>
                                <p>Tanggal Mulai: <?php echo $aktivitas['start_date']; ?></p>
                                <p>Tanggal Selesai: <?php echo $aktivitas['end_date']; ?></p>
                                <p>Status Aktivitas: <?php echo $aktivitas['status_activity']; ?></p>
                                <p>Detail Aktivitas: <?php echo $aktivitas['detail_activity']; ?></p>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
<?php
        } else {
            echo "<script>
                    alert('Gagal mengambil data aktivitas');
                    window.location='absensi-akun.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Gagal mengambil data nama akun');
                window.location='absensi-akun.php';
              </script>";
        exit;
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
