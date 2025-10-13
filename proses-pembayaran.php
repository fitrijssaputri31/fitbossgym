<?php
// Mulai session untuk mendapatkan data member yang login
session_start();

// =============================================
// BAGIAN DEBUGGING (TAMBAHAN)
// =============================================
// Tampilkan semua error PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debugging Proses Pembayaran...</h1>";

// Cek apakah session user ada
if (isset($_SESSION['user_id'])) {
    echo "<p><strong>Status Login:</strong> OK. user ID: " . $_SESSION['user_id'] . "</p>";
} else {
    echo "<p><strong>Status Login:</strong> GAGAL. user tidak terdeteksi. Silakan login dulu.</p>";
    // Hentikan skrip jika tidak login
    exit(); 
}

// Cek data yang dikirim dari formulir
echo "<h3>Data yang Diterima dari Form (POST):</h3>";
echo "<pre>";
print_r($_POST);
echo "</pre>";
// =============================================
// AKHIR BAGIAN DEBUGGING
// =============================================


// Panggil file koneksi
require 'koneksi.php';

// Ambil ID user dari session
$user_id = $_SESSION['user_id'];

// Ambil data dari form pembayaran
$tipe_paket = $_POST['tipe_paket'];
$durasi_bulan = (int)$_POST['durasi_bulan'];
$total_bayar = (float)$_POST['total_bayar'];
$metode_pembayaran = $_POST['payment_method'];

// Hitung tanggal mulai dan berakhir
$tanggal_mulai = date("Y-m-d");
$tanggal_berakhir = date("Y-m-d", strtotime("+$durasi_bulan month"));

// --- PROSES TRANSAKSI DATABASE ---
mysqli_begin_transaction($koneksi);

try {
    // 1. INSERT ke tabel 'memberships'
    $sql_membership = "INSERT INTO memberships (user_id, tipe_paket, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?)";
    $stmt_membership = mysqli_prepare($koneksi, $sql_membership);
    $status_membership = "Menunggu Konfirmasi";
    mysqli_stmt_bind_param($stmt_membership, "issss", $user_id, $tipe_paket, $tanggal_mulai, $tanggal_berakhir, $status_membership);
    mysqli_stmt_execute($stmt_membership);

    $membership_id = mysqli_insert_id($koneksi);

    // 2. INSERT ke tabel 'transactions'
    $sql_transaction = "INSERT INTO transactions (membership_id, jumlah_bayar, metode_pembayaran, status) VALUES (?, ?, ?, ?)";
    $stmt_transaction = mysqli_prepare($koneksi, $sql_transaction);
    $status_transaksi = "Menunggu Konfirmasi";
    mysqli_stmt_bind_param($stmt_transaction, "idss", $membership_id, $total_bayar, $metode_pembayaran, $status_transaksi);
    mysqli_stmt_execute($stmt_transaction);

    mysqli_commit($koneksi);
    
    echo "<p><strong>Status Database:</strong> SUKSES menyimpan data!</p>";
    // Arahkan ke halaman konfirmasi
    header("Location: member/konfirmasi.html");
    exit();

} catch (mysqli_sql_exception $exception) {
    mysqli_rollback($koneksi);
    
    echo "<p><strong>Status Database:</strong> GAGAL menyimpan data! Error: " . $exception->getMessage() . "</p>";
    // Arahkan ke halaman gagal
    // header("Location: gagal.html");
    // exit();
}

?>