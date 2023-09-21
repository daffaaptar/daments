<?php
// Contoh waktu jam masuk dan jam keluar
$jam_masuk = "09:00";
$jam_keluar = "17:30";

// Pecah jam masuk dan jam keluar menjadi jam dan menit
list($jam_masuk_jam, $jam_masuk_menit) = explode(':', $jam_masuk);
list($jam_keluar_jam, $jam_keluar_menit) = explode(':', $jam_keluar);

// Hitung selisih jam dan menit
$selisih_jam = $jam_keluar_jam - $jam_masuk_jam;
$selisih_menit = $jam_keluar_menit - $jam_masuk_menit;

// Handle jika hasil selisih menit negatif
if ($selisih_menit < 0) {
    $selisih_jam--; // Kurangi satu jam
    $selisih_menit += 60; // Tambahkan 60 menit
}

// Cetak durasi
echo "Durasi kerja: $selisih_jam jam $selisih_menit menit";
?>