<?php 

function update_data_absen($id_absen, $tanggal, $jam_msk, $jam_klr, $keterangan) {
  // Implementasikan koneksi ke database Anda di sini
  $servername = "localhost";
  $username = "your_username";
  $password = "your_password";
  $database = "your_database";

  $conn = new mysqli($servername, $username, $password, $database);

  // Check the connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Gunakan prepared statement untuk menghindari SQL injection
  $stmt = $conn->prepare("UPDATE data_absen SET tanggal = ?, jam_msk = ?, jam_klr = ?, keterangan = ? WHERE id_absen = ?");
  $stmt->bind_param("ssssi", $tanggal, $jam_msk, $jam_klr, $keterangan, $id_absen);
  $stmt->execute();

  // Periksa apakah pembaruan berhasil
  $affected_rows = $stmt->affected_rows;
  
  // Tutup statement dan koneksi database
  $stmt->close();
  $conn->close();

  return $affected_rows;
}
?>