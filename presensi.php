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
            alert('Perhatian anda tidak punya hak akses');
            window.history.back(); 
          </script>";
    exit;
  }

$title = 'Daftar Akun';

include 'layout/header.php';

// tampil seluruh data
$data_akun = select("SELECT * FROM akun");

// tampil data berdasarkan user login
$id_akun = $_SESSION['id_akun'];

$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

if (isset($_POST['ubah_keterangan'])) {
    // Ambil id_user yang akan diubah keterangannya
    $id_absen = $_POST['id_absen'];

    // Ambil keterangan yang baru dimasukkan oleh pengguna
    $new_keterangan = $_POST['keterangan'];

    // Lanjutkan dengan perubahan keterangan jika data yang diperlukan tersedia
    if (isset($id_absen) && isset($new_keterangan)) {
        // Perbarui keterangan dalam tabel data_absen
        $query_update_keterangan = "UPDATE data_absen SET keterangan = ? WHERE id_absen = ?";
        $stmt = $db->prepare($query_update_keterangan);
        
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($db->error));
        }
        
        // Bind parameters
        $stmt->bind_param('si', $new_keterangan, $id_absen);
        
        // Eksekusi pernyataan
        if ($stmt->execute()) {
            echo "<script>
                    alert('Keterangan Berhasil Diubah');
                    document.location.href = 'presensi.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Keterangan Gagal Diubah');
                    document.location.href = 'presensi.php';
                  </script>";
        }

        // Tutup pernyataan
        $stmt->close();
    } else {
        echo "<script>
                alert('Data yang diperlukan tidak lengkap.');
                document.location.href = 'presensi.php';
              </script>";
    }
}


?>


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <section class="content">
			<div class="container-fluid">
				<div class="card">
				<div class='card-body'>

