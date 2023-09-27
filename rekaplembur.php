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

$title = 'Rekap Lembur';

include 'layout/header.php';

// Ambil data lembur berdasarkan user login
$id_user = $_SESSION['id_akun'];
$data_lembur = select("SELECT * FROM overtime WHERE id_lembur = $id_user");

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
                    <h3 class='sub-header'>Rekap Lembur</h3>
                    <table class='table table-bordered table-hover mt-3'>
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
                            $no = 0;
                            foreach ($data_lembur as $lembur) :
                                $no++;
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($lembur['tanggal'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($lembur['datang'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($lembur['pulang'])); ?></td>
                                    <td><?php 
                                    $jam_masuk = DateTime::createFromFormat('H:i:s', $lembur['datang']);
                                    $jam_keluar = DateTime::createFromFormat('H:i:s', $lembur['pulang']);
                                    
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
                                    ?></td>
                                    <td><?php echo $lembur['agenda']; ?></td>
                                    <td><?php echo $lembur['nota']; ?></td>
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
