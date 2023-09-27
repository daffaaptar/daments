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
<style>
  h4 {
    margin-top:30px;
  }
</style>

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
            <div class="card-header">
                    <h3 class="card-title" style="margin-top: 5px;">Detail Lembur </h3>
                    <a href="exportxllebur.php?id_user=<?php echo $id_user; ?>" class="btn btn-danger float-right">Export to Excel</a>
                </div>
                <div class='card-body'>
                    <?php
                    $bulan_sebelumnya = '';
                    $no = 0;
                    foreach ($data_lembur as $lembur) :
                        $tanggal = date('d-M-Y', strtotime($lembur['tanggal']));
                        $bulan = date('F Y', strtotime($lembur['tanggal']));

                        // Cek apakah bulan berubah
                        if ($bulan != $bulan_sebelumnya) {
                            // Jika bulan berbeda, buat tabel baru
                            if ($bulan_sebelumnya != '') {
                                echo '</tbody></table>'; // Tutup tabel sebelumnya
                            }
                            echo "<h4 class='sub-header'>$bulan</h4>";
                            echo '<table class="table table-bordered table-hover mt-3">';
                            echo '
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
                                <tbody>';
                            $no = 0;
                        }

                        $datang = date('H:i', strtotime($lembur['datang']));
                        $pulang = date('H:i', strtotime($lembur['pulang']));
                        $jam_masuk = DateTime::createFromFormat('H:i:s', $lembur['datang']);
                        $jam_keluar = DateTime::createFromFormat('H:i:s', $lembur['pulang']);
                        $durasi_lembur = '';

                        if ($jam_masuk && $jam_keluar) {
                            $selisih_waktu = $jam_masuk->diff($jam_keluar);
                            $jam = $selisih_waktu->format('%h');
                            $menit = $selisih_waktu->format('%i');
                            $total_menit = ($jam * 60) + $menit;

                            if ($total_menit > 480) { // Lebih dari 8 jam (8 jam * 60 menit)
                                $lebih_jam = floor($total_menit / 60) - 8;
                                $sisanya_menit = $total_menit % 60;
                                $durasi_lembur = "8 jam + $lebih_jam jam $sisanya_menit menit";
                            } else {
                                $durasi_lembur = $selisih_waktu->format('%h jam %i menit');
                            }
                        }

                        $no++; // Tambahkan nomor urut
                        echo "
                            <tr>
                                <td style='text-align: center; vertical-align: middle;'>$no</td>
                                <td style='vertical-align: middle;'>$tanggal</td>
                                <td style='vertical-align: middle;'>$datang</td>
                                <td style='vertical-align: middle;'>$pulang</td>
                                <td style='text-align: center; vertical-align: middle;'>$durasi_lembur</td>
                                <td style='vertical-align: middle;'>{$lembur['agenda']}</td>
                                <td style='vertical-align: middle;'>{$lembur['nota']}</td>
                            </tr>
                        ";

                        $bulan_sebelumnya = $bulan;
                    endforeach;

                    if (!empty($data_lembur)) {
                        echo '</tbody></table>'; // Tutup tabel terakhir
                    } else {
                        echo "<div class='alert alert-warning'><strong>Tidak ada data lembur untuk ditampilkan.</strong></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>
