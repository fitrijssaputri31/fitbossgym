<?php
// Selalu mulai file PHP yang menggunakan session dengan session_start()
session_start();

// 1. Panggil file koneksi
require 'koneksi.php';

// 2. Ambil data dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// 3. Validasi sederhana
if (empty($email) || empty($password)) {
    die("Error: Email dan password harus diisi!");
}

// 4. Siapkan query untuk mencari customer berdasarkan email
$sql = "SELECT * FROM customers WHERE email = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 5. Cek apakah customer ditemukan dan verifikasi password
if ($customer = mysqli_fetch_assoc($result)) {
    // Customer dengan email tersebut ditemukan, sekarang verifikasi passwordnya
    if (password_verify($password, $customer['password'])) {
        // Jika password cocok
        
        // Simpan informasi penting customer ke dalam session
        $_SESSION['customer_id'] = $customer['id'];
        $_SESSION['nama_lengkap'] = $customer['nama_lengkap'];
        
        // Arahkan ke halaman dashboard member
        header("Location: member/dashboard.html"); // Sesuaikan dengan lokasi folder Anda
        exit();

    } else {
        // Jika password salah
        echo "Login gagal! Password salah.";
        header("refresh:3;url=login.html");
        exit();
    }
} else {
    // Jika email tidak ditemukan
    echo "Login gagal! Email tidak terdaftar.";
    header("refresh:3;url=login.html");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);

?>