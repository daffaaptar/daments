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
// if ($_SESSION["level"] != "karyawwan") {
//   echo "<script>
//           alert('Perhatian anda tidak punya hak akses');
//           window.history.back(); 
//         </script>";
//   exit;
// }

 
include 'layout/header.php';
if (isset($_POST['tambah'])) {
    // Validasi email jika sama
    $email = $_POST['email'];
    $existing_email = select("SELECT email FROM akun WHERE email = '$email'");
    if ($existing_email) {
        echo "<script>
                alert('Email sudah terdaftar. Gunakan email lain.');
                document.location.href = 'absen.php';
              </script>";
        exit;
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
  
    <form action="proses_form.php" method="post">
        <label for="tipe">Tipe Aktivitas:</label>
        <select name="tipe" name="tipe" id="tipe" class="form-control">
            <option value="">-- Pilih Activity --</option>
            <option value="development">Development</option>
            <option value="discuss">Discuss</option>
            <option value="review">Review</option>
        </select>
        <br>
        
        <label for="projectName">Nama Proyek:</label>
        <input type="text" name="projectName" id="projectName" class="form-control" required>
        <br>
        
        <label for="startDate">Tanggal Mulai:</label>
        <input type="date" name="startDate" id="startDate" class="form-control" required>
        <br>
        
        <label for="endDate">Tanggal Selesai:</label>
        <input type="date" name="endDate" id="endDate" class="form-control" required>
        <br>
        
        <label for="durasi">Durasi (jam):</label>
        <input type="number" name="durasi" id="durasi" class="form-control" required>
        <br>
        
        <label for="detail">Detail Aktivitas:</label>
        <textarea name="detail" id="detail" rows="4" class="form-control" required></textarea>
        <br>
        
        <input type="submit" name="tambah"value="Simpan" class="btn btn-primary">
    </form>
    </div> 
</div> 
</div> 
</section>
</div>


 
 
<?php include 'layout/footer.php'; ?>