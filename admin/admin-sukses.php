<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukses - Admin FitBoss</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="admin-wrapper">
         <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <div class="status-card-container">
                <div class="status-card">
                    <span class="status-icon success">✅</span>
                    <h2 class="status-title">Data Berhasil Disimpan!</h2>
                    <p class="status-subtitle">Jadwal kelas baru telah berhasil ditambahkan ke dalam sistem.</p>
                    <div class="status-actions">
                        <a href="admin-add-schedule.php" class="btn btn-secondary">Tambah Data Lagi</a>
                        <a href="schedule.php" class="btn btn-primary">Kembali ke Daftar Jadwal</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>