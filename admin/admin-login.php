<?php
session_start();

// Jika pengguna sudah login, langsung arahkan sesuai peran, JANGAN tampilkan form lagi
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php"); // Sesuaikan dengan nama file Anda
        exit();
    } else { // Jika yang login member, arahkan ke dashboard member
        header("Location: member/dashboard.html"); // Sesuaikan path jika perlu
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - FitBoss Gym</title>
    <link rel="stylesheet" href="style.css">
    </head>
<body class="auth-page">
    <div class="auth-container">
        <a href="index.php" class="logo auth-logo">Fit<span>Boss</span></a>
        <div class="auth-card">
            <h2>ADMIN LOGIN</h2>
            <form action="proses-login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary auth-btn">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>