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
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

if (isset($_POST['submit'])) {
    $tipe_activity = mysqli_real_escape_string($db, $_POST["tipe"]);
    $project_name = mysqli_real_escape_string($db, $_POST["projectName"]);
    $start_date = mysqli_real_escape_string($db, $_POST["startDate"]);
    $end_date = mysqli_real_escape_string($db, $_POST["endDate"]);
    $durasi = mysqli_real_escape_string($db, $_POST["durasi"]);
    $status_activity = mysqli_real_escape_string($db, $_POST["status"]);
    $detail_activity = mysqli_real_escape_string($db, $_POST["detail"]);
    
    // Sesuaikan kolom yang akan diisi sesuai dengan struktur tabel "activity"
    $sql = "INSERT INTO activity (tipe_activity, project_name, start_date, end_date, durasi, status_activity, detail_activity) 
            VALUES ('$tipe_activity', '$project_name', '$start_date', '$end_date', $durasi, '$status_activity', '$detail_activity')";

    if (mysqli_query($db, $sql)) {
        echo "<script>window.alert('Success');
              window.location='absen.php';</script>";
    } else {
        echo "<script>window.alert('Failed');
              window.location='absen.php';</script>";
    }
} 

?> 
 
<!-- Content Wrapper. Contains page content --> 
<div class="content-wrapper">
<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class="nav-icon fas fa-user-cog"></i> Activity</h1>
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
        <label for="tipe">Type Activity:</label>
        <select name="tipe" id="tipe" class="form-control">
            <option value="">-- Select an activity --</option>
            <option value="development">Development</option>
            <option value="discuss">Discuss</option>
            <option value="review">Review</option>
        </select>
        <br>
        
        <label for="projectName">Project Name:</label>
        <input type="text" name="projectName" id="projectName" class="form-control" required>
        <br>
        
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" id="startDate" class="form-control" required>
        <br>
        
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" id="endDate" class="form-control" required>
        <br>
        
        <label for="durasi">Duration (jam):</label>
        <input type="number" name="durasi" id="durasi" class="form-control" required>
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
 
<?php include 'layout/footer.php'; ?>