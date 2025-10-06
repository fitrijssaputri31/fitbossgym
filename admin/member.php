<?php
session_start();
require '../koneksi.php';

// Cek keamanan: pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin-login.html");
    exit();
}

// Query SQL BARU: Menggabungkan tabel customers dan memberships
// Query ini mengambil data customer beserta data membership TERBARU mereka.
$sql = "SELECT 
            c.id, 
            c.nama_lengkap, 
            c.email, 
            m.status AS status_membership, 
            m.tanggal_berakhir 
        FROM 
            customers c
        LEFT JOIN 
            (SELECT * FROM memberships ORDER BY tanggal_mulai DESC) m 
        ON 
            c.id = m.customer_id
        WHERE
            c.role = 'member'
        GROUP BY 
            c.id
        ORDER BY 
            c.id DESC";

$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FitBoss Gym</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>

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
    if (mysqli_num_rows($result) > 0) {
        while ($member = mysqli_fetch_assoc($result)) {
            // Ambil status dan ubah menjadi huruf kecil untuk perbandingan
            $status = $member['status_membership'];
            $status_lower = strtolower($status ?? ''); // <-- Ubah ke huruf kecil
            
            $status_class = 'expired'; // Default-nya merah
            
            // Periksa status yang sudah diubah ke huruf kecil
            if ($status_lower == 'aktif' || $status_lower == 'menunggu konfirmasi') {
                $status_class = 'active'; // Ubah jadi hijau
            }
    ?>
        <tr>
            <td>FIT-<?php echo $member['id']; ?></td>
            <td><?php echo htmlspecialchars($member['nama_lengkap']); ?></td>
            <td><?php echo htmlspecialchars($member['email']); ?></td>
            <td>
                <?php if ($status): ?>
                    <span class="status <?php echo $status_class; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </span>
                <?php else: ?>
                    <span>-</span>
                <?php endif; ?>
            </td>
            <td>
                <?php 
                    if ($member['tanggal_berakhir']) {
                        echo date('d F Y', strtotime($member['tanggal_berakhir']));
                    } else {
                        echo '-';
                    }
                ?>
            </td>
            <td><button class="btn btn-sm btn-secondary btn-detail" data-id="<?php echo $member['id']; ?>">Lihat Detail</button></td>
        </tr>
    <?php
        } // Akhir dari loop while
    } else {
        echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada data member.</td></tr>";
    }
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
                <a href="#" id="hapus-member-btn" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus member ini? Seluruh data membership dan transaksinya juga akan terhapus permanen.');">Hapus Member</a>
            </div>
        </div>
    </div>
   <script>
    const detailModal = document.getElementById('detail-modal');
    const detailButtons = document.querySelectorAll('.btn-detail');
    const closeDetailModalBtn = detailModal.querySelector('.close-modal');
    const detailOverlay = detailModal.querySelector('.modal-overlay');
    const hapusBtn = document.getElementById('hapus-member-btn');

    function openDetailModal(memberId) {
        // Update link tombol hapus dengan ID member yang benar
        hapusBtn.href = `proses-hapus-member.php?id=${memberId}`;

        // Tampilkan modal
        detailModal.style.display = 'block';

        // Di sini nanti kita akan tambahkan kode untuk mengisi detail member lainnya
    }

    function closeDetailModal() {
        detailModal.style.display = 'none';
    }

    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const memberId = this.getAttribute('data-id');
            openDetailModal(memberId);
        });
    });

    closeDetailModalBtn.addEventListener('click', closeDetailModal);
    detailOverlay.addEventListener('click', closeDetailModal);
</script>

    
</body>
</html>