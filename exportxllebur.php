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

// Query basis data untuk mengambil data overtime berdasarkan ID
$query_absen = select("
    SELECT
        overtime.id_lembur,
        DATE_FORMAT(overtime.tanggal, '%d-%M-%Y') AS tanggal,
        DATE_FORMAT(overtime.datang, '%H:%i') AS jam_masuk,
        DATE_FORMAT(overtime.pulang, '%H:%i') AS jam_keluar,
        CASE
            WHEN TIME_TO_SEC(TIMEDIFF(overtime.pulang, overtime.datang)) > 28800 THEN
                CONCAT('8 jam + ', FLOOR((TIME_TO_SEC(TIMEDIFF(overtime.pulang, overtime.datang)) - 28800) / 3600), ' jam ', FLOOR(((TIME_TO_SEC(TIMEDIFF(overtime.pulang, overtime.datang)) - 28800) % 3600) / 60), ' menit')
            ELSE
                TIME_FORMAT(TIMEDIFF(overtime.pulang, overtime.datang), '%H jam %i menit')
        END AS durasi_lembur,
        overtime.agenda,
        overtime.nota
    FROM
        overtime
    WHERE
        overtime.id_lembur = $id_user;
");

// Check if there are any rows returned
if (empty($query_absen)) {
    echo "<p>Tidak ada data lembur yang ditemukan untuk akun ini.</p>";
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
$sheet->setCellValue('B2', 'Tanggal');
$sheet->setCellValue('C2', 'Jam Masuk');
$sheet->setCellValue('D2', 'Jam Keluar');
$sheet->setCellValue('E2', 'Durasi + Lembur');
$sheet->setCellValue('F2', 'Agenda');
$sheet->setCellValue('G2', 'Nota');

// Mengisi data nama dan jabatan (role) di atas tabel
$query_nama_jabatan = select("SELECT nama, level FROM akun WHERE id_akun = $id_user ");
$nama = $query_nama_jabatan[0]['nama'];
$level = $query_nama_jabatan[0]['level'];
$sheet->setCellValue('A3', $nama);
$sheet->setCellValue('B3', $level);

// Mengisi data overtime ke dalam file Excel
$no = 1;
$row = 3;

foreach ($query_absen as $key => $absen) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $absen['tanggal']);
    $sheet->setCellValue('C' . $row, $absen['jam_masuk']);
    $sheet->setCellValue('D' . $row, $absen['jam_keluar']);
    $sheet->setCellValue('E' . $row, $absen['durasi_lembur']);
    $sheet->setCellValue('F' . $row, $absen['agenda']);
    $sheet->setCellValue('G' . $row, $absen['nota']);
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

$sheet->getStyle('A1:G' . $border)->applyFromArray($styleArray);

// Menyimpan file Excel
$writer = new Xlsx($spreadsheet);
$filename = "Detail_Lembur_$id_user.xlsx";
$writer->save($filename);

// Mengirim file Excel untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
readfile($filename);
unlink($filename); // Menghapus file setelah diunduh
exit;
?>
