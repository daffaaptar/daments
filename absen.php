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

// membatasi halaman sesuai user login
if ($_SESSION["level"] != "karyawan") {
    echo "<script>
            alert('Perhatian anda tidak punya hak akses');
            document.location.href = 'dataakun.php';
          </script>";
    exit;
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>
  
    <!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-header">
    <!-- tampil seluruh data -->        
<h3 class="card-title">Hallo <?= $_SESSION['nama']; ?> </h3>

</div>
<!-- /.card-header -->
<div class="card-body" >
<div class=" max-w-7xl mx-auto sm:px-6 lg:px-8  ">  
<div class="ciah shadow-sm sm:rounded-lg" style=" width: 100%; height: 150vh; background-image: url('https://media.licdn.com/dms/image/D5605AQGeUxt6kfzs5A/feedshare-thumbnail_720_1280/0/1693883976893?e=2147483647&v=beta&t=knBoP755Kd0yNKGUvVK1IuCycgebBBLGNfJy0CFhI38'); backdrop-filter: blur(5px); background-size: cover;  height: 60vh ;    background-size: cover ;    background-position: center ;    background-repeat: no-repeat ;">  
    <div> 
    <center>
    <?php
        $this_day = date("d");
        $sql = "SELECT * FROM data_absen NATURAL LEFT JOIN tanggal WHERE nama_tgl='$this_day' AND id_user='{$_SESSION['id_akun']}'";
        $result = $db->query($sql);

        // Notifikasi Absen
        if (isset($_GET['ab'])) {
            if ($_GET['ab'] == 1) {
                echo "<div class='alert alert-warning'><strong>Terimakasih, Absen berhasil.</strong></div>";
            } elseif ($_GET['ab'] == 2) {
                echo "<div class='alert alert-danger'><strong>Maaf, Absen Gagal. Silahkan Coba Kembali!</strong></div>";
            }
        }

        if ($result->num_rows == 0) {
            $status = './lib/img/warning.png';
            $message = "Anda Belum Mengisi Absen Hari Ini";
            $disable_in = "";
            $disable_out = " disabled='disabled'";
        } else {

            $disable_in = " disabled='disabled'";

            $get_day = $result->fetch_assoc();
            
            if ($get_day['jam_klr'] !== "") {
                $status = './lib/img/complete.png';
                $message = "Absensi hari ini selesai! Terimakasih.";
                $disable_out = " disabled='disabled'";
            } else {
                $status = './lib/img/minus.png';
                $message = "Absen Masuk Selesai. Jangan Lupa Absen Pulang !";
                $disable_out = "";
            }
        }

        echo "
            <button type='button' class='btn btn-success' onclick=\"window.location.href='./model/proses.php?absen=1';\" $disable_in style='margin-top:180px;  font-size:18px; border-radius:5px;'>Absen Masuk</button>
            <button type='button' class='btn btn-danger' onclick=\"window.location.href='./model/proses.php?absen=2';\" $disable_out style='margin-top:180px;  font-size:18px; border-radius:5px;'>Absen Keluar</button>   
        ";
        ;
        $db->close();
        ?>

                            </div>  
                        </div>  
                    </div>  
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php
echo "
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
      <form action='modal/proses.php' method='post'>
      <label for='keterangan'>Masukan keterangan hari ini :</label>
      <input type='text' id='keterangan' name='keterangan'  class='form-control'>
      <input type='hidden' name='absen' value='1'>
      </form>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
        <button type='button' class='btn btn-danger' onclick=\"window.location.href='./model/proses.php?absen=2';\" $disable_out>Absen Keluar</button>
      </div>
      </div>
    </div>
  </div>
</div>
";

?>
<?php include 'layout/footer.php'; ?>