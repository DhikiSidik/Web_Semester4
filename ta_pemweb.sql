-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Agu 2023 pada 15.32
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta_pemweb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `foto` varchar(25) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `stok` int(100) DEFAULT NULL,
  `harga` int(100) DEFAULT NULL,
  `idKategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `foto`, `nama_barang`, `stok`, `harga`, `idKategori`) VALUES
(1, 'grill.jpg', 'Grill', 20, 10000, 3),
(2, 'head lamp.jpg', 'Head Lamp', 30, 5000, 6),
(3, 'kompor besar.jpg', 'Kompor Besar', 18, 10000, 3),
(4, 'kompor kecil.jpg', 'Kompor Kecil', 30, 7000, 3),
(5, 'lampu tenda.webp', 'Lampu Tenda', 30, 5000, 6),
(6, 'matras.jpg', 'Matras', 30, 5000, 4),
(7, 'nesting besar.jpg', 'Nesting Besar', 30, 10000, 3),
(8, 'nesting kecil.jpeg', 'Nesting Kecil', 30, 5000, 3),
(9, 'sleeping bag.jpg', 'Sleeping Bag', 30, 15000, 4),
(10, 'tas carrier 30L.png', 'Tas Carrier 30L', 30, 25000, 1),
(11, 'tas carrier 40L.png', 'Tas Carrier 40L', 30, 30000, 1),
(12, 'tas carrier 60L.png', 'Tas Carrier 60L', 30, 35000, 1),
(13, 'tas carrier 80L.png', 'Tas Carrier 80L', 30, 40000, 1),
(14, 'tenda 2 orang.jpeg', 'Tenda Kapasitas 2 Orang', 30, 25000, 2),
(15, 'tenda 4 orang.jpeg', 'Tenda Kapasitas 4 Orang', 23, 30000, 2),
(16, 'tenda 6 orang.jpeg', 'Tenda Kapasitas 6 Orang', 30, 40000, 2),
(17, 'tenda 8 orang.jpeg', 'Tenda Kapasitas 8 Orang', 30, 50000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `jenis` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `jenis`) VALUES
(1, 'Tas Punggung'),
(2, 'Tenda'),
(3, 'Perkakas Masak'),
(4, 'Peralatan Tidur'),
(5, 'Pakaian'),
(6, 'Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `idPesanan` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tanggalPesan` date NOT NULL,
  `totalHarga` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`idPesanan`, `idUser`, `tanggalPesan`, `totalHarga`, `status`) VALUES
(14, 29, '2023-08-03', '30000.00', 'done');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `jenis_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `jenis_role`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Owner');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sewa`
--

CREATE TABLE `sewa` (
  `id` int(11) NOT NULL,
  `id_pemesanan` int(25) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `lama_sewa_start` date DEFAULT NULL,
  `lama_sewa_end` date DEFAULT NULL,
  `total_harga` int(11) NOT NULL,
  `idPesanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sewa`
--

INSERT INTO `sewa` (`id`, `id_pemesanan`, `idUser`, `idBarang`, `nama_barang`, `jumlah`, `lama_sewa_start`, `lama_sewa_end`, `total_harga`, `idPesanan`) VALUES
(16, 0, 29, 3, 'Kompor Besar', 5, '2023-08-12', '2023-08-15', 30000, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `no_hp` int(12) NOT NULL,
  `jns_klmn` varchar(12) NOT NULL,
  `tgl` date DEFAULT NULL,
  `alamat` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `kode` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `nama`, `username`, `password`, `no_hp`, `jns_klmn`, `tgl`, `alamat`, `role`, `kode`) VALUES
(25, 'user@gmail.com', 'user', 'user', '$2y$10$77oOnJsK5kGqGyQ.4RCfweXQ195roeiiEjmBNkmcL0ZRB/L/w6xEK', 2147483647, 'Laki-laki', '2023-07-01', 'user', 2, NULL),
(26, 'admin@gmail.com', 'admin', 'admin', '$2y$10$3otNx9rtgeTs2nNAy6wk9.kwM9lGMthYd/POjA0c8cZMRmrOm04lO', 2147483647, 'Laki-laki', '2023-07-02', 'admin', 1, NULL),
(27, 'owner@gmail.com', 'owner', 'owner', '$2y$10$MK7NauyoU5iIrC4xSn3VW.SKWpm3OSLw5q1zCN5JKKI/Kg2ARlCmm', 2147483647, 'Laki-laki', '2023-07-03', 'owner', 3, NULL),
(29, 'dhikisidik26@gmail.com', 'dhiki sidik', 'dhiki', '$2y$10$ut5nt61gRU/RNpODw8hcZ.xL423xiknpEpkkkzSzEbtPauu7sSLSK', 2147483647, 'Laki-laki', '2010-06-16', 'Surabaya', 2, 549589);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKategori` (`idKategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idBarang` (`idBarang`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idPesanan`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idBarang` (`idBarang`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idPesanan` (`idPesanan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idPesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idKategori`) REFERENCES `kategori` (`id`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`idBarang`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `sewa`
--
ALTER TABLE `sewa`
  ADD CONSTRAINT `sewa_ibfk_1` FOREIGN KEY (`idBarang`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `sewa_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
