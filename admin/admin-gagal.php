<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gagal - Admin FitBoss</title>
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
            
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="logout-link">Logout</a>
    </div>
</aside>

        <main class="main-content">
             <div class="status-card-container">
                <div class="status-card">
                    <span class="status-icon error">❌</span>
                    <h2 class="status-title">Terjadi Kesalahan!</h2>
                    <p class="status-subtitle">Data gagal disimpan karena terjadi kesalahan. Silakan periksa kembali data yang Anda masukkan.</p>
                    <div class="status-actions">
                        <a href="admin-add-schedule.html" class="btn btn-primary">Kembali ke Formulir</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>