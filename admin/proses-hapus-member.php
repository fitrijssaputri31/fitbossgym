<?php
session_start();
require '../koneksi.php';

// Cek keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

// Cek apakah ID member dikirim
if (isset($_GET['id'])) {
    $id_member = $_GET['id'];

    // Siapkan perintah SQL DELETE
    $sql = "DELETE FROM users WHERE id = ? AND role = 'member'";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_member);

    // Eksekusi dan arahkan kembali
    if (mysqli_stmt_execute($stmt)) {
        header("Location: member.php");
    } else {
        echo "Error: Gagal menghapus data.";
    }
    exit();

} else {
    header("Location: member.php");
    exit();
}
?>