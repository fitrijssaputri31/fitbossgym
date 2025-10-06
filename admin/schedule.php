<?php
session_start();
require '../koneksi.php';

// Cek keamanan: pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin-login.html");
    exit();
}

// Ambil semua data jadwal dari database, diurutkan berdasarkan hari dan waktu
$sql = "SELECT * FROM class_schedule ORDER BY FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), class_time";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jadwal - Admin FitBoss</title>
    <link rel="stylesheet" href="../style.css">
    </head>
<body>

    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <header class="admin-header">
                <h1>Manajemen Jadwal Kelas</h1>
                <p>Tambah, ubah, atau hapus jadwal kelas mingguan.</p>
            </header>

            <div class="toolbar">
                <a href="admin-add-schedule.php" class="btn btn-primary">+ Tambah Jadwal Baru</a>
            </div>

            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Nama Kelas</th>
                            <th>Nama Coach</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Cek apakah ada data yang ditemukan
                        if (mysqli_num_rows($result) > 0) {
                            // Looping untuk menampilkan setiap baris data
                            while ($schedule = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($schedule['day_of_week']); ?></td>
                                <td><?php echo htmlspecialchars($schedule['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($schedule['coach_name']); ?></td>
                                <td><?php echo date('H:i', strtotime($schedule['class_time'])); ?></td>
                                <td>
                                    <a href="admin-edit-schedule.php?id=<?php echo $schedule['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <a href="proses-hapus-jadwal.php?id=<?php echo $schedule['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php
                            } // Akhir dari loop while
                        } else {
                            // Tampilkan pesan jika tabel kosong
                            echo "<tr><td colspan='5' style='text-align:center;'>Belum ada jadwal kelas yang ditambahkan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>