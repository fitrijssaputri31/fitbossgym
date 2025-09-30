<?php
session_start();
require '../koneksi.php';

// Cek apakah user sudah login dan apakah rolenya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak, tendang ke halaman login
    header("Location: ../admin-login.html");
    exit();
}

// Ambil semua data member dari database
$sql = "SELECT * FROM customers ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Member - Admin FitBoss</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="admin-wrapper">
        <aside class="sidebar">
    <a href="../index.html" class="logo sidebar-logo">Fit<span>Boss</span></a>
    <nav class="sidebar-nav">
        <ul>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'member.php' ? 'active' : ''; ?>">
                <a href="member.php">Manajemen Member</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'schedule.php' ? 'active' : ''; ?>">
                <a href="schedule.php">Manajemen Jadwal</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'payments.php' ? 'active' : ''; ?>">
                <a href="payments.php">Konfirmasi Pembayaran</a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="logout-link">Logout</a>
    </div>
</aside>

        <main class="main-content">
            <header class="admin-header">
                <h1>Manajemen Member</h1>
                <p>Lihat, cari, dan kelola semua data member.</p>
            </header>

            <div class="toolbar">
                <div class="search-bar">
                    <input type="text" placeholder="Cari member berdasarkan nama atau email...">
                </div>
            </div>

            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID Member</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Status Membership</th>
                            <th>Aktif Hingga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    // Looping untuk menampilkan setiap baris data member
    while ($member = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <td>FIT-<?php echo $member['id']; ?></td>
            <td><?php echo htmlspecialchars($member['nama_lengkap']); ?></td>
            <td><?php echo htmlspecialchars($member['email']); ?></td>
            <td>
                <span class="status active">Aktif</span>
            </td>
            <td>
                21 Oktober 2025
            </td>
            <td><button class="btn btn-sm btn-secondary btn-detail">Lihat Detail</button></td>
        </tr>
    <?php
    } // Akhir dari loop while
    ?>
</tbody>
                </table>
            </div>
        </main>
    </div>
    <div id="detail-modal" class="modal">
    <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="close-modal">&times;</button>
            <h2 class="section-title">Detail Member</h2>
            
            <div class="admin-member-card">
                <div class="qr-code-admin">
                    <img src="../images/placeholder-qr.png" alt="QR Code Member">
                    <p><strong>ID Member:</strong> FIT-001</p>
                </div>
                <div class="member-info-admin">
                    <h3 class="member-name">Fitriani Jayus Saputri</h3>
                    <p><strong>Email:</strong> fitriani.js@example.com</p>
                    <p><strong>Status:</strong> <span class="status active">Aktif</span></p>
                    <p><strong>Aktif Hingga:</strong> 21 Oktober 2025</p>
                </div>
            </div>

            <div class="confirmation-section">
                <h4>Pembayaran Menunggu Konfirmasi</h4>
                <div class="summary-item">
                    <span>ID Transaksi: INV/2025/09/25/003</span>
                    <a href="../images/placeholder-bukti.jpg" target="_blank" class="proof-link">Lihat Bukti Pembayaran</a>
                    <span>Jumlah: <strong>Rp 275.000</strong></span>
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn btn-success">Konfirmasi Pembayaran</button>
                <button class="btn btn-secondary">Edit Data</button>
                <button class="btn btn-danger">Hapus Member</button>
            </div>
        </div>
    </div>
</div>
</div>

    <script>
    // Script untuk Modal Detail Member di Halaman Admin
    const detailModal = document.getElementById('detail-modal');
    const detailButtons = document.querySelectorAll('.btn-detail'); // Kita akan gunakan class
    const closeDetailModalBtn = detailModal.querySelector('.close-modal');
    const detailOverlay = detailModal.querySelector('.modal-overlay');

    function openDetailModal() {
        detailModal.style.display = 'block';
    }

    function closeDetailModal() {
        detailModal.style.display = 'none';
    }

    detailButtons.forEach(button => {
        button.addEventListener('click', openDetailModal);
    });

    closeDetailModalBtn.addEventListener('click', closeDetailModal);
    detailOverlay.addEventListener('click', closeDetailModal);
</script>

</body>
</html>