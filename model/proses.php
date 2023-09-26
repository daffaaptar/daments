<?php 
session_start();
date_default_timezone_set('Asia/Jakarta');
include '../config/database.php';

if (isset($_POST['login'])) {
 $email = mysqli_real_escape_string($db, $_POST['email']);
 $pwd = sha1(mysqli_escape_string($db, $_POST['pwd']));

 $sql = "SELECT * FROM user WHERE email_user='$email' AND pwd_user='$pwd'";
 $query = $db->query($sql);
 $hitung = $query->num_rows;
 
 if ($hitung!==0) {
  $ambil = $query->fetch_assoc();

  extract($ambil);

  
  if ($level_user==='pb') {
   $_SESSION['pb']=$email;
   $_SESSION['id']=$id_user;
   header("Location:../index.php");
  } elseif ($level_user==='sw') {
   $_SESSION['sw']=$email;
   $_SESSION['id']=$id_user;
   header("Location:../index.php");
  }
 }else{
  header("location:../index.php?log=2");
 }
}
elseif (isset($_GET['logout'])) {
 session_destroy();
 
}
/**********************************************************/
//
//    Proses untuk User Siswa
//
/**********************************************************/
elseif (isset($_GET['absen'])) {
	if($_GET['absen']==1){
		$month = date("m");
		$day_tgl = date("d");
		$day = date("N");
		$hour = date("H:i");
		$status = "Menunggu";
		$sql = "INSERT INTO data_absen (
			id_user,
			id_bln,
			id_hri,
			id_tgl,
			jam_msk,
			st_jam_msk) VALUES (
			?,
			?,
			?,
			?,
			?,
			?)";
		if ($statement = $db->prepare($sql)) {
			$statement->bind_param(
				"iiiiss", $_SESSION['id_akun'], $month, $day, $day_tgl, $hour, $status
				);
			if ($statement->execute()) {
				// Absen sukses
				$db->close();
				header("location:../absen.php");
				alert('selamat pagi!');
			} else {
				header("location:../absen&ab=2");
			}
		}else {
			header("location:../absen&ab=2");
		}
		
	} else {
		// Absensi pulang -> melakukan Update jam pulang
		$id_user = mysqli_real_escape_string($db, $_SESSION['id_akun']);
		$id_bln = date("m");
		$day_tgl = date("d");
		$day = date("N");
		$hour = date("H:i");
		$status = "Menunggu";
		$sql = "UPDATE data_absen SET jam_klr=?, st_jam_klr=? WHERE id_user='$id_user' AND id_tgl='$day_tgl' AND id_bln='$id_bln'";

  if ($statement= $db->prepare($sql)) {
   $statement->bind_param(
    "ss", $hour, $status
    );
   if ($statement->execute()) {
    $db->close();
    header("location:../overtime.php");
    

   } else {
    header("location:../absen&ab=2");
   }
  } else {
   header("location:../absen&ab=2");
  }
  return;
 }
}


?>
