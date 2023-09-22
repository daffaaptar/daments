<?php 

// include "config\database.php"

// $id = $_GET['id_user'];

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   // Mendapatkan data yang dikirimkan dari formulir
//   $keterangan = $_POST['keterangan'];

//   // Query SQL untuk melakukan update hanya pada bagian keterangan
//   $update_query = "UPDATE tabel_nama SET keterangan = '$keterangan' WHERE id = $id";

//   if (mysqli_query($koneksi, $update_query)) {
//       echo "Keterangan berhasil diupdate!";
//   } else {
//       echo "Terjadi kesalahan saat mengupdate keterangan: " . mysqli_error($koneksi);
//   }
// }

// // Mendapatkan data yang sudah ada dari database
// $query = "SELECT * FROM tabel_nama WHERE id = $id";
// $result = mysqli_query($koneksi, $query);
// $data = mysqli_fetch_assoc($result);
?>