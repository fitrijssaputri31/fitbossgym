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
            <header class="admin-header">
                <h1>Dashboard</h1>
                <p>Selamat Datang kembali, Admin!</p>
            </header>

            <div class="stat-cards">
                <div class="stat-card">
                    <h4>Member Aktif</h4>
                    <p class="stat-number">150</p>
                </div>
                <div class="stat-card pending">
                    <h4>Pembayaran Menunggu Konfirmasi</h4>
                    <p class="stat-number">5</p>
                </div>
                <div class="stat-card">
                    <h4>Pendapatan (Bulan Ini)</h4>
                    <p class="stat-number">Rp 15.000.000</p>
                </div>
            </div>

            <div class="content-placeholder">
                <p>Area konten tambahan seperti chart atau tabel data terbaru.</p>
            </div>
        </main>
    </div>

</body>
</html>