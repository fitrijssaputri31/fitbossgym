<?php
session_start();
require '../koneksi.php';

// Cek keamanan: pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin-login.php");
    exit();
}

// 1. Query untuk menghitung jumlah member aktif
$sql_member_aktif = "SELECT COUNT(id) as total FROM memberships WHERE status = 'Aktif'";
$result_member_aktif = mysqli_query($koneksi, $sql_member_aktif);
$data_member_aktif = mysqli_fetch_assoc($result_member_aktif);
$jumlah_member_aktif = $data_member_aktif['total'];

// 2. Query untuk menghitung pembayaran menunggu konfirmasi
$sql_pembayaran_pending = "SELECT COUNT(id) as total FROM transactions WHERE status = 'Menunggu Konfirmasi'";
$result_pembayaran_pending = mysqli_query($koneksi, $sql_pembayaran_pending);
$data_pembayaran_pending = mysqli_fetch_assoc($result_pembayaran_pending);
$jumlah_pembayaran_pending = $data_pembayaran_pending['total'];

// 3. Query untuk menghitung total pendapatan
$sql_pendapatan = "SELECT SUM(jumlah_bayar) as total FROM transactions WHERE status = 'Berhasil'";
$result_pendapatan = mysqli_query($koneksi, $sql_pendapatan);
$data_pendapatan = mysqli_fetch_assoc($result_pendapatan);
$total_pendapatan = $data_pendapatan['total'] ?? 0; // Default 0 jika tidak ada data

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FitBoss Gym</title>
    <link rel="stylesheet" href="../style.css">
    </head>
<body>

    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <header class="admin-header">
                <h1>Dashboard</h1>
                <p>Selamat Datang kembali, Admin!</p>
            </header>

            <div class="stat-cards">
                <div class="stat-card">
                    <h4>Member Aktif</h4>
                    <p class="stat-number"><?php echo $jumlah_member_aktif; ?></p>
                </div>
                <div class="stat-card pending">
                    <h4>Pembayaran Menunggu Konfirmasi</h4>
                    <p class="stat-number"><?php echo $jumlah_pembayaran_pending; ?></p>
                </div>
                <div class="stat-card">
                    <h4>Pendapatan (Bulan Ini)</h4>
                    <p class="stat-number">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></p>
                </div>
            </div>

            <div class="content-placeholder">
                <p>Area konten tambahan seperti chart atau tabel data terbaru.</p>
            </div>
        </main>
    </div>

</body>
</html>