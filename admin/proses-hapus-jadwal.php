<?php
session_start();
require '../koneksi.php';

// Cek keamanan: pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

// Cek apakah ID jadwal dikirim melalui URL
if (isset($_GET['id'])) {
    $id_jadwal = $_GET['id'];

    // Siapkan perintah SQL untuk menghapus data
    $sql = "DELETE FROM class_schedule WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_jadwal); // 'i' berarti tipe datanya Integer

    // Eksekusi perintah
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, arahkan kembali ke halaman manajemen jadwal
        header("Location: schedule.php");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: Gagal menghapus data.";
    }
    exit();

} else {
    // Jika tidak ada ID yang dikirim, kembali ke halaman utama admin
    header("Location: dashboard.php");
    exit();
}
?>