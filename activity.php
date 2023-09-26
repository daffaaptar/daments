<?php 
session_start(); 
 
// membatasi halaman sebelum login 
if (!isset($_SESSION["login"])) { 
    echo "<script> 
            alert('Anda perlu login untuk memasuki halaman'); 
            document.location.href = 'index.php'; 
        </script>"; 
    exit; 
} 
 
$title = 'Detail Absensi'; 

// membatasi halaman sesuai user login
if ($_SESSION["level"] != "karyawan") {
  echo "<script>
          alert('Perhatian anda tidak punya hak akses');
          window.history.back(); 
        </script>";
  exit;
}

 
include 'layout/header.php';

$id_akun = $_SESSION['id_akun'];


if (isset($_POST['submit'])) {
    $tipe_activity = mysqli_real_escape_string($db, $_POST["tipe"]);
    $project_name = mysqli_real_escape_string($db, $_POST["projectName"]);
    $start_date = mysqli_real_escape_string($db, $_POST["startDate"]);
    $end_date = mysqli_real_escape_string($db, $_POST["endDate"]);
    $status_activity = mysqli_real_escape_string($db, $_POST["status"]);
    $detail_activity = mysqli_real_escape_string($db, $_POST["detail"]);
    
    // Sesuaikan kolom yang akan diisi sesuai dengan struktur tabel "activity"


    $sql =  "INSERT INTO activity (id_akun, tipe_activity, project_name, start_date, end_date,  status_activity, detail_activity) 
    VALUES ('$id_akun', '$tipe_activity', '$project_name', '$start_date', '$end_date', '$status_activity', '$detail_activity')";



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
        <label for="tipe">Type Activity & Project Name:</label>
        <textarea id="summernote" name="tipe" class="form-control" rows="4" required></textarea>
        <br>

        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" id="startDate" class="form-control" >
        <br>
        
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" id="endDate" class="form-control" >
        <br>
        
        

        <label for="status">Status Activity:</label>
        <select name="status" id="status" class="form-control">
            <option value="">-- Select an status --</option>
            <option value="complete">Completed</option>
            <option value="discuss">Process</option>
        </select>
        <br>
        <label for="detail">Detail Aktivitas:</label>
        <textarea name="detail" id="detail" rows="4" class="form-control" required></textarea>
        <br>
        
        <input type="submit" value="submit" name="submit" class="btn btn-primary">
    </form>
    </div> 
</div> 
</div> 
</section>
</div> 
<script>
    $(document).ready(function() {
    $('#summernote').summernote();
    });
</script>
</body>
 </html>
 
<?php include 'layout/footer2.php'; ?>