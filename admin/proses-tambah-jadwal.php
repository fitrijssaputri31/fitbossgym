<?php
session_start();
require '../koneksi.php';

// Cek keamanan: pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

// Ambil data dari formulir
$hari = $_POST['hari'];
$nama_kelas = $_POST['nama_kelas'];
$nama_coach = $_POST['nama_coach'];
$waktu = $_POST['waktu'];

// Validasi sederhana
if (empty($hari) || empty($nama_kelas) || empty($nama_coach) || empty($waktu)) {
    // Arahkan ke halaman gagal jika ada yang kosong
    header("Location: admin-gagal.php");
    exit();
}

// Siapkan perintah SQL untuk menyimpan data
$sql = "INSERT INTO class_schedule (day_of_week, class_name, coach_name, class_time) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $hari, $nama_kelas, $nama_coach, $waktu);

// Eksekusi perintah dan arahkan ke halaman yang sesuai
if (mysqli_stmt_execute($stmt)) {
    // Jika berhasil, arahkan ke halaman sukses
    header("Location: admin-sukses.php");
} else {
    // Jika gagal, arahkan ke halaman gagal
    header("Location: admin-gagal.php");
}

exit();
?>