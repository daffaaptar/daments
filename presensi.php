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

$title = 'Daftar Akun';

include 'layout/header.php';

// tampil seluruh data
$data_akun = select("SELECT * FROM akun");

// tampil data berdasarkan user login
$id_akun = $_SESSION['id_akun'];
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

// jika tombol tambah di tekan jalankan script berikut
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Ditambahkan');
                document.location.href = 'akun.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Ditambahkan');
                document.location.href = 'akun.php';
              </script>";
    }
}

// jika tombol ubah di tekan jalankan script berikut
if (isset($_POST['ubah'])) {
    if (update_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Diubah');
                document.location.href = 'akun.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Diubah');
                document.location.href = 'akun.php';
              </script>";
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<center><div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                            <?php
	if (isset($_SESSION['karyawan'])) {
		$sql = "SELECT*FROM akun WHERE id_akun='$_SESSION[id_akun]'";
	    $query = $db->query($sql);
		$get_user=$query->fetch_assoc();
		$name = $get_user['nama'];
		$id_user = $get_user['id_akun'];

		echo "<h1 class='page-header'>Welcome, $name</h1>";
		
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
			        echo "<div class='table-responsive'>
			           <table class='table table-striped'>
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
			          echo "</table></div>";
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
			      
			      $query_absen=$db->query("SELECT*FROM data_absen NATURAL LEFT JOIN bulan NATURAL JOIN hari NATURAL JOIN tanggal WHERE id_bln='$id_month' AND id_user='$id_user'");
			      
			      $cek = $query_absen->num_rows;
			      if ($cek!==0) {
			        echo "<br>  <h5 class='sub-header'><strong>Absensi:</strong> $name<br><br><strong>Bulan:</strong> $month $year </h5>";
			        echo "<div class='table-responsive'>
			           <table class='table table-bordered'>
			            <thead>
                  <tr>
                  <th rowspan='2' style='text-align: center; vertical-align: middle;'>NO</th>
                  <th rowspan='2' style='text-align: center; vertical-align: middle;'>Tanggal</th>
                  <th class='text-center' style='width: 10%;'>Datang</th>
                  <th class='text-center' width='10%'>Pulang</th>
                  <th rowspan='2' class='text-center' width='7%' style='text-align: center; vertical-align: middle;'>Isoma</th>
                  <th rowspan='2' width='10%' style='text-align: center; vertical-align: middle;'>Durasi</th>
                  <th class='text-center' style='width: 10%;'>Jumlah</th>
                  <th rowspan='2' width='50%' style='text-align: center; vertical-align: middle;'>Keterangan/Progres</th>
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
			                <td></td>
			                <td></td>
			                <td></td>
			                <td></td>
			                
			              </tr>";
			          }
			          echo "</table></div>";
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
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include 'layout/footer.php'; ?>
