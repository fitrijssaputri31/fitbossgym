<?php

// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$password = ""; // Di XAMPP default-nya kosong
$database = "fitboss_db";

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>