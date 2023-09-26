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

// Ambil parameter ID dari URL
$id_user = $_GET['id_user'];

// Koneksi ke database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=amal", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi untuk menjalankan kueri database
function select($query) {
    global $pdo;
    try {
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Kueri database gagal: " . $e->getMessage());
    }
}

// Query basis data untuk mengambil data absensi berdasarkan ID
$query_absen = select("
    SELECT
        data_absen.id_absen,
        tanggal.nama_tgl AS tanggal,
        bulan.nama_bln AS bulan,
        hari.nama_hri AS hari,
        data_absen.jam_msk,
        data_absen.jam_klr,
        data_absen.keterangan
    FROM
        data_absen
    JOIN tanggal ON data_absen.id_tgl = tanggal.id_tgl
    JOIN bulan ON data_absen.id_bln = bulan.id_bln
    JOIN hari ON data_absen.id_hri = hari.id_hri
    WHERE
        data_absen.id_user = $id_user;
");

// Check if there are any rows returned
if (empty($query_absen)) {
    echo "<p>Tidak ada data absensi yang ditemukan untuk akun ini.</p>";
    exit;
}

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header ke file Excel
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Tanggal');
$sheet->setCellValue('C1', 'Jam Masuk');
$sheet->setCellValue('D1', 'Jam Keluar');
$sheet->setCellValue('E1', 'Durasi');
$sheet->setCellValue('F1', 'Keterangan');

// Mengisi data absensi ke dalam file Excel
$no = 1;
$row = 2;

foreach ($query_absen as $key => $absen) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, "$absen[hari], $absen[tanggal] $absen[bulan] " . date("Y"));
    $sheet->setCellValue('C' . $row, $absen['jam_msk']);
    $sheet->setCellValue('D' . $row, $absen['jam_klr']);

    $jam_masuk = DateTime::createFromFormat('H:i', $absen['jam_msk']);
    $jam_keluar = DateTime::createFromFormat('H:i', $absen['jam_klr']);

    if ($jam_masuk && $jam_keluar) {
        $selisih_waktu = $jam_masuk->diff($jam_keluar);
        $sheet->setCellValue('E' . $row, $selisih_waktu->format('%H jam %i menit'));
    } else {
        $sheet->setCellValue('E' . $row, "Format waktu tidak valid");
    }

    $sheet->setCellValue('F' . $row, $absen['keterangan']);
    $row++;
}

// Mengatur tampilan tabel pada file Excel
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$border = $row - 1;

$sheet->getStyle('A1:F' . $border)->applyFromArray($styleArray);



// Menyimpan file Excel
$writer = new Xlsx($spreadsheet);
$filename = "Detail_Absensi_$id_user.xlsx";
$writer->save($filename);

// Mengirim file Excel untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
readfile($filename);
unlink($filename); // Menghapus file setelah diunduh
exit;
?>