<?php
if (isset($_SESSION['karyawan'])) {
$sql = "SELECT*FROM akun WHERE id_akun='$_SESSION[id_akun]'";
$query = $db->query($sql);
$get_user=$query->fetch_assoc();
$name = $get_user['nama'];
$id_user = $get_user['id_akun'];
if ($db->query("SELECT*FROM data_absen WHERE id_user='$id_user'")->num_rows!==0) {
$no=0;
$query_month=$db->query("SELECT*FROM bulan ORDER BY id_bln ASC");
while ($get_month=$query_month->fetch_assoc()) {
        $month=$get_month['nama_bln'];
        $id_month=$get_month['id_bln'];
        $query_absen=$db->query("SELECT*FROM data_absen NATURAL LEFT JOIN bulan NATURAL JOIN hari NATURAL JOIN tanggal WHERE id_bln='$id_month' AND id_user='$id_user'");

        $cek = $query_absen->num_rows;
        if ($cek!==0) {
            echo "<h3 class='sub-header'>Absensiku - $month </h3>";
            echo "
    <table class='table table-bordered table-hover mt-3'>
        <thead>
            <tr>
                <th>No</th>
                <th>Hari, Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                </tr>
            </thead>
            <tbody>";
        $no=0;
        while ($get_absen=$query_absen->fetch_assoc()) {
            $no++;
            $date = "$get_absen[nama_hri], $get_absen[nama_tgl] $get_absen[nama_bln] ".date("Y");
            $time_in = "$get_absen[jam_msk]";
            if ($get_absen['jam_klr']==="") {
                $time_out = "<strong>Belum Absen</strong>";
            } else {
                $time_out = "$get_absen[jam_klr]";
            }
            echo "<tr>
                    <td>$no</td>
                    <td>$date</td>
                    <td>$time_in</td>
                    <td>$time_out</td>
                    
                </tr>";
        }
        echo "</table>";
    }
}
$db->close();
} else {
echo "<div class='alert alert-warning'><strong>Tidak ada Absensi untuk ditampilkan.</strong></div>";
}
} else {
$query = $db->query("SELECT*FROM akun WHERE id_akun='$id_akun'");
$get_user=$query->fetch_assoc();
$name = $get_user['nama'];
$id_user = $get_user['id_akun'];
if ($db->query("SELECT*FROM data_absen WHERE id_user='$id_user'")->num_rows!==0) {
$no=0;
$query_month=$db->query("SELECT*FROM bulan ORDER BY id_bln ASC");
while ($get_month=$query_month->fetch_assoc()) {
$month = $get_month['nama_bln'];
$year = date("Y");
$id_month=$get_month['id_bln'];

//membuat durasi



$query_absen=$db->query("SELECT*FROM data_absen NATURAL LEFT JOIN bulan NATURAL JOIN hari NATURAL JOIN tanggal WHERE id_bln='$id_month' AND id_user='$id_user'");

$cek = $query_absen->num_rows;
if ($cek!==0) {
    echo "<br>  <h5 class='sub-header' style='text-align:center;'><br>Bulan: $month $year </h5>";
    echo "
        <table class='table table-bordered table-hover mt-3'>
            <thead>
            <tr>
            <th rowspan='2' style='text-align: center; vertical-align: middle;'>NO</th>
            <th rowspan='2' style='text-align: center; vertical-align: middle;'>Tanggal</th>
            <th class='text-center' style='width: 10%;'>Datang</th>
            <th class='text-center' width='10%'>Pulang</th>
            
            <th rowspan='2' width='10%' style='text-align: center; vertical-align: middle;'>Durasi</th>
            
            <th rowspan='3' width='50%' style='text-align: center; vertical-align: middle;'>Keterangan/Progres</th>
            <th></th>
        </tr>
            </thead>
            <tbody>";
            $no = 0;
            while ($get_absen = $query_absen->fetch_assoc()) {
                    $no++;
                    $date = "{$get_absen['nama_hri']}, {$get_absen['nama_tgl']} {$get_absen['nama_bln']} " . date("Y");
                    $time_in = $get_absen['jam_msk'];
                    $time_out = $get_absen['jam_klr'];
                    $keterangan = $get_absen['keterangan'];

if ($time_out === "") {
$time_out = "<strong>Belum Absen</strong>";
$selisih_waktu = ""; // Tidak ada selisih waktu jika jam keluar kosong

} else {


$masuk = DateTime::createFromFormat('H:i', $time_in);
$keluar = DateTime::createFromFormat('H:i', $time_out);

if ($masuk && $keluar) {
$selisih_waktu = $masuk->diff($keluar);

} else {
$selisih_waktu = "<strong>Format waktu tidak valid</strong>";

}
}

        echo "<tr>
                <td>$no</td>
                <td>$date</td>
                <td>$time_in</td>
                <td>$time_out</td>
                <td>" . ($selisih_waktu instanceof DateInterval ? $selisih_waktu->format('%H jam %i menit') : $selisih_waktu) . "</td>
                <td>$keterangan</td>
                <td style='text-align:right;'> <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#keluar' style='font-size:18px; border-radius:5px;'>
                <i class='nav-icon fas fa-pen'></i>
                </button> </td>
            </tr>";
}
echo "</table>";
                            }
                }
                $db->close();
            } else {
                echo "<div class='alert alert-warning'><strong>Tidak ada Absensi untuk ditampilkan.</strong></div>";
            }
    }
?>


                    </div>
                </div>
            </div>
        </section>
</div>

<div class='modal fade' id='keluar' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='staticBackdropLabel'><i class='fas fa-sign-out-alt'></i>Keterangan</h5>
        <button type='button' class='close' data-bs-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
      <form method="POST">
    <input type="hidden" name="id_absen" value="<?php echo $id_absen; ?>">
    <div class="form-group">
        <label for="keterangan">Keterangan:</label>
        <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?php echo $keterangan; ?>" required>
    </div>
    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
    <button type="submit" name="ubah_keterangan" class="btn btn-primary">Ubah Keterangan</button>
</form>
      
    </div>
  </div>
</div>

<?php include 'layout/footer.php'; ?>