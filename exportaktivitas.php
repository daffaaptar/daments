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

// Query basis data untuk mengambil data aktivitas berdasarkan ID
$query_activity = select("
    SELECT
        activity.tanggal,
        activity.tipe_activity AS type_activity,
        DATE_FORMAT(activity.start_date, '%d-%M-%Y') AS start_date,
        DATE_FORMAT(activity.end_date, '%d-%M-%Y') AS end_date,
        activity.status_activity AS status_activity,
        activity.detail_activity AS detail_activity
    FROM
        activity
    WHERE
        activity.id_akun = $id_user;
");

// Check if there are any rows returned
if (empty($query_activity)) {
    echo "<p>Tidak ada data aktivitas yang ditemukan untuk akun ini.</p>";
    exit;
}

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header ke file Excel
$sheet->setCellValue('A1', 'Nama :');
$sheet->setCellValue('B1', 'Jabatan :');
$sheet->setCellValue('A2', 'No');
$sheet->setCellValue('B2', 'Tanggal Mulai');
$sheet->setCellValue('C2', 'Tanggal Selesai');
$sheet->setCellValue('D2', 'Status Aktivitas');
$sheet->setCellValue('E2', 'Detail Aktivitas');

// Mengisi data nama dan jabatan (role) di atas tabel
$query_nama_jabatan = select("SELECT nama, level FROM akun WHERE id_akun = $id_user ");
$nama = $query_nama_jabatan[0]['nama'];
$level = $query_nama_jabatan[0]['level'];
$sheet->setCellValue('A3', $nama);
$sheet->setCellValue('B3', $level);

// Mengisi data aktivitas ke dalam file Excel
$no = 1;
$row = 3;

foreach ($query_activity as $key => $activity) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $activity['tanggal_mulai']);
    $sheet->setCellValue('C' . $row, $activity['tanggal_selesai']);
    $sheet->setCellValue('D' . $row, $activity['status_aktivitas']);
    $sheet->setCellValue('E' . $row, $activity['detail_aktivitas']);
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

$sheet->getStyle('A1:E' . $border)->applyFromArray($styleArray);

// Menyimpan file Excel
$writer = new Xlsx($spreadsheet);
$filename = "Detail_Activity_$id_user.xlsx";
$writer->save($filename);

// Mengirim file Excel untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
readfile($filename);
unlink($filename); // Menghapus file setelah diunduh
exit;
?>
