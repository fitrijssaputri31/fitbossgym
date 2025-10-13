<?php
session_start();

// Panggil file koneksi di sini
require '../koneksi.php';

// Cek apakah pengguna sudah login DAN apakah perannya adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak, hancurkan session yang mungkin "rusak" dan arahkan ke halaman login admin
    session_unset();
    session_destroy();
    header("Location: ../admin-login.php");
    exit();
}

// Selanjutnya adalah kode spesifik untuk setiap halaman...



// Query SQL BARU: Menggabungkan 3 tabel (users, memberships, transactions)
// Query ini mengambil data member beserta membership & transaksi TERBARU mereka.
$sql = "SELECT 
            c.id AS user_id, 
            c.nama_lengkap, 
            c.email, 
            m.id AS membership_id,
            m.status AS status_membership, 
            m.tanggal_berakhir,
            t.id AS transaction_id,
            t.status AS transaction_status,
            t.jumlah_bayar,
            t.bukti_pembayaran
        FROM 
            users c
        LEFT JOIN 
            (SELECT *, ROW_NUMBER() OVER(PARTITION BY user_id ORDER BY tanggal_mulai DESC) as rn FROM memberships) m 
        ON 
            c.id = m.user_id AND m.rn = 1
        LEFT JOIN
            transactions t ON m.id = t.membership_id
        WHERE
            c.role = 'member'
        ORDER BY 
            c.id DESC";

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
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <header class="admin-header">
                <h1>Manajemen Member</h1>
                <p>Lihat, cari, dan kelola semua data member.</p>
            </header>

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
                                $status = $member['status_membership'];
                                $status_lower = strtolower($status ?? '');
                                $status_class = ($status_lower == 'aktif' || $status_lower == 'menunggu konfirmasi') ? 'active' : 'expired';
                        ?>
                            <tr>
                                <td>FIT-<?php echo $member['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($member['nama_lengkap']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td>
                                    <?php if ($status): ?>
                                        <span class="status <?php echo $status_class; ?>"><?php echo htmlspecialchars($status); ?></span>
                                    <?php else: echo '-'; endif; ?>
                                </td>
                                <td>
                                    <?php echo $member['tanggal_berakhir'] ? date('d F Y', strtotime($member['tanggal_berakhir'])) : '-'; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-secondary btn-detail" 
                                            data-id="<?php echo $member['user_id']; ?>"
                                            data-nama="<?php echo htmlspecialchars($member['nama_lengkap']); ?>"
                                            data-email="<?php echo htmlspecialchars($member['email']); ?>"
                                            data-status="<?php echo htmlspecialchars($status); ?>"
                                            data-status-class="<?php echo $status_class; ?>"
                                            data-aktif-hingga="<?php echo $member['tanggal_berakhir'] ? date('d F Y', strtotime($member['tanggal_berakhir'])) : '-'; ?>"
                                            data-trans-id="<?php echo $member['transaction_id']; ?>"
                                            data-member-id="<?php echo $member['membership_id']; ?>"
                                            data-jumlah="<?php echo 'Rp ' . number_format($member['jumlah_bayar'] ?? 0, 0, ',', '.'); ?>"
                                            data-bukti="<?php echo htmlspecialchars($member['bukti_pembayaran']); ?>"
                                            data-trans-status="<?php echo $member['transaction_status']; ?>">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        <?php
                            }
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
                    <p><strong id="modal-id-member"></strong></p>
                </div>
                <div class="member-info-admin">
                    <h3 class="member-name" id="modal-nama"></h3>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Status:</strong> <span class="status" id="modal-status"></span></p>
                    <p><strong>Aktif Hingga:</strong> <span id="modal-aktif-hingga"></span></p>
                </div>
            </div>

            <div class="confirmation-section" id="modal-konfirmasi-section">
                <h4>Pembayaran Menunggu Konfirmasi</h4>
                <div class="summary-item">
                    <span id="modal-id-transaksi"></span>
                    <a href="#" target="_blank" class="proof-link" id="modal-bukti-link">Lihat Bukti Pembayaran</a>
                    <span id="modal-jumlah"></span>
                </div>
            </div>

            <div class="modal-actions">
                <a href="#" id="konfirmasi-btn" class="btn btn-success">Konfirmasi Pembayaran</a>
                <a href="#" id="edit-btn" class="btn btn-secondary">Edit Data</a>
                <a href="#" id="hapus-btn" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus member ini?');">Hapus Member</a>
            </div>
        </div>
    </div>

   <script>
    const detailModal = document.getElementById('detail-modal');
    const detailButtons = document.querySelectorAll('.btn-detail');
    const closeDetailModalBtn = detailModal.querySelector('.close-modal');
    const detailOverlay = detailModal.querySelector('.modal-overlay');

    // Ambil semua elemen di dalam modal yang akan diubah
    const modalIdMember = document.getElementById('modal-id-member');
    const modalNama = document.getElementById('modal-nama');
    const modalEmail = document.getElementById('modal-email');
    const modalStatus = document.getElementById('modal-status');
    const modalAktifHingga = document.getElementById('modal-aktif-hingga');
    const modalKonfirmasiSection = document.getElementById('modal-konfirmasi-section');
    const modalIdTransaksi = document.getElementById('modal-id-transaksi');
    const modalBuktiLink = document.getElementById('modal-bukti-link');
    const modalJumlah = document.getElementById('modal-jumlah');
    const konfirmasiBtn = document.getElementById('konfirmasi-btn');
    const editBtn = document.getElementById('edit-btn');
    const hapusBtn = document.getElementById('hapus-btn');

    function openDetailModal(data) {
        // Isi semua data dari tombol ke dalam modal
        modalIdMember.textContent = `ID Member: FIT-${data.id}`;
        modalNama.textContent = data.nama;
        modalEmail.textContent = data.email;
        modalStatus.textContent = data.status || '-';
        modalStatus.className = `status ${data.statusClass}`;
        modalAktifHingga.textContent = data.aktifHingga;

        // Logika untuk menampilkan/menyembunyikan bagian konfirmasi
        if (data.transStatus === 'Menunggu Konfirmasi') {
            modalKonfirmasiSection.style.display = 'block';
            modalIdTransaksi.textContent = `ID Transaksi: ${data.transId || '-'}`;
            modalJumlah.innerHTML = `Jumlah: <strong>${data.jumlah || '-'}</strong>`;
            
            // Link bukti pembayaran
            if (data.bukti) {
                modalBuktiLink.href = `../uploads/${data.bukti}`; // Ganti 'uploads' jika nama folder berbeda
                modalBuktiLink.style.display = 'inline';
            } else {
                modalBuktiLink.style.display = 'none';
            }
            
            // Update link tombol konfirmasi
            konfirmasiBtn.href = `proses-konfirmasi.php?trans_id=${data.transId}&member_id=${data.memberId}`;
            konfirmasiBtn.style.display = 'inline-block';
        } else {
            modalKonfirmasiSection.style.display = 'none';
            konfirmasiBtn.style.display = 'none';
        }

        // Update link tombol edit dan hapus
        editBtn.href = `member.php?id=${data.id}`;
        hapusBtn.href = `proses-hapus-member.php?id=${data.id}`;

        detailModal.style.display = 'block';
    }

    function closeDetailModal() {
        detailModal.style.display = 'none';
    }

    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Ambil semua data dari atribut 'data-*' tombol yang diklik
            const data = {
                id: this.dataset.id,
                nama: this.dataset.nama,
                email: this.dataset.email,
                status: this.dataset.status,
                statusClass: this.dataset.statusClass,
                aktifHingga: this.dataset.aktifHingga,
                transId: this.dataset.transId,
                memberId: this.dataset.memberId,
                jumlah: this.dataset.jumlah,
                bukti: this.dataset.bukti,
                transStatus: this.dataset.transStatus
            };
            openDetailModal(data);
        });
    });

    closeDetailModalBtn.addEventListener('click', closeDetailModal);
    detailOverlay.addEventListener('click', closeDetailModal);
    </script>
</body>
</html>