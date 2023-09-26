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
if ($_SESSION["level"] != "karyawan") {
    echo "<script>
            alert('Anda tidak memiliki hak akses untuk mengakses halaman ini');
            window.history.back();
          </script>";
    exit;
}

include 'layout/header.php';

$id_akun = $_SESSION['id_akun'];

// Skrip PHP untuk menambahkan data aktivitas ke dalam database
if (isset($_POST['submit'])) {
    $tanggal = mysqli_real_escape_string($db, $_POST["tanggal"]);
    $tipe_activity = mysqli_real_escape_string($db, $_POST["tipe"]);
    $start_date = mysqli_real_escape_string($db, $_POST["startDate"]);
    $end_date = mysqli_real_escape_string($db, $_POST["endDate"]);
    $status_activity = mysqli_real_escape_string($db, $_POST["status"]);
    $detail_activity = mysqli_real_escape_string($db, $_POST["detail"]);

    // Tanggal otomatis
    $tanggal_sekarang = date("d-m-Y");

    // Skrip SQL untuk menyimpan data aktivitas
    $sql =  "INSERT INTO activity (id_akun, tanggal, tipe_activity, start_date, end_date, status_activity, detail_activity) 
    VALUES ('$id_akun', '$tanggal_sekarang', '$tipe_activity', '$start_date', '$end_date', '$status_activity', '$detail_activity')";

    if (mysqli_query($db, $sql)) {
        echo "<script>window.alert('Success');
              window.location='absen.php';</script>";
    } else {
        echo "<script>window.alert('Failed');
              window.location='absen.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summernote</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>

<body>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="nav-icon fas fa-user"></i> Aktifitas</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            
                            <input type="hidden" name="tanggal" id="tanggal" class="form-control">
                            <br>
                            <label for="tipe">Type Activity & Project Name:</label>
                            <textarea id="summernote" name="tipe" class="form-control" rows="4" required></textarea>
                            <br>

                            <label for="startDate">Start Date:</label>
                            <input type="date" name="startDate" id="startDate" class="form-control">
                            <br>
                            <label for="endDate">End Date:</label>
                            <input type="date" name="endDate" id="endDate" class="form-control">
                            <br>
                            <label for="status">Status Activity:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Select an status --</option>
                                <option value="Complete">Completed</option>
                                <option value="Proses">Process</option>
                            </select>
                            <br>
                            <label for="detail">Detail Aktivitas:</label>
                            <textarea name="detail" id="detail" rows="4" class="form-control" required></textarea>
                            <br>

                            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function () {
            $('#summernote').summernote();
        });
    </script>
</body>

</html>

<?php include 'layout/footer2.php'; ?>
