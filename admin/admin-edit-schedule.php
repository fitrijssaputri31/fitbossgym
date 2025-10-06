<?php
session_start();
require '../koneksi.php';

// Cek keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin-login.html");
    exit();
}

// Cek apakah ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: schedule.php");
    exit();
}

$id_jadwal = $_GET['id'];

// Ambil data jadwal yang akan diedit dari database
$sql = "SELECT * FROM class_schedule WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_jadwal);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$schedule = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan, kembali ke halaman daftar
if (!$schedule) {
    header("Location:schedule.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - Admin FitBoss</title>
    <link rel="stylesheet" href="../style.css">
    </head>
<body>

    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <header class="admin-header">
                <h1>Edit Jadwal Kelas</h1>
                <p>Ubah detail jadwal kelas di bawah ini.</p>
            </header>

            <div class="form-card">
                <form action="proses-edit-jadwal.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">

                    <div class="input-group">
                        <label for="hari">Hari</label>
                        <select id="hari" name="hari" required>
                            <option value="Senin" <?php echo ($schedule['day_of_week'] == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                            <option value="Selasa" <?php echo ($schedule['day_of_week'] == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                            <option value="Rabu" <?php echo ($schedule['day_of_week'] == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                            <option value="Kamis" <?php echo ($schedule['day_of_week'] == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                            <option value="Jumat" <?php echo ($schedule['day_of_week'] == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                            <option value="Sabtu" <?php echo ($schedule['day_of_week'] == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" value="<?php echo htmlspecialchars($schedule['class_name']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="nama_coach">Nama Coach</label>
                        <input type="text" id="nama_coach" name="nama_coach" value="<?php echo htmlspecialchars($schedule['coach_name']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="waktu">Waktu</label>
                        <input type="time" id="waktu" name="waktu" value="<?php echo $schedule['class_time']; ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary auth-btn">Simpan Perubahan</button>
                </form>
            </div>
        </main>
    </div>

</body>
</html>