-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Sep 2025 pada 14.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitboss_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `class_bookings`
--

CREATE TABLE `class_bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `class_schedule_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `coach_name` varchar(255) NOT NULL,
  `day_of_week` varchar(20) NOT NULL,
  `class_time` time NOT NULL,
  `class_image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `coaches`
--

CREATE TABLE `coaches` (
  `id` int(11) NOT NULL,
  `coach_name` varchar(255) NOT NULL,
  `coach_photo_url` varchar(255) DEFAULT NULL,
  `coach_expertise` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'member',
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `nama_lengkap`, `email`, `password`, `role`, `nomor_telepon`, `tanggal_daftar`) VALUES
(3, 'Fitriani Jayus Saputri', 'saputrifitriani876@gmail.com', '$2y$10$/GmFLSyGTFSoVdfXpQgLz.XtoJQL61JxoOwXE57AGP04hMlqoQtqe', 'admin', '082214045638', '2025-09-25 20:58:06'),
(9, 'yy', 'fitrianijayuscirebon@gmail.com', '$2y$10$AVLaGtyJuDlvR4Zg.ecMLuZOmA/5oJGmo6MjwFZehLwbEL7bnK9oO', 'member', '0895415368000', '2025-09-29 06:31:06'),
(10, 'aa', '2414101024@unma.ac.id', '$2y$10$nImYMK9H.NtZelJKhxAZn.48VMFuDH3gixMoK6RwU86mMgDjlSwLG', 'member', '09867565457', '2025-09-30 07:25:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `tipe_paket` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `memberships`
--

INSERT INTO `memberships` (`id`, `customer_id`, `coach_id`, `tipe_paket`, `tanggal_mulai`, `tanggal_berakhir`, `status`) VALUES
(5, 3, NULL, 'Gym + Class Membership (1 Bulan)', '2025-09-26', '2025-10-26', 'Menunggu Konfirmasi'),
(6, 3, NULL, 'Gym + Class Membership (1 Bulan)', '2025-09-26', '2025-10-26', 'Menunggu Konfirmasi'),
(7, 3, NULL, 'Gym + Class Membership (1 Bulan)', '2025-09-26', '2025-10-26', 'Menunggu Konfirmasi'),
(8, 3, NULL, 'Gym + Class Membership (1 Bulan)', '2025-09-26', '2025-10-26', 'Menunggu Konfirmasi'),
(9, 3, NULL, 'Gym + Class Membership (1 Bulan)', '2025-09-26', '2025-10-26', 'Menunggu Konfirmasi'),
(10, 10, NULL, 'Gym + Class', '2025-09-30', '2025-10-30', 'aktif'),
(11, 10, NULL, 'Gym + Class', '2025-09-30', '2025-10-30', 'aktif'),
(12, 10, NULL, 'Gym + Class', '2025-09-30', '2025-10-30', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `tanggal_bayar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Menunggu Konfirmasi',
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `membership_id`, `jumlah_bayar`, `metode_pembayaran`, `tanggal_bayar`, `status`, `bukti_pembayaran`) VALUES
(1, 5, 325000.00, 'transfer', '2025-09-26 10:14:58', 'Menunggu Konfirmasi', NULL),
(2, 6, 325000.00, 'transfer', '2025-09-26 10:28:10', 'Menunggu Konfirmasi', NULL),
(3, 7, 325000.00, 'transfer', '2025-09-26 10:28:47', 'Menunggu Konfirmasi', NULL),
(4, 8, 325000.00, 'qris', '2025-09-26 10:34:31', 'Menunggu Konfirmasi', NULL),
(5, 9, 325000.00, 'transfer', '2025-09-26 12:16:01', 'Menunggu Konfirmasi', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `class_bookings`
--
ALTER TABLE `class_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `class_schedule_id` (`class_schedule_id`);

--
-- Indeks untuk tabel `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `class_bookings`
--
ALTER TABLE `class_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `class_bookings`
--
ALTER TABLE `class_bookings`
  ADD CONSTRAINT `class_bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_bookings_ibfk_2` FOREIGN KEY (`class_schedule_id`) REFERENCES `class_schedule` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `memberships_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
