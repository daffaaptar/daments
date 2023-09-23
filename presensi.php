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
                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Aktivitas</title>
</head>
<body>
    <h1>Form Aktivitas</h1>
    <form action="proses_form.php" method="post">
        <label for="tipe">Tipe Aktivitas:</label>
        <select name="tipe" id="tipe">
            <option value="development">Development</option>
            <option value="discuss">Discuss</option>
            <option value="review">Review</option>
            <option value="testing">Testing</option>
        </select>
        <br>
        
        <label for="projectName">Nama Proyek:</label>
        <input type="text" name="projectName" id="projectName" required>
        <br>
        
        <label for="startDate">Tanggal Mulai:</label>
        <input type="date" name="startDate" id="startDate" required>
        <br>
        
        <label for="endDate">Tanggal Selesai:</label>
        <input type="date" name="endDate" id="endDate" required>
        <br>
        
        <label for="durasi">Durasi (jam):</label>
        <input type="number" name="durasi" id="durasi" required>
        <br>
        
        <label for="detail">Detail Aktivitas:</label>
        <textarea name="detail" id="detail" rows="4" required></textarea>
        <br>
        
        <input type="submit" value="Simpan">
    </form>
</body>
</html>


<?php include 'layout/footer.php'; ?>