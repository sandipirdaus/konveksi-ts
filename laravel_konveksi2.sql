-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jul 2023 pada 17.45
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_konveksi2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_gaji_karyawan`
--

CREATE TABLE `tbl_gaji_karyawan` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `qty_barang` varchar(255) NOT NULL,
  `nama_pekerja` varchar(255) NOT NULL,
  `harga_jasa` varchar(255) NOT NULL,
  `qty_pekerjaan` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pekerjaan` varchar(50) NOT NULL,
  `vendor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_gaji_karyawan`
--

INSERT INTO `tbl_gaji_karyawan` (`id`, `deskripsi`, `qty_barang`, `nama_pekerja`, `harga_jasa`, `qty_pekerjaan`, `total`, `keterangan`, `tanggal`, `jenis_pekerjaan`, `vendor`) VALUES
(22, 'Potong Baju PDH', '10', 'Ibu Dian', '25000', '10', '250000', 'sudah_di_bayar', '2021-01-09', 'Potong', 'SMK YATINDO'),
(23, 'Potong Baju Batik', '27', 'Pak Zaenudin', '27000', '27', '729000', 'sudah_di_bayar', '2021-01-09', 'Potong', 'SMK YATINDO'),
(24, 'Potong Celana Pendek', '18', 'Ibu Dwi', '19000', '20', '380000', 'sudah_di_bayar', '2021-01-09', 'Potong', 'SMK YATINDO'),
(25, 'Jahit Baju Batik', '10', 'Pak Yanto', '19000', '10', '190000', 'sudah_di_bayar', '2021-01-09', 'Jahit', 'SMK YATINDO'),
(26, 'Jahit Baju PDH', '39', 'Bapak Dewi', '19500', '40', '780000', 'sudah_di_bayar', '2021-01-09', 'Jahit', 'SMK YATINDO'),
(27, 'Jahit Baju Kokoh', '30', 'Ibu Melia', '19500', '30', '585000', 'sudah_di_bayar', '2021-01-09', 'Jahit', 'SMK YATINDO');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_loker`
--

CREATE TABLE `tbl_loker` (
  `id` int(11) NOT NULL,
  `id_loker` varchar(10) NOT NULL,
  `nama_loker` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_loker`
--

INSERT INTO `tbl_loker` (`id`, `id_loker`, `nama_loker`) VALUES
(1, 'L1', 'LOKER_1.1'),
(2, 'L1', 'LOKER_1.2'),
(3, 'L1', 'LOKER_1.3'),
(4, 'L1', 'LOKER_1.4'),
(6, 'L2', 'LOKER_2.1'),
(7, 'L2', 'LOKER_2.2'),
(8, 'L2', 'LOKER_2.3'),
(9, 'L2', 'LOKER_2.4'),
(11, 'L3', 'LOKER_3.1'),
(12, 'L3', 'LOKER_3.2'),
(13, 'L3', 'LOKER_3.3'),
(14, 'L3', 'LOKER_3.4'),
(16, 'L4', 'LOKER_4.1'),
(17, 'L4', 'LOKER_4.2'),
(18, 'L4', 'LOKER_4.3'),
(19, 'L4', 'LOKER_4.4'),
(21, 'L5', 'LOKER_5.1'),
(22, 'L5', 'LOKER_5.2'),
(23, 'L5', 'LOKER_5.3'),
(24, 'L5', 'LOKER_5.4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_orderan`
--

CREATE TABLE `tbl_orderan` (
  `id` int(11) NOT NULL,
  `tgl_order` date NOT NULL,
  `no_po` varchar(50) NOT NULL,
  `nama_vendor` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `pesanan_untuk` varchar(50) NOT NULL,
  `sistem_dp` varchar(10) NOT NULL,
  `dp` int(50) DEFAULT NULL,
  `deadline` date NOT NULL,
  `jenis_orderan` varchar(300) NOT NULL,
  `bahan` varchar(300) NOT NULL,
  `warna` varchar(300) NOT NULL,
  `harga_satuan` varchar(300) NOT NULL,
  `qty` varchar(150) NOT NULL,
  `catatan` varchar(300) NOT NULL,
  `pembelanjaan_bahan` varchar(50) NOT NULL,
  `harga` varchar(150) NOT NULL,
  `hpp_bahan` varchar(150) NOT NULL,
  `hpp_cmt` varchar(150) NOT NULL,
  `hpp_bordir` varchar(150) NOT NULL,
  `profit_value` int(11) NOT NULL,
  `omset_total` int(11) NOT NULL,
  `pemeriksa` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_orderan`
--

INSERT INTO `tbl_orderan` (`id`, `tgl_order`, `no_po`, `nama_vendor`, `no_hp`, `alamat`, `pesanan_untuk`, `sistem_dp`, `dp`, `deadline`, `jenis_orderan`, `bahan`, `warna`, `harga_satuan`, `qty`, `catatan`, `pembelanjaan_bahan`, `harga`, `hpp_bahan`, `hpp_cmt`, `hpp_bordir`, `profit_value`, `omset_total`, `pemeriksa`, `status`) VALUES
(77, '2021-01-08', 'PO.003', 'SMK YATINDO', '08999490', 'Bekasi', 'Bpk Herman', 'TIDAK', NULL, '2021-01-15', '[\"PDH\",null]', '[\"Cotton\",null]', '[\"Biru\",null]', '[\"75000\",null]', '[\"12\",null]', '[\"catatan 1\",null]', 'roll', '36500', '36500', '17500', '18500', 2500, 30000, 'Ahmad Zakaria', 3),
(78, '2021-01-09', 'PO.004', 'SMK BKM2', '08999490', 'Bekasi Pengasinan', 'Bapak Fajar', 'TIDAK', 0, '2021-02-28', '[\"Seragam Baju Sekolah\",\"PDH\",\"PDH\",\"Celana Abu-Abu\",null]', '[\"Cotton\",\"Cotton\",\"Cotton\",\"Cotton\",null]', '[\"Hitam\",\"Biru\",\"Coklat\",\"Abu-Abu\",null]', '[\"64000\",\"75000\",\"75000\",\"45000\",null]', '[\"120\",\"116\",\"190\",\"147\",null]', '[\"Catatan 1\",\"catatan 2\",\"catatan 3\",\"Catatan 4\",null]', 'roll', '36500', '36500', '17500', '7500', 197500, 2005500, 'Ahmad Zakariaaaaa', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_stok`
--

CREATE TABLE `tbl_stok` (
  `id` int(11) NOT NULL,
  `nama_loker` varchar(150) NOT NULL,
  `nama_vendor` varchar(150) NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `qty` int(11) NOT NULL,
  `warna` varchar(150) NOT NULL,
  `bahan` varchar(150) NOT NULL,
  `size` varchar(150) NOT NULL,
  `pemeriksa` varchar(100) NOT NULL,
  `tgl_pemeriksaan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_stok`
--

INSERT INTO `tbl_stok` (`id`, `nama_loker`, `nama_vendor`, `nama_barang`, `qty`, `warna`, `bahan`, `size`, `pemeriksa`, `tgl_pemeriksaan`) VALUES
(11, 'LOKER_4.1', 'SMK BINA JAYA', 'Baju Pdl', 10, 'Abu-Abu', 'Cotton', 'M', 'Ahmad Zakariaaaaa', '2021-01-09'),
(14, 'LOKER_2.3', 'EPSON', 'Baju Seragam', 5, 'Biru', 'Cotton', 'L', 'Ahmad Zakariaaaaa', '2021-01-09'),
(15, 'LOKER_5.3', 'EPSON', 'Baju Seragam', 10, 'Biru', 'Cotton', 'L', 'Ahmad Zakariaaaaa', '2021-01-09'),
(24, 'LOKER_3.3', 'SD ANNADWAH', 'BAJU PRAMUKA', 14, 'Coklat', 'Cotton', 'L', 'Ahmad Zakariaaaaa', '2021-01-09'),
(25, 'LOKER_3.3', 'SD ANNADWAH', 'Baju Batik', 10, 'Hitam', 'Cotton', 'M', 'Ahmad Zakariaaaaa', '2021-01-09'),
(26, 'LOKER_4.4', 'SMK BINA PRESTASI', 'Baju Praktek', 3, 'Hitam', 'Cotton', 'L', 'Ahmad Zakariaaaaa', '2021-01-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `foto`) VALUES
(15, 'Ahmad Zakaria', 'admin@gmail.com', '$2y$10$HIhUrSDb1OqkmsRVi4YBWe57ry1xxOA6z73w69H9Boeh5bL126bvu', 'my_image.png'),
(16, 'Abdul Ghani', 'abdul@gmail.com', '$2y$10$lqk97W6G2ELK53Bsz7HDQ.Zmo9JQ/cvlfVZYW1S0dMMLn9IvjUxuW', 'avatar5.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_gaji_karyawan`
--
ALTER TABLE `tbl_gaji_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_loker`
--
ALTER TABLE `tbl_loker`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_orderan`
--
ALTER TABLE `tbl_orderan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_stok`
--
ALTER TABLE `tbl_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_gaji_karyawan`
--
ALTER TABLE `tbl_gaji_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `tbl_loker`
--
ALTER TABLE `tbl_loker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tbl_orderan`
--
ALTER TABLE `tbl_orderan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `tbl_stok`
--
ALTER TABLE `tbl_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
