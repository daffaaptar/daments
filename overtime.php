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
        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
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
        <label for="durasi">Durasi (jam):</label>
        <input type="number" id="durasi" name="durasi" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="jam-lembur">Jumlah Jam Lembur:</label>
        <input type="number" id="jam-lembur" name="jam-lembur" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="agenda">Agenda saat Lembur:</label>
        <textarea id="agenda" name="agenda" class="form-control" rows="4" required></textarea>
    </div>
    <label for="agenda">Nota Dinas:</label>
    <div id="summernote"><p>Hello Summernote</p></div>
    <script>
    $(document).ready(function() {
    $('#summernote').summernote();
    });
  </script>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
       </div>
        </div>
         </div>
        </section>
      </div>
   </body>
</html>
<?php include 'layout/footer.php'; ?>