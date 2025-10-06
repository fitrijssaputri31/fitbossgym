<?php
session_start();
require '../koneksi.php';

// Cek keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

// Cek apakah data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil semua data dari formulir
    $id_jadwal = $_POST['id'];
    $hari = $_POST['hari'];
    $nama_kelas = $_POST['nama_kelas'];
    $nama_coach = $_POST['nama_coach'];
    $waktu = $_POST['waktu'];

    // Validasi sederhana
    if (empty($id_jadwal) || empty($hari) || empty($nama_kelas) || empty($nama_coach) || empty($waktu)) {
        header("Location: admin-gagal.php");
        exit();
    }

    // Siapkan perintah SQL UPDATE
    $sql = "UPDATE class_schedule SET day_of_week = ?, class_name = ?, coach_name = ?, class_time = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    
    // Bind parameter ke statement
    mysqli_stmt_bind_param($stmt, "ssssi", $hari, $nama_kelas, $nama_coach, $waktu, $id_jadwal);

    // Eksekusi statement dan arahkan
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, arahkan kembali ke halaman daftar jadwal
        header("Location: schedule.php"); // Arahkan kembali ke daftar jadwal
    } else {
        // Jika gagal, arahkan ke halaman gagal
        header("Location: admin-gagal.php");
    }
    exit();

} else {
    // Jika halaman diakses tanpa metode POST, kembali ke dashboard
    header("Location: dashboard.php");
    exit();
}
?>