<?php
// Tampilkan semua error untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Memanggil file koneksi.php
require 'koneksi.php';

// 2. Menerima data dari formulir register.html
$nama_lengkap = $_POST['fullname'];
$email = $_POST['email'];
$nomor_telepon = $_POST['phone'];
$password = $_POST['password'];

// 3. Validasi sederhana (pastikan semua field terisi)
if (empty($nama_lengkap) || empty($email) || empty($nomor_telepon) || empty($password)) {
    die("Error: Semua kolom harus diisi!");
}

// 4. Enkripsi Password
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// 5. Menyiapkan dan Menjalankan Perintah SQL
$sql = "INSERT INTO users (nama_lengkap, email, nomor_telepon, password) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $nama_lengkap, $email, $nomor_telepon, $password_hashed);

// 6. Mengeksekusi statement dan Cek Hasil
if (mysqli_stmt_execute($stmt)) {
    // Jika registrasi berhasil, arahkan ke halaman sukses
    header("Location:register-sukses.html");
    exit();
} else {
    // Jika registrasi gagal, arahkan ke halaman gagal
    header("Location:gagal.html");
    exit();
}

// Menutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);

?>