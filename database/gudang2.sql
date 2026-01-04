-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 31 Des 2025 pada 23.43
-- Versi server: 8.0.30
-- Versi PHP: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'Edit Barang', 'Memperbarui data barang: Hop Sykes', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:15:12', '2025-12-21 11:15:12'),
(2, 1, 'Tambah Barang', 'Menambahkan barang baru: Destiny Simon', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:26:13', '2025-12-21 11:26:13'),
(3, 1, 'Edit Barang', 'Memperbarui data barang: Arden Stevenson', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:28:34', '2025-12-21 11:28:34'),
(4, 1, 'Tambah Barang', 'Menambahkan barang baru: Orla Hampton', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:36:49', '2025-12-21 11:36:49'),
(5, 1, 'Hapus Barang', 'Menghapus barang: Destiny Simon', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:38:51', '2025-12-21 11:38:51'),
(6, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251221-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:48:01', '2025-12-21 11:48:01'),
(7, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 11:54:00', '2025-12-21 11:54:00'),
(8, 1, 'Produksi', 'Menyelesaikan produksi: PROD-20251221-001. Output: 1 pcs', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 12:06:30', '2025-12-21 12:06:30'),
(9, 1, 'Hapus Barang', 'Menghapus barang: Orla Hampton', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 12:08:24', '2025-12-21 12:08:24'),
(10, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 04:00:07', '2025-12-22 04:00:07'),
(11, 1, 'Edit Barang', 'Memperbarui data barang: Arden Stevenson', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 04:01:10', '2025-12-22 04:01:10'),
(12, 1, 'Hapus Barang', 'Menghapus barang: Acetic Acid 99% (CH3COOH)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 04:23:22', '2025-12-22 04:23:22'),
(13, 1, 'Edit Barang', 'Memperbarui data barang: Kain Fleece Combed 30s - Super Black', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 05:00:15', '2025-12-22 05:00:15'),
(14, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: test@example.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 06:01:38', '2025-12-22 06:01:38'),
(15, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: test@example.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 06:02:10', '2025-12-22 06:02:10'),
(16, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: test@example.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 06:02:18', '2025-12-22 06:02:18'),
(17, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: test@example.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 06:02:43', '2025-12-22 06:02:43'),
(18, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: test@example.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 06:14:01', '2025-12-22 06:14:01'),
(19, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 06:15:12', '2025-12-22 06:15:12'),
(20, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-22 23:54:01', '2025-12-22 23:54:01'),
(21, 1, 'Tambah Barang', 'Menambahkan barang baru: Jeremy Potts', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 00:35:50', '2025-12-23 00:35:50'),
(22, 1, 'Edit Barang', 'Memperbarui data barang: Bearing Mesin Knitting 878', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 00:37:03', '2025-12-23 00:37:03'),
(23, 1, 'Hapus Barang', 'Menghapus barang: Bearing Mesin Knitting 878', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 00:37:27', '2025-12-23 00:37:27'),
(24, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251223-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 02:01:28', '2025-12-23 02:01:28'),
(25, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 14:34:14', '2025-12-23 14:34:14'),
(26, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251223-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 15:17:04', '2025-12-23 15:17:04'),
(27, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251223-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 15:19:10', '2025-12-23 15:19:10'),
(28, 1, 'Hapus Barang', 'Menghapus barang: Jeremy Potts', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 15:23:06', '2025-12-23 15:23:06'),
(29, 1, 'Update Profil', 'Memperbarui informasi profil pribadi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:22:39', '2025-12-23 17:22:39'),
(30, 1, 'Update Profil', 'Memperbarui informasi profil pribadi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:23:15', '2025-12-23 17:23:15'),
(31, 1, 'Update Profil', 'Memperbarui informasi profil pribadi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:23:25', '2025-12-23 17:23:25'),
(32, 1, 'Update Profil', 'Memperbarui informasi profil pribadi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:24:10', '2025-12-23 17:24:10'),
(33, 1, 'Update Profil', 'Memperbarui informasi profil pribadi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:24:20', '2025-12-23 17:24:20'),
(34, 1, 'Ganti Password', 'Mengubah password akun', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:25:00', '2025-12-23 17:25:00'),
(35, 1, 'Edit User', 'Memperbarui data user: Andi Dwi Suharto', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:26:11', '2025-12-23 17:26:11'),
(36, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:36:36', '2025-12-23 17:36:36'),
(37, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-23 17:48:43', '2025-12-23 17:48:43'),
(38, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 01:30:18', '2025-12-24 01:30:18'),
(39, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251224-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 02:08:16', '2025-12-24 02:08:16'),
(40, 1, 'Produksi', 'Menyelesaikan produksi: PROD-20251224-001. Batch: BCH-20251224-001, Output: 791 Kilogram, Biaya: 22.168.293', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 02:09:42', '2025-12-24 02:09:42'),
(41, 1, 'Tambah Supplier', 'Menambahkan supplier baru: Charlotte Gonzalez', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 04:20:05', '2025-12-24 04:20:05'),
(42, 1, 'Hapus Supplier', 'Menghapus supplier: Basil Summers', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 04:20:18', '2025-12-24 04:20:18'),
(43, 1, 'Hapus Supplier', 'Menghapus supplier: Charlotte Gonzalez', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 04:20:27', '2025-12-24 04:20:27'),
(44, 1, 'Tambah Supplier', 'Menambahkan supplier baru: Noelani Terrell', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 04:20:38', '2025-12-24 04:20:38'),
(45, 1, 'Hapus Supplier', 'Menghapus supplier: Noelani Terrell', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 04:21:03', '2025-12-24 04:21:03'),
(46, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 15:43:54', '2025-12-24 15:43:54'),
(47, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251224-017', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 16:01:21', '2025-12-24 16:01:21'),
(48, 1, 'Produksi', 'Menyelesaikan produksi: PROD-20251224-017. Batch: BCH-20251224-007, Output: 3 Kilogram, Biaya: 95.271', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 16:07:24', '2025-12-24 16:07:24'),
(49, 1, 'Tambah Barang', 'Menambahkan barang baru: Alana Barry', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 17:13:56', '2025-12-24 17:13:56'),
(50, 1, 'Tambah Barang', 'Menambahkan barang baru: Maia Benson', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 18:12:24', '2025-12-24 18:12:24'),
(51, 1, 'Edit Barang', 'Memperbarui data barang: Oil Mesin Knitting 387', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 18:14:19', '2025-12-24 18:14:19'),
(52, 1, 'Edit User', 'Memperbarui data user: Agus Produksi / PPIC', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 19:37:39', '2025-12-24 19:37:39'),
(53, 6, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 19:37:54', '2025-12-24 19:37:54'),
(54, 6, 'Produksi', 'Membuat rencana produksi baru: PROD-20251225-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 19:42:02', '2025-12-24 19:42:02'),
(55, 6, 'Produksi', 'Menyetujui permintaan material: PROD-20251225-001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 19:44:19', '2025-12-24 19:44:19'),
(56, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 19:47:41', '2025-12-24 19:47:41'),
(57, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-24 19:58:27', '2025-12-24 19:58:27'),
(58, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 00:01:13', '2025-12-25 00:01:13'),
(59, 1, 'Login', 'Berhasil masuk ke sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 01:11:00', '2025-12-25 01:11:00'),
(60, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 02:23:32', '2025-12-25 02:23:32'),
(61, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 02:25:03', '2025-12-25 02:25:03'),
(62, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 17:58:45', '2025-12-25 17:58:45'),
(63, 1, 'Edit User', 'Memperbarui data user: Andi Dwi Suharto', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:03:19', '2025-12-25 18:03:19'),
(64, 1, 'Edit User', 'Memperbarui data user: Agus Produksi / PPIC', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:08:59', '2025-12-25 18:08:59'),
(65, 1, 'Edit User', 'Memperbarui data user: Budi Gudang', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:09:38', '2025-12-25 18:09:38'),
(66, 1, 'Edit User', 'Memperbarui data user: Siti Finance', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:10:15', '2025-12-25 18:10:15'),
(67, 1, 'Edit User', 'Memperbarui data user: Hendra Operasional', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:10:43', '2025-12-25 18:10:43'),
(68, 1, 'Edit User', 'Memperbarui data user: Adam Miftah (Admin)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:11:17', '2025-12-25 18:11:17'),
(69, 1, 'Edit User', 'Memperbarui data user: Dedi Supervisor', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:11:59', '2025-12-25 18:11:59'),
(70, 1, 'Edit Barang', 'Memperbarui data barang: Belt Mesin Knitting 208', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:20:38', '2025-12-25 18:20:38'),
(71, 4, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 18:26:11', '2025-12-25 18:26:11'),
(72, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 19:05:52', '2025-12-25 19:05:52'),
(73, 1, 'Catat Pembayaran', 'Mencatat pembayaran Pelunasan Piutang untuk INV-20251225-0001 sebesar Rp 188.512', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 20:31:38', '2025-12-25 20:31:38'),
(74, 1, 'Catat Pembayaran', 'Mencatat pembayaran Pelunasan Hutang untuk PO-20251226-0001 sebesar Rp 19.434.019', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 20:32:08', '2025-12-25 20:32:08'),
(75, 1, 'Tambah User', 'Menambahkan user baru: Erica Berger (finance)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 20:51:15', '2025-12-25 20:51:15'),
(76, 1, 'Hapus User', 'Menghapus user: Erica Berger', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 20:51:23', '2025-12-25 20:51:23'),
(77, 1, 'Login', 'Berhasil masuk ke sistem', '140.213.14.55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-25 21:13:58', '2025-12-25 21:13:58'),
(78, 1, 'Login', 'Berhasil masuk ke sistem', '112.215.151.22', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 21:25:58', '2025-12-25 21:25:58'),
(79, 1, 'Update Hak Akses', 'Memperbarui pengaturan hak akses untuk roles: admin, manajer, finance, kepala_gudang, staff_gudang, produksi', '112.215.151.134', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 22:45:07', '2025-12-25 22:45:07'),
(80, 3, 'Login', 'Berhasil masuk ke sistem', '112.215.151.134', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 22:46:48', '2025-12-25 22:46:48'),
(81, 1, 'Login', 'Berhasil masuk ke sistem', '112.215.151.134', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 22:47:58', '2025-12-25 22:47:58'),
(82, 1, 'Hapus User', 'Menghapus user: Adam Miftah (Admin)', '112.215.151.134', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 22:51:49', '2025-12-25 22:51:49'),
(83, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: admin@gmail.com', '112.215.235.195', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 22:56:20', '2025-12-25 22:56:20'),
(84, 1, 'Login', 'Berhasil masuk ke sistem', '112.215.235.195', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-25 22:56:31', '2025-12-25 22:56:31'),
(85, 1, 'Login', 'Berhasil masuk ke sistem', '182.3.42.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-26 00:55:41', '2025-12-26 00:55:41'),
(86, 1, 'Login', 'Berhasil masuk ke sistem', '140.213.0.231', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-26 01:03:40', '2025-12-26 01:03:40'),
(87, 1, 'Login', 'Berhasil masuk ke sistem', '140.213.11.146', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-26 04:26:57', '2025-12-26 04:26:57'),
(88, 1, 'Login', 'Berhasil masuk ke sistem', '82.102.25.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-26 17:51:13', '2025-12-26 17:51:13'),
(89, 1, 'Login', 'Berhasil masuk ke sistem', '140.213.6.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-26 17:56:03', '2025-12-26 17:56:03'),
(90, 1, 'Login', 'Berhasil masuk ke sistem', '140.213.15.172', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-26 23:47:11', '2025-12-26 23:47:11'),
(91, 1, 'Login', 'Berhasil masuk ke sistem', '112.215.65.252', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-27 05:35:59', '2025-12-27 05:35:59'),
(92, 1, 'Login', 'Berhasil masuk ke sistem', '112.215.45.217', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 05:51:47', '2025-12-27 05:51:47'),
(93, 7, 'Login', 'Berhasil masuk ke sistem', '112.215.45.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 05:59:14', '2025-12-27 05:59:14'),
(94, 7, 'Produksi', 'Membuat rencana produksi baru: PROD-20251227-001', '112.215.152.159', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 06:56:53', '2025-12-27 06:56:53'),
(95, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 13:05:53', '2025-12-27 13:05:53'),
(96, 1, 'Tambah Barang', 'Menambahkan barang baru: Josephine Herman', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 13:36:41', '2025-12-27 13:36:41'),
(97, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251227-002', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 13:58:11', '2025-12-27 13:58:11'),
(98, 1, 'Produksi', 'Menyetujui permintaan material: PROD-20251227-002', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 13:58:24', '2025-12-27 13:58:24'),
(99, 1, 'Catat Pembayaran', 'Mencatat pembayaran Pelunasan Hutang untuk PO-20251227-0001 sebesar Rp 26.409', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 15:27:40', '2025-12-27 15:27:40'),
(100, 1, 'Buat Permintaan Material', 'Dibuat permintaan material baru: MR-20251227-0001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:25:12', '2025-12-27 16:25:12'),
(101, 1, 'Produksi', 'Membuat rencana produksi baru: PROD-20251227-003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:31:28', '2025-12-27 16:31:28'),
(102, 1, 'Permintaan Material', 'Membuat permintaan material baru: PROD-20251227-004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:38:45', '2025-12-27 16:38:45'),
(103, 1, 'Produksi', 'Menyetujui permintaan material: PROD-20251227-004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:38:54', '2025-12-27 16:38:54'),
(104, 1, 'Produksi', 'Menyetujui permintaan material: PROD-20251227-004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:38:54', '2025-12-27 16:38:54'),
(105, 1, 'Produksi', 'Menyetujui permintaan material: PROD-20251227-003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:39:16', '2025-12-27 16:39:16'),
(106, 1, 'Produksi', 'Menyetujui permintaan material: PROD-20251227-003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:39:16', '2025-12-27 16:39:16'),
(107, 1, 'Edit User', 'Memperbarui data user: Andi Dwi Suharto', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 16:54:25', '2025-12-27 16:54:25'),
(108, 1, 'Update Hak Akses', 'Memperbarui pengaturan hak akses untuk roles: admin, manajer, finance, kepala_gudang, staff_gudang, produksi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 17:00:16', '2025-12-27 17:00:16'),
(109, 1, 'Tambah Barang', 'Menambahkan barang baru: Cheryl Ortiz', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 17:06:14', '2025-12-27 17:06:14'),
(110, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: supervisor@gudang.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 18:19:49', '2025-12-27 18:19:49'),
(111, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-27 18:20:08', '2025-12-27 18:20:08'),
(112, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 15:14:32', '2025-12-28 15:14:32'),
(113, 1, 'Hapus User', 'Menghapus user: Test User', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 15:16:20', '2025-12-28 15:16:20'),
(114, 1, 'Hapus User', 'Menghapus user: Adam Miftah (Admin)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 15:16:25', '2025-12-28 15:16:25'),
(115, 1, 'Edit User', 'Memperbarui data user: Dedi Supervisor', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 16:08:35', '2025-12-28 16:08:35'),
(116, 1, 'Edit User', 'Memperbarui data user: Hendra Operasional', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 16:08:54', '2025-12-28 16:08:54'),
(117, 1, 'Edit User', 'Memperbarui data user: Siti Finance', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 16:09:21', '2025-12-28 16:09:21'),
(118, 1, 'Edit User', 'Memperbarui data user: Budi Gudang', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 16:09:49', '2025-12-28 16:09:49'),
(119, 1, 'Edit User', 'Memperbarui data user: Agus Produksi / PPIC', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-28 16:10:21', '2025-12-28 16:10:21'),
(120, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:34:47', '2025-12-30 06:34:47'),
(121, 7, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:47:17', '2025-12-30 06:47:17'),
(122, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 07:58:02', '2025-12-30 07:58:02'),
(123, 1, 'Tambah Barang', 'Menambahkan barang baru: Ashton Munoz', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 08:25:12', '2025-12-30 08:25:12'),
(124, 1, 'Hapus Barang', 'Menghapus barang: Ashton Munoz', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 08:25:37', '2025-12-30 08:25:37'),
(125, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 10:13:55', '2025-12-30 10:13:55'),
(126, 1, 'Hapus Barang', 'Menghapus barang: Acetic Acid 99% (CH3COOH)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 10:20:30', '2025-12-30 10:20:30'),
(127, 1, 'Hapus Barang', 'Menghapus barang: Aquaproof', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 10:20:34', '2025-12-30 10:20:34'),
(128, 1, 'Hapus Barang', 'Menghapus barang: Avitex Cat Tembok', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 10:20:39', '2025-12-30 10:20:39'),
(129, 1, 'Update Hak Akses', 'Memperbarui pengaturan hak akses untuk roles: admin, finance, kepala_gudang, staff_gudang, produksi, manajer', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 12:19:29', '2025-12-30 12:19:29'),
(130, 1, 'Update Hak Akses', 'Memperbarui konfigurasi hak akses untuk role: Admin, Finance, Kepala_gudang, Staff_gudang, Produksi, Manajer', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 12:20:37', '2025-12-30 12:20:37'),
(131, 1, 'Update Hak Akses', 'Memperbarui konfigurasi hak akses untuk role: Admin, Manajer, Finance, Kepala_gudang, Staff_gudang, Produksi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 12:20:53', '2025-12-30 12:20:53'),
(132, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 13:08:48', '2025-12-30 13:08:48'),
(133, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 15:38:32', '2025-12-30 15:38:32'),
(134, 1, 'Update Hak Akses', 'Memperbarui konfigurasi hak akses untuk: Admin, Manajer, Finance, Kepala_gudang, Staff_gudang, Produksi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 16:11:17', '2025-12-30 16:11:17'),
(135, 1, 'Update Hak Akses', 'Memperbarui konfigurasi hak akses untuk: Admin, Manajer, Finance, Kepala_gudang, Staff_gudang, Produksi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 16:11:23', '2025-12-30 16:11:23'),
(136, NULL, 'Login Gagal', 'Percobaan login gagal untuk email: admin@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 19:12:14', '2025-12-31 19:12:14'),
(137, 1, 'Login', 'Berhasil masuk ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 19:16:48', '2025-12-31 19:16:48'),
(138, 1, 'Hapus Permanen', 'Menghapus permanen Customer: Phelan May', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:28:56', '2025-12-31 20:28:56'),
(139, 1, 'Hapus Permanen', 'Menghapus permanen Customer: Walter Long', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:28:59', '2025-12-31 20:28:59'),
(140, 1, 'Hapus Permanen', 'Menghapus permanen Item: Avitex Cat Tembok', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:29:26', '2025-12-31 20:29:26'),
(141, 1, 'Hapus Permanen', 'Menghapus permanen Item: Aquaproof', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:29:30', '2025-12-31 20:29:30'),
(142, 1, 'Hapus Permanen', 'Menghapus permanen Item: Acetic Acid 99% (CH3COOH)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:29:33', '2025-12-31 20:29:33'),
(143, 1, 'Hapus Permanen', 'Menghapus permanen Item: Ashton Munoz', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:29:36', '2025-12-31 20:29:36'),
(144, 1, 'Hapus Permanen', 'Menghapus permanen Customer: Gillian Berry', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:31:05', '2025-12-31 20:31:05'),
(145, 1, 'Ganti Password', 'Mengubah password akun', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:32:24', '2025-12-31 20:32:24'),
(146, 1, 'Permintaan Material', 'Menyelesaikan permintaan material: PROD-20251227-004. Batch: BCH-20260101-001, Output: 147 Kilogram, Biaya: 4.760.912', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 20:46:26', '2025-12-31 20:46:26'),
(147, 1, 'Edit User', 'Memperbarui data user: Adam Miftah (Admin)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-31 22:04:59', '2025-12-31 22:04:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cash_flows`
--

CREATE TABLE `cash_flows` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cash_flows`
--

INSERT INTO `cash_flows` (`id`, `type`, `amount`, `transaction_date`, `category`, `reference_type`, `reference_id`, `notes`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'in', 202695.00, '2025-12-23', 'Penjualan', 'Sale', 7, 'Pembayaran INV-20251223-0002', 1, '2025-12-23 02:51:00', '2025-12-23 02:51:00', NULL),
(2, 'out', 1075710974.00, '2014-10-14', 'Pembelian', 'Pembelian', 5, 'Pembayaran PO-20141014-0001', 1, '2025-12-23 16:01:46', '2025-12-23 16:01:46', NULL),
(3, 'out', 26777346.00, '2025-12-23', 'Pembelian', 'Pembelian', 6, 'Pembayaran PO-20251223-0001', 1, '2025-12-23 16:04:10', '2025-12-23 16:04:10', NULL),
(4, 'in', 312676.00, '2025-12-23', 'Penjualan', 'Sale', 8, 'Pembayaran INV-20251223-0003', 1, '2025-12-23 16:05:14', '2025-12-23 16:05:14', NULL),
(5, 'out', 16.00, '2025-12-24', 'Biaya Operasional', 'Expense', 3, 'Pengeluaran: Sed nostrum dicta in', 1, '2025-12-23 17:14:01', '2025-12-23 17:14:01', NULL),
(7, 'in', 49405.00, '2025-12-24', 'Penjualan', 'Sale', 9, 'Update Pembayaran INV-20251224-0001', 1, '2025-12-24 04:34:23', '2025-12-24 04:34:23', NULL),
(8, 'out', 15000018.00, '2025-12-24', 'Pembelian', 'Pembelian', 7, 'Pembayaran PO-20251224-0001', 1, '2025-12-24 04:35:12', '2025-12-24 04:35:12', NULL),
(9, 'out', 29409.00, '2025-12-24', 'Pembelian', 'Pembelian', 8, 'Pembayaran PO-20251224-0002', 1, '2025-12-24 04:38:23', '2025-12-24 04:38:23', NULL),
(10, 'in', 124160.00, '2025-12-25', 'Penjualan', 'Sale', 10, 'Pembayaran INV-20251225-0001', 1, '2025-12-24 18:16:14', '2025-12-24 18:16:14', NULL),
(11, 'out', 13273323.00, '2022-04-05', 'Pembelian', 'Pembelian', 9, 'Pembayaran PO-20220405-0001', 1, '2025-12-24 18:19:08', '2025-12-24 18:19:08', NULL),
(12, 'out', 422077008.00, '2025-12-26', 'Pelunasan Hutang', 'Pembelian', 7, 'Pelunasan PO-20251224-0001', 4, '2025-12-25 18:27:39', '2025-12-25 18:27:39', NULL),
(13, 'out', 5154.00, '2025-12-26', 'Pelunasan Hutang', 'Pembelian', 8, 'Pelunasan PO-20251224-0002', 4, '2025-12-25 18:27:57', '2025-12-25 18:27:57', NULL),
(14, 'out', 8.00, '2021-10-20', 'Pelunasan Hutang', 'Pembelian', 9, 'Pelunasan PO-20220405-0001', 4, '2025-12-25 19:04:08', '2025-12-25 19:04:08', NULL),
(15, 'out', 2706.00, '2025-12-26', 'Pelunasan Hutang', 'Pembelian', 8, 'Pelunasan PO-20251224-0002', 4, '2025-12-25 19:04:33', '2025-12-25 19:04:33', NULL),
(16, 'out', 12.00, '1980-01-26', 'Pelunasan Hutang', 'Pembelian', 9, 'Pelunasan PO-20220405-0001', 1, '2025-12-25 19:06:19', '2025-12-25 19:06:19', NULL),
(17, 'out', 18233642.00, '2004-02-02', 'Pembelian', 'Pembelian', 10, 'Pembayaran PO-20040202-0001', 1, '2025-12-25 19:07:29', '2025-12-25 19:07:29', NULL),
(18, 'out', 1.00, '2025-12-26', 'Pelunasan Hutang', 'Pembelian', 9, 'Pelunasan PO-20220405-0001', 1, '2025-12-25 19:12:44', '2025-12-25 19:12:44', NULL),
(19, 'out', 86335248.00, '2007-10-30', 'Pembelian', 'Pembelian', 11, 'Pembayaran PO-20071030-0001', 1, '2025-12-25 19:54:22', '2025-12-25 19:54:22', NULL),
(20, 'out', 18000.00, '2025-12-26', 'Pembelian', 'Pembelian', 12, 'Pembayaran PO-20251226-0001', 1, '2025-12-25 20:05:50', '2025-12-25 20:05:50', NULL),
(21, 'in', 188512.00, '2018-01-08', 'Pelunasan Piutang', 'Sale', 10, 'Pelunasan INV-20251225-0001', 1, '2025-12-25 20:31:38', '2025-12-25 20:31:38', NULL),
(22, 'out', 19434019.00, '2025-12-26', 'Pelunasan Hutang', 'Pembelian', 12, 'Pelunasan PO-20251226-0001', 1, '2025-12-25 20:32:08', '2025-12-25 20:32:08', NULL),
(23, 'in', 2162385.00, '2025-12-27', 'Penjualan', 'Sale', 11, 'Pembayaran INV-20251227-0001', 1, '2025-12-26 20:00:02', '2025-12-26 20:00:02', NULL),
(24, 'out', 3000.00, '2025-12-27', 'Pembelian', 'Pembelian', 13, 'Pembayaran PO-20251227-0001', 1, '2025-12-27 14:01:08', '2025-12-27 14:01:08', NULL),
(25, 'out', 26409.00, '2025-12-27', 'Pelunasan Hutang', 'Pembelian', 13, 'Pelunasan PO-20251227-0001', 1, '2025-12-27 15:27:40', '2025-12-27 15:27:40', NULL),
(26, 'out', 58.00, '1991-11-11', 'Pembelian', 'Pembelian', 14, 'Pembayaran PO-19911111-0001', 1, '2025-12-27 15:30:07', '2025-12-27 15:30:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'generic',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Benang (Yarn)', 'benang-yarn', 'yarn', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(2, 'Bahan Kimia (Chemical)', 'bahan-kimia-chemical', 'chemical', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(3, 'Zat Warna (Dyestuff)', 'zat-warna-dyestuff', 'dyestuff', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(4, 'Kain Greige (Kain Mentah)', 'kain-greige-kain-mentah', 'fabric', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(5, 'Kain Jadi (Finished Fabric)', 'kain-jadi-finished-fabric', 'fabric', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(6, 'Sparepart Mesin Rajut', 'sparepart-mesin-rajut', 'sparepart', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(7, 'Sparepart Mesin Dyeing', 'sparepart-mesin-dyeing', 'sparepart', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(8, 'Alat Tulis & Umum', 'alat-tulis-umum', 'general', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(9, 'Bahan Laboratorium', 'bahan-laboratorium', 'chemical', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(10, 'Cat & Pelapis (Paint)', 'cat-pelapis-paint', 'cat', '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(11, 'Bahan Baku Benang', 'bahan-baku-benang', 'generic', '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(12, 'Bahan Kimia', 'bahan-kimia', 'generic', '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(13, 'Kain Greige', 'kain-greige', 'generic', '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(14, 'Kain Jadi', 'kain-jadi', 'generic', '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(15, 'Sparepart Mesin', 'sparepart-mesin', 'generic', '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cats`
--

CREATE TABLE `cats` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_paint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(8,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hex_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nama Toko Anda',
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'INV',
  `invoice_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '{PREFIX}/{YEAR}/{MONTH}/{ID}',
  `sj_prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'SJ',
  `sj_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '{PREFIX}/{YEAR}/{MONTH}/{ID}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `company_settings`
--

INSERT INTO `company_settings` (`id`, `name`, `address`, `phone`, `email`, `logo`, `favicon`, `created_at`, `updated_at`, `invoice_prefix`, `invoice_format`, `sj_prefix`, `sj_format`) VALUES
(1, 'NBC Indonesia', 'JL. MALIGI 1 LOT A9-A10 KAWASAN INDUSTRI KIIC, KARAWANG 41361 JAWA BARAT', '62-21-8904245', 'contact@nbc-jp.com', 'company_logo/ftuw0Nao7JKlXjeDKI4AsDX3mT8qb0PPom8YyM1f.png', 'company_logo/Qgn6fAtAIausKaP3oLQ1ahv5pkJUXfELAJagUbuq.png', '2025-12-16 16:39:55', '2025-12-24 19:57:20', 'INV', '{PREFIX}/{YEAR}/{MONTH}/{ID}', 'SJ', '{PREFIX}/{YEAR}/{MONTH}/{ID}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Individu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'PT Garmen Jaya Makmur', 'info@garmenjaya.com', '021-5551234', 'Jl. Industri No. 12, Kawasan Industri Jababeka, Bekasi', 'Factory', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(3, 'Toko Tekstil Abadi Sentosa', 'sales@tekstilabadi.com', '022-4445678', 'Pasar Baru Trade Center Lt. 1 No. 45, Bandung', 'Distributor', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(4, 'CV Busana Muslimah Sejahtera', 'admin@busanamuslim.co.id', '021-3337890', 'Jl. Raya Ciputat No. 88, Tangerang Selatan', 'Small Business', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(5, 'Fashion Wear Inc.', 'procurement@fashionwear.com', '021-2224321', 'SCBD Tower A Lt. 10, Jakarta Selatan', 'Brand', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(6, 'PT Seragam Sekolah Indonesia', 'kontak@seragamsekolah.id', '024-6669876', 'Jl. Pahlawan No. 5, Semarang', 'Factory', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(7, 'Butik Cantik Menawan', 'hello@butikcantik.com', '0812-3456-7890', 'Jl. Merdeka No. 10, Surabaya', 'Butik', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(8, 'Konveksi Berkah Ramadhan', 'berkahkonveksi@gmail.com', '0878-9900-1122', 'Jl. Kebon Jeruk No. 22, Jakarta Barat', 'Small Business', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(9, 'PT Tekstil Ekspor Mandiri', 'export@tekstilekspor.com', '021-1112233', 'Kawasan Berikat Nusantara, Cakung, Jakarta Utara', 'Exporter', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(10, 'Distributor Benang Nusantara', 'yarn@benangnusantara.net', '022-7778899', 'Kopo Indah Business Park, Bandung', 'Distributor', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL),
(11, 'Designer Studio Annisa', 'annisa@designer.id', '0811-2233-4455', 'Kemang Raya No. 15, Jakarta Selatan', 'Designer', '2025-12-23 15:27:28', '2025-12-23 15:27:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `proof_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `expenses`
--

INSERT INTO `expenses` (`id`, `category_id`, `user_id`, `expense_date`, `amount`, `description`, `proof_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 6, 1, '2025-12-24', 16.00, 'Sed nostrum dicta in', NULL, '2025-12-23 17:14:01', '2025-12-23 17:14:01', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Operasional', 'Biaya operasional sehari-hari', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(2, 'Gaji Karyawan', 'Pembayaran gaji staff', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(3, 'Listrik & Air', 'Tagihan utilitas bulanan', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(4, 'Perawatan & Perbaikan', 'Maintenance mesin dan gedung', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(5, 'ATK & Keperluan Kantor', 'Alat tuli kantor dan kebutuhan admin', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(6, 'Transportasi', 'Bensin, tol, dan biaya kirim', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(7, 'Konsumsi', 'Makan minum karyawan/tamu', '2025-12-22 04:12:40', '2025-12-22 04:12:40'),
(8, 'Lain-lain', 'Biaya tak terduga', '2025-12-22 04:12:40', '2025-12-22 04:12:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `product_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL,
  `current_stock` int NOT NULL DEFAULT '0',
  `stock` int NOT NULL,
  `min_stock` int NOT NULL DEFAULT '10',
  `category_id` bigint UNSIGNED NOT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `composition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_spec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gsm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paint_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volume` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texture` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motif` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finish_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `product_code`, `barcode`, `sku`, `name`, `purchase_price`, `price`, `current_stock`, `stock`, `min_stock`, `category_id`, `color_id`, `unit_id`, `description`, `image`, `color_name`, `color_code`, `composition`, `technical_spec`, `gsm`, `width`, `brand`, `paint_type`, `volume`, `size`, `texture`, `motif`, `grade`, `finish_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'XSECZKMCTU', '8326071164137', 'YRN-CC-20s', 'Benang Cotton Combed 20s', 41457.00, 43533.00, 0, 1921, 10, 1, NULL, 12, 'Benang Cotton Combed 20s 100% Cotton NBC Indonesia', 'items/polyester_thread.png', NULL, NULL, '100% Cotton', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-30 08:22:58', NULL),
(2, '2EUJZBWR6P', '1407863845841', 'YRN-CC-24s', 'Benang Cotton Combed 24s', 31426.00, 42472.00, 0, 2004, 10, 1, NULL, 12, 'Benang Cotton Combed 24s 100% Cotton NBC Indonesia', 'items/polyester_thread.png', NULL, NULL, '100% Cotton', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-30 08:22:58', NULL),
(3, '4N5RGUC7GJ', '4465821354767', 'YRN-CC-30s', 'Benang Cotton Combed 30s', 39683.00, 46368.00, 0, 4165, 10, 1, NULL, 12, 'Benang Cotton Combed 30s 100% Cotton NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% Cotton', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(4, 'E0DMMTMGVI', '6207894891232', 'YRN-CC-40s', 'Benang Cotton Combed 40s', 28896.00, 52774.00, 0, 2892, 10, 1, NULL, 12, 'Benang Cotton Combed 40s 100% Cotton NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% Cotton', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(5, '3QNQVMFURC', '1546078025702', 'YRN-CD-20s', 'Benang Cotton Carded 20s', 42155.00, 55888.00, 0, 1404, 10, 1, NULL, 12, 'Benang Cotton Carded 20s 100% Cotton NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% Cotton', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(6, 'GLG5RWPNL2', '2000492394299', 'YRN-CD-24s', 'Benang Cotton Carded 24s', 36040.00, 42894.00, 0, 2165, 10, 1, NULL, 12, 'Benang Cotton Carded 24s 100% Cotton NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% Cotton', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(7, 'FCRYPC5A0X', '9781479439501', 'YRN-CD-30s', 'Benang Cotton Carded 30s', 25570.00, 52288.00, 0, 882, 10, 1, NULL, 12, 'Benang Cotton Carded 30s 100% Cotton NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% Cotton', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(8, 'QECKWSI2EX', '3352332172947', 'YRN-CD-40s', 'Benang Cotton Carded 40s', 40918.00, 54741.00, 0, 2185, 10, 1, NULL, 12, 'Benang Cotton Carded 40s 100% Cotton NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% Cotton', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(9, 'COPYW8QLDJ', '1306993761240', 'YRN-CVC-20s', 'Benang Chief Value Cotton 20s', 31935.00, 46030.00, 0, 2803, 10, 1, NULL, 12, 'Benang Chief Value Cotton 20s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(10, 'UBLOQHPTLU', '3788466204255', 'YRN-CVC-24s', 'Benang Chief Value Cotton 24s', 36286.00, 48496.00, 0, 4213, 10, 1, NULL, 12, 'Benang Chief Value Cotton 24s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(11, 'JYGCWVOTDN', '9028479509480', 'YRN-CVC-30s', 'Benang Chief Value Cotton 30s', 27018.00, 40675.00, 0, 1879, 10, 1, NULL, 12, 'Benang Chief Value Cotton 30s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(12, 'LEAY4POOXT', '7723769424557', 'YRN-CVC-40s', 'Benang Chief Value Cotton 40s', 39698.00, 40204.00, 0, 3832, 10, 1, NULL, 12, 'Benang Chief Value Cotton 40s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(13, 'CLVJUPAS2W', '3551833578781', 'YRN-TC-20s', 'Benang Tetoron Cotton 20s', 40003.00, 43532.00, 0, 4296, 10, 1, NULL, 12, 'Benang Tetoron Cotton 20s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(14, 'TDMEOAKCQD', '1695453663380', 'YRN-TC-24s', 'Benang Tetoron Cotton 24s', 32536.00, 41665.00, 0, 2394, 10, 1, NULL, 12, 'Benang Tetoron Cotton 24s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(15, 'OXNUZ8V1VH', '6812691512450', 'YRN-TC-30s', 'Benang Tetoron Cotton 30s', 33536.00, 41410.00, 0, 1404, 10, 1, NULL, 12, 'Benang Tetoron Cotton 30s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(16, 'UHDJBHIBHO', '9286459314825', 'YRN-TC-40s', 'Benang Tetoron Cotton 40s', 33361.00, 55889.00, 0, 3530, 10, 1, NULL, 12, 'Benang Tetoron Cotton 40s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(17, 'BWAW6SWQJ2', '7490583062260', 'YRN-PE-20s', 'Benang Polyester DTY 20s', 42941.00, 47416.00, 0, 4597, 10, 1, NULL, 12, 'Benang Polyester DTY 20s 100% PE NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% PE', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(18, 'H6F554G0HW', '7214754950272', 'YRN-PE-24s', 'Benang Polyester DTY 24s', 29562.00, 53164.00, 0, 586, 10, 1, NULL, 12, 'Benang Polyester DTY 24s 100% PE NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% PE', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(19, 'WODNIE7IEW', '7281959877671', 'YRN-PE-30s', 'Benang Polyester DTY 30s', 31688.00, 49079.00, 0, 873, 10, 1, NULL, 12, 'Benang Polyester DTY 30s 100% PE NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% PE', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(20, 'DGIG05MFKZ', '4832202841918', 'YRN-PE-40s', 'Benang Polyester DTY 40s', 44336.00, 59980.00, 0, 2227, 10, 1, NULL, 12, 'Benang Polyester DTY 40s 100% PE NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, '100% PE', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(21, 'XQNUTQVZAO', '7508306442144', 'YRN-RAY-20s', 'Benang Rayon Viscose 20s', 29984.00, 59894.00, 0, 2849, 10, 1, NULL, 12, 'Benang Rayon Viscose 20s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(22, 'X9H2ALKYTG', '7957710193239', 'YRN-RAY-24s', 'Benang Rayon Viscose 24s', 33792.00, 40523.00, 0, 1809, 10, 1, NULL, 12, 'Benang Rayon Viscose 24s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(23, 'DXF9UULEQW', '8859310879482', 'YRN-RAY-30s', 'Benang Rayon Viscose 30s', 29000.00, 47124.00, 0, 2279, 10, 1, NULL, 12, 'Benang Rayon Viscose 30s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(24, 'MRXQUJS66T', '4682538817871', 'YRN-RAY-40s', 'Benang Rayon Viscose 40s', 34366.00, 52013.00, 0, 954, 10, 1, NULL, 12, 'Benang Rayon Viscose 40s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(25, 'J0C1AV6EY6', '9960568089549', 'YRN-BAM-20s', 'Benang Cotton Bamboo 20s', 29523.00, 52321.00, 0, 3482, 10, 1, NULL, 12, 'Benang Cotton Bamboo 20s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(26, '8W1METPGIE', '5937198881304', 'YRN-BAM-24s', 'Benang Cotton Bamboo 24s', 44596.00, 58388.00, 0, 1585, 10, 1, NULL, 12, 'Benang Cotton Bamboo 24s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(27, 'GGBMYHTSYW', '4506308003474', 'YRN-BAM-30s', 'Benang Cotton Bamboo 30s', 26118.00, 55883.00, 0, 4774, 10, 1, NULL, 12, 'Benang Cotton Bamboo 30s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(28, 'IYCVK11HSS', '1773825765910', 'YRN-BAM-40s', 'Benang Cotton Bamboo 40s', 28531.00, 49757.00, 0, 1123, 10, 1, NULL, 12, 'Benang Cotton Bamboo 40s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(29, '50CF41Z7XC', '6508450153294', 'YRN-MOD-20s', 'Benang Cotton Modal 20s', 40232.00, 56463.00, 0, 2864, 10, 1, NULL, 12, 'Benang Cotton Modal 20s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(30, 'HMQOXHCLBI', '5471808502410', 'YRN-MOD-24s', 'Benang Cotton Modal 24s', 39775.00, 58002.00, 0, 3616, 10, 1, NULL, 12, 'Benang Cotton Modal 24s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(31, 'WYNSY24LAP', '8832987199274', 'YRN-MOD-30s', 'Benang Cotton Modal 30s', 39661.00, 59474.00, 0, 1097, 10, 1, NULL, 12, 'Benang Cotton Modal 30s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(32, '4K1Y9MGZF6', '8489789569134', 'YRN-MOD-40s', 'Benang Cotton Modal 40s', 29469.00, 46269.00, 0, 1220, 10, 1, NULL, 12, 'Benang Cotton Modal 40s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(33, '5GKVRE8GFH', '4297914091101', 'YRN-PC-20s', 'Benang Polyester Cotton 20s', 25324.00, 44043.00, 0, 1821, 10, 1, NULL, 12, 'Benang Polyester Cotton 20s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 20s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-31 20:46:26', NULL),
(34, '3Y0ZQ6NGSQ', '8029313804336', 'YRN-PC-24s', 'Benang Polyester Cotton 24s', 29842.00, 41176.00, 0, 3944, 10, 1, NULL, 12, 'Benang Polyester Cotton 24s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 24s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(35, 'YMTTZKIT9K', '9630157424402', 'YRN-PC-30s', 'Benang Polyester Cotton 30s', 36360.00, 52545.00, 0, 1495, 10, 1, NULL, 12, 'Benang Polyester Cotton 30s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 30s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(36, 'BQGGR29FMU', '8154343903724', 'YRN-PC-40s', 'Benang Polyester Cotton 40s', 33624.00, 56866.00, 0, 3813, 10, 1, NULL, 12, 'Benang Polyester Cotton 40s Blended NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, 'Blended', 'Ne 40s/1', NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(37, 'JOSYFLGJAI', '9339904232202', 'YRN-SP-20D', 'Spandex Lycra 20D', 125000.00, 160000.00, 0, 300, 10, 1, NULL, 12, 'Spandex Lycra 20D  Inviya', 'items/yarn_sample.png', NULL, NULL, NULL, '20 Denier', NULL, NULL, 'Inviya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(38, 'JPI3GR6FNF', '3852299948715', 'YRN-SP-40D', 'Spandex Lycra 40D', 110000.00, 145000.00, 0, 450, 10, 1, NULL, 12, 'Spandex Lycra 40D  Inviya', 'items/yarn_sample.png', NULL, NULL, NULL, '40 Denier', NULL, NULL, 'Inviya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(39, 'DXW5B57NY8', '9710785358829', 'CHM-SODA-61', 'Soda Ash Light', 1940822.00, 589486.00, 0, 20, 10, 2, NULL, 9, 'Soda Ash Light Fixing agent NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Fixing agent', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(40, '3ZUYQBR6EF', '7782524506272', 'CHM-CAUS-25', 'Caustic Soda Flake', 246797.00, 2048299.00, 0, 49, 10, 2, NULL, 9, 'Caustic Soda Flake NaOH 98% NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'NaOH 98%', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(41, 'XUFW1TWCV6', '3932856789792', 'CHM-HYDR-22', 'Hydrogen Peroxide 50%', 529831.00, 1074140.00, 0, 40, 10, 2, NULL, 7, 'Hydrogen Peroxide 50% Bleaching NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Bleaching', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:46', '2025-12-27 14:06:46', NULL),
(42, 'JILALFFLGT', '8206114778460', 'CHM-ACET-75', 'Acetic Acid 99%', 931269.00, 2097742.00, 0, 13, 10, 2, NULL, 7, 'Acetic Acid 99% Neutralizer NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Neutralizer', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-31 19:52:40', NULL),
(43, 'RW4LKD2ASY', '1836481330914', 'CHM-SODI-57', 'Sodium Silicate', 1185866.00, 2756479.00, 0, 9, 10, 2, NULL, 7, 'Sodium Silicate Stabilizer NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Stabilizer', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(44, 'EFFYUBSOV7', '7623161646732', 'CHM-GLUB-33', 'Gluber Salt', 1106425.00, 1595642.00, 0, 27, 10, 2, NULL, 9, 'Gluber Salt Electrolyte NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Electrolyte', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(45, '6AT3KQN4SS', '2629331009217', 'CHM-WETT-42', 'Wetting Agent L-01', 1174989.00, 1809501.00, 0, 44, 10, 2, NULL, 7, 'Wetting Agent L-01 Surfactant NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Surfactant', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(46, '56QGIFZAK2', '1642936912331', 'CHM-SEQU-57', 'Sequestering Agent', 1077737.00, 1962758.00, 0, 48, 10, 2, NULL, 7, 'Sequestering Agent Chelating NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Chelating', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(47, 'TTB2U3SOI1', '9997504129971', 'CHM-SOFT-54', 'Softener Cationic', 564705.00, 2686534.00, 0, 41, 10, 2, NULL, 9, 'Softener Cationic Pelembut NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Pelembut', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(48, 'SPUGAWHGTD', '5811818967908', 'CHM-SILI-42', 'Silicone Emulsion', 704399.00, 2637695.00, 0, 6, 10, 2, NULL, 7, 'Silicone Emulsion Silky finish NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Silky finish', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(49, 'UKI03XVDHJ', '5904344736015', 'CHM-ENZY-37', 'Enzyme Biopolish', 1853350.00, 1461968.00, 0, 10, 10, 2, NULL, 7, 'Enzyme Biopolish Bulu cleaner NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Bulu cleaner', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(50, '6XZTV24ZXY', '2044406027699', 'CHM-ANTI-12', 'Anti Foam', 1623711.00, 996923.00, 0, 12, 10, 2, NULL, 7, 'Anti Foam Defoamer NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Defoamer', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(51, 'GDQIP8HXGD', '1326460946532', 'CHM-FIXI-90', 'Fixing Agent DF', 1158001.00, 1845817.00, 0, 9, 10, 2, NULL, 7, 'Fixing Agent DF Color fix NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Color fix', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(52, '0IBWK54FMB', '2410237239237', 'CHM-LEVE-99', 'Levelling Agent', 429540.00, 2151532.00, 0, 36, 10, 2, NULL, 7, 'Levelling Agent Leveling NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Leveling', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(53, 'WA1ISFACWS', '2749378267546', 'CHM-SCOU-48', 'Scouring Agent', 619985.00, 2327462.00, 0, 23, 10, 2, NULL, 7, 'Scouring Agent Pemasakan NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Pemasakan', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(54, 'CBONN4KLUQ', '6764699708355', 'CHM-SOAP-42', 'Soap-L', 1427139.00, 1220461.00, 0, 5, 10, 2, NULL, 7, 'Soap-L Washing NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Washing', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(55, 'B3UR7P71JH', '5530853468143', 'CHM-ANTI-11', 'Anti Creasing', 297561.00, 1807627.00, 0, 5, 10, 2, NULL, 7, 'Anti Creasing Pelumas kain NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Pelumas kain', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(56, 'ANG2URJOGM', '4044254478113', 'CHM-DE-A-17', 'De-Aerating', 493695.00, 2308341.00, 0, 37, 10, 2, NULL, 7, 'De-Aerating Penghilang udara NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Penghilang udara', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(57, 'NDAUKYLWX0', '5946069371105', 'CHM-ANTI-44', 'Anti Migrating', 158682.00, 2196641.00, 0, 15, 10, 2, NULL, 7, 'Anti Migrating Pencegah migrasi NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Pencegah migrasi', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(58, 'V7CF23SOBH', '9627131418045', 'CHM-FIRE-25', 'Fire Retardant', 1937311.00, 1319886.00, 0, 9, 10, 2, NULL, 7, 'Fire Retardant Tahan api NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Tahan api', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(59, 'XKWQQBC92U', '4708869939420', 'CHM-HYDR-23', 'Hydrophilic Agent', 1557203.00, 1012168.00, 0, 8, 10, 2, NULL, 7, 'Hydrophilic Agent Penyerap NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Penyerap', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(60, '9TAJKTSKQA', '4511867172139', 'CHM-ANTI-40', 'Anti-Static', 175724.00, 905317.00, 0, 24, 10, 2, NULL, 7, 'Anti-Static Anti statis NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, 'Anti statis', NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(61, 'MKYLVW14AT', '1980063906443', 'DYE-REA-01', 'Reactive Black Grade 1', 148882.00, 129464.00, 0, 32, 10, 3, NULL, 12, 'Reactive Black Grade 1  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(62, 'NIZFW2G8P6', '2928470128774', 'DYE-REA-02', 'Reactive Black Grade 2', 117669.00, 344760.00, 0, 99, 10, 3, NULL, 12, 'Reactive Black Grade 2  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(63, 'XRADSMU3GN', '7462791353806', 'DYE-REA-03', 'Reactive Black Grade 3', 238435.00, 136108.00, 0, 89, 10, 3, NULL, 12, 'Reactive Black Grade 3  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(64, 'U8TGVUMJZA', '9742855071561', 'DYE-DIS-01', 'Disperse Red Grade 1', 178911.00, 137248.00, 0, 197, 10, 3, NULL, 12, 'Disperse Red Grade 1  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(65, 'BFSG0DW0EZ', '9330177623424', 'DYE-DIS-02', 'Disperse Red Grade 2', 93525.00, 137927.00, 0, 143, 10, 3, NULL, 12, 'Disperse Red Grade 2  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(66, 'YR3SDYJ7R6', '5856797671843', 'DYE-DIS-03', 'Disperse Red Grade 3', 140134.00, 249927.00, 0, 198, 10, 3, NULL, 12, 'Disperse Red Grade 3  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(67, 'ZBZDCWTZMB', '3299594461835', 'DYE-ACI-01', 'Acid Orange Grade 1', 234832.00, 266246.00, 0, 126, 10, 3, NULL, 12, 'Acid Orange Grade 1  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(68, 'LSNPZ2DC5M', '5741895844338', 'DYE-ACI-02', 'Acid Orange Grade 2', 181500.00, 207638.00, 0, 198, 10, 3, NULL, 12, 'Acid Orange Grade 2  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(69, 'GHLFJ9YPVM', '4026152035426', 'DYE-ACI-03', 'Acid Orange Grade 3', 122218.00, 290686.00, 0, 33, 10, 3, NULL, 12, 'Acid Orange Grade 3  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(70, 'YA9YHOAAKI', '8909522970033', 'DYE-CAT-01', 'Cationic Pink Grade 1', 109721.00, 277205.00, 0, 132, 10, 3, NULL, 12, 'Cationic Pink Grade 1  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(71, 'FUIGSV7RX1', '5011840578732', 'DYE-CAT-02', 'Cationic Pink Grade 2', 109918.00, 176705.00, 0, 49, 10, 3, NULL, 12, 'Cationic Pink Grade 2  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(72, 'P6WMXEQSUV', '1721313626465', 'DYE-CAT-03', 'Cationic Pink Grade 3', 147834.00, 259577.00, 0, 195, 10, 3, NULL, 12, 'Cationic Pink Grade 3  NBC Indonesia', 'items/chemical_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(73, 'NK5Q3KOHKT', '1243372090540', 'FAB-S/-SUP-98', 'Kain S/J 30s Combed - Super Black', 98671.00, 130407.00, 0, 714, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Super Black 100% Cotton ', 'items/silk_fabric.png', NULL, NULL, '100% Cotton', NULL, '140-150', '38\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-30 08:22:58', NULL),
(74, 'MUSL5YVE8P', '2711490647827', 'FAB-S/-OPT-49', 'Kain S/J 30s Combed - Optical White', 96937.00, 136388.00, 0, 342, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Optical White 100% Cotton ', 'items/silk_fabric.png', NULL, NULL, '100% Cotton', NULL, '140-150', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-30 08:22:58', NULL),
(75, 'PPNZURQPEI', '2504417761620', 'FAB-S/-NAV-39', 'Kain S/J 30s Combed - Navy Blue', 100919.00, 126106.00, 0, 969, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Navy Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(76, 'SIPVIXESOS', '3960267277369', 'FAB-S/-MAR-94', 'Kain S/J 30s Combed - Maroon', 111032.00, 126687.00, 0, 518, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Maroon 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '43\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(77, 'OFNAZS9DZ7', '9161470347861', 'FAB-S/-RED-97', 'Kain S/J 30s Combed - Red', 108373.00, 125699.00, 0, 162, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Red 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '37\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(78, 'OLSPED4P7Y', '9043888262235', 'FAB-S/-ROY-27', 'Kain S/J 30s Combed - Royal Blue', 113316.00, 140261.00, 0, 128, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Royal Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(79, '9PPRWIFHBV', '7602623332121', 'FAB-S/-DAR-55', 'Kain S/J 30s Combed - Dark Grey', 109966.00, 139788.00, 0, 560, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Dark Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '45\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(80, 'DOKLDHC74O', '4265783069049', 'FAB-S/-LIG-23', 'Kain S/J 30s Combed - Light Grey', 103871.00, 140585.00, 0, 146, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Light Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '45\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(81, '4PNLVD30X9', '2401550732816', 'FAB-S/-TUR-53', 'Kain S/J 30s Combed - Turkish Blue', 101080.00, 139213.00, 0, 713, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Turkish Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '37\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(82, 'TUWAPMIIZO', '7740231915866', 'FAB-S/-EME-34', 'Kain S/J 30s Combed - Emerald Green', 97730.00, 144810.00, 0, 467, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Emerald Green 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '43\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(83, 'AF24FMGUFL', '5049103914434', 'FAB-S/-YEL-51', 'Kain S/J 30s Combed - Yellow', 110269.00, 122894.00, 0, 185, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Yellow 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '41\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 15:30:07', NULL),
(84, 'RLA1HMFAQR', '9178219323930', 'FAB-S/-PIN-91', 'Kain S/J 30s Combed - Pink', 98609.00, 136098.00, 0, 776, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Pink 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(85, '0WSZ7U2BZE', '9094278233815', 'FAB-S/-PUR-74', 'Kain S/J 30s Combed - Purple', 103236.00, 123161.00, 0, 296, 10, 5, NULL, 12, 'Kain S/J 30s Combed - Purple 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '140-150', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(86, 'GBB3VXSA7U', '4817632204487', 'FAB-PI-SUP-70', 'Kain Pique 24s Combed - Super Black', 108088.00, 136005.00, 0, 225, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Super Black 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(87, 'NJJDUEGFJ0', '6127467956554', 'FAB-PI-OPT-40', 'Kain Pique 24s Combed - Optical White', 102709.00, 136353.00, 0, 537, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Optical White 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '43\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(88, 'JSNVMIE7SE', '8042314552537', 'FAB-PI-NAV-77', 'Kain Pique 24s Combed - Navy Blue', 111064.00, 126113.00, 0, 644, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Navy Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '38\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(89, 'ONJ3LCRMAM', '2722047938867', 'FAB-PI-MAR-77', 'Kain Pique 24s Combed - Maroon', 99636.00, 140110.00, 0, 984, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Maroon 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(90, 'V4D3UTC1P0', '3682370833783', 'FAB-PI-RED-98', 'Kain Pique 24s Combed - Red', 112476.00, 133932.00, 0, 634, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Red 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '45\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(91, 'DOLYAIWNBS', '1948229352352', 'FAB-PI-ROY-83', 'Kain Pique 24s Combed - Royal Blue', 103159.00, 133362.00, 0, 471, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Royal Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '37\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(92, 'IIYWZKEWFX', '8417981838800', 'FAB-PI-DAR-64', 'Kain Pique 24s Combed - Dark Grey', 114589.00, 137129.00, 0, 334, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Dark Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '37\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(93, 'NGRGRHGYWY', '6939829617012', 'FAB-PI-LIG-25', 'Kain Pique 24s Combed - Light Grey', 106452.00, 130919.00, 0, 828, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Light Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '45\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(94, 'XVYEIGH2FO', '5081647373442', 'FAB-PI-TUR-30', 'Kain Pique 24s Combed - Turkish Blue', 102692.00, 120316.00, 0, 359, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Turkish Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '45\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(95, 'MHU1PPZBM8', '2878766626132', 'FAB-PI-EME-39', 'Kain Pique 24s Combed - Emerald Green', 101176.00, 142734.00, 0, 371, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Emerald Green 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(96, 'WQUGSOXSMF', '4539493440042', 'FAB-PI-YEL-38', 'Kain Pique 24s Combed - Yellow', 107561.00, 125082.00, 0, 274, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Yellow 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(97, 'EISMRGJDCP', '1250120779890', 'FAB-PI-PIN-60', 'Kain Pique 24s Combed - Pink', 107988.00, 132068.00, 0, 798, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Pink 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '38\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(98, 'YNHEKT73SU', '1419337863247', 'FAB-PI-PUR-24', 'Kain Pique 24s Combed - Purple', 99871.00, 135518.00, 0, 945, 10, 5, NULL, 12, 'Kain Pique 24s Combed - Purple 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '200-210', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(99, '9PUV39ZZ6P', '5150875455776', 'FAB-BA-SUP-40', 'Kain Baby Terry 20s - Super Black', 114626.00, 137618.00, 0, 337, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Super Black 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '38\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(100, 'O2JKENBWNG', '5650022474122', 'FAB-BA-OPT-61', 'Kain Baby Terry 20s - Optical White', 103997.00, 137875.00, 0, 799, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Optical White 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '39\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(101, '7EBU4K3L7E', '9703252075389', 'FAB-BA-NAV-86', 'Kain Baby Terry 20s - Navy Blue', 100018.00, 126850.00, 0, 534, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Navy Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(102, 'JZQKZHZOOR', '6033869322821', 'FAB-BA-MAR-50', 'Kain Baby Terry 20s - Maroon', 100232.00, 135525.00, 0, 955, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Maroon 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '36\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(103, 'ZOIYYLLXXW', '3357159957095', 'FAB-BA-RED-51', 'Kain Baby Terry 20s - Red', 101675.00, 126366.00, 0, 410, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Red 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '37\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(104, 'MSW11LGTXK', '9875499251639', 'FAB-BA-ROY-11', 'Kain Baby Terry 20s - Royal Blue', 114155.00, 143339.00, 0, 894, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Royal Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(105, '7KD1EBGGYX', '7820556281362', 'FAB-BA-DAR-12', 'Kain Baby Terry 20s - Dark Grey', 113055.00, 129082.00, 0, 423, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Dark Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '41\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(106, 'N4J7V2EVPP', '3421264546546', 'FAB-BA-LIG-53', 'Kain Baby Terry 20s - Light Grey', 98524.00, 123931.00, 0, 280, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Light Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(107, 'TOGLOBWGTO', '1788635898661', 'FAB-BA-TUR-92', 'Kain Baby Terry 20s - Turkish Blue', 96520.00, 137681.00, 0, 304, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Turkish Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '36\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(108, 'GAKIIH18VM', '2077925664873', 'FAB-BA-EME-51', 'Kain Baby Terry 20s - Emerald Green', 102622.00, 134792.00, 0, 1033, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Emerald Green 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '41\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-31 20:46:26', NULL),
(109, 'SAZDK3GVNM', '6523789562659', 'FAB-BA-YEL-43', 'Kain Baby Terry 20s - Yellow', 113355.00, 135494.00, 0, 192, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Yellow 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '38\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(110, 'GEPHB1YUFB', '1374945565403', 'FAB-BA-PIN-86', 'Kain Baby Terry 20s - Pink', 103384.00, 140041.00, 0, 160, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Pink 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '42\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(111, 'EFLAFO7T5S', '6255600385330', 'FAB-BA-PUR-35', 'Kain Baby Terry 20s - Purple', 101660.00, 125442.00, 0, 926, 10, 5, NULL, 12, 'Kain Baby Terry 20s - Purple 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '240-260', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(112, 'LAWEQ2VTBG', '3606564156635', 'FAB-FL-SUP-21', 'Kain Fleece 30s - Super Black', 96770.00, 136482.00, 0, 883, 10, 5, NULL, 12, 'Kain Fleece 30s - Super Black 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(113, 'IUKGXISZN8', '9301761918972', 'FAB-FL-OPT-74', 'Kain Fleece 30s - Optical White', 101601.00, 131895.00, 0, 742, 10, 5, NULL, 12, 'Kain Fleece 30s - Optical White 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '39\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(114, 'OPH8258ARB', '7006002750620', 'FAB-FL-NAV-16', 'Kain Fleece 30s - Navy Blue', 114439.00, 143113.00, 0, 980, 10, 5, NULL, 12, 'Kain Fleece 30s - Navy Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '42\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(115, '34FBBGDAQE', '3450851319914', 'FAB-FL-MAR-86', 'Kain Fleece 30s - Maroon', 97513.00, 138812.00, 0, 277, 10, 5, NULL, 12, 'Kain Fleece 30s - Maroon 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '40\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(116, 'OVEESWJRFJ', '9949437800039', 'FAB-FL-RED-79', 'Kain Fleece 30s - Red', 101815.00, 130797.00, 0, 679, 10, 5, NULL, 12, 'Kain Fleece 30s - Red 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(117, 'NEYKEGQ8IU', '5314096391303', 'FAB-FL-ROY-69', 'Kain Fleece 30s - Royal Blue', 112361.00, 124622.00, 0, 293, 10, 5, NULL, 12, 'Kain Fleece 30s - Royal Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '43\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(118, 'UI3ULO4LDS', '3208175048480', 'FAB-FL-DAR-56', 'Kain Fleece 30s - Dark Grey', 113217.00, 123289.00, 0, 168, 10, 5, NULL, 12, 'Kain Fleece 30s - Dark Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '41\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(119, 'RCN6TGBBUC', '1680017833110', 'FAB-FL-LIG-93', 'Kain Fleece 30s - Light Grey', 110712.00, 135740.00, 0, 969, 10, 5, NULL, 12, 'Kain Fleece 30s - Light Grey 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '38\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(120, 'CQVEPIFPWF', '5035199811158', 'FAB-FL-TUR-80', 'Kain Fleece 30s - Turkish Blue', 102798.00, 139132.00, 0, 406, 10, 5, NULL, 12, 'Kain Fleece 30s - Turkish Blue 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '36\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(121, 'MJASQ0QZLL', '1078713177627', 'FAB-FL-EME-29', 'Kain Fleece 30s - Emerald Green', 96297.00, 137345.00, 0, 154, 10, 5, NULL, 12, 'Kain Fleece 30s - Emerald Green 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '36\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(122, 'QBCGEQAJN7', '7006877177347', 'FAB-FL-YEL-46', 'Kain Fleece 30s - Yellow', 111204.00, 135983.00, 0, 517, 10, 5, NULL, 12, 'Kain Fleece 30s - Yellow 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '44\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(123, 'JDU1XFK89S', '7881226684118', 'FAB-FL-PIN-33', 'Kain Fleece 30s - Pink', 113509.00, 142561.00, 0, 291, 10, 5, NULL, 12, 'Kain Fleece 30s - Pink 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '280-300', '37\" Tubular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(124, 'YFN1VCFZKJ', '8835486090654', 'GRG-S/J-31', 'Greige S/J 30s Combed', 84098.00, 99718.00, 0, 1787, 10, 4, NULL, 12, 'Greige S/J 30s Combed 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '199', '42\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(125, 'BLQ7F7LQJC', '5740461520463', 'GRG-PIQ-36', 'Greige Pique 24s Combed', 83967.00, 94471.00, 0, 2293, 10, 4, NULL, 12, 'Greige Pique 24s Combed 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '242', '42\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(126, 'BSOMIMJFRM', '2864378151274', 'GRG-BAB-73', 'Greige Baby Terry 20s', 81674.00, 90693.00, 0, 4336, 10, 4, NULL, 12, 'Greige Baby Terry 20s 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '231', '42\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(127, 'LV28IE8NFW', '7613632752941', 'GRG-FLE-91', 'Greige Fleece 30s', 81783.00, 94281.00, 0, 1616, 10, 4, NULL, 12, 'Greige Fleece 30s 100% Cotton ', 'items/fabric_sample.png', NULL, NULL, '100% Cotton', NULL, '216', '42\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(128, 'YKJYOAJ85T', '6364243080161', 'SPA-K-JAR-50', 'Jarum Mesin Knitting 481', 898759.00, 1068966.00, 0, 1, 10, 1, NULL, 1, 'Jarum Mesin Knitting 481  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(129, 'WXTY5TFNGX', '8852452534347', 'SPA-K-SIN-90', 'Sinker Mesin Knitting 497', 4102862.00, 5530099.00, 0, 33, 10, 1, NULL, 10, 'Sinker Mesin Knitting 497  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(130, 'OSILA5EGW7', '8236511373068', 'SPA-K-BEL-16', 'Belt Mesin Knitting 201', 505854.00, 4839983.00, 0, 47, 10, 1, NULL, 10, 'Belt Mesin Knitting 201  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(131, 'ZN0YJK6PGU', '2015959955865', 'SPA-K-BEA-73', 'Bearing Mesin Knitting 943', 2997058.00, 802906.00, 0, 13, 10, 1, NULL, 1, 'Bearing Mesin Knitting 943  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(132, 'TEOKLYVRUI', '9360212034249', 'SPA-K-SEA-32', 'Seal Mesin Knitting 396', 713894.00, 4052647.00, 0, 10, 10, 1, NULL, 1, 'Seal Mesin Knitting 396  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(133, 'RSZTQULPUZ', '9908511514670', 'SPA-K-INV-94', 'Inverter Mesin Knitting 107', 3580273.00, 4865741.00, 0, 21, 10, 1, NULL, 1, 'Inverter Mesin Knitting 107  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(134, 'O1DWGXXZY5', '4248697929501', 'SPA-K-SEN-59', 'Sensor Mesin Knitting 250', 2638779.00, 2126620.00, 0, 19, 10, 1, NULL, 1, 'Sensor Mesin Knitting 250  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(135, 'DHIAHBC8W9', '7311729598976', 'SPA-K-MOT-14', 'Motor Mesin Knitting 721', 2011599.00, 3239794.00, 0, 41, 10, 1, NULL, 1, 'Motor Mesin Knitting 721  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-30 08:03:17', NULL),
(136, 'LFTNZJYHWN', '2223801776040', 'SPA-K-PUM-81', 'Pump Mesin Knitting 902', 3095210.00, 3306314.00, 0, 39, 10, 1, NULL, 10, 'Pump Mesin Knitting 902  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(137, 'XZYNEO2UHN', '2881466975448', 'SPA-K-OIL-21', 'Oil Mesin Knitting 930', 463928.00, 3123836.00, 0, 19, 10, 1, NULL, 1, 'Oil Mesin Knitting 930  NBC Indonesia', 'items/yarn_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(138, 'J8XLWXCK3V', '5998095346854', 'SPA-D-JAR-39', 'Jarum Mesin Dyeing 693', 2399220.00, 4097869.00, 0, 46, 10, 7, NULL, 10, 'Jarum Mesin Dyeing 693  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(139, 'FG45ORJDTW', '2562667982275', 'SPA-D-SIN-26', 'Sinker Mesin Dyeing 406', 743534.00, 5026745.00, 0, 40, 10, 7, NULL, 1, 'Sinker Mesin Dyeing 406  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL);
INSERT INTO `items` (`id`, `product_code`, `barcode`, `sku`, `name`, `purchase_price`, `price`, `current_stock`, `stock`, `min_stock`, `category_id`, `color_id`, `unit_id`, `description`, `image`, `color_name`, `color_code`, `composition`, `technical_spec`, `gsm`, `width`, `brand`, `paint_type`, `volume`, `size`, `texture`, `motif`, `grade`, `finish_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(140, 'H0WLQJOFNP', '5206932198899', 'SPA-D-BEL-57', 'Belt Mesin Dyeing 153', 1872997.00, 4312775.00, 0, 12, 10, 7, NULL, 10, 'Belt Mesin Dyeing 153  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(141, 'NC0HRXX3A8', '7332747114928', 'SPA-D-BEA-71', 'Bearing Mesin Dyeing 328', 233150.00, 6213749.00, 0, 24, 10, 7, NULL, 10, 'Bearing Mesin Dyeing 328  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(142, 'DVUHHS1GGG', '6212010953429', 'SPA-D-SEA-11', 'Seal Mesin Dyeing 168', 990887.00, 3373806.00, 0, 26, 10, 7, NULL, 1, 'Seal Mesin Dyeing 168  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(143, 'JM4XGYNBZV', '7204840937687', 'SPA-D-INV-29', 'Inverter Mesin Dyeing 466', 2689887.00, 1820851.00, 0, 16, 10, 7, NULL, 1, 'Inverter Mesin Dyeing 466  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(144, 'AKE4TIBZMD', '9220407888882', 'SPA-D-SEN-76', 'Sensor Mesin Dyeing 492', 3753326.00, 1578584.00, 0, 33, 10, 7, NULL, 10, 'Sensor Mesin Dyeing 492  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(145, '5IW83PHIDK', '7078551126296', 'SPA-D-MOT-25', 'Motor Mesin Dyeing 846', 1125068.00, 6167770.00, 0, 28, 10, 7, NULL, 1, 'Motor Mesin Dyeing 846  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(146, '732RT4SDHK', '3586788900730', 'SPA-D-PUM-94', 'Pump Mesin Dyeing 232', 3775687.00, 2088133.00, 0, 27, 10, 7, NULL, 1, 'Pump Mesin Dyeing 232  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(147, 'JI1CWOP2TH', '8020196741690', 'SPA-D-OIL-28', 'Oil Mesin Dyeing 346', 4138159.00, 4443334.00, 0, 32, 10, 7, NULL, 10, 'Oil Mesin Dyeing 346  NBC Indonesia', 'items/sparepart_sample.png', NULL, NULL, NULL, NULL, NULL, NULL, 'NBC Indonesia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(148, 'TTRJB03V8R', '7018533008495', 'PNT-JOT-14', 'Jotun Majestic True Beauty', 1569816.00, 2597205.00, 0, 88, 10, 10, NULL, 8, 'Jotun Majestic True Beauty  ', 'items/paint_sample.png', 'Putih Salju', 'JS-101', NULL, NULL, NULL, NULL, NULL, 'Matt', '2.5L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:47', '2025-12-27 14:06:47', NULL),
(149, 'V9FR7FOJRG', '2807959186067', 'PNT-DUL-14', 'Dulux Weathershield', 1873081.00, 1561926.00, 0, 23, 10, 10, NULL, 1, 'Dulux Weathershield  ', 'items/paint_sample.png', 'Brilliant White', 'DX-99', NULL, NULL, NULL, NULL, NULL, 'Exterior', '5L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(150, 'SGFKXJAPAK', '7985326439593', 'PNT-NIP-14', 'Nippon Paint Weatherbond', 1177354.00, 960064.00, 0, 79, 10, 10, NULL, 8, 'Nippon Paint Weatherbond  ', 'items/paint_sample.png', 'Sky Blue', 'NP-40', NULL, NULL, NULL, NULL, NULL, 'Exterior', '20L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(152, 'RL9LV7UGYR', '8685465005388', 'PNT-MOW-83', 'Mowilex Weathercoat', 700249.00, 635450.00, 0, 40, 10, 10, NULL, 1, 'Mowilex Weathercoat  ', 'items/paint_sample.png', 'Stone Grey', 'MW-88', NULL, NULL, NULL, NULL, NULL, 'Exterior', '2.5L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(154, '0QCMC6QXBL', '4036834962871', 'PNT-PRO-60', 'Propan Decorshield', 2072338.00, 465461.00, 0, 95, 10, 10, NULL, 8, 'Propan Decorshield  ', 'items/paint_sample.png', 'Light Beige', 'PP-55', NULL, NULL, NULL, NULL, NULL, 'Exterior', '5L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(155, 'HCACTBR4JI', '2297984570819', 'PNT-EPO-73', 'Epoxy Floor Paint', 684104.00, 620695.00, 0, 27, 10, 10, NULL, 1, 'Epoxy Floor Paint  ', 'items/paint_sample.png', 'Green Gloss', 'EP-10', NULL, NULL, NULL, NULL, NULL, 'Industrial', '20kg', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(156, 'QKQHOJW3HH', '5806096204158', 'PNT-WOO-90', 'Wood Stain P-01', 1766318.00, 2857867.00, 0, 80, 10, 10, NULL, 8, 'Wood Stain P-01  ', 'items/paint_sample.png', 'Clear Gloss', 'WD-01', NULL, NULL, NULL, NULL, NULL, 'Finish', '1L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(157, 'VJPCRDKPCL', '6545686331760', 'PNT-THI-21', 'Thinner High Gloss', 1792511.00, 2307872.00, 0, 15, 10, 10, NULL, 1, 'Thinner High Gloss  ', 'items/paint_sample.png', 'Clear', 'TH-HG', NULL, NULL, NULL, NULL, NULL, 'Solvent', '5L', NULL, NULL, NULL, NULL, NULL, '2025-12-27 14:06:48', '2025-12-27 14:06:48', NULL),
(158, 'PRD-000158', '8998193808850', 'SKU-BAH-CHE-1B43', 'Cheryl Ortiz', 615.00, 974.00, 0, 91, 10, 9, NULL, 1, 'Et qui non id nobis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Qui sed placeat est', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 17:06:14', '2025-12-27 17:06:14', NULL),
(160, 'AW30MSVWGG', '7176327298517', 'YARN-CC20S', 'Benang Cotton Combed 20s', 33000.00, 43000.00, 0, 2000, 10, 11, NULL, 3, 'Benang Cotton Combed 20s untuk kain tebal/heavyweight.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(161, '0V9NVRLDGX', '6717979478207', 'YARN-CC24S', 'Benang Cotton Combed 24s', 34000.00, 44000.00, 0, 3000, 10, 11, NULL, 3, 'Benang Cotton Combed 24s standard distro.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(162, 'SH2VEIBO95', '1697995564772', 'YARN-CC30S', 'Benang Cotton Combed 30s', 35000.00, 45000.00, 0, 5000, 10, 11, NULL, 3, 'Benang katun combed 30s kualitas premium untuk Rajut.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(163, 'QAWCQOU7WX', '8073971032194', 'YARN-CC40S', 'Benang Cotton Combed 40s', 37000.00, 48000.00, 0, 1000, 10, 11, NULL, 3, 'Benang Cotton Combed 40s untuk kain tipis/adem.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(164, 'EADIWZO4ZB', '9812384025409', 'YARN-BAM30S', 'Benang Cotton Bamboo 30s', 45000.00, 58000.00, 0, 1500, 10, 11, NULL, 3, 'Benang campuran Kapas dan Serat Bambu anti-bakteri.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(165, 'KQNDZTGJS3', '2832996395152', 'YARN-MOD30S', 'Benang Cotton Modal 30s', 50000.00, 65000.00, 0, 1000, 10, 11, NULL, 3, 'Benang campuran Kapas dan Serat Kayu (Modal) sangat lembut.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(166, 'RWPQF5X28V', '4963698679702', 'YARN-CVC30S', 'Benang CVC 30s (Chief Value Cotton)', 30000.00, 38000.00, 0, 4000, 10, 11, NULL, 3, 'Campuran Cotton 60% + Polyester 40%.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(167, 'SMXM44RP9C', '6598817114705', 'YARN-TC30S', 'Benang TC 30s (Tetoron Cotton)', 25000.00, 32000.00, 0, 4000, 10, 11, NULL, 3, 'Campuran Polyester 65% + Cotton 35%.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(168, 'WC4OC2GSFF', '5444257893610', 'YARN-PE150D', 'Benang Polyester 150D/48F', 22000.00, 28000.00, 0, 3000, 10, 11, NULL, 3, 'Benang Polyester Filament DTY 150D.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(169, 'THYZ4QYFW4', '2665490083446', 'YARN-PE75D', 'Benang Polyester 75D/36F', 23000.00, 29000.00, 0, 2000, 10, 11, NULL, 3, 'Benang Polyester Filament halus.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(170, 'ME9S0ZPW0Z', '5929905260403', 'YARN-SPX20D', 'Benang Spandex 20D', 120000.00, 150000.00, 0, 500, 10, 11, NULL, 3, 'Benang elastis Spandex / Lycra 20 Denier.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(171, 'FJDPESM2IP', '2057669499413', 'YARN-SPX40D', 'Benang Spandex 40D', 110000.00, 140000.00, 0, 600, 10, 11, NULL, 3, 'Benang elastis Spandex / Lycra 40 Denier.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(172, 'CLHJV7KRXH', '4249877999789', 'CHEM-SODA', 'Soda Ash Light (Na2CO3)', 250000.00, 300000.00, 0, 100, 10, 12, NULL, 9, 'Fixing agent untuk reaktif. Kemasan 50kg.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(173, 'MJTS4NLB4K', '5645505169849', 'CHEM-CAUSTIC', 'Caustic Soda Flake 98% (NaOH)', 350000.00, 420000.00, 0, 80, 10, 12, NULL, 9, 'Untuk proses Scouring, Bleaching, Mercerizing. Kemasan 25kg.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(174, 'UOKGKWCRX1', '5642155216466', 'CHEM-H2O2', 'Hydrogen Peroxide 50% (H2O2)', 450000.00, 550000.00, 0, 40, 10, 12, NULL, 7, 'Bleaching agent oksidator kuat. Jerrycan 30kg.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(175, '7XA3LBQQZ9', '4663272897562', 'CHEM-GLAUB', 'Glauber Salt (Na2SO4)', 120000.00, 160000.00, 0, 200, 10, 12, NULL, 9, 'Elektrolit untuk meratakan penyerapan warna.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(177, 'WN2GNKZBN3', '2311650153277', 'CHEM-STAB', 'Stabilizer H2O2', 800000.00, 950000.00, 0, 15, 10, 12, NULL, 7, 'Menstabilkan reaksi bleaching peroxide.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(178, 'LJCYEEPB47', '6453051572633', 'CHEM-SEQ', 'Sequestering Agent (Anti Sadah)', 750000.00, 900000.00, 0, 25, 10, 12, NULL, 7, 'Mengikat logam berat dalam air.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(179, 'XQCBQ8NVW7', '7348145085211', 'CHEM-WET', 'Wetting Agent (Pembasah)', 650000.00, 800000.00, 0, 30, 10, 12, NULL, 7, 'Mempercepat pembasahan kain.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(180, 'F24ST0HPQ0', '3317315446741', 'CHEM-SOAP', 'Soaping Agent', 700000.00, 850000.00, 0, 35, 10, 12, NULL, 7, 'Pencucian warna luntur setelah dyeing.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(181, '5MT9RXEBVW', '8670217549201', 'CHEM-SOFT', 'Softener Flake (Pelembut)', 500000.00, 650000.00, 0, 60, 10, 12, NULL, 9, 'Pelembut kain handfeel silky.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(182, 'U5J1FILZTJ', '6500801562612', 'CHEM-SIL', 'Silicone Oil Emulsion', 1200000.00, 1500000.00, 0, 10, 10, 12, NULL, 7, 'Finishing agent untuk efek licin/bouncy.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(183, 'M0JOU9BNBB', '2431894712936', 'CHEM-ENZ', 'Enzyme Cellulase (Biopolish)', 1500000.00, 1800000.00, 0, 8, 10, 12, NULL, 7, 'Makan bulu kain (Biopolishing).', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(184, 'INIDIY3ZSC', '6754520362805', 'DYE-RED-FNR', 'Novacron Red FN-R', 150000.00, 200000.00, 0, 50, 10, 3, NULL, 3, 'Reactive Red. High Fastness.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(185, '3ZHHLZYPQN', '1393251156449', 'DYE-BLU-FNR', 'Novacron Blue FN-R', 180000.00, 240000.00, 0, 45, 10, 3, NULL, 3, 'Reactive Blue.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(186, 'VLFNJZIRUL', '3441914684867', 'DYE-YEL-FN2R', 'Novacron Yellow FN-2R', 160000.00, 210000.00, 0, 40, 10, 3, NULL, 3, 'Reactive Yellow reddish.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(187, 'VP4QWOHG6T', '6642737974093', 'DYE-BLK-B', 'Sumifix Black B 150%', 85000.00, 120000.00, 0, 200, 10, 3, NULL, 3, 'Reactive Black Deep.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(188, 'GVZQLKKU3N', '5261788202792', 'DYE-RED-3BF', 'Sumifix Supra Red 3BF', 140000.00, 180000.00, 0, 30, 10, 3, NULL, 3, 'Reactive Red bluish.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(189, 'WZGPN9RCX2', '6055056318141', 'DYE-PE-RED60', 'Disp. Red 60 (Polyester)', 110000.00, 140000.00, 0, 25, 10, 3, NULL, 3, 'Disperse Red untuk Polyester.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(190, 'NEAMXS46GZ', '4874966526928', 'DYE-PE-BLU56', 'Disp. Blue 56 (Polyester)', 115000.00, 150000.00, 0, 25, 10, 3, NULL, 3, 'Disperse Blue untuk Polyester.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(191, 'FKX74TEDEE', '4302406737489', 'FIN-CC30-BLK-R', 'Kain Cotton Combed 30s Hitam Reaktif', 98000.00, 115000.00, 0, 500, 10, 14, NULL, 3, 'Single Jersey 30s Black Reactive High Grade.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(192, 'EVM0GAV7BC', '2402668088966', 'FIN-CC30-WHT', 'Kain Cotton Combed 30s Putih', 90000.00, 105000.00, 0, 300, 10, 14, NULL, 3, 'Single Jersey 30s White Bluish.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(193, '0IRMD5CE3U', '9625778767896', 'FIN-CC30-RED', 'Kain Cotton Combed 30s Merah Cabe', 105000.00, 125000.00, 0, 200, 10, 14, NULL, 3, 'Single Jersey 30s Red.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(194, 'PIQR3XW7IE', '9850031303854', 'FIN-CC30-NAV', 'Kain Cotton Combed 30s Navy', 105000.00, 125000.00, 0, 250, 10, 14, NULL, 3, 'Single Jersey 30s Navy Blue.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(195, 'GRC6MSZ6YE', '6678932674227', 'FIN-CC24-BLK', 'Kain Cotton Combed 24s Hitam Reaktif', 100000.00, 118000.00, 0, 300, 10, 14, NULL, 3, 'Single Jersey 24s lebih tebal.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(196, 'H1TVEPO278', '2212082078536', 'FIN-PIQUE-WHT', 'Kain Pique Combed 24s/30s (Lacoste)', 110000.00, 135000.00, 0, 150, 10, 14, NULL, 3, 'Kain wangki/polo corak hexagon.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(197, '0ANITHWPKD', '1472093525272', 'FIN-BTER-M71', 'Kain Baby Terry C20s Misty M71', 95000.00, 115000.00, 0, 250, 10, 14, NULL, 3, 'Untuk Hoodie/Sweater ringan.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(198, 'GYAN3MKWLU', '8544542762332', 'FIN-FLE-BLK', 'Kain Cotton Fleece C30s Hitam', 115000.00, 140000.00, 0, 100, 10, 14, NULL, 3, 'Fleece tebal berbulu untuk jaket.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(199, 'DZKMPMJQHJ', '1883092128901', 'FIN-RIB-30-BLK', 'Rib Cotton Combed 30s Hitam', 105000.00, 125000.00, 0, 50, 10, 14, NULL, 3, 'Aksesoris kerah/lengan 1x1.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(200, 'HT5LDOAIOR', '4425244355698', 'FIN-BUR-30-BLK', 'Bur Cotton Combed 30s Hitam', 105000.00, 125000.00, 0, 50, 10, 14, NULL, 3, 'Untuk variasi (Rib tebal).', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(201, 'WZ1P0M9SDX', '6350856946224', 'PART-NDL-VO', 'Jarum Rajut Groz-Beckert VO 71.50', 1500000.00, 1800000.00, 0, 10, 10, 15, NULL, 10, 'Jarum mesin circular 24G.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(202, 'XVMBJJ4CUB', '2161787764346', 'PART-SINK', 'Sinker Kern-Liebers', 1200000.00, 1400000.00, 0, 10, 10, 15, NULL, 10, 'Plat sinker mesin rajut.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(203, 'ND84OEOOAS', '5073812679151', 'PART-BELT-B52', 'V-Belt B-52 Mitsubishi', 45000.00, 65000.00, 0, 20, 10, 15, NULL, 1, 'V-Belt karet hitam B-52.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(204, 'Y1KBOV9BL3', '8775994679926', 'PART-OIL-32', 'Oli Mesin Rajut (Knitting Oil) ISO 32', 500000.00, 700000.00, 0, 5, 10, 15, NULL, 1, 'Pelumas jarum mesin rajut, washable.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(205, 'AHEVVBFVMG', '8259373006237', 'PART-INV-55', 'Inverter Delta 5.5 KW', 3500000.00, 4500000.00, 0, 2, 10, 15, NULL, 1, 'Pengatur kecepatan motor mesin.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL),
(206, 'TSBIRV68ML', '3899383364456', 'PART-SEAL-2', 'Seal Mechanical Pump 2\"', 250000.00, 350000.00, 0, 15, 10, 15, NULL, 1, 'Seal pompa celup dyeing.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:32:15', '2025-12-30 08:32:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keramiks`
--

CREATE TABLE `keramiks` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `material_requests`
--

CREATE TABLE `material_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `request_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `production_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `request_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `fulfilled_by` bigint UNSIGNED DEFAULT NULL,
  `fulfilled_at` timestamp NULL DEFAULT NULL,
  `warehouse_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `material_requests`
--

INSERT INTO `material_requests` (`id`, `request_number`, `production_id`, `user_id`, `request_date`, `status`, `notes`, `approved_by`, `approved_at`, `fulfilled_by`, `fulfilled_at`, `warehouse_id`, `created_at`, `updated_at`) VALUES
(1, 'MR-20251227-0001', 6, 1, '2012-12-29', 'pending', 'Animi doloribus dol', NULL, NULL, NULL, NULL, 5, '2025-12-27 16:25:12', '2025-12-27 16:25:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `material_request_items`
--

CREATE TABLE `material_request_items` (
  `id` bigint UNSIGNED NOT NULL,
  `material_request_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty_requested` decimal(15,2) NOT NULL,
  `qty_issued` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `material_request_items`
--

INSERT INTO `material_request_items` (`id`, `material_request_id`, `item_id`, `qty_requested`, `qty_issued`, `created_at`, `updated_at`) VALUES
(1, 1, 92, 825.00, 0.00, '2025-12-27 16:25:12', '2025-12-27 16:25:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_05_11_043212_add_role_to_users_table', 1),
(3, '2025_05_11_065213_create_categories_table', 1),
(4, '2025_05_11_065224_create_items_table', 1),
(5, '2025_05_11_065240_create_keramiks_table', 1),
(6, '2025_05_11_065247_create_cats_table', 1),
(7, '2025_05_11_072733_add_specific_item_fields_to_items_table', 1),
(8, '2025_05_11_091455_create_cache_table', 1),
(9, '2025_05_11_091811_add_description_to_items_table', 1),
(10, '2025_05_11_092517_make_unit_column_nullable_in_items_table', 1),
(11, '2025_05_12_050329_create_sales_table', 1),
(12, '2025_05_12_050335_create_sale_items_table', 1),
(13, '2025_05_12_053457_create_sale_returns_table', 1),
(14, '2025_05_12_053526_create_sale_return_items_table', 1),
(15, '2025_05_12_084451_add_current_stock_to_items_table', 1),
(16, '2025_05_14_173156_create_suppliers_table', 1),
(17, '2025_05_14_173820_create_pembelians_table', 1),
(18, '2025_05_14_173858_create_pembelian_items_table', 1),
(19, '2025_05_14_174053_create_retur_pembelians_table', 1),
(20, '2025_05_14_174117_create_retur_pembelian_items_table', 1),
(21, '2025_05_14_183752_create_companies_table', 1),
(22, '2025_05_26_214126_add_purchase_number_to_pembelians_table', 1),
(23, '2025_06_16_210928_add_return_number_to_retur_pembelians_table', 1),
(24, '2025_06_19_145116_create_company_settings_table', 1),
(25, '2025_12_21_171607_add_codes_to_items_table', 2),
(26, '2025_12_21_172218_add_image_to_items_table', 3),
(27, '2025_12_21_172443_create_customers_table', 4),
(28, '2025_12_21_172620_create_units_table', 5),
(29, '2025_12_21_172649_add_unit_id_to_items_table', 6),
(32, '2025_12_21_174046_add_details_to_users_table', 7),
(33, '2025_12_21_174048_create_activity_logs_table', 7),
(34, '2025_12_21_184210_create_productions_tables', 8),
(35, '2025_12_21_184937_create_expenses_table', 9),
(36, '2025_12_21_190752_add_favicon_to_company_settings_table', 10),
(37, '2025_12_21_191952_create_permissions_tables', 11),
(38, '2025_12_22_111147_create_expenses_tables', 12),
(40, '2025_12_22_115152_add_color_permissions', 14),
(41, '2025_12_22_115706_add_technical_columns_to_items_table', 15),
(42, '2025_12_22_120148_add_technical_spec_to_items_table', 16),
(43, '2025_12_22_131156_create_warehouses_table', 17),
(44, '2025_12_22_131159_create_warehouse_stocks_table', 17),
(45, '2025_12_22_131200_create_stock_adjustments_table', 17),
(46, '2025_12_22_131201_create_stock_transfers_table', 17),
(47, '2025_12_23_080604_add_customer_id_to_sales_table', 18),
(48, '2025_12_23_094307_add_finance_columns_to_sales_table', 19),
(49, '2025_12_23_094310_add_finance_columns_to_pembelians_table', 19),
(50, '2025_12_23_094312_create_cash_flows_table', 19),
(51, '2025_12_23_095305_add_min_stock_to_items_table', 20),
(52, '2025_12_23_100115_create_stock_ledgers_table', 21),
(53, '2025_12_23_100617_create_payments_table', 22),
(55, '2025_12_24_090317_add_professional_fields_to_productions_table', 23),
(56, '2025_12_22_114913_create_colors_table', 24),
(57, '2025_12_24_101601_add_color_id_to_items_table', 25),
(58, '2025_12_24_102836_add_soft_deletes_to_master_tables', 26),
(59, '2025_12_24_230501_update_productions_status_enum', 27),
(60, '2025_12_26_020030_add_reference_number_to_pembelians_table', 28),
(61, '2025_12_26_022143_add_invoice_number_to_pembelians_table', 29),
(63, '2025_12_26_034000_seed_refined_permissions', 30),
(64, '2025_12_27_223318_create_material_requests_table', 31),
(65, '2025_12_27_223319_create_material_request_items_table', 31),
(66, '2025_12_27_235800_add_granular_permissions', 32),
(67, '2025_12_30_171300_create_password_reset_tokens_table', 33),
(68, '2026_01_01_020657_add_soft_deletes_to_transaction_tables', 34),
(69, '2026_01_01_025834_add_formats_to_company_settings_table', 35),
(70, '2026_01_01_033000_add_soft_deletes_to_categories_table', 36);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `reference_type`, `reference_id`, `amount`, `payment_date`, `payment_method`, `notes`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pembelian', 7, 422077008.00, '2025-12-26 00:00:00', 'cash', NULL, 4, '2025-12-25 18:27:39', '2025-12-25 18:27:39', NULL),
(2, 'Pembelian', 8, 5154.00, '2025-12-26 00:00:00', 'cash', 'Aperiam alias volupt', 4, '2025-12-25 18:27:57', '2025-12-25 18:27:57', NULL),
(3, 'Pembelian', 9, 8.00, '2021-10-20 00:00:00', 'cash', 'Anim voluptate aperi', 4, '2025-12-25 19:04:08', '2025-12-25 19:04:08', NULL),
(4, 'Pembelian', 8, 2706.00, '2025-12-26 00:00:00', 'cash', 'Ut enim non quos min', 4, '2025-12-25 19:04:33', '2025-12-25 19:04:33', NULL),
(5, 'Pembelian', 9, 12.00, '1980-01-26 00:00:00', 'transfer', 'Do eum labore occaec', 1, '2025-12-25 19:06:19', '2025-12-25 19:06:19', NULL),
(6, 'Pembelian', 9, 1.00, '2025-12-26 00:00:00', 'cash', NULL, 1, '2025-12-25 19:12:44', '2025-12-25 19:12:44', NULL),
(7, 'Sale', 10, 188512.00, '2018-01-08 00:00:00', 'transfer', 'Magni blanditiis nul', 1, '2025-12-25 20:31:38', '2025-12-25 20:31:38', NULL),
(8, 'Pembelian', 12, 19434019.00, '2025-12-26 00:00:00', 'cash', 'Asperiores veniam e', 1, '2025-12-25 20:32:08', '2025-12-25 20:32:08', NULL),
(9, 'Pembelian', 13, 26409.00, '2025-12-27 00:00:00', 'cash', NULL, 1, '2025-12-27 15:27:40', '2025-12-27 15:27:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelians`
--

CREATE TABLE `pembelians` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `purchase_date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `due_date` date DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembelians`
--

INSERT INTO `pembelians` (`id`, `purchase_number`, `invoice_number`, `reference_number`, `supplier_id`, `purchase_date`, `notes`, `total_amount`, `payment_method`, `paid_amount`, `payment_status`, `due_date`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'PO-20141014-0001', 'FAK-20251226-0001', NULL, 8, '2025-12-23', NULL, 1075710974.00, 'cash', 1075710974.00, 'paid', '2011-02-19', 1, '2025-12-23 16:01:46', '2025-12-25 19:46:56', NULL),
(7, 'PO-20251224-0001', 'FAK-20251226-0002', NULL, 7, '2025-12-24', 'Consectetur quas vel', 437077026.00, 'cash', 437077026.00, 'paid', '2025-12-24', 1, '2025-12-24 04:35:12', '2025-12-25 19:47:17', NULL),
(9, 'PO-20220405-0001', 'FAK-20251226-0003', NULL, 10, '2022-04-05', 'Blanditiis corrupti', 13273344.00, 'cash', 13273344.00, 'paid', '2012-12-29', 1, '2025-12-24 18:19:08', '2025-12-25 19:47:23', NULL),
(11, 'PO-20071030-0001', 'FAK-20251226-0004', '162', 9, '2007-10-30', 'Quos corrupti excep', 86335248.00, 'cash', 86335248.00, 'paid', '2025-12-26', 1, '2025-12-25 19:54:22', '2025-12-25 19:56:52', NULL),
(12, 'PO-20251226-0001', '301', '969', 2, '2025-12-26', 'Eum fugiat dolor er', 19452019.00, 'transfer', 19452019.00, 'paid', '2013-07-31', 1, '2025-12-25 20:05:50', '2025-12-25 20:32:08', NULL),
(13, 'PO-20251227-0001', 'FAK-20251227-0001', NULL, 8, '2025-12-27', NULL, 29409.00, 'cash', 29409.00, 'paid', '2025-12-27', 1, '2025-12-27 14:01:08', '2025-12-27 15:27:40', NULL),
(14, 'PO-19911111-0001', '427', '752', 11, '1991-11-11', 'Id sequi rerum ducim', 3308070.00, 'transfer', 58.00, 'partial', '1993-05-11', 1, '2025-12-27 15:30:07', '2025-12-27 15:30:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_items`
--

CREATE TABLE `pembelian_items` (
  `id` bigint UNSIGNED NOT NULL,
  `pembelian_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembelian_items`
--

INSERT INTO `pembelian_items` (`id`, `pembelian_id`, `item_id`, `item_name`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(15, 5, 133, 'Sensor Mesin Knitting 419', 806, 1334629.00, 1075710974.00, '2025-12-25 19:46:56', '2025-12-25 19:46:56'),
(16, 7, 135, 'Pump Mesin Knitting 376', 171, 2556006.00, 437077026.00, '2025-12-25 19:47:17', '2025-12-25 19:47:17'),
(17, 9, 79, 'Kain S/J 30s Combed - Crimson Red', 126, 105344.00, 13273344.00, '2025-12-25 19:47:23', '2025-12-25 19:47:23'),
(19, 11, 73, 'Kain S/J 30s Combed - Abu-abu (Grey)', 816, 105803.00, 86335248.00, '2025-12-25 19:56:52', '2025-12-25 19:56:52'),
(20, 12, 6, 'Benang Cotton Carded 24s', 463, 42013.00, 19452019.00, '2025-12-25 20:05:50', '2025-12-25 20:05:50'),
(21, 13, 4, 'Benang Cotton Combed 40s', 1, 29409.00, 29409.00, '2025-12-27 14:01:08', '2025-12-27 14:01:08'),
(22, 14, 83, 'Kain S/J 30s Combed - Yellow', 30, 110269.00, 3308070.00, '2025-12-27 15:30:07', '2025-12-27 15:30:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `group`, `created_at`, `updated_at`) VALUES
(1, 'inventory.view', 'Melihat Data Produk', 'Inventory', '2025-12-31 20:37:16', '2025-12-31 20:37:16'),
(2, 'inventory.create', 'Tambah Produk', 'Inventory', '2025-12-31 20:37:16', '2025-12-31 20:37:16'),
(3, 'inventory.edit', 'Edit Produk', 'Inventory', '2025-12-31 20:37:16', '2025-12-31 20:37:16'),
(4, 'inventory.delete', 'Hapus/Arsip Produk', 'Inventory', '2025-12-31 20:37:16', '2025-12-31 20:37:16'),
(5, 'inventory.import', 'Import Data Produk', 'Inventory', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(6, 'inventory.label', 'Cetak Label/Barcode QR', 'Inventory', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(7, 'inventory.scanner', 'Akses Mobile Scanner', 'Inventory', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(8, 'master.categories', 'Kelola Kategori Produk', 'Master Data', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(9, 'master.units', 'Kelola Satuan', 'Master Data', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(10, 'master.suppliers', 'Kelola Supplier', 'Master Data', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(11, 'master.customers', 'Kelola Pelanggan', 'Master Data', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(12, 'sales.view', 'Melihat Daftar Penjualan', 'Transaksi Penjualan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(13, 'sales.create', 'Input Penjualan/Scan Keluar', 'Transaksi Penjualan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(14, 'sales.edit', 'Edit Data Penjualan', 'Transaksi Penjualan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(15, 'sales.delete', 'Hapus/Arsip Penjualan', 'Transaksi Penjualan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(16, 'sales.report', 'Melihat Laporan Penjualan', 'Transaksi Penjualan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(17, 'sales.return', 'Kelola Retur Penjualan', 'Transaksi Penjualan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(18, 'purchase.view', 'Melihat Daftar Pembelian', 'Transaksi Pembelian', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(19, 'purchase.create', 'Input Pembelian/Terima Barang', 'Transaksi Pembelian', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(20, 'purchase.edit', 'Edit Data Pembelian', 'Transaksi Pembelian', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(21, 'purchase.delete', 'Hapus/Arsip Pembelian', 'Transaksi Pembelian', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(22, 'purchase.approve', 'Persetujuan Pembelian Besar', 'Transaksi Pembelian', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(23, 'purchase.return', 'Kelola Retur Pembelian', 'Transaksi Pembelian', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(24, 'production.view', 'Melihat Rencana & Request Produksi', 'Produksi / PPIC', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(25, 'production.create', 'Buat Rencana & Permintaan Material', 'Produksi / PPIC', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(26, 'production.edit', 'Update Hasil Barang Jadi', 'Produksi / PPIC', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(27, 'production.delete', 'Batalkan Rencana Produksi', 'Produksi / PPIC', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(28, 'production.status', 'Update Status Produksi', 'Produksi / PPIC', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(29, 'warehouse.manage', 'Kelola Gudang & Lokasi', 'Gudang & Stok', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(30, 'adjustment.create', 'Input Stock Opname', 'Gudang & Stok', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(31, 'adjustment.approve', 'Persetujuan Penyesuaian Stok', 'Gudang & Stok', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(32, 'transfer.create', 'Input Transfer Antar Rak/Gudang', 'Gudang & Stok', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(33, 'transfer.approve', 'Persetujuan Transfer Stok', 'Gudang & Stok', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(34, 'stock.ledger', 'Melihat Jurnal/Buku Stok', 'Gudang & Stok', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(35, 'finance.view', 'Melihat Dashboard Keuangan', 'Finance', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(36, 'finance.cashflow', 'Melihat Arus Kas (Cash Flow)', 'Finance', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(37, 'finance.payable', 'Mengelola Hutang Supplier', 'Finance', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(38, 'finance.receivable', 'Mengelola Piutang Customer', 'Finance', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(39, 'expense.manage', 'Kelola Biaya Operasional', 'Finance', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(40, 'payment.process', 'Proses & Cetak Bukti Bayar', 'Finance', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(41, 'reports.view', 'Akses Menu Laporan', 'Laporan & Analisis', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(42, 'reports.profit_loss', 'Melihat Laporan Laba Rugi', 'Laporan & Analisis', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(43, 'reports.valuation', 'Melihat Valuasi Inventaris (Aset)', 'Laporan & Analisis', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(44, 'reports.turnover', 'Analisis Slow/Fast Moving', 'Laporan & Analisis', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(45, 'reports.performance', 'Melihat Kinerja Gudang', 'Laporan & Analisis', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(46, 'settings.company', 'Konfigurasi Profil & Dokumen', 'Sistem & Keamanan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(47, 'settings.users', 'Manajemen Akun Karyawan', 'Sistem & Keamanan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(48, 'settings.rbac', 'Manajemen Hak Akses (RBAC)', 'Sistem & Keamanan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(49, 'settings.logs', 'Audit Log / History Aktivitas', 'Sistem & Keamanan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(50, 'settings.trash', 'Akses Pusat Pemulihan (Data Restore)', 'Sistem & Keamanan', '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(51, 'system.tools', 'Backup Database & System Tools', 'Sistem & Keamanan', '2025-12-31 20:37:17', '2025-12-31 20:37:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `productions`
--

CREATE TABLE `productions` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty_planned` int NOT NULL,
  `qty_actual` int DEFAULT NULL,
  `waste_qty` decimal(15,2) NOT NULL DEFAULT '0.00',
  `waste_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('planned','approved','ready','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'planned',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `productions`
--

INSERT INTO `productions` (`id`, `code`, `batch_number`, `item_id`, `qty_planned`, `qty_actual`, `waste_qty`, `waste_reason`, `machine_name`, `total_cost`, `status`, `start_date`, `end_date`, `notes`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'PROD-20251224-001', 'BCH-20251224-001', 73, 483, 791, 798.00, 'Hic magnam aliquid v', 'Cassidy Reilly', 22168293.00, 'completed', '2025-12-24', '2025-12-24', 'Quo id nisi tempor n', 1, '2025-12-24 02:08:16', '2025-12-24 02:09:42', NULL),
(6, 'PROD-20251124-001', NULL, 103, 435, NULL, 0.00, NULL, 'SET-01', 0.00, 'planned', '2025-11-24', NULL, 'Seeded production data for Kain S/J 30s Combed - Super Black', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(7, 'PROD-20251201-002', 'BCH-20251224-002', 76, 500, 491, 9.00, 'Normal production loss', 'SET-01', 88691500.00, 'completed', '2025-12-01', '2025-12-03', 'Seeded production data for Kain S/J 30s Combed - Broken White', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(8, 'PROD-20251214-003', NULL, 126, 127, NULL, 0.00, NULL, 'DYE-02', 0.00, 'cancelled', '2025-12-14', NULL, 'Production cancelled due to machine maintenance.', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(9, 'PROD-20251221-004', 'BCH-20251224-003', 123, 129, 123, 6.00, 'Normal production loss', 'DYE-01', 6257012.00, 'completed', '2025-12-21', '2025-12-23', 'Seeded production data for Greige S/J 30s Combed', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(10, 'PROD-20251216-005', NULL, 77, 313, NULL, 0.00, NULL, 'SET-01', 0.00, 'cancelled', '2025-12-16', NULL, 'Production cancelled due to machine maintenance.', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(11, 'PROD-20251222-006', NULL, 74, 125, NULL, 0.00, NULL, 'DYE-01', 0.00, 'planned', '2025-12-22', NULL, 'Seeded production data for Kain S/J 30s Combed - Biru Benhur', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(12, 'PROD-20251201-007', NULL, 121, 246, NULL, 0.00, NULL, 'KNIT-02', 0.00, 'planned', '2025-12-01', NULL, 'Seeded production data for Kain Pique 24s Combed - Hitam', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(13, 'PROD-20251202-008', NULL, 113, 180, NULL, 0.00, NULL, 'SET-01', 0.00, 'in_progress', '2025-12-02', NULL, 'Seeded production data for Kain Pique 24s Combed - Cokelat', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(14, 'PROD-20251223-009', NULL, 91, 338, NULL, 0.00, NULL, 'KNIT-02', 0.00, 'in_progress', '2025-12-23', NULL, 'Seeded production data for Kain S/J 30s Combed - Maroon Red', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(15, 'PROD-20251124-010', 'BCH-20251224-004', 95, 384, 376, 8.00, 'Normal production loss', 'KNIT-01', 56845868.00, 'completed', '2025-11-24', '2025-11-27', 'Seeded production data for Kain S/J 30s Combed - Navy Blue 02', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(16, 'PROD-20251223-011', 'BCH-20251224-005', 105, 221, 211, 10.00, 'Normal production loss', 'KNIT-01', 35233058.00, 'completed', '2025-12-23', '2025-12-24', 'Seeded production data for Kain S/J 30s Combed - Turkis', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(17, 'PROD-20251203-012', NULL, 93, 499, NULL, 0.00, NULL, 'KNIT-02', 0.00, 'cancelled', '2025-12-03', NULL, 'Production cancelled due to machine maintenance.', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(18, 'PROD-20251212-013', 'BCH-20251224-006', 118, 177, 175, 2.00, 'Normal production loss', 'SET-01', 79984356.00, 'completed', '2025-12-12', '2025-12-15', 'Seeded production data for Kain Pique 24s Combed - Fuchsia Pink', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(19, 'PROD-20251126-014', NULL, 124, 490, NULL, 0.00, NULL, 'KNIT-01', 0.00, 'in_progress', '2025-11-26', NULL, 'Seeded production data for Greige Pique 24s Combed', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(20, 'PROD-20251220-015', NULL, 79, 300, NULL, 0.00, NULL, 'DYE-01', 0.00, 'planned', '2025-12-20', NULL, 'Seeded production data for Kain S/J 30s Combed - Crimson Red', 1, '2025-12-24 02:14:03', '2025-12-24 02:14:03', NULL),
(21, 'PROD-20251224-017', 'BCH-20251224-007', 72, 3, 3, 0.50, NULL, NULL, 95271.00, 'completed', '2025-12-24', '2025-12-24', NULL, 1, '2025-12-24 16:01:21', '2025-12-24 16:07:24', NULL),
(22, 'PROD-20251225-001', NULL, 84, 207, 207, 0.00, NULL, 'Chava Parks', 0.00, 'in_progress', '2025-12-25', NULL, 'Ex dolore nulla dign', 6, '2025-12-24 19:42:02', '2025-12-26 04:28:27', NULL),
(23, 'PROD-20251227-001', NULL, 88, 86, NULL, 0.00, NULL, 'Quemby Frost', 0.00, 'planned', '2008-12-23', NULL, 'Earum provident in', 7, '2025-12-27 06:56:53', '2025-12-27 06:56:53', NULL),
(24, 'PROD-20251227-002', NULL, 86, 177, 177, 0.00, NULL, 'Cheyenne Burgess', 0.00, 'in_progress', '2025-12-27', NULL, 'Nulla minima iste ra', 1, '2025-12-27 13:58:11', '2025-12-27 13:58:38', NULL),
(25, 'PROD-20251227-003', NULL, 101, 672, NULL, 0.00, NULL, 'Amy Morrison', 0.00, 'approved', '2014-12-19', NULL, 'Dolores aliqua Ex e', 1, '2025-12-27 16:31:28', '2025-12-27 16:39:16', NULL),
(26, 'PROD-20251227-004', 'BCH-20260101-001', 108, 602, 147, 456.00, 'Eiusmod ea libero im', 'Adele Holmes', 4760912.00, 'completed', '1998-04-07', '2026-01-01', NULL, 1, '2025-12-27 16:38:45', '2025-12-31 20:46:26', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `production_materials`
--

CREATE TABLE `production_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `production_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty_needed` int NOT NULL,
  `qty_used` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `production_materials`
--

INSERT INTO `production_materials` (`id`, `production_id`, `item_id`, `qty_needed`, `qty_used`, `created_at`, `updated_at`) VALUES
(8, 5, 3, 633, 633, '2025-12-24 02:08:16', '2025-12-24 02:08:52'),
(9, 6, 131, 479, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(10, 6, 46, 47, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(11, 6, 55, 45, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(12, 7, 21, 550, 550, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(13, 7, 40, 39, 39, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(14, 7, 66, 30, 30, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(15, 8, 24, 140, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(16, 8, 55, 14, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(17, 9, 10, 142, 142, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(18, 9, 60, 10, 10, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(19, 10, 9, 344, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(20, 10, 66, 15, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(21, 11, 25, 138, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(22, 11, 48, 39, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(23, 11, 55, 26, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(24, 12, 33, 271, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(25, 12, 42, 41, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(26, 12, 56, 46, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(27, 13, 4, 198, 198, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(28, 13, 60, 5, 5, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(29, 14, 12, 372, 372, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(30, 14, 48, 46, 46, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(31, 14, 54, 37, 37, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(32, 15, 8, 422, 422, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(33, 15, 50, 23, 23, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(34, 15, 67, 19, 19, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(35, 16, 12, 243, 243, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(36, 16, 39, 50, 50, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(37, 16, 56, 16, 16, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(38, 17, 23, 549, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(39, 17, 64, 16, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(40, 18, 25, 195, 195, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(41, 18, 50, 42, 42, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(42, 19, 24, 539, 539, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(43, 19, 64, 33, 33, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(44, 20, 38, 330, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(45, 20, 52, 16, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(46, 20, 62, 23, 0, '2025-12-24 02:14:03', '2025-12-24 02:14:03'),
(47, 21, 2, 3, 3, '2025-12-24 16:01:21', '2025-12-24 16:06:39'),
(49, 22, 41, 453, 453, '2025-12-24 19:42:15', '2025-12-27 06:57:34'),
(50, 23, 4, 347, 0, '2025-12-27 06:56:53', '2025-12-27 06:56:53'),
(51, 24, 149, 182, 182, '2025-12-27 13:58:11', '2025-12-27 13:58:38'),
(52, 25, 27, 150, 0, '2025-12-27 16:31:28', '2025-12-27 16:31:28'),
(53, 26, 33, 188, 188, '2025-12-27 16:38:45', '2025-12-31 20:45:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_pembelians`
--

CREATE TABLE `retur_pembelians` (
  `id` bigint UNSIGNED NOT NULL,
  `return_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembelian_id` bigint UNSIGNED NOT NULL,
  `retur_date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `total_returned_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `retur_pembelians`
--

INSERT INTO `retur_pembelians` (`id`, `return_number`, `pembelian_id`, `retur_date`, `notes`, `total_returned_amount`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'RTR-20251230-7', 7, '2025-12-30', NULL, 7668018.00, 1, '2025-12-30 08:03:17', '2025-12-30 08:03:17', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_pembelian_items`
--

CREATE TABLE `retur_pembelian_items` (
  `id` bigint UNSIGNED NOT NULL,
  `retur_pembelian_id` bigint UNSIGNED NOT NULL,
  `pembelian_item_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `subtotal_returned` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `retur_pembelian_items`
--

INSERT INTO `retur_pembelian_items` (`id`, `retur_pembelian_id`, `pembelian_item_id`, `item_id`, `item_name`, `quantity`, `unit_price`, `subtotal_returned`, `created_at`, `updated_at`) VALUES
(8, 7, 16, 135, 'Pump Mesin Knitting 376', 3, 2556006.00, 7668018.00, '2025-12-30 08:03:17', '2025-12-30 08:03:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', 1, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(2, 'admin', 2, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(3, 'admin', 3, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(4, 'admin', 4, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(5, 'admin', 5, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(6, 'admin', 6, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(7, 'admin', 7, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(8, 'admin', 8, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(9, 'admin', 9, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(10, 'admin', 10, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(11, 'admin', 11, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(12, 'admin', 12, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(13, 'admin', 13, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(14, 'admin', 14, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(15, 'admin', 15, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(16, 'admin', 16, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(17, 'admin', 17, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(18, 'admin', 18, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(19, 'admin', 19, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(20, 'admin', 20, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(21, 'admin', 21, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(22, 'admin', 22, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(23, 'admin', 23, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(24, 'admin', 24, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(25, 'admin', 25, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(26, 'admin', 26, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(27, 'admin', 27, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(28, 'admin', 28, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(29, 'admin', 29, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(30, 'admin', 30, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(31, 'admin', 31, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(32, 'admin', 32, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(33, 'admin', 33, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(34, 'admin', 34, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(35, 'admin', 35, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(36, 'admin', 36, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(37, 'admin', 37, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(38, 'admin', 38, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(39, 'admin', 39, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(40, 'admin', 40, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(41, 'admin', 41, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(42, 'admin', 42, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(43, 'admin', 43, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(44, 'admin', 44, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(45, 'admin', 45, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(46, 'admin', 46, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(47, 'admin', 47, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(48, 'admin', 48, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(49, 'admin', 49, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(50, 'admin', 50, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(51, 'admin', 51, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(52, 'manajer', 1, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(53, 'manajer', 7, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(54, 'manajer', 8, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(55, 'manajer', 9, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(56, 'manajer', 10, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(57, 'manajer', 11, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(58, 'manajer', 12, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(59, 'manajer', 16, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(60, 'manajer', 18, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(61, 'manajer', 22, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(62, 'manajer', 24, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(63, 'manajer', 31, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(64, 'manajer', 33, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(65, 'manajer', 34, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(66, 'manajer', 35, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(67, 'manajer', 36, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(68, 'manajer', 41, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(69, 'manajer', 42, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(70, 'manajer', 44, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(71, 'manajer', 43, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(72, 'manajer', 45, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(73, 'manajer', 46, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(74, 'manajer', 49, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(75, 'finance', 1, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(76, 'finance', 12, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(77, 'finance', 16, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(78, 'finance', 18, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(79, 'finance', 35, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(80, 'finance', 36, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(81, 'finance', 37, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(82, 'finance', 38, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(83, 'finance', 39, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(84, 'finance', 40, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(85, 'finance', 41, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(86, 'finance', 42, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(87, 'finance', 43, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(88, 'kepala_gudang', 1, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(89, 'kepala_gudang', 2, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(90, 'kepala_gudang', 3, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(91, 'kepala_gudang', 6, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(92, 'kepala_gudang', 7, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(93, 'kepala_gudang', 29, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(94, 'kepala_gudang', 30, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(95, 'kepala_gudang', 31, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(96, 'kepala_gudang', 32, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(97, 'kepala_gudang', 33, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(98, 'kepala_gudang', 34, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(99, 'kepala_gudang', 12, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(100, 'kepala_gudang', 17, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(101, 'kepala_gudang', 18, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(102, 'kepala_gudang', 19, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(103, 'kepala_gudang', 23, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(104, 'kepala_gudang', 24, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(105, 'kepala_gudang', 41, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(106, 'kepala_gudang', 44, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(107, 'kepala_gudang', 45, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(108, 'staff_gudang', 1, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(109, 'staff_gudang', 2, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(110, 'staff_gudang', 3, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(111, 'staff_gudang', 6, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(112, 'staff_gudang', 7, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(113, 'staff_gudang', 8, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(114, 'staff_gudang', 9, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(115, 'staff_gudang', 30, '2025-12-31 20:37:17', '2025-12-31 20:37:17'),
(116, 'staff_gudang', 32, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(117, 'staff_gudang', 34, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(118, 'staff_gudang', 12, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(119, 'staff_gudang', 13, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(120, 'staff_gudang', 18, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(121, 'staff_gudang', 19, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(122, 'staff_gudang', 24, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(123, 'staff_gudang', 28, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(124, 'produksi', 1, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(125, 'produksi', 24, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(126, 'produksi', 25, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(127, 'produksi', 26, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(128, 'produksi', 27, '2025-12-31 20:37:18', '2025-12-31 20:37:18'),
(129, 'produksi', 28, '2025-12-31 20:37:18', '2025-12-31 20:37:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_date` date NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `due_date` date DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `change_amount` decimal(10,2) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sales`
--

INSERT INTO `sales` (`id`, `invoice_number`, `sale_date`, `customer_id`, `customer_name`, `total_amount`, `discount_amount`, `tax_amount`, `grand_total`, `payment_method`, `payment_status`, `due_date`, `paid_amount`, `change_amount`, `user_id`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'INV-20251223-0001', '2025-12-23', NULL, 'Aurora Best', 42410.00, 96.00, 59.00, 42373.00, 'cash', 'paid', NULL, 42373.00, 0.00, 1, 'Veritatis cum quia e', '2025-12-23 02:27:58', '2025-12-23 02:27:58', NULL),
(7, 'INV-20251223-0002', '2025-12-23', NULL, 'Aurora Best', 202690.00, 60.00, 65.00, 202695.00, 'cash', 'paid', NULL, 202695.00, 0.00, 1, 'Perferendis eum poss', '2025-12-23 02:51:00', '2025-12-23 02:51:00', NULL),
(8, 'INV-20251223-0003', '2025-12-23', 4, 'CV Busana Muslimah Sejahtera', 312676.00, 0.00, 0.00, 312676.00, 'transfer', 'paid', NULL, 312676.00, 0.00, 1, NULL, '2025-12-23 16:05:14', '2025-12-23 16:05:14', NULL),
(9, 'INV-20251224-0001', '2025-12-24', 10, 'Distributor Benang Nusantara', 49348.00, 33.00, 90.00, 49405.00, 'transfer', 'paid', NULL, 49405.00, 0.00, 1, 'Et exercitationem se', '2025-12-24 04:23:24', '2025-12-24 04:34:23', NULL),
(10, 'INV-20251225-0001', '2025-12-25', 11, 'Designer Studio Annisa', 312676.00, 43.00, 39.00, 312672.00, 'cash', 'paid', '2025-12-25', 312672.00, 0.00, 1, 'Et sed molestias lab', '2025-12-24 18:16:14', '2025-12-25 20:31:38', NULL),
(11, 'INV-20251227-0001', '2025-12-27', 7, 'Butik Cantik Menawan', 2162385.00, 0.00, 0.00, 2162385.00, 'transfer', 'paid', NULL, 2162385.00, 0.00, 1, NULL, '2025-12-26 20:00:02', '2025-12-31 19:52:40', '2025-12-31 19:52:40'),
(12, 'INV-20251227-0002', '2025-12-27', 7, 'Butik Cantik Menawan', 223318.00, 0.00, 0.00, 223318.00, 'cash', 'credit', '2025-12-27', 0.00, 0.00, 1, NULL, '2025-12-26 23:58:11', '2025-12-26 23:58:11', NULL),
(13, 'INV-20251227-0003', '2025-12-27', 10, 'Distributor Benang Nusantara', 689.00, 0.00, 0.00, 689.00, 'cash', 'credit', '2025-12-27', 0.00, 0.00, 1, NULL, '2025-12-27 13:59:08', '2025-12-27 13:59:08', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `item_id`, `item_name`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(7, 6, 13, 'Benang Tetoron Cotton 20s', 1, 42410.00, 42410.00, '2025-12-23 02:27:58', '2025-12-23 02:27:58'),
(8, 7, 64, 'Disperse Red Grade 2', 1, 202690.00, 202690.00, '2025-12-23 02:51:00', '2025-12-23 02:51:00'),
(9, 8, 68, 'Acid Orange Grade 3', 1, 312676.00, 312676.00, '2025-12-23 16:05:14', '2025-12-23 16:05:14'),
(11, 9, 3, 'Benang Cotton Combed 30s', 1, 49348.00, 49348.00, '2025-12-24 04:34:23', '2025-12-24 04:34:23'),
(12, 10, 68, 'Acid Orange Grade 3', 1, 312676.00, 312676.00, '2025-12-24 18:16:14', '2025-12-24 18:16:14'),
(14, 12, 66, 'Acid Orange Grade 1', 1, 223318.00, 223318.00, '2025-12-26 23:58:11', '2025-12-26 23:58:11'),
(15, 13, 148, 'Alana Barry', 1, 689.00, 689.00, '2025-12-27 13:59:08', '2025-12-27 13:59:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint UNSIGNED NOT NULL,
  `return_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_returned_amount` decimal(15,2) NOT NULL,
  `refund_amount` decimal(15,2) DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sale_returns`
--

INSERT INTO `sale_returns` (`id`, `return_number`, `sale_id`, `user_id`, `return_date`, `total_returned_amount`, `refund_amount`, `reason`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'R202512230001', NULL, 1, '2025-12-23 01:21:42', 125916.00, 125916.00, 'Hello', NULL, '2025-12-23 01:21:42', '2025-12-23 01:21:42', NULL),
(2, 'R202512230002', 8, 1, '2025-12-23 16:14:44', 312676.00, 312676.00, 'Barang Rusak', NULL, '2025-12-23 16:14:44', '2025-12-23 16:14:44', NULL),
(3, 'R202512240003', 6, 1, '2025-12-23 17:00:00', 94312.00, 2.00, 'Architecto occaecat', 'Iusto quia blanditii', '2025-12-24 04:32:50', '2025-12-24 04:33:28', NULL),
(4, 'R202512250004', 7, 1, '2025-12-24 18:17:36', 202690.00, 47.00, 'Enim molestias totam', 'Quaerat voluptate et', '2025-12-24 18:17:36', '2025-12-24 18:17:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sale_return_items`
--

CREATE TABLE `sale_return_items` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_return_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price_per_unit` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sale_return_items`
--

INSERT INTO `sale_return_items` (`id`, `sale_return_id`, `item_id`, `quantity`, `price_per_unit`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 67, 1, 125916.00, 125916.00, '2025-12-23 01:21:42', '2025-12-23 01:21:42'),
(2, 2, 68, 1, 312676.00, 312676.00, '2025-12-23 16:14:44', '2025-12-23 16:14:44'),
(4, 3, 4, 2, 47156.00, 94312.00, '2025-12-24 04:33:28', '2025-12-24 04:33:28'),
(5, 4, 64, 1, 202690.00, 202690.00, '2025-12-24 18:17:36', '2025-12-24 18:17:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` bigint UNSIGNED NOT NULL,
  `adjustment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty_before` decimal(15,2) NOT NULL,
  `qty_adjustment` decimal(15,2) NOT NULL,
  `qty_after` decimal(15,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','level_1_approved','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` bigint UNSIGNED NOT NULL,
  `level_1_approved_by` bigint UNSIGNED DEFAULT NULL,
  `level_1_approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stock_adjustments`
--

INSERT INTO `stock_adjustments` (`id`, `adjustment_no`, `warehouse_id`, `item_id`, `qty_before`, `qty_adjustment`, `qty_after`, `reason`, `status`, `created_by`, `level_1_approved_by`, `level_1_approved_at`, `approved_by`, `approved_at`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ADJ-1766384297', 1, 1, 4304.00, 0.01, 4304.01, 'Salah input', 'approved', 1, 1, '2025-12-22 06:18:23', 1, '2025-12-22 06:18:26', NULL, '2025-12-22 06:18:17', '2025-12-22 06:18:26', NULL),
(2, 'ADJ-20251224-001', 5, 17, 100.00, -6.00, 109.00, 'Retur Supplier Terdeteksi Cacat', 'level_1_approved', 5, 1, '2025-12-24 16:38:59', NULL, NULL, 'Menunggu pengecekan fisik.', '2025-12-24 02:47:02', '2025-12-24 16:38:59', NULL),
(3, 'ADJ-20251224-002', 6, 10, 100.00, -6.00, 90.00, 'Selisih Stock Opname - Barang Ditemukan', 'pending', 5, NULL, NULL, NULL, NULL, 'Menunggu pengecekan fisik.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(4, 'ADJ-20251224-003', 3, 1, 100.00, 7.00, 102.00, 'Barang Hilang / Tidak Ditemukan', 'pending', 5, NULL, NULL, NULL, NULL, 'Menunggu pengecekan fisik.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(5, 'ADJ-20251224-004', 6, 19, 100.00, 4.00, 96.00, 'Barang Rusak Saat Pemindahan', 'pending', 5, NULL, NULL, NULL, NULL, 'Menunggu pengecekan fisik.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(6, 'ADJ-L1-20251224-001', 4, 5, 200.00, -19.00, 193.00, 'Barang Rusak / Reject Produksi', 'level_1_approved', 5, 3, '2025-12-24 00:47:02', NULL, NULL, 'Sudah diverifikasi supervisor.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(7, 'ADJ-L1-20251224-002', 4, 7, 200.00, -18.00, 186.00, 'Barang Rusak / Reject Produksi', 'level_1_approved', 5, 3, '2025-12-23 21:47:02', NULL, NULL, 'Sudah diverifikasi supervisor.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(8, 'ADJ-OK-20251224-001', 4, 10, 167.00, -42.00, 125.00, 'Penyusutan Alami (Kelembaban)', 'approved', 5, 3, '2025-12-23 02:47:02', 1, '2025-12-24 02:47:02', 'Stok diperbarui secara sistem.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(9, 'ADJ-OK-20251224-002', 6, 4, 363.00, -4.00, 359.00, 'Salah Input Saat Penerimaan', 'approved', 5, 3, '2025-12-23 02:47:02', 1, '2025-12-24 02:47:02', 'Stok diperbarui secara sistem.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(10, 'ADJ-OK-20251224-003', 4, 19, 103.00, -41.00, 62.00, 'Barang Rusak Saat Pemindahan', 'approved', 5, 3, '2025-12-23 02:47:02', 1, '2025-12-24 02:47:02', 'Stok diperbarui secara sistem.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(11, 'ADJ-OK-20251224-004', 5, 20, 456.00, 47.00, 503.00, 'Retur Supplier Terdeteksi Cacat', 'approved', 5, 3, '2025-12-23 02:47:02', 1, '2025-12-24 02:47:02', 'Stok diperbarui secara sistem.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(12, 'ADJ-OK-20251224-005', 6, 10, 284.00, -16.00, 268.00, 'Selisih Stock Opname - Barang Ditemukan', 'approved', 5, 3, '2025-12-23 02:47:02', 1, '2025-12-24 02:47:02', 'Stok diperbarui secara sistem.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(13, 'ADJ-REJ-20251224-001', 4, 13, 150.00, 100.00, 250.00, 'Permintaan Penambahan Stok Tanpa Dasar Berita Acara', 'rejected', 5, NULL, NULL, NULL, NULL, 'Ditolak karena tidak ada bukti fisik.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(14, 'ADJ-REJ-20251224-002', 4, 17, 150.00, 100.00, 250.00, 'Permintaan Penambahan Stok Tanpa Dasar Berita Acara', 'rejected', 5, NULL, NULL, NULL, NULL, 'Ditolak karena tidak ada bukti fisik.', '2025-12-24 02:47:02', '2025-12-24 02:47:02', NULL),
(15, 'ADJ-1766843768', 4, 5, 0.00, 933.00, 933.00, 'Aute soluta vero com', 'pending', 1, NULL, NULL, NULL, NULL, NULL, '2025-12-27 13:56:08', '2025-12-27 13:56:08', NULL),
(16, 'ADJ-1766843769', 4, 5, 0.00, 933.00, 933.00, 'Aute soluta vero com', 'pending', 1, NULL, NULL, NULL, NULL, NULL, '2025-12-27 13:56:09', '2025-12-27 13:56:09', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_ledgers`
--

CREATE TABLE `stock_ledgers` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `warehouse_id` bigint UNSIGNED NOT NULL,
  `qty_change` decimal(15,2) NOT NULL,
  `qty_after` decimal(15,2) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stock_ledgers`
--

INSERT INTO `stock_ledgers` (`id`, `item_id`, `warehouse_id`, `qty_change`, `qty_after`, `type`, `reference_type`, `reference_id`, `notes`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 133, 1, 806.00, 823.00, 'in', 'App\\Models\\Pembelian', 5, 'Pembelian PO-20141014-0001', 1, '2025-12-23 16:01:46', '2025-12-23 16:01:46'),
(2, 88, 1, -279.00, 707.00, 'return', 'App\\Models\\Pembelian', 3, 'Hapus Pembelian PO-19751225-0001', 1, '2025-12-23 16:03:39', '2025-12-23 16:03:39'),
(3, 88, 1, -624.00, 83.00, 'return', 'App\\Models\\Pembelian', 4, 'Hapus Pembelian PO-20160322-0001', 1, '2025-12-23 16:03:46', '2025-12-23 16:03:46'),
(4, 55, 1, -500.00, -489.00, 'return', 'App\\Models\\Pembelian', 4, 'Hapus Pembelian PO-20160322-0001', 1, '2025-12-23 16:03:46', '2025-12-23 16:03:46'),
(5, 35, 1, 969.00, 2303.00, 'in', 'App\\Models\\Pembelian', 6, 'Pembelian PO-20251223-0001', 1, '2025-12-23 16:04:10', '2025-12-23 16:04:10'),
(6, 133, 1, -806.00, 17.00, 'return', 'App\\Models\\Pembelian', 5, 'Revisi Pembelian PO-20141014-0001 (Revert)', 1, '2025-12-23 16:04:25', '2025-12-23 16:04:25'),
(7, 133, 1, 806.00, 823.00, 'in', 'App\\Models\\Pembelian', 5, 'Revisi Pembelian PO-20141014-0001 (New)', 1, '2025-12-23 16:04:25', '2025-12-23 16:04:25'),
(8, 68, 1, -23.00, 1.00, 'out', 'App\\Models\\Sale', 8, 'Penjualan INV-20251223-0003', 1, '2025-12-23 16:05:14', '2025-12-23 16:05:14'),
(9, 1, 1, -1.00, 4302.00, 'return', 'App\\Models\\Production', 1, 'Revert Finished Good (Hapus Produksi PROD-20251221-001)', 1, '2025-12-24 02:09:22', '2025-12-24 02:09:22'),
(10, 1, 1, 1.00, 4303.00, 'return', 'App\\Models\\Production', 1, 'Revert Material Usage (Hapus Produksi PROD-20251221-001)', 1, '2025-12-24 02:09:22', '2025-12-24 02:09:22'),
(11, 3, 1, 1.00, 2577.00, 'return', 'App\\Models\\Production', 1, 'Revert Material Usage (Hapus Produksi PROD-20251221-001)', 1, '2025-12-24 02:09:22', '2025-12-24 02:09:22'),
(12, 3, 1, -633.00, 1944.00, 'production', 'App\\Models\\Production', 5, 'Usage for production: PROD-20251224-001 (Batch: BCH-20251224-001)', 1, '2025-12-24 02:09:42', '2025-12-24 02:09:42'),
(13, 73, 1, 791.00, 1084.00, 'production', 'App\\Models\\Production', 5, 'Finished goods from: PROD-20251224-001 (Batch: BCH-20251224-001)', 1, '2025-12-24 02:09:42', '2025-12-24 02:09:42'),
(14, 10, 4, -42.00, 125.00, 'adjustment', 'App\\Models\\StockAdjustment', 8, 'Penyusutan Alami (Kelembaban)', 1, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(15, 4, 6, -4.00, 359.00, 'adjustment', 'App\\Models\\StockAdjustment', 9, 'Salah Input Saat Penerimaan', 1, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(16, 19, 4, -41.00, 62.00, 'adjustment', 'App\\Models\\StockAdjustment', 10, 'Barang Rusak Saat Pemindahan', 1, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(17, 20, 5, 47.00, 503.00, 'adjustment', 'App\\Models\\StockAdjustment', 11, 'Retur Supplier Terdeteksi Cacat', 1, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(18, 10, 6, -16.00, 268.00, 'adjustment', 'App\\Models\\StockAdjustment', 12, 'Selisih Stock Opname - Barang Ditemukan', 1, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(19, 6, 6, -46.00, 100.00, 'transfer', 'App\\Models\\StockTransfer', 9, 'Transfer out to Gudang Kain Jadi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(20, 6, 5, 46.00, 66.00, 'transfer', 'App\\Models\\StockTransfer', 9, 'Transfer in from Gudang Lantai Produksi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(21, 11, 6, -31.00, 100.00, 'transfer', 'App\\Models\\StockTransfer', 10, 'Transfer out to Gudang Kain Jadi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(22, 11, 5, 31.00, 63.00, 'transfer', 'App\\Models\\StockTransfer', 10, 'Transfer in from Gudang Lantai Produksi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(23, 7, 6, -18.00, 100.00, 'transfer', 'App\\Models\\StockTransfer', 11, 'Transfer out to Gudang Kain Jadi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(24, 7, 5, 18.00, 25.00, 'transfer', 'App\\Models\\StockTransfer', 11, 'Transfer in from Gudang Lantai Produksi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(25, 13, 6, -41.00, 100.00, 'transfer', 'App\\Models\\StockTransfer', 12, 'Transfer out to Gudang Kain Jadi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(26, 13, 5, 41.00, 52.00, 'transfer', 'App\\Models\\StockTransfer', 12, 'Transfer in from Gudang Lantai Produksi', 1, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(27, 71, 1, -173.00, 1.00, 'out', 'App\\Models\\Sale', 9, 'Penjualan INV-20251224-0001', 1, '2025-12-24 04:23:24', '2025-12-24 04:23:24'),
(28, 71, 1, 1.00, 2.00, 'return', 'App\\Models\\Sale', 9, 'Revisi Penjualan INV-20251224-0001 (Revert)', 1, '2025-12-24 04:34:23', '2025-12-24 04:34:23'),
(29, 3, 1, -1.00, 1943.00, 'out', 'App\\Models\\Sale', 9, 'Revisi Penjualan INV-20251224-0001 (New)', 1, '2025-12-24 04:34:23', '2025-12-24 04:34:23'),
(30, 135, 1, 171.00, 199.00, 'in', 'App\\Models\\Pembelian', 7, 'Pembelian PO-20251224-0001', 1, '2025-12-24 04:35:12', '2025-12-24 04:35:12'),
(31, 35, 1, -969.00, 1333.00, 'return', 'App\\Models\\Pembelian', 6, 'Hapus Pembelian PO-20251223-0001', 1, '2025-12-24 04:35:43', '2025-12-24 04:35:43'),
(32, 16, 1, 1.00, 4602.00, 'in', 'App\\Models\\Pembelian', 8, 'Pembelian PO-20251224-0002', 1, '2025-12-24 04:38:23', '2025-12-24 04:38:23'),
(33, 2, 1, -3.00, 2501.00, 'production', 'App\\Models\\Production', 21, 'Usage for production: PROD-20251224-017 (Batch: BCH-20251224-007)', 1, '2025-12-24 16:07:24', '2025-12-24 16:07:24'),
(34, 72, 1, 3.00, 314.00, 'production', 'App\\Models\\Production', 21, 'Finished goods from: PROD-20251224-017 (Batch: BCH-20251224-007)', 1, '2025-12-24 16:07:24', '2025-12-24 16:07:24'),
(35, 68, 1, -1.00, 1.00, 'out', 'App\\Models\\Sale', 10, 'Penjualan INV-20251225-0001', 1, '2025-12-24 18:16:14', '2025-12-24 18:16:14'),
(36, 79, 1, 126.00, 354.00, 'in', 'App\\Models\\Pembelian', 9, 'Pembelian PO-20220405-0001', 1, '2025-12-24 18:19:08', '2025-12-24 18:19:08'),
(37, 6, 1, 434.00, 4812.00, 'in', 'App\\Models\\Pembelian', 10, 'Pembelian PO-20040202-0001', 1, '2025-12-25 19:07:29', '2025-12-25 19:07:29'),
(38, 6, 1, -434.00, 4378.00, 'return', 'App\\Models\\Pembelian', 10, 'Revisi Pembelian PO-20040202-0001 (Revert)', 1, '2025-12-25 19:08:03', '2025-12-25 19:08:03'),
(39, 74, 1, 537.00, 824.00, 'in', 'App\\Models\\Pembelian', 10, 'Revisi Pembelian PO-20040202-0001 (New)', 1, '2025-12-25 19:08:03', '2025-12-25 19:08:03'),
(40, 74, 1, -537.00, 287.00, 'return', 'App\\Models\\Pembelian', 10, 'Hapus Pembelian PO-20040202-0001', 1, '2025-12-25 19:15:46', '2025-12-25 19:15:46'),
(41, 16, 1, -1.00, 4601.00, 'return', 'App\\Models\\Pembelian', 8, 'Hapus Pembelian PO-20251224-0002', 1, '2025-12-25 19:43:26', '2025-12-25 19:43:26'),
(42, 133, 1, -806.00, 17.00, 'return', 'App\\Models\\Pembelian', 5, 'Revisi Pembelian PO-20141014-0001 (Revert)', 1, '2025-12-25 19:46:56', '2025-12-25 19:46:56'),
(43, 133, 1, 806.00, 823.00, 'in', 'App\\Models\\Pembelian', 5, 'Revisi Pembelian PO-20141014-0001 (New)', 1, '2025-12-25 19:46:56', '2025-12-25 19:46:56'),
(44, 135, 1, -171.00, 28.00, 'return', 'App\\Models\\Pembelian', 7, 'Revisi Pembelian PO-20251224-0001 (Revert)', 1, '2025-12-25 19:47:17', '2025-12-25 19:47:17'),
(45, 135, 1, 171.00, 199.00, 'in', 'App\\Models\\Pembelian', 7, 'Revisi Pembelian PO-20251224-0001 (New)', 1, '2025-12-25 19:47:17', '2025-12-25 19:47:17'),
(46, 79, 1, -126.00, 228.00, 'return', 'App\\Models\\Pembelian', 9, 'Revisi Pembelian PO-20220405-0001 (Revert)', 1, '2025-12-25 19:47:23', '2025-12-25 19:47:23'),
(47, 79, 1, 126.00, 354.00, 'in', 'App\\Models\\Pembelian', 9, 'Revisi Pembelian PO-20220405-0001 (New)', 1, '2025-12-25 19:47:23', '2025-12-25 19:47:23'),
(48, 73, 1, 816.00, 1900.00, 'in', 'App\\Models\\Pembelian', 11, 'Pembelian PO-20071030-0001', 1, '2025-12-25 19:54:22', '2025-12-25 19:54:22'),
(49, 73, 1, -816.00, 1084.00, 'return', 'App\\Models\\Pembelian', 11, 'Revisi Pembelian PO-20071030-0001 (Revert)', 1, '2025-12-25 19:56:52', '2025-12-25 19:56:52'),
(50, 73, 1, 816.00, 1900.00, 'in', 'App\\Models\\Pembelian', 11, 'Revisi Pembelian PO-20071030-0001 (New)', 1, '2025-12-25 19:56:52', '2025-12-25 19:56:52'),
(51, 6, 1, 463.00, 4841.00, 'in', 'App\\Models\\Pembelian', 12, 'Pembelian PO-20251226-0001', 1, '2025-12-25 20:05:50', '2025-12-25 20:05:50'),
(52, 42, 1, -33.00, 1.00, 'out', 'App\\Models\\Sale', 11, 'Penjualan INV-20251227-0001', 1, '2025-12-26 20:00:02', '2025-12-26 20:00:02'),
(53, 66, 1, -79.00, 1.00, 'out', 'App\\Models\\Sale', 12, 'Penjualan INV-20251227-0002', 1, '2025-12-26 23:58:11', '2025-12-26 23:58:11'),
(54, 150, 6, 3.00, 3.00, 'in', 'Item', 150, 'Stok awal saat pendaftaran barang', 1, '2025-12-27 13:36:41', '2025-12-27 13:36:41'),
(55, 148, 1, -25.00, 1.00, 'out', 'App\\Models\\Sale', 13, 'Penjualan INV-20251227-0003', 1, '2025-12-27 13:59:08', '2025-12-27 13:59:08'),
(56, 4, 1, 1.00, 4449.00, 'in', 'App\\Models\\Pembelian', 13, 'Pembelian PO-20251227-0001', 1, '2025-12-27 14:01:08', '2025-12-27 14:01:08'),
(57, 1, 1, 510.00, 510.00, 'in', 'Item', 1, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(58, 2, 1, 3389.00, 3389.00, 'in', 'Item', 2, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(59, 3, 1, 2217.00, 2217.00, 'in', 'Item', 3, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(60, 4, 1, 1839.00, 1839.00, 'in', 'Item', 4, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(61, 5, 1, 2633.00, 2633.00, 'in', 'Item', 5, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(62, 6, 1, 3346.00, 3346.00, 'in', 'Item', 6, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(63, 7, 1, 1975.00, 1975.00, 'in', 'Item', 7, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(64, 8, 1, 1611.00, 1611.00, 'in', 'Item', 8, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(65, 9, 1, 2876.00, 2876.00, 'in', 'Item', 9, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(66, 10, 1, 2174.00, 2174.00, 'in', 'Item', 10, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(67, 11, 1, 2131.00, 2131.00, 'in', 'Item', 11, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(68, 12, 1, 1757.00, 1757.00, 'in', 'Item', 12, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(69, 13, 1, 4870.00, 4870.00, 'in', 'Item', 13, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(70, 14, 1, 4357.00, 4357.00, 'in', 'Item', 14, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(71, 15, 1, 3071.00, 3071.00, 'in', 'Item', 15, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(72, 16, 1, 3260.00, 3260.00, 'in', 'Item', 16, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:19', '2025-12-27 14:01:19'),
(73, 17, 1, 4630.00, 4630.00, 'in', 'Item', 17, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(74, 18, 1, 3834.00, 3834.00, 'in', 'Item', 18, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(75, 19, 1, 3348.00, 3348.00, 'in', 'Item', 19, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(76, 20, 1, 3494.00, 3494.00, 'in', 'Item', 20, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(77, 21, 1, 3463.00, 3463.00, 'in', 'Item', 21, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(78, 22, 1, 886.00, 886.00, 'in', 'Item', 22, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(79, 23, 1, 1605.00, 1605.00, 'in', 'Item', 23, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(80, 24, 1, 2869.00, 2869.00, 'in', 'Item', 24, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(81, 25, 1, 1190.00, 1190.00, 'in', 'Item', 25, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(82, 26, 1, 2300.00, 2300.00, 'in', 'Item', 26, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(83, 27, 1, 4406.00, 4406.00, 'in', 'Item', 27, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(84, 28, 1, 2680.00, 2680.00, 'in', 'Item', 28, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(85, 29, 1, 3654.00, 3654.00, 'in', 'Item', 29, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(86, 30, 1, 864.00, 864.00, 'in', 'Item', 30, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(87, 31, 1, 588.00, 588.00, 'in', 'Item', 31, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(88, 32, 1, 575.00, 575.00, 'in', 'Item', 32, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(89, 33, 1, 3415.00, 3415.00, 'in', 'Item', 33, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(90, 34, 1, 798.00, 798.00, 'in', 'Item', 34, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(91, 35, 1, 2492.00, 2492.00, 'in', 'Item', 35, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(92, 36, 1, 2635.00, 2635.00, 'in', 'Item', 36, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(93, 37, 1, 300.00, 300.00, 'in', 'Item', 37, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(94, 38, 1, 450.00, 450.00, 'in', 'Item', 38, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(95, 39, 1, 24.00, 24.00, 'in', 'Item', 39, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(96, 40, 1, 8.00, 8.00, 'in', 'Item', 40, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(97, 41, 1, 31.00, 31.00, 'in', 'Item', 41, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(98, 42, 1, 47.00, 47.00, 'in', 'Item', 42, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(99, 43, 1, 31.00, 31.00, 'in', 'Item', 43, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(100, 44, 1, 28.00, 28.00, 'in', 'Item', 44, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(101, 45, 1, 32.00, 32.00, 'in', 'Item', 45, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(102, 46, 1, 38.00, 38.00, 'in', 'Item', 46, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(103, 47, 1, 20.00, 20.00, 'in', 'Item', 47, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(104, 48, 1, 24.00, 24.00, 'in', 'Item', 48, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(105, 49, 1, 13.00, 13.00, 'in', 'Item', 49, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(106, 50, 1, 45.00, 45.00, 'in', 'Item', 50, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(107, 51, 1, 21.00, 21.00, 'in', 'Item', 51, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(108, 52, 1, 32.00, 32.00, 'in', 'Item', 52, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(109, 53, 1, 8.00, 8.00, 'in', 'Item', 53, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(110, 54, 1, 17.00, 17.00, 'in', 'Item', 54, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(111, 55, 1, 28.00, 28.00, 'in', 'Item', 55, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(112, 56, 1, 29.00, 29.00, 'in', 'Item', 56, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(113, 57, 1, 30.00, 30.00, 'in', 'Item', 57, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(114, 58, 1, 8.00, 8.00, 'in', 'Item', 58, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(115, 59, 1, 43.00, 43.00, 'in', 'Item', 59, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(116, 60, 1, 13.00, 13.00, 'in', 'Item', 60, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(117, 61, 1, 154.00, 154.00, 'in', 'Item', 61, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(118, 62, 1, 134.00, 134.00, 'in', 'Item', 62, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(119, 63, 1, 28.00, 28.00, 'in', 'Item', 63, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(120, 64, 1, 106.00, 106.00, 'in', 'Item', 64, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(121, 65, 1, 41.00, 41.00, 'in', 'Item', 65, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(122, 66, 1, 156.00, 156.00, 'in', 'Item', 66, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(123, 67, 1, 26.00, 26.00, 'in', 'Item', 67, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(124, 68, 1, 157.00, 157.00, 'in', 'Item', 68, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(125, 69, 1, 23.00, 23.00, 'in', 'Item', 69, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(126, 70, 1, 61.00, 61.00, 'in', 'Item', 70, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(127, 71, 1, 176.00, 176.00, 'in', 'Item', 71, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(128, 72, 1, 107.00, 107.00, 'in', 'Item', 72, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(129, 73, 1, 984.00, 984.00, 'in', 'Item', 73, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(130, 74, 1, 184.00, 184.00, 'in', 'Item', 74, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:20', '2025-12-27 14:01:20'),
(131, 75, 1, 732.00, 732.00, 'in', 'Item', 75, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(132, 76, 1, 824.00, 824.00, 'in', 'Item', 76, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(133, 77, 1, 538.00, 538.00, 'in', 'Item', 77, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(134, 78, 1, 748.00, 748.00, 'in', 'Item', 78, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(135, 79, 1, 538.00, 538.00, 'in', 'Item', 79, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(136, 80, 1, 832.00, 832.00, 'in', 'Item', 80, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(137, 81, 1, 688.00, 688.00, 'in', 'Item', 81, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(138, 82, 1, 193.00, 193.00, 'in', 'Item', 82, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(139, 83, 1, 797.00, 797.00, 'in', 'Item', 83, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(140, 84, 1, 135.00, 135.00, 'in', 'Item', 84, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(141, 85, 1, 264.00, 264.00, 'in', 'Item', 85, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(142, 86, 1, 388.00, 388.00, 'in', 'Item', 86, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(143, 87, 1, 293.00, 293.00, 'in', 'Item', 87, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(144, 88, 1, 312.00, 312.00, 'in', 'Item', 88, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(145, 89, 1, 907.00, 907.00, 'in', 'Item', 89, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(146, 90, 1, 222.00, 222.00, 'in', 'Item', 90, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(147, 91, 1, 123.00, 123.00, 'in', 'Item', 91, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(148, 92, 1, 804.00, 804.00, 'in', 'Item', 92, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(149, 93, 1, 934.00, 934.00, 'in', 'Item', 93, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(150, 94, 1, 404.00, 404.00, 'in', 'Item', 94, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(151, 95, 1, 214.00, 214.00, 'in', 'Item', 95, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(152, 96, 1, 368.00, 368.00, 'in', 'Item', 96, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(153, 97, 1, 222.00, 222.00, 'in', 'Item', 97, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(154, 98, 1, 111.00, 111.00, 'in', 'Item', 98, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(155, 99, 1, 836.00, 836.00, 'in', 'Item', 99, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(156, 100, 1, 596.00, 596.00, 'in', 'Item', 100, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(157, 101, 1, 133.00, 133.00, 'in', 'Item', 101, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(158, 102, 1, 661.00, 661.00, 'in', 'Item', 102, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(159, 103, 1, 113.00, 113.00, 'in', 'Item', 103, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(160, 104, 1, 276.00, 276.00, 'in', 'Item', 104, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(161, 105, 1, 141.00, 141.00, 'in', 'Item', 105, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(162, 106, 1, 867.00, 867.00, 'in', 'Item', 106, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(163, 107, 1, 308.00, 308.00, 'in', 'Item', 107, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(164, 108, 1, 902.00, 902.00, 'in', 'Item', 108, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(165, 109, 1, 287.00, 287.00, 'in', 'Item', 109, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(166, 110, 1, 881.00, 881.00, 'in', 'Item', 110, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(167, 111, 1, 259.00, 259.00, 'in', 'Item', 111, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(168, 112, 1, 256.00, 256.00, 'in', 'Item', 112, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(169, 113, 1, 772.00, 772.00, 'in', 'Item', 113, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(170, 114, 1, 635.00, 635.00, 'in', 'Item', 114, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(171, 115, 1, 213.00, 213.00, 'in', 'Item', 115, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(172, 116, 1, 865.00, 865.00, 'in', 'Item', 116, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(173, 117, 1, 465.00, 465.00, 'in', 'Item', 117, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(174, 118, 1, 255.00, 255.00, 'in', 'Item', 118, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(175, 119, 1, 120.00, 120.00, 'in', 'Item', 119, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(176, 120, 1, 401.00, 401.00, 'in', 'Item', 120, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(177, 121, 1, 405.00, 405.00, 'in', 'Item', 121, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(178, 122, 1, 612.00, 612.00, 'in', 'Item', 122, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(179, 123, 1, 447.00, 447.00, 'in', 'Item', 123, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(180, 124, 1, 1172.00, 1172.00, 'in', 'Item', 124, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(181, 125, 1, 3978.00, 3978.00, 'in', 'Item', 125, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(182, 126, 1, 2570.00, 2570.00, 'in', 'Item', 126, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:21', '2025-12-27 14:01:21'),
(183, 127, 1, 1380.00, 1380.00, 'in', 'Item', 127, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(184, 128, 1, 44.00, 44.00, 'in', 'Item', 128, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(185, 129, 1, 18.00, 18.00, 'in', 'Item', 129, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(186, 130, 1, 15.00, 15.00, 'in', 'Item', 130, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(187, 131, 1, 28.00, 28.00, 'in', 'Item', 131, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(188, 132, 1, 28.00, 28.00, 'in', 'Item', 132, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(189, 133, 1, 47.00, 47.00, 'in', 'Item', 133, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(190, 134, 1, 27.00, 27.00, 'in', 'Item', 134, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(191, 135, 1, 5.00, 5.00, 'in', 'Item', 135, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(192, 136, 1, 13.00, 13.00, 'in', 'Item', 136, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(193, 137, 1, 47.00, 47.00, 'in', 'Item', 137, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(194, 138, 1, 49.00, 49.00, 'in', 'Item', 138, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(195, 139, 1, 42.00, 42.00, 'in', 'Item', 139, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(196, 140, 1, 46.00, 46.00, 'in', 'Item', 140, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(197, 141, 1, 30.00, 30.00, 'in', 'Item', 141, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(198, 142, 1, 35.00, 35.00, 'in', 'Item', 142, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(199, 143, 1, 3.00, 3.00, 'in', 'Item', 143, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(200, 144, 1, 19.00, 19.00, 'in', 'Item', 144, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(201, 145, 1, 34.00, 34.00, 'in', 'Item', 145, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(202, 146, 1, 17.00, 17.00, 'in', 'Item', 146, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(203, 147, 1, 22.00, 22.00, 'in', 'Item', 147, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(204, 148, 1, 23.00, 23.00, 'in', 'Item', 148, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(205, 149, 1, 84.00, 84.00, 'in', 'Item', 149, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(206, 150, 1, 35.00, 35.00, 'in', 'Item', 150, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(208, 152, 1, 68.00, 68.00, 'in', 'Item', 152, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(210, 154, 1, 39.00, 39.00, 'in', 'Item', 154, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(211, 155, 1, 78.00, 78.00, 'in', 'Item', 155, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(212, 156, 1, 25.00, 25.00, 'in', 'Item', 156, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(213, 157, 1, 43.00, 43.00, 'in', 'Item', 157, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:01:22', '2025-12-27 14:01:22'),
(214, 1, 1, 1921.00, 1921.00, 'in', 'Item', 1, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(215, 2, 1, 2004.00, 2004.00, 'in', 'Item', 2, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(216, 3, 1, 4165.00, 4165.00, 'in', 'Item', 3, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(217, 4, 1, 2892.00, 2892.00, 'in', 'Item', 4, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(218, 5, 1, 1404.00, 1404.00, 'in', 'Item', 5, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(219, 6, 1, 2165.00, 2165.00, 'in', 'Item', 6, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(220, 7, 1, 882.00, 882.00, 'in', 'Item', 7, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(221, 8, 1, 2185.00, 2185.00, 'in', 'Item', 8, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(222, 9, 1, 2803.00, 2803.00, 'in', 'Item', 9, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(223, 10, 1, 4213.00, 4213.00, 'in', 'Item', 10, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(224, 11, 1, 1879.00, 1879.00, 'in', 'Item', 11, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(225, 12, 1, 3832.00, 3832.00, 'in', 'Item', 12, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(226, 13, 1, 4296.00, 4296.00, 'in', 'Item', 13, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(227, 14, 1, 2394.00, 2394.00, 'in', 'Item', 14, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(228, 15, 1, 1404.00, 1404.00, 'in', 'Item', 15, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(229, 16, 1, 3530.00, 3530.00, 'in', 'Item', 16, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(230, 17, 1, 4597.00, 4597.00, 'in', 'Item', 17, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(231, 18, 1, 586.00, 586.00, 'in', 'Item', 18, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(232, 19, 1, 873.00, 873.00, 'in', 'Item', 19, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(233, 20, 1, 2227.00, 2227.00, 'in', 'Item', 20, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(234, 21, 1, 2849.00, 2849.00, 'in', 'Item', 21, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(235, 22, 1, 1809.00, 1809.00, 'in', 'Item', 22, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(236, 23, 1, 2279.00, 2279.00, 'in', 'Item', 23, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(237, 24, 1, 954.00, 954.00, 'in', 'Item', 24, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(238, 25, 1, 3482.00, 3482.00, 'in', 'Item', 25, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(239, 26, 1, 1585.00, 1585.00, 'in', 'Item', 26, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(240, 27, 1, 4774.00, 4774.00, 'in', 'Item', 27, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(241, 28, 1, 1123.00, 1123.00, 'in', 'Item', 28, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(242, 29, 1, 2864.00, 2864.00, 'in', 'Item', 29, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(243, 30, 1, 3616.00, 3616.00, 'in', 'Item', 30, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(244, 31, 1, 1097.00, 1097.00, 'in', 'Item', 31, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(245, 32, 1, 1220.00, 1220.00, 'in', 'Item', 32, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(246, 33, 1, 2009.00, 2009.00, 'in', 'Item', 33, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(247, 34, 1, 3944.00, 3944.00, 'in', 'Item', 34, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(248, 35, 1, 1495.00, 1495.00, 'in', 'Item', 35, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(249, 36, 1, 3813.00, 3813.00, 'in', 'Item', 36, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(250, 37, 1, 300.00, 300.00, 'in', 'Item', 37, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(251, 38, 1, 450.00, 450.00, 'in', 'Item', 38, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(252, 39, 1, 20.00, 20.00, 'in', 'Item', 39, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(253, 40, 1, 49.00, 49.00, 'in', 'Item', 40, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(254, 41, 1, 40.00, 40.00, 'in', 'Item', 41, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(255, 42, 1, 12.00, 12.00, 'in', 'Item', 42, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(256, 43, 1, 9.00, 9.00, 'in', 'Item', 43, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(257, 44, 1, 27.00, 27.00, 'in', 'Item', 44, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(258, 45, 1, 44.00, 44.00, 'in', 'Item', 45, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(259, 46, 1, 48.00, 48.00, 'in', 'Item', 46, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(260, 47, 1, 41.00, 41.00, 'in', 'Item', 47, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(261, 48, 1, 6.00, 6.00, 'in', 'Item', 48, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(262, 49, 1, 10.00, 10.00, 'in', 'Item', 49, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(263, 50, 1, 12.00, 12.00, 'in', 'Item', 50, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(264, 51, 1, 9.00, 9.00, 'in', 'Item', 51, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(265, 52, 1, 36.00, 36.00, 'in', 'Item', 52, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(266, 53, 1, 23.00, 23.00, 'in', 'Item', 53, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(267, 54, 1, 5.00, 5.00, 'in', 'Item', 54, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(268, 55, 1, 5.00, 5.00, 'in', 'Item', 55, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(269, 56, 1, 37.00, 37.00, 'in', 'Item', 56, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(270, 57, 1, 15.00, 15.00, 'in', 'Item', 57, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(271, 58, 1, 9.00, 9.00, 'in', 'Item', 58, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(272, 59, 1, 8.00, 8.00, 'in', 'Item', 59, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(273, 60, 1, 24.00, 24.00, 'in', 'Item', 60, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(274, 61, 1, 32.00, 32.00, 'in', 'Item', 61, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(275, 62, 1, 99.00, 99.00, 'in', 'Item', 62, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(276, 63, 1, 89.00, 89.00, 'in', 'Item', 63, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(277, 64, 1, 197.00, 197.00, 'in', 'Item', 64, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(278, 65, 1, 143.00, 143.00, 'in', 'Item', 65, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(279, 66, 1, 198.00, 198.00, 'in', 'Item', 66, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(280, 67, 1, 126.00, 126.00, 'in', 'Item', 67, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(281, 68, 1, 198.00, 198.00, 'in', 'Item', 68, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(282, 69, 1, 33.00, 33.00, 'in', 'Item', 69, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:48', '2025-12-27 14:06:48'),
(283, 70, 1, 132.00, 132.00, 'in', 'Item', 70, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(284, 71, 1, 49.00, 49.00, 'in', 'Item', 71, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(285, 72, 1, 195.00, 195.00, 'in', 'Item', 72, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(286, 73, 1, 714.00, 714.00, 'in', 'Item', 73, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(287, 74, 1, 342.00, 342.00, 'in', 'Item', 74, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(288, 75, 1, 969.00, 969.00, 'in', 'Item', 75, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(289, 76, 1, 518.00, 518.00, 'in', 'Item', 76, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(290, 77, 1, 162.00, 162.00, 'in', 'Item', 77, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(291, 78, 1, 128.00, 128.00, 'in', 'Item', 78, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(292, 79, 1, 560.00, 560.00, 'in', 'Item', 79, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(293, 80, 1, 146.00, 146.00, 'in', 'Item', 80, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(294, 81, 1, 713.00, 713.00, 'in', 'Item', 81, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(295, 82, 1, 467.00, 467.00, 'in', 'Item', 82, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(296, 83, 1, 155.00, 155.00, 'in', 'Item', 83, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(297, 84, 1, 776.00, 776.00, 'in', 'Item', 84, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(298, 85, 1, 296.00, 296.00, 'in', 'Item', 85, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(299, 86, 1, 225.00, 225.00, 'in', 'Item', 86, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(300, 87, 1, 537.00, 537.00, 'in', 'Item', 87, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(301, 88, 1, 644.00, 644.00, 'in', 'Item', 88, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(302, 89, 1, 984.00, 984.00, 'in', 'Item', 89, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(303, 90, 1, 634.00, 634.00, 'in', 'Item', 90, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(304, 91, 1, 471.00, 471.00, 'in', 'Item', 91, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(305, 92, 1, 334.00, 334.00, 'in', 'Item', 92, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(306, 93, 1, 828.00, 828.00, 'in', 'Item', 93, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(307, 94, 1, 359.00, 359.00, 'in', 'Item', 94, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(308, 95, 1, 371.00, 371.00, 'in', 'Item', 95, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(309, 96, 1, 274.00, 274.00, 'in', 'Item', 96, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(310, 97, 1, 798.00, 798.00, 'in', 'Item', 97, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(311, 98, 1, 945.00, 945.00, 'in', 'Item', 98, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(312, 99, 1, 337.00, 337.00, 'in', 'Item', 99, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(313, 100, 1, 799.00, 799.00, 'in', 'Item', 100, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(314, 101, 1, 534.00, 534.00, 'in', 'Item', 101, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(315, 102, 1, 955.00, 955.00, 'in', 'Item', 102, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(316, 103, 1, 410.00, 410.00, 'in', 'Item', 103, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(317, 104, 1, 894.00, 894.00, 'in', 'Item', 104, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(318, 105, 1, 423.00, 423.00, 'in', 'Item', 105, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(319, 106, 1, 280.00, 280.00, 'in', 'Item', 106, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(320, 107, 1, 304.00, 304.00, 'in', 'Item', 107, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(321, 108, 1, 886.00, 886.00, 'in', 'Item', 108, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(322, 109, 1, 192.00, 192.00, 'in', 'Item', 109, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(323, 110, 1, 160.00, 160.00, 'in', 'Item', 110, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(324, 111, 1, 926.00, 926.00, 'in', 'Item', 111, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(325, 112, 1, 883.00, 883.00, 'in', 'Item', 112, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(326, 113, 1, 742.00, 742.00, 'in', 'Item', 113, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(327, 114, 1, 980.00, 980.00, 'in', 'Item', 114, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(328, 115, 1, 277.00, 277.00, 'in', 'Item', 115, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(329, 116, 1, 679.00, 679.00, 'in', 'Item', 116, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(330, 117, 1, 293.00, 293.00, 'in', 'Item', 117, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(331, 118, 1, 168.00, 168.00, 'in', 'Item', 118, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(332, 119, 1, 969.00, 969.00, 'in', 'Item', 119, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(333, 120, 1, 406.00, 406.00, 'in', 'Item', 120, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(334, 121, 1, 154.00, 154.00, 'in', 'Item', 121, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(335, 122, 1, 517.00, 517.00, 'in', 'Item', 122, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(336, 123, 1, 291.00, 291.00, 'in', 'Item', 123, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(337, 124, 1, 1787.00, 1787.00, 'in', 'Item', 124, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(338, 125, 1, 2293.00, 2293.00, 'in', 'Item', 125, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(339, 126, 1, 4336.00, 4336.00, 'in', 'Item', 126, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(340, 127, 1, 1616.00, 1616.00, 'in', 'Item', 127, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(341, 128, 1, 1.00, 1.00, 'in', 'Item', 128, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(342, 129, 1, 33.00, 33.00, 'in', 'Item', 129, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(343, 130, 1, 47.00, 47.00, 'in', 'Item', 130, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(344, 131, 1, 13.00, 13.00, 'in', 'Item', 131, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(345, 132, 1, 10.00, 10.00, 'in', 'Item', 132, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(346, 133, 1, 21.00, 21.00, 'in', 'Item', 133, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(347, 134, 1, 19.00, 19.00, 'in', 'Item', 134, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(348, 135, 1, 44.00, 44.00, 'in', 'Item', 135, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(349, 136, 1, 39.00, 39.00, 'in', 'Item', 136, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(350, 137, 1, 19.00, 19.00, 'in', 'Item', 137, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(351, 138, 1, 46.00, 46.00, 'in', 'Item', 138, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(352, 139, 1, 40.00, 40.00, 'in', 'Item', 139, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(353, 140, 1, 12.00, 12.00, 'in', 'Item', 140, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(354, 141, 1, 24.00, 24.00, 'in', 'Item', 141, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(355, 142, 1, 26.00, 26.00, 'in', 'Item', 142, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(356, 143, 1, 16.00, 16.00, 'in', 'Item', 143, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(357, 144, 1, 33.00, 33.00, 'in', 'Item', 144, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:49', '2025-12-27 14:06:49'),
(358, 145, 1, 28.00, 28.00, 'in', 'Item', 145, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(359, 146, 1, 27.00, 27.00, 'in', 'Item', 146, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(360, 147, 1, 32.00, 32.00, 'in', 'Item', 147, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(361, 148, 1, 88.00, 88.00, 'in', 'Item', 148, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(362, 149, 1, 23.00, 23.00, 'in', 'Item', 149, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(363, 150, 1, 79.00, 79.00, 'in', 'Item', 150, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(365, 152, 1, 40.00, 40.00, 'in', 'Item', 152, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(367, 154, 1, 95.00, 95.00, 'in', 'Item', 154, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(368, 155, 1, 27.00, 27.00, 'in', 'Item', 155, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(369, 156, 1, 80.00, 80.00, 'in', 'Item', 156, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(370, 157, 1, 15.00, 15.00, 'in', 'Item', 157, 'Saldo awal (Seeding Master Data)', 1, '2025-12-27 14:06:50', '2025-12-27 14:06:50'),
(371, 83, 1, 30.00, 185.00, 'in', 'App\\Models\\Pembelian', 14, 'Pembelian PO-19911111-0001', 1, '2025-12-27 15:30:07', '2025-12-27 15:30:07'),
(372, 158, 4, 91.00, 91.00, 'in', 'Item', 158, 'Stok awal saat pendaftaran barang', 1, '2025-12-27 17:06:14', '2025-12-27 17:06:14'),
(374, 42, 1, 1.00, 13.00, 'return', 'App\\Models\\Sale', 11, 'Hapus Penjualan INV-20251227-0001', 1, '2025-12-31 19:52:40', '2025-12-31 19:52:40');
INSERT INTO `stock_ledgers` (`id`, `item_id`, `warehouse_id`, `qty_change`, `qty_after`, `type`, `reference_type`, `reference_id`, `notes`, `user_id`, `created_at`, `updated_at`) VALUES
(375, 33, 1, -188.00, 1821.00, 'production', 'App\\Models\\Production', 26, 'Usage for production: PROD-20251227-004 (Batch: BCH-20260101-001)', 1, '2025-12-31 20:46:26', '2025-12-31 20:46:26'),
(376, 108, 1, 147.00, 1033.00, 'production', 'App\\Models\\Production', 26, 'Finished goods from: PROD-20251227-004 (Batch: BCH-20260101-001)', 1, '2025-12-31 20:46:26', '2025-12-31 20:46:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `transfer_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_warehouse_id` bigint UNSIGNED NOT NULL,
  `to_warehouse_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty` decimal(15,2) NOT NULL,
  `status` enum('pending','approved','shipped','received','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` bigint UNSIGNED NOT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `transfer_date` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stock_transfers`
--

INSERT INTO `stock_transfers` (`id`, `transfer_no`, `from_warehouse_id`, `to_warehouse_id`, `item_id`, `qty`, `status`, `created_by`, `approved_by`, `transfer_date`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TRF-7984D37C', 1, 2, 1, 38.00, 'approved', 1, 1, '2025-12-23 01:00:40', 'Generated sample transfer data.', '2025-12-23 00:58:41', '2025-12-23 01:00:40', NULL),
(6, 'TRF-20251224-001', 3, 6, 2, 45.00, 'pending', 5, NULL, NULL, 'Permintaan bahan baku untuk SPK baru.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(7, 'TRF-20251224-002', 3, 6, 5, 90.00, 'pending', 5, NULL, NULL, 'Permintaan bahan baku untuk SPK baru.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(8, 'TRF-20251224-003', 3, 6, 18, 96.00, 'pending', 5, NULL, NULL, 'Permintaan bahan baku untuk SPK baru.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(9, 'TRF-OK-20251224-001', 6, 5, 6, 46.00, 'approved', 5, 3, '2025-12-23 22:55:18', 'Pemindahan produk jadi dari produksi ke gudang stok.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(10, 'TRF-OK-20251224-002', 6, 5, 11, 31.00, 'approved', 5, 3, '2025-12-23 09:55:18', 'Pemindahan produk jadi dari produksi ke gudang stok.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(11, 'TRF-OK-20251224-003', 6, 5, 7, 18.00, 'approved', 5, 3, '2025-12-23 17:55:18', 'Pemindahan produk jadi dari produksi ke gudang stok.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(12, 'TRF-OK-20251224-004', 6, 5, 13, 41.00, 'approved', 5, 3, '2025-12-23 15:55:18', 'Pemindahan produk jadi dari produksi ke gudang stok.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(13, 'TRF-REJ-20251224-001', 3, 4, 17, 500.00, 'rejected', 5, NULL, NULL, 'Kapasitas gudang tujuan penuh.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL),
(14, 'TRF-REJ-20251224-002', 3, 4, 12, 500.00, 'rejected', 5, NULL, NULL, 'Kapasitas gudang tujuan penuh.', '2025-12-24 02:55:18', '2025-12-24 02:55:18', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `email`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Basil Summers', 'Eu voluptas ipsum e', 'zogadyvot@mailinator.com', '+1 (916) 146-3972', 'Inventore ea consequ', '2025-12-21 10:40:06', '2025-12-24 04:20:18', '2025-12-24 04:20:18'),
(2, 'PT Indorama Synthetics Tbk', 'Bpk. Hendra Gunawan', 'sales@indorama.com', '021-3922333', 'Gedung Graha Irama, Jl. HR Rasuna Said, Jakarta', '2025-12-23 15:34:08', '2025-12-23 15:34:08', NULL),
(3, 'PT Argo Pantes Tbk', 'Ibu Maria Ulfa', 'procurement@argopantes.com', '021-5501463', 'Jl. MH Thamrin No. 1, Cikokol, Tangerang', '2025-12-23 15:34:08', '2025-12-23 15:34:08', NULL),
(4, 'BASF Indonesia', 'Mr. Simon Tan', 'info.indonesia@basf.com', '021-5262481', 'DBS Bank Tower Lt. 27, Ciputra World 1, Jakarta', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(5, 'Huntsman Indonesia', 'Bpk. Agus Salim', 'contact_us@huntsman.com', '021-8234567', 'Jl. Raya Bogor Km 27, Ciracas, Jakarta', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(6, 'Archroma Indonesia', 'Ibu Siti Aminah', 'sales.id@archroma.com', '021-8672233', 'Jl. Jababeka II Blok C, Cikarang, Bekasi', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(7, 'PT Sri Rejeki Isman Tbk (Sritex)', 'Bpk. Iwan Kurniawan', 'marketing@sritex.co.id', '0271-593188', 'Jl. KH Samanhudi 88, Jetis, Sukoharjo, Solo', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(8, 'DyStar Indonesia', 'Ms. Linda Wong', 'dyestuff@dystar.com', '021-5270550', 'Menara Global Lt. 20, Jl. Jend Gatot Subroto, Jakarta', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(9, 'PT Lucky Textile', 'Bpk. Bambang Sujatmiko', 'lucky@luckytextile.id', '021-5918888', 'Jl. Raya Serang Km 12, Cikupa, Tangerang', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(10, 'Groz-Beckert Indonesia', 'Bpk. Rudi Hartono', 'sales.id@groz-beckert.com', '022-7798899', 'Kawasan Industri Batujajar, Bandung', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(11, 'PT Asahi Kasei Indonesia', 'Mr. Tanaka', 'procurement@asahi-kasei.co.jp', '021-5201111', 'Wisma Keiai Lt. 10, Jl. Jend Sudirman, Jakarta', '2025-12-23 15:34:09', '2025-12-23 15:34:09', NULL),
(12, 'Charlotte Gonzalez', 'Adipisci soluta cum', 'xecunoc@mailinator.com', '+1 (276) 306-9413', 'Officia dolorum quas', '2025-12-24 04:20:05', '2025-12-24 04:20:27', '2025-12-24 04:20:27'),
(13, 'Noelani Terrell', 'Hic veritatis ration', 'bohep@mailinator.com', '+1 (721) 687-1435', 'Omnis culpa unde qu', '2025-12-24 04:20:38', '2025-12-24 04:21:03', '2025-12-24 04:21:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `units`
--

INSERT INTO `units` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', 'Pcs', '2025-12-21 10:27:28', '2025-12-22 04:54:48'),
(2, 'Non est ut incidunt', NULL, '2025-12-21 10:27:28', '2025-12-21 10:27:28'),
(3, 'Kg', 'kg', '2025-12-22 04:16:38', '2025-12-22 04:16:38'),
(4, 'Meter', 'Mtr', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(5, 'Yard', 'Yd', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(6, 'Roll', 'Roll', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(7, 'Drum', 'Drm', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(8, 'Pail', 'Pail', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(9, 'Sak', 'Sak', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(10, 'Box', 'Box', '2025-12-22 04:16:38', '2025-12-22 04:54:48'),
(11, 'Liter', 'L', '2025-12-22 04:16:38', '2025-12-22 04:16:38'),
(12, 'Kilogram', 'Kg', '2025-12-22 04:54:48', '2025-12-22 04:54:48'),
(13, 'Cone', 'Cone', '2025-12-22 04:54:48', '2025-12-22 04:54:48'),
(14, 'Pack', 'Pack', '2025-12-22 04:54:48', '2025-12-22 04:54:48'),
(15, 'Set', 'Set', '2025-12-22 04:54:48', '2025-12-22 04:54:48'),
(16, 'Unit', 'Unit', '2025-12-22 04:54:48', '2025-12-22 04:54:48'),
(17, 'Pallet', 'Pallet', '2025-12-22 04:59:15', '2025-12-22 04:59:15'),
(18, 'Can', 'Can', '2025-12-22 04:59:15', '2025-12-22 04:59:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `image`, `phone`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Adam Miftah (Admin)', 'admin@gmail.com', 'users/hmgsUbpcTg7rDNLTB14XetnvYrveLWxPTzOCohng.jpg', '081234567890', '2025-12-16 16:35:55', '$2y$12$XQeS.v7LxvT9yMqmtBXFfu..qCmfvNcBEIQVN2xhgHyByrNnDP.j2', 'admin', 'active', 'VWoENzafckyFDr6TcROlovp02ZxxbhLpfhuti16Ly2fdFKrv9CdsEj5efrd0', '2025-12-16 16:35:56', '2025-12-31 22:04:59'),
(3, 'Hendra Operasional', 'manajer@gudang.com', 'users/JWbS1pG3BNx2Sv3QKTH1K43KV1IUAvbknQv1QVyU.jpg', '081234567891', NULL, '$2y$12$UQL3rbeLQYyUAopxPVHVieCCAcJUex925pZF05e5tWkN5.oBe9ixu', 'manajer', 'active', NULL, '2025-12-23 17:16:01', '2025-12-31 19:10:32'),
(4, 'Siti Finance', 'finance@gudang.com', 'users/J0AljQ88Bb11SvW4UMOpYk8A4bnLoYh7nK1UStIe.jpg', '081234567892', NULL, '$2y$12$9Ef97n24LiwE/jkKEP3BW.vMd78sNzBNn19sgTfZ/vMS/rAk3ZOoC', 'finance', 'active', NULL, '2025-12-23 17:16:01', '2025-12-31 19:10:32'),
(5, 'Budi Gudang', 'staff@gudang.com', 'users/XZftfexF2G6iJP2NbSzQcqkjEfYq3WFNgnLxa4D5.jpg', '081234567893', NULL, '$2y$12$AMtHoP8xODXW.5yVCNqDeudH0ZmLwfRKnEm.XvBdvmKVrv9F7WhCO', 'staff_gudang', 'active', NULL, '2025-12-23 17:16:01', '2025-12-31 19:10:32'),
(6, 'Agus Produksi / PPIC', 'produksi@gudang.com', 'users/76e498bLzKETPMOd5lDAXDec2QSTDeCoQ8yJgROf.jpg', '081234567894', NULL, '$2y$12$/4RQmtOQNHruVV1sJURN0uyTC9M1FGPtjwQV7qEkv/LNYAaa/90Le', 'produksi', 'active', NULL, '2025-12-23 17:16:01', '2025-12-31 19:10:32'),
(7, 'Dedi Supervisor', 'supervisor@gudang.com', 'users/slxZxTFtJr3cn3rdOUzAesbJfaCnJdyQl0gSlInm.jpg', '081234567895', NULL, '$2y$12$R1xvCHRn3fg044vaYMJXUejPcJIC6VFhEGTcWtrfuC2RYhVKdQU6G', 'kepala_gudang', 'active', NULL, '2025-12-24 16:24:13', '2025-12-31 19:10:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `code`, `address`, `is_default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gudang Utama', 'WH-MAIN', 'Jl. Industri Utama No. 1, Bandung', 1, '2025-12-22 06:13:00', '2025-12-27 14:06:48', NULL),
(2, 'Eugenia Mcgowan', 'Possimus officia eo', 'Unde irure sit accus', 0, '2025-12-23 00:28:11', '2025-12-23 00:28:11', NULL),
(3, 'Gudang Bahan Baku', 'WH-RAW', 'Gedung A, Area Timur', 0, '2025-12-23 17:39:10', '2025-12-27 14:06:50', NULL),
(4, 'Gudang Chemical & Dyestuff', 'WH-CHEM', 'Gedung B (Ventilasi Khusus)', 0, '2025-12-23 17:39:10', '2025-12-27 14:06:50', NULL),
(5, 'Gudang Kain Jadi', 'WH-FIN', 'Gedung C, Area Pengiriman', 0, '2025-12-23 17:39:10', '2025-12-27 14:06:50', NULL),
(6, 'Gudang Lantai Produksi', 'WH-PROD', 'Area Workshop Utama', 0, '2025-12-23 17:39:10', '2025-12-27 14:06:50', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `warehouse_stocks`
--

CREATE TABLE `warehouse_stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `warehouse_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `stock` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `warehouse_stocks`
--

INSERT INTO `warehouse_stocks` (`id`, `warehouse_id`, `item_id`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1921.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(2, 1, 2, 2004.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(3, 1, 3, 4165.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(4, 1, 4, 2892.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(5, 1, 5, 1404.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(6, 1, 6, 2165.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(7, 1, 7, 882.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(8, 1, 8, 2185.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(9, 1, 9, 2803.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(10, 1, 10, 4213.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(11, 1, 11, 1879.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(12, 1, 12, 3832.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(13, 1, 13, 4296.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(14, 1, 14, 2394.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(15, 1, 15, 1404.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(16, 1, 16, 3530.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(17, 1, 17, 4597.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(18, 1, 18, 586.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(19, 1, 19, 873.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(20, 1, 20, 2227.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(21, 1, 21, 2849.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(22, 1, 22, 1809.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(23, 1, 23, 2279.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(24, 1, 24, 954.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(25, 1, 25, 3482.00, '2025-12-22 06:13:00', '2025-12-27 14:06:48'),
(26, 1, 26, 1585.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(27, 1, 27, 4774.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(28, 1, 28, 1123.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(29, 1, 29, 2864.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(30, 1, 30, 3616.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(31, 1, 31, 1097.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(32, 1, 32, 1220.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(33, 1, 33, 1821.00, '2025-12-22 06:13:01', '2025-12-31 20:46:26'),
(34, 1, 34, 3944.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(35, 1, 35, 1495.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(36, 1, 36, 3813.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(37, 1, 37, 300.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(38, 1, 38, 450.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(39, 1, 39, 20.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(40, 1, 40, 49.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(41, 1, 41, 40.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(42, 1, 42, 13.00, '2025-12-22 06:13:01', '2025-12-31 19:52:40'),
(43, 1, 43, 9.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(44, 1, 44, 27.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(45, 1, 45, 44.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(46, 1, 46, 48.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(47, 1, 47, 41.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(48, 1, 48, 6.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(49, 1, 49, 10.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(50, 1, 50, 12.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(51, 1, 51, 9.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(52, 1, 52, 36.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(53, 1, 53, 23.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(54, 1, 54, 5.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(55, 1, 55, 5.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(56, 1, 56, 37.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(57, 1, 57, 15.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(58, 1, 58, 9.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(59, 1, 59, 8.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(60, 1, 60, 24.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(61, 1, 61, 32.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(62, 1, 62, 99.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(63, 1, 63, 89.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(64, 1, 64, 197.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(65, 1, 65, 143.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(66, 1, 66, 198.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(67, 1, 67, 126.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(68, 1, 68, 198.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(69, 1, 69, 33.00, '2025-12-22 06:13:01', '2025-12-27 14:06:48'),
(70, 1, 70, 132.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(71, 1, 71, 49.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(72, 1, 72, 195.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(73, 1, 73, 714.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(74, 1, 74, 342.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(75, 1, 75, 969.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(76, 1, 76, 518.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(77, 1, 77, 162.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(78, 1, 78, 128.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(79, 1, 79, 560.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(80, 1, 80, 146.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(81, 1, 81, 713.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(82, 1, 82, 467.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(83, 1, 83, 185.00, '2025-12-22 06:13:01', '2025-12-27 15:30:07'),
(84, 1, 84, 776.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(85, 1, 85, 296.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(86, 1, 86, 225.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(87, 1, 87, 537.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(88, 1, 88, 644.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(89, 1, 89, 984.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(90, 1, 90, 634.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(91, 1, 91, 471.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(92, 1, 92, 334.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(93, 1, 93, 828.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(94, 1, 94, 359.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(95, 1, 95, 371.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(96, 1, 96, 274.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(97, 1, 97, 798.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(98, 1, 98, 945.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(99, 1, 99, 337.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(100, 1, 100, 799.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(101, 1, 101, 534.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(102, 1, 102, 955.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(103, 1, 103, 410.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(104, 1, 104, 894.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(105, 1, 105, 423.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(106, 1, 106, 280.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(107, 1, 107, 304.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(108, 1, 108, 1033.00, '2025-12-22 06:13:01', '2025-12-31 20:46:26'),
(109, 1, 109, 192.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(110, 1, 110, 160.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(111, 1, 111, 926.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(112, 1, 112, 883.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(113, 1, 113, 742.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(114, 1, 114, 980.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(115, 1, 115, 277.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(116, 1, 116, 679.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(117, 1, 117, 293.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(118, 1, 118, 168.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(119, 1, 119, 969.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(120, 1, 120, 406.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(121, 1, 121, 154.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(122, 1, 122, 517.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(123, 1, 123, 291.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(124, 1, 124, 1787.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(125, 1, 125, 2293.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(126, 1, 126, 4336.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(127, 1, 127, 1616.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(128, 1, 128, 1.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(129, 1, 129, 33.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(131, 1, 131, 13.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(132, 1, 132, 10.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(133, 1, 133, 21.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(134, 1, 134, 19.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(135, 1, 135, 44.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(136, 1, 136, 39.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(137, 1, 137, 19.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(138, 1, 138, 46.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(139, 1, 139, 40.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(140, 1, 140, 12.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(141, 1, 141, 24.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(142, 1, 142, 26.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(143, 1, 143, 16.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(144, 1, 144, 33.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(145, 1, 145, 28.00, '2025-12-22 06:13:01', '2025-12-27 14:06:49'),
(146, 1, 146, 27.00, '2025-12-22 06:13:01', '2025-12-27 14:06:50'),
(147, 2, 1, 38.00, '2025-12-23 01:00:39', '2025-12-23 01:00:40'),
(148, 4, 10, 125.00, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(149, 6, 4, 359.00, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(150, 4, 19, 62.00, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(151, 5, 20, 503.00, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(152, 6, 10, 268.00, '2025-12-24 02:47:02', '2025-12-24 02:47:02'),
(153, 6, 6, 100.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(154, 5, 6, 66.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(155, 6, 11, 100.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(156, 5, 11, 63.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(157, 6, 7, 100.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(158, 5, 7, 25.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(159, 6, 13, 100.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(160, 5, 13, 52.00, '2025-12-24 02:55:18', '2025-12-24 02:55:18'),
(161, 6, 150, 3.00, '2025-12-27 13:36:41', '2025-12-27 13:36:41'),
(162, 1, 148, 88.00, '2025-12-27 13:59:08', '2025-12-27 14:06:50'),
(163, 1, 130, 47.00, '2025-12-27 14:01:22', '2025-12-27 14:06:49'),
(164, 1, 147, 32.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(165, 1, 149, 23.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(166, 1, 150, 79.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(168, 1, 152, 40.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(170, 1, 154, 95.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(171, 1, 155, 27.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(172, 1, 156, 80.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(173, 1, 157, 15.00, '2025-12-27 14:01:22', '2025-12-27 14:06:50'),
(174, 4, 158, 91.00, '2025-12-27 17:06:14', '2025-12-27 17:06:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_name_unique` (`name`);

--
-- Indeks untuk tabel `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indeks untuk tabel `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_category_id_foreign` (`category_id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_categories_name_unique` (`name`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_product_code_unique` (`product_code`),
  ADD UNIQUE KEY `items_barcode_unique` (`barcode`),
  ADD UNIQUE KEY `items_sku_unique` (`sku`),
  ADD KEY `items_category_id_foreign` (`category_id`),
  ADD KEY `items_unit_id_foreign` (`unit_id`),
  ADD KEY `items_color_id_foreign` (`color_id`);

--
-- Indeks untuk tabel `keramiks`
--
ALTER TABLE `keramiks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `material_requests`
--
ALTER TABLE `material_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_requests_request_number_unique` (`request_number`),
  ADD KEY `material_requests_production_id_foreign` (`production_id`),
  ADD KEY `material_requests_user_id_foreign` (`user_id`),
  ADD KEY `material_requests_approved_by_foreign` (`approved_by`),
  ADD KEY `material_requests_fulfilled_by_foreign` (`fulfilled_by`),
  ADD KEY `material_requests_warehouse_id_foreign` (`warehouse_id`);

--
-- Indeks untuk tabel `material_request_items`
--
ALTER TABLE `material_request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_request_items_material_request_id_foreign` (`material_request_id`),
  ADD KEY `material_request_items_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_reference_type_reference_id_index` (`reference_type`,`reference_id`);

--
-- Indeks untuk tabel `pembelians`
--
ALTER TABLE `pembelians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembelians_purchase_number_unique` (`purchase_number`),
  ADD KEY `pembelians_supplier_id_foreign` (`supplier_id`),
  ADD KEY `pembelians_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pembelian_items`
--
ALTER TABLE `pembelian_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelian_items_pembelian_id_foreign` (`pembelian_id`),
  ADD KEY `pembelian_items_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indeks untuk tabel `productions`
--
ALTER TABLE `productions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productions_code_unique` (`code`),
  ADD KEY `productions_item_id_foreign` (`item_id`),
  ADD KEY `productions_user_id_foreign` (`user_id`),
  ADD KEY `productions_batch_number_index` (`batch_number`);

--
-- Indeks untuk tabel `production_materials`
--
ALTER TABLE `production_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_materials_production_id_foreign` (`production_id`),
  ADD KEY `production_materials_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `retur_pembelians`
--
ALTER TABLE `retur_pembelians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retur_pembelians_pembelian_id_foreign` (`pembelian_id`),
  ADD KEY `retur_pembelians_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `retur_pembelian_items`
--
ALTER TABLE `retur_pembelian_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retur_pembelian_items_retur_pembelian_id_foreign` (`retur_pembelian_id`),
  ADD KEY `retur_pembelian_items_pembelian_item_id_foreign` (`pembelian_item_id`),
  ADD KEY `retur_pembelian_items_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_permission_id_unique` (`role`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indeks untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`);

--
-- Indeks untuk tabel `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sale_returns_return_number_unique` (`return_number`),
  ADD KEY `sale_returns_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_returns_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sale_return_items`
--
ALTER TABLE `sale_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_items_sale_return_id_foreign` (`sale_return_id`),
  ADD KEY `sale_return_items_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_adjustments_adjustment_no_unique` (`adjustment_no`),
  ADD KEY `stock_adjustments_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `stock_adjustments_item_id_foreign` (`item_id`),
  ADD KEY `stock_adjustments_created_by_foreign` (`created_by`),
  ADD KEY `stock_adjustments_level_1_approved_by_foreign` (`level_1_approved_by`),
  ADD KEY `stock_adjustments_approved_by_foreign` (`approved_by`);

--
-- Indeks untuk tabel `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_ledgers_item_id_foreign` (`item_id`),
  ADD KEY `stock_ledgers_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `stock_ledgers_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_transfers_transfer_no_unique` (`transfer_no`),
  ADD KEY `stock_transfers_from_warehouse_id_foreign` (`from_warehouse_id`),
  ADD KEY `stock_transfers_to_warehouse_id_foreign` (`to_warehouse_id`),
  ADD KEY `stock_transfers_item_id_foreign` (`item_id`),
  ADD KEY `stock_transfers_created_by_foreign` (`created_by`),
  ADD KEY `stock_transfers_approved_by_foreign` (`approved_by`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouses_code_unique` (`code`);

--
-- Indeks untuk tabel `warehouse_stocks`
--
ALTER TABLE `warehouse_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouse_stocks_warehouse_id_item_id_unique` (`warehouse_id`,`item_id`),
  ADD KEY `warehouse_stocks_item_id_foreign` (`item_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT untuk tabel `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT untuk tabel `material_requests`
--
ALTER TABLE `material_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `material_request_items`
--
ALTER TABLE `material_request_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pembelians`
--
ALTER TABLE `pembelians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pembelian_items`
--
ALTER TABLE `pembelian_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `productions`
--
ALTER TABLE `productions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `production_materials`
--
ALTER TABLE `production_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `retur_pembelians`
--
ALTER TABLE `retur_pembelians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `retur_pembelian_items`
--
ALTER TABLE `retur_pembelian_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT untuk tabel `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sale_return_items`
--
ALTER TABLE `sale_return_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

--
-- AUTO_INCREMENT untuk tabel `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `warehouse_stocks`
--
ALTER TABLE `warehouse_stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `material_requests`
--
ALTER TABLE `material_requests`
  ADD CONSTRAINT `material_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_requests_fulfilled_by_foreign` FOREIGN KEY (`fulfilled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_requests_production_id_foreign` FOREIGN KEY (`production_id`) REFERENCES `productions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_requests_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `material_request_items`
--
ALTER TABLE `material_request_items`
  ADD CONSTRAINT `material_request_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `material_request_items_material_request_id_foreign` FOREIGN KEY (`material_request_id`) REFERENCES `material_requests` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelians`
--
ALTER TABLE `pembelians`
  ADD CONSTRAINT `pembelians_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian_items`
--
ALTER TABLE `pembelian_items`
  ADD CONSTRAINT `pembelian_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelian_items_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelians` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `productions`
--
ALTER TABLE `productions`
  ADD CONSTRAINT `productions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `production_materials`
--
ALTER TABLE `production_materials`
  ADD CONSTRAINT `production_materials_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_materials_production_id_foreign` FOREIGN KEY (`production_id`) REFERENCES `productions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `retur_pembelians`
--
ALTER TABLE `retur_pembelians`
  ADD CONSTRAINT `retur_pembelians_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `retur_pembelians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `retur_pembelian_items`
--
ALTER TABLE `retur_pembelian_items`
  ADD CONSTRAINT `retur_pembelian_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `retur_pembelian_items_pembelian_item_id_foreign` FOREIGN KEY (`pembelian_item_id`) REFERENCES `pembelian_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `retur_pembelian_items_retur_pembelian_id_foreign` FOREIGN KEY (`retur_pembelian_id`) REFERENCES `retur_pembelians` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `sale_returns_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sale_returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sale_return_items`
--
ALTER TABLE `sale_return_items`
  ADD CONSTRAINT `sale_return_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_return_items_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD CONSTRAINT `stock_adjustments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_adjustments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_adjustments_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_adjustments_level_1_approved_by_foreign` FOREIGN KEY (`level_1_approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_adjustments_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  ADD CONSTRAINT `stock_ledgers_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_ledgers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_ledgers_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD CONSTRAINT `stock_transfers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_transfers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_transfers_from_warehouse_id_foreign` FOREIGN KEY (`from_warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `stock_transfers_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `stock_transfers_to_warehouse_id_foreign` FOREIGN KEY (`to_warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Ketidakleluasaan untuk tabel `warehouse_stocks`
--
ALTER TABLE `warehouse_stocks`
  ADD CONSTRAINT `warehouse_stocks_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `warehouse_stocks_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
