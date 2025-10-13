<?php
// Selalu mulai session untuk bisa mengaksesnya
session_start();

// 1. Hapus semua variabel session
session_unset();

// 2. Hancurkan session
session_destroy();

// 3. Arahkan pengguna kembali ke halaman utama
header("Location: index.php");
exit();

?>