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

// membatasi halaman sesuai user login
if ($_SESSION["level"] != "karyawan") {
    echo "<script>
            alert('Anda tidak memiliki hak akses ke halaman ini');
            window.history.back(); 
          </script>";
    exit;
}

$title = 'Rekap Aktivitas';

include 'layout/header.php';

// Ambil data aktivitas berdasarkan user login
$id_akun = $_SESSION['id_akun']; // Sesuaikan dengan nama kolom yang benar
$data_activity = select("SELECT * FROM activity WHERE id_akun = $id_akun"); // Sesuaikan dengan nama kolom yang benar

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- Isi dengan judul halaman jika diperlukan -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class='card-body'>
                    <h3 class='sub-header'>Rekap Aktivitas</h3>
                    <table class='table table-bordered table-hover mt-3'>
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">No</th>
                                <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                                <th style="text-align: center; vertical-align: middle;">Tipe Aktivitas & Nama Project</th>
                                <th style="text-align: center; vertical-align: middle;">Tanggal Mulai</th>
                                <th style="text-align: center; vertical-align: middle;">Tanggal Selesai</th>
                                <th style="text-align: center; vertical-align: middle;">Status Aktivitas</th>
                                <th style="text-align: center; vertical-align: middle;">Detail Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($data_activity as $activity) :
                                $no++;
                            ?>
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;"><?php echo $no++; ?></td>
                                    <td style="vertical-align: middle;"><?php echo date("d F Y", strtotime($activity['tanggal'])); ?></td>
                                    <td style="vertical-align: middle;"><?php echo $activity['tipe_activity']; ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?php echo date("d F Y", strtotime($activity['start_date'])); ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?php echo date("d F Y", strtotime($activity['end_date'])); ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?php echo $activity['status_activity']; ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?php echo $activity['detail_activity']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>
