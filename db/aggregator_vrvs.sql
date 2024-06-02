-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2024 at 03:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aggregator_vrvs`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama`) VALUES
(1, 'Furnitur'),
(2, 'Peralatan Rumah'),
(3, 'Makanan & Minuman'),
(4, 'Fashion'),
(5, 'Elektronik'),
(6, 'Mainan'),
(7, 'Alat Belajar'),
(8, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pelanggan`
--

CREATE TABLE `tbl_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telepon` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `foto_profil` varchar(355) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`id_pelanggan`, `nama`, `email`, `password`, `no_telepon`, `alamat`, `kota`, `foto_profil`) VALUES
(1, 'Sang Rajaa', 'sangraja@gmail.com', '$2y$10$dkO5109mNd06nO37B0ftJe2DNXZ4aPQMYcbWE7WtM/80pwyywS7dW', '81200005555', 'Anjun, Telukjambe Barat, Karawang Barat, Bekasi', 'Bekasi', '20240201102246-Photo Profile.jpg'),
(11, 'Rakha Fadhilah', 'muhammad.rakha.fadhilah@gmail.com', '$2y$10$fhW9XuUkxI96EAQ0GaVrRO.d6JZFVtYqR0AzhX1myhHvpXC6uJwxC', '85711481324', 'Dusun Tengah 1, RT03/RW01, Desa Telukbango, Kecamatan Batujaya', 'Karawang', ''),
(12, 'M Rakha', 'mielloart@gmail.com', '$2y$10$2UwlbN1nuHm4Z1r6BeW/3.IGP5qp1oNQwLZFJM5afbFDGMBq36l5y', '85882810644', 'Rumah Bidan Iin, Dusun Tengah I, RT03/RW01, Desa Telukbango, Kecamatan Batujaya, Kabupaten Karawang, Jawa Barat, 41354', 'Karawang', ''),
(13, 'Hanif', 'user123@gmail.com', '$2y$10$2vIqhOh8YktPO5LYRqr4W.ZN4A5Ac7cb0XMFnULYrcxA62KDGc2sS', '0895333530959', 'Kosambi', 'Karawang', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pemesanan`
--

CREATE TABLE `tbl_pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tipe_pelanggan` varchar(7) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `waktu_pemesanan` datetime NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pemesanan`
--

INSERT INTO `tbl_pemesanan` (`id_pemesanan`, `id_pelanggan`, `tipe_pelanggan`, `id_produk`, `jumlah`, `waktu_pemesanan`, `total_harga`, `status`) VALUES
(1, 2, 'Penjual', 2, 1, '2024-01-28 12:13:12', 32000000.00, 'Keranjang'),
(2, 2, 'Penjual', 1, 1, '2024-01-28 11:20:27', 32000000.00, 'Keranjang'),
(3, 2, 'Penjual', 3, 1, '2024-02-01 10:31:16', 300000.00, 'Keranjang'),
(4, 2, 'Penjual', 3, 1, '2024-02-01 10:32:18', 300000.00, 'Keranjang'),
(5, 11, 'User', 4, 1, '2024-02-01 02:33:09', 125000.00, 'Keranjang'),
(6, 11, 'User', 2, 3, '2024-02-01 02:33:35', 21750000.00, 'Keranjang'),
(7, 11, 'User', 6, 3, '2024-02-01 04:08:36', 96000000.00, 'Keranjang'),
(8, 2, 'Penjual', 4, 3, '2024-02-01 04:30:22', 900000.00, 'Diterima'),
(9, 5, 'Penjual', 9, 2, '2024-02-05 01:46:26', 4700000.00, 'Keranjang'),
(10, 11, 'User', 9, 1, '2024-02-05 05:28:03', 2350000.00, 'Dibayar'),
(11, 11, 'User', 6, 1, '2024-02-05 11:40:05', 32000000.00, 'Diterima'),
(12, 11, 'User', 1, 2, '2024-02-06 08:44:53', 5000000.00, 'Keranjang'),
(13, 2, 'Penjual', 10, 1, '2024-02-06 11:41:09', 30000000.00, 'Keranjang'),
(14, 2, 'Penjual', 13, 3, '2024-02-09 09:00:01', 90000.00, 'Keranjang'),
(15, 2, 'Penjual', 12, 1, '2024-02-16 12:00:44', 82500000.00, 'Keranjang'),
(16, 2, 'Penjual', 12, 1, '2024-02-16 12:01:19', 82500000.00, 'Keranjang'),
(17, 5, 'Penjual', 3, 1, '2024-02-17 09:12:12', 300000.00, 'Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penjual`
--

CREATE TABLE `tbl_penjual` (
  `id_penjual` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telepon` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `deskripsi_penjual` text NOT NULL,
  `foto_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_penjual`
--

INSERT INTO `tbl_penjual` (`id_penjual`, `nama`, `email`, `password`, `no_telepon`, `alamat`, `kota`, `deskripsi_penjual`, `foto_profil`) VALUES
(1, 'Fajar', 'fajar@gmail.com', 'fajar123', '89374626727', 'DUSUN TENGAH 1, RT03/RW01, DESA TELUKBANGO, KECAMATAN BATUJAYA, KABUPATEN KARAWANG', 'Karawang', 'Menjual peralatan rumah tangga. Berkualitas, terpercaya, dan juga murah meriah, itulah yang menjadi ciri khas toko kami.', ''),
(2, 'Mukhlis', 'amindama@gmail.com', '$2y$10$4gBYJs5GNUS3tbF/xQaRWe0e5wz/vFHjEp0f4POfBD.7LUPTlR9Vu', '85711481324', 'DUSUN TENGAH 1, RT03/RW01, DESA TELUKBANGO, KECAMATAN BATUJAYA', 'Karawang', '                                                                                                                                                                        Menjual apa saja, random hehe. Berkualitas, terpercaya, dan juga murah meriah, itulah yang menjadi ciri khas toko kami.                                                                                                                                                ', '20240206054025-Me1.jpg'),
(5, 'Bapak Ahmad', 'ahmad@gmail.com', '$2y$10$aweLpYHwhm3el/FBBXZVGujBLLjVhQ64Y4hYVc/hKku79ToV6fWrm', '872880008800', 'Dusun Tengah 1, Desa Telukbango, Kecamatan Batujaya', 'Karawang', 'Menjual beberapa furnitur bambu rotan.', ''),
(6, 'Suhaemin', 'suhaemin@gmail.com', '$2y$10$SmoUNX9l9PY4AuuBxehlKOrHDR69B6tjoD7qy5R1FM7TMtinjW9F.', '08129382398', 'Kampung Wetan, Desa Ambyar, Kecamatan Jayakerta', 'Karawang', '                                                    ', ''),
(7, 'fajar', 'mfajarramadhan04@gmail.com', '$2y$10$p/ZIIQIhs0XbnvQP/LOpj.52bXg/qsrhos29yMOZXSSUDOP62DnG.', '0895333530959', 'Karawang', 'Karawang', '', ''),
(8, 'fajar', 'fajar123@gmail.com', '$2y$10$Bx0HQA3s5OCkKphY88g86u3/Bu7IXAPDxYumvKnm2ZLsBUAeZ604C', '0895333530959', 'Karawang', 'Karawang', 'Menjual segala jenis furniture bambu rotan ', '20240602032506-horizon-logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `visual` varchar(255) NOT NULL,
  `format_visual` varchar(5) NOT NULL,
  `rating` decimal(3,2) NOT NULL,
  `jenis_produk` int(11) NOT NULL,
  `kondisi` varchar(10) NOT NULL,
  `berat` decimal(10,0) NOT NULL,
  `cacat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `id_penjual`, `nama`, `deskripsi`, `harga`, `stok`, `visual`, `format_visual`, `rating`, `jenis_produk`, `kondisi`, `berat`, `cacat`) VALUES
(1, 2, 'Gazebo Pak Muhsin - Bambu Hitam', 'Gazebo berbahan bambu hitam, dengan khas buatan tangan Desa Parungsari, Bpk Muhsin. Gazebo ini memiliki ketahanan yang kuat dan memiliki keawetan yang cukup baik.', 2500000.00, 5, '20240128042623-WhatsApp Image 2023-11-15 at 17.24.13 (2).jpeg', 'img', 0.00, 1, 'Baru', 12, 'Ada di bagian bokongnya. Terlalu hitam. Sangat tidak bagus untuk dipandang'),
(2, 2, 'Gazebo Bambu Rotan Parungsari - Pak Muhsin', 'Berbahan bambu Parungsari, dan dibuat dalam corak khas Desa Parungsari. Gazebo ini sudah pernah dijual ekspor ke beberapa Negara Asia Tenggara. Malaysia, Vietnam, Filipina, dll.', 7250000.00, 1, '20240128044017-WhatsApp Image 2023-11-15 at 17.24.15.jpeg', 'img', 0.00, 1, 'Baru', 50, ''),
(3, 2, 'Meja Bambu Parungsari - Pak Muhsin', 'Meja ukuran 2x2m berbahan bambu, asal Desa Parungsari, ciptaan tangan pak Muhsin. Memiliki ketahanan yang kuat dan corak khas, meja ini bisa diandalkan dari kualitasnya.', 300000.00, 10, '20240128044339-furnitur.glb', '3d', 3.50, 1, 'Baru', 8, ''),
(4, 2, 'Kursi Bambu Parungsari', '', 125000.00, 1, '20240215170833-WhatsApp Image 2023-11-15 at 17.24.14 (2).jpeg', 'img', 3.92, 1, 'Baru', 8, ''),
(6, 2, 'Gazebo Kayu Desa Parungsari - Pak Muhsin', 'Gazebo kayu asal Desa Parungsari. Dibuat oleh tangan pak Muhsin, dengan gaya khas Parungsari. Gazebo ini memiliki ketahanan dan keawetan yang maksimal, karena bahannya yang selektif.', 32000000.00, 1, '20240128053812-gazebo.glb', '3d', 0.00, 1, 'Baru', 54, ''),
(7, 2, 'Meja Bambu Desa Parungsari (Satuan)', 'Meja bambu motif batik khas kearifan lokal asal Desa Parungsari, dibuat oleh tangan pak Muhsin. Meja ini memiliki ketahanan yang kuat, karena resource bahan yang selektif.', 220000.00, 20, '20240128054352-Meja.glb', '3d', 0.00, 1, 'Baru', 0, ''),
(9, 2, 'Gazebo Taman Bahan Kayu (Asal Parungsari)', 'Gazebo kayu asal Parungsari. Cocok untuk lingkungan-lingkungan taman.', 2350000.00, 20, '20240128083657-Gazebo Taman.glb', '3d', 0.00, 1, 'Baru', 50, ''),
(10, 2, 'Desain Vila Kayu Ukuran Besar - Bambu Motif Batik', 'Berbahan bambu dan bermotif batik, asal Desa Parungsari. Memiliki corak yang khas dan sangat awet.', 30000000.00, 1, '20240128084021-WhatsApp Image 2023-11-15 at 17.24.14.jpeg', 'img', 0.00, 1, 'Baru', 120, ''),
(11, 2, 'Kursi Panjang Bambu Hitam Motif Batik', 'Kursi set panjang bahan bambu, cocok untuk rebahan. Hanya motif dasar. Silakan pesan khusus jika ingin motif batik. Selalu ready buka senin sampai sabtu untuk pemesanan khusus', 480000.00, 20, '20240221022946-Meja Set Panjang.glb', '3d', 0.00, 1, 'Bekas', 10, ''),
(12, 6, 'Gazebo Bambu Kuning Batik', 'Gazebo bambu kuning corak batik khas kearifan lokal Parungsari, memiliki keawetan yang maksimal dan kualitas yang terjamin. Gazebo jenis ini sudah pernah dijual beberapa kali di ekspor.', 82500000.00, 2, '20240206025027-WhatsApp Image 2023-11-15 at 17.24.13 (15).jpeg', 'img', 0.00, 1, 'Baru', 40, ''),
(13, 2, 'Produk Tes', 'tes deskripsi', 30000.00, 4, '20240206053916-WhatsApp Image 2023-11-15 at 17.24.13 (17).jpeg', 'img', 0.00, 1, 'Bekas', 0, ''),
(16, 2, 'Meja Set Kecil - Tanpa Motif', 'Meja set kecil berbahan bambu hitam, bisa bongkar pasang untuk hemat pengiriman. Hanya motif dasar. Untuk meja dengan motif, bisa menggunakan pesanan khusus.', 210000.00, 10, '20240220181344-Furniture - Laporan 3.glb', '3d', 0.00, 1, 'Baru', 6, ''),
(17, 8, 'Meja Belajar', 'Meja Belajar berkualitas dengan harga yang pas!', 3000000.00, 2, '20240602032306-meja-belajar.jpg', 'img', 0.00, 1, 'Baru', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ulasan`
--

CREATE TABLE `tbl_ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `tipe_pembeli` varchar(8) NOT NULL,
  `ulasan` varchar(350) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ulasan`
--

INSERT INTO `tbl_ulasan` (`id_ulasan`, `id_produk`, `id_pembeli`, `tipe_pembeli`, `ulasan`, `rating`) VALUES
(1, 3, 1, 'User', 'Mantappp, packing rapi, dan bahan kuat. Suka banget', 4),
(2, 3, 1, 'User', 'Bagus, barang sesuai preview. Terimakasih pak Muhsin', 3),
(3, 3, 1, 'User', 'Sangat sesuai dengan pesanan. Bagus', 5),
(4, 3, 1, 'User', 'Pengirimannya agak lambat ya, saya nunggu lama', 1),
(5, 3, 1, 'User', 'Baguss barangnya sesuai pesanan. Makasih pak Muhsin', 4),
(6, 11, 2, 'Penjual', 'Bagusss sempurna. Saya kasih bintang 5 yaak!', 5),
(7, 11, 2, 'Penjual', 'Saya kasiih agak kurang ya. Soalnya pengirimannya terlalu lama, dan packing nya kurang rapi. Saya disini harus nyusun komponen furniturnya dulu dan itu agak ribet.', 2),
(8, 11, 2, 'Penjual', 'Bagus bagus, mantappp', 3),
(9, 11, 2, 'Penjual', 'Mantaaappp', 3),
(10, 11, 2, 'Penjual', 'Bagus', 4),
(11, 11, 2, 'Penjual', 'Bintang lima buat produk iniii !!! Josss 👍', 5),
(12, 11, 2, 'Penjual', 'Mantaaappp', 5),
(13, 11, 2, 'Penjual', '', 4),
(14, 3, 5, 'Penjual', 'Bagusss', 4),
(15, 11, 2, 'Penjual', '', 2),
(16, 11, 2, 'Penjual', '', 5),
(17, 11, 2, 'Penjual', '', 5),
(18, 11, 2, 'Penjual', 'Kerennnn', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tbl_pemesanan`
--
ALTER TABLE `tbl_pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tbl_penjual`
--
ALTER TABLE `tbl_penjual`
  ADD PRIMARY KEY (`id_penjual`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indexes for table `tbl_ulasan`
--
ALTER TABLE `tbl_ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_penjual` (`id_pembeli`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_pemesanan`
--
ALTER TABLE `tbl_pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_penjual`
--
ALTER TABLE `tbl_penjual`
  MODIFY `id_penjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_ulasan`
--
ALTER TABLE `tbl_ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pemesanan`
--
ALTER TABLE `tbl_pemesanan`
  ADD CONSTRAINT `tbl_pemesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id_produk`);

--
-- Constraints for table `tbl_ulasan`
--
ALTER TABLE `tbl_ulasan`
  ADD CONSTRAINT `tbl_ulasan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
