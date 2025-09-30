<?php
// Selalu mulai file PHP yang menggunakan session dengan session_start()
session_start();

// Panggil file koneksi
require 'koneksi.php';

// Ambil data dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi sederhana
if (empty($email) || empty($password)) {
    // Arahkan ke halaman gagal jika ada field kosong
    header("Location: gagal.html");
    exit();
}

// Siapkan query untuk mencari customer berdasarkan email
$sql = "SELECT * FROM customers WHERE email = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Cek apakah customer ditemukan dan verifikasi password
if ($customer = mysqli_fetch_assoc($result)) {
    // Customer dengan email tersebut ditemukan, sekarang verifikasi passwordnya
    if (password_verify($password, $customer['password'])) {
        // Jika password cocok
        
        // Simpan informasi penting customer ke dalam session
        $_SESSION['customer_id'] = $customer['id'];
        $_SESSION['nama_lengkap'] = $customer['nama_lengkap'];
        $_SESSION['role'] = $customer['role']; // <-- SIMPAN PERAN (ROLE) KE SESSION
        
        // **LOGIKA PENGALIHAN BERDASARKAN PERAN (ROLE)**
        if ($customer['role'] == 'admin') {
            // Jika perannya admin, arahkan ke dashboard admin
            header("Location: admin/dashboard.php");
        } else {
            // Jika perannya member, arahkan ke dashboard member
            header("Location: member/dashboard.html");
        }
        exit();

    } else {
        // Jika password salah, arahkan ke halaman gagal
        header("Location: gagal.html");
        exit();
    }
} else {
    // Jika email tidak ditemukan, arahkan ke halaman gagal
    header("Location: gagal.html");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);

?>