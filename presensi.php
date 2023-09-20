<?php

session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('login dulu dong');
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#presensi">Presensi</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-bs-target="Activity">Activity</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-bs-target="OverTime">OverTime</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</div></center>
<div class="modal " id="presensi" tabindex="-1"">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered">    
        <tr>
            <th rowspan="2" style="text-align: center; vertical-align: middle;">NO</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle;">Tanggal</th>
            <th class="text-center" style="width: 10%;">Datang</th>
            <th class="text-center" width="10%">Pulang</th>
            <th rowspan="2" class="text-center" width="7%" style="text-align: center; vertical-align: middle;">Isoma</th>
            <th rowspan="2" width="10%" style="text-align: center; vertical-align: middle;">Durasi</th>
            <th colspan="2" class="text-center" style="width: 10%;">Jumlah</th>
            <th rowspan="2" width="50%" style="text-align: center; vertical-align: middle;">Keterangan/Progres</th>
          </tr>
          <tr>
            <th class="text-center">Pukul</th>
            <th class="text-center">Pukul</th>
            <th class="text-center" width="8%">Jam</th>
            <th class="text-center" width="8%">Menit</th>
          </tr>
          <tr>
            <td style="text-align: center; vertical-align: middle;">1</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">1 Agustus 2023</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">08.00</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">18.00</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">1:00</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">9:00</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">7</td>
            <td width="10%" style="text-align: center; vertical-align: middle;">8</td>
            <td ></td>
          </tr>
          
    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php include 'layout/footer.php'; ?>
