<?php
session_start();

// Membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Anda perlu login untuk memasuki halaman');
            document.location.href = 'index.php';
          </script>";
    exit;
}

$title = 'Daftar Akun';

include 'layout/header.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $tanggal = $_POST["tanggal"];
    $datang = $_POST["datang"];
    $pulang = $_POST["pulang"];
    $agenda = $_POST["agenda"];
    $notaDinas = $_POST["nota"];

    // Persiapan dan eksekusi pernyataan SQL INSERT
    $sql = "INSERT INTO overtime (tanggal, datang, pulang, agenda, nota) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssss", $tanggal, $datang, $pulang, $agenda, $notaDinas);

    if ($stmt->execute()) {
        // Data berhasil dimasukkan ke dalam database
        echo "<script>
                alert('Data telah berhasil dimasukkan ke dalam database.');
                document.location.href = 'absen.php'; // Ganti dengan halaman yang sesuai
              </script>";
    } else {
        // Terjadi kesalahan saat memasukkan data
        echo "Error: " . $stmt->error;
    }

    // Tutup pernyataan
    $stmt->close();
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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-user-clock"></i> Overtime</h1>
            </div><!-- /.col -->
        <div class="col-sm-6">
     </div><!-- /.col -->
     </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
        <!-- /.content-header -->
    
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
    
<!-- Main content -->
<div class="card">
<!-- /.card-header -->
<div class="card-body">

<form action="#" method="post">
    <div class="form-group">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" class="form-control">
    </div>
    <div class="form-group">
        <label for="datang">Datang Pukul:</label>
        <input type="time" id="datang" name="datang" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="pulang">Pulang Pukul:</label>
        <input type="time" id="pulang" name="pulang" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="agenda">Agenda saat Lembur:</label>
        <textarea id="agenda" name="agenda" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group">
    <label for="nota">Nota Dinas:</label>
    <textarea id="summernote" name="nota" class="form-control" rows="4" required></textarea>
    </div>
    <script>
    $(document).ready(function() {
    $('#summernote').summernote();
    });
    </script>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
       </div>
        </div>
         </div>
        </section>
      </div>
      
   </body>
</html>
<?php include 'layout/footer2.php'; ?>
