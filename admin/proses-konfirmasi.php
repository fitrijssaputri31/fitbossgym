<?php
session_start();
require '../koneksi.php';

// Cek keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

// Cek apakah ID transaksi dan ID membership dikirim
if (isset($_GET['trans_id']) && isset($_GET['member_id'])) {
    $transaction_id = $_GET['trans_id'];
    $membership_id = $_GET['member_id'];

    // Siapkan perintah UPDATE untuk tabel transactions
    $sql_trans = "UPDATE transactions SET status = 'Berhasil' WHERE id = ?";
    $stmt_trans = mysqli_prepare($koneksi, $sql_trans);
    mysqli_stmt_bind_param($stmt_trans, "i", $transaction_id);

    // Siapkan perintah UPDATE untuk tabel memberships
    $sql_member = "UPDATE memberships SET status = 'Aktif' WHERE id = ?";
    $stmt_member = mysqli_prepare($koneksi, $sql_member);
    mysqli_stmt_bind_param($stmt_member, "i", $membership_id);

    // Eksekusi kedua perintah
    if (mysqli_stmt_execute($stmt_trans) && mysqli_stmt_execute($stmt_member)) {
        // Jika berhasil, arahkan kembali ke halaman member
        header("Location: member.php");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: Gagal mengkonfirmasi pembayaran.";
    }
    exit();

} else {
    // Jika tidak ada ID, kembali ke halaman member
    header("Location: member.php");
    exit();
}
?>