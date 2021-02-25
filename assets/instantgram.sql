-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2019 at 02:08 AM
-- Server version: 5.7.22
-- PHP Version: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instantgram`
--

-- --------------------------------------------------------

--
-- Table structure for table `balasan_komen`
--

CREATE TABLE `balasan_komen` (
  `idbalasan_komen` int(11) NOT NULL,
  `idposting` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `isi_komen` varchar(200) DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `balasan_komen`
--

INSERT INTO `balasan_komen` (`idbalasan_komen`, `idposting`, `username`, `isi_komen`, `tanggal`) VALUES
(1, 5, 'vari8', 'Wah bagus', '2019-05-17 01:36:12'),
(8, 5, 'vincent', 'wkwkwk', '2019-05-19 07:53:08'),
(19, 7, 'chrisjo', 'mantabb', '2019-05-19 12:40:00'),
(20, 9, 'chrisjo', 'Sungguh menakjubkan', '2019-05-20 09:32:53'),
(21, 9, 'chrisjo', 'Kapan ya aku bisa melihat bumi secara langsung seperti ini hmm... :(', '2019-05-20 09:33:46'),
(22, 9, 'vincent', 'OMG!', '2019-05-20 09:34:42'),
(23, 10, 'vari8', 'Mantab', '2019-05-22 02:54:32'),
(24, 5, 'vari8', 'keren bro fotonya', '2019-05-22 02:54:53'),
(25, 10, 'chrisjo', 'wowowow', '2019-05-22 02:55:54'),
(26, 10, 'jason', 'I <3 Ubaya', '2019-05-26 05:42:31'),
(27, 12, 'jeremy', 'mana muka mu?', '2019-05-27 00:12:48'),
(28, 10, 'jeremy', 'muantul', '2019-05-27 00:13:09'),
(29, 10, 'vari8', 'bebas', '2019-05-27 00:35:29'),
(30, 7, 'vari8', 'mantabs', '2019-05-27 00:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `idgambar` int(11) NOT NULL,
  `idposting` int(11) NOT NULL,
  `extention` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`idgambar`, `idposting`, `extention`) VALUES
(8, 4, 'jpg'),
(9, 4, 'jpg'),
(10, 4, 'jpg'),
(11, 5, 'jpg'),
(12, 5, 'jpg'),
(13, 5, 'jpg'),
(14, 5, 'jpg'),
(15, 6, 'jpg'),
(16, 6, 'jpg'),
(17, 7, 'jpg'),
(18, 7, 'jpg'),
(19, 7, 'jpg'),
(20, 7, 'jpg'),
(21, 7, 'jpg'),
(22, 7, 'jpeg'),
(23, 7, 'jpg'),
(24, 7, 'jpg'),
(29, 9, 'jpg'),
(30, 10, 'jpeg'),
(31, 10, 'jpg'),
(32, 11, 'jpg'),
(33, 11, 'jpg'),
(34, 11, 'jpeg'),
(35, 12, 'jpeg'),
(36, 13, 'jpg'),
(37, 13, 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jempol_like`
--

CREATE TABLE `jempol_like` (
  `idposting` int(11) NOT NULL,
  `username` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jempol_like`
--

INSERT INTO `jempol_like` (`idposting`, `username`) VALUES
(5, 'chrisjo'),
(5, 'vari8'),
(5, 'vincent'),
(6, 'vincent'),
(7, 'chrisjo'),
(7, 'vari8'),
(7, 'vincent'),
(9, 'chrisjo'),
(9, 'vincent'),
(10, 'chrisjo'),
(10, 'jason'),
(10, 'jeremy'),
(11, 'jason');

-- --------------------------------------------------------

--
-- Table structure for table `posting`
--

CREATE TABLE `posting` (
  `idposting` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `komen` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posting`
--

INSERT INTO `posting` (`idposting`, `username`, `tanggal`, `komen`) VALUES
(4, 'vari8', '2019-05-02 17:00:00', 'My first post :D'),
(5, 'chrisjo', '2019-05-16 17:00:00', 'horeee'),
(6, 'chrisjo', '2019-05-16 22:25:33', 'Lagi heppy :D'),
(7, 'chrisjo', '2019-05-18 18:42:38', 'I Love UBAYA'),
(9, 'vari8', '2019-05-19 19:26:43', 'Bumi Itu Indah'),
(10, 'vari8', '2019-05-21 00:54:22', 'My Post :)'),
(11, 'jason', '2019-05-25 03:43:21', 'Makan terus! hehe'),
(12, 'jeremy', '2019-05-25 22:12:35', 'Anonymous'),
(13, 'vari8', '2019-05-25 22:35:55', 'bebas');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(40) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `salt` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `nama`, `password`, `salt`) VALUES
('chrisjo', 'Chris Jo', 'eee43247b4782a5ced8d380d6e4cffd2', 'a945621f71a3bcbfd80f1effbc1426fd'),
('elsa', 'elsa', 'b2bbb9d87a6992fdc6c660d0bf799c50', 'd05a2fa43ddad33510ecd539d0c71eb5'),
('jason', 'Jason Sitompul', '7a8b908a8004d0bb399b720dac02bd23', 'd5a8c4613c4e968bb4bcf55283e81a3d'),
('jeremy', 'Jeremy Okky', 'fe716dd258081c63eb74a0e4039f3ef7', '3e721d6dd8530f98a5cf43693079b2ed'),
('vari8', 'vari', 'a58c2a2b07192bcf4387d173dbc7a80b', '2d0845a5631beec0c5b068dbdd958ace'),
('vincent', 'vincent', '4bd936733c3d4cd81b58cf0c80be6ae7', 'a97a82270d7e11e408cd343618b08fc5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balasan_komen`
--
ALTER TABLE `balasan_komen`
  ADD PRIMARY KEY (`idbalasan_komen`),
  ADD KEY `fk_balasan_komen_posting1_idx` (`idposting`),
  ADD KEY `fk_balasan_komen_user1_idx` (`username`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`idgambar`),
  ADD KEY `fk_gambar_posting1_idx` (`idposting`);

--
-- Indexes for table `jempol_like`
--
ALTER TABLE `jempol_like`
  ADD PRIMARY KEY (`idposting`,`username`),
  ADD KEY `fk_user_has_posting_posting1_idx` (`idposting`),
  ADD KEY `fk_user_has_posting_user1_idx` (`username`);

--
-- Indexes for table `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`idposting`),
  ADD KEY `fk_posting_user_idx` (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balasan_komen`
--
ALTER TABLE `balasan_komen`
  MODIFY `idbalasan_komen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `idgambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `posting`
--
ALTER TABLE `posting`
  MODIFY `idposting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balasan_komen`
--
ALTER TABLE `balasan_komen`
  ADD CONSTRAINT `fk_balasan_komen_posting1` FOREIGN KEY (`idposting`) REFERENCES `posting` (`idposting`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_balasan_komen_user1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gambar`
--
ALTER TABLE `gambar`
  ADD CONSTRAINT `fk_gambar_posting1` FOREIGN KEY (`idposting`) REFERENCES `posting` (`idposting`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jempol_like`
--
ALTER TABLE `jempol_like`
  ADD CONSTRAINT `fk_user_has_posting_posting1` FOREIGN KEY (`idposting`) REFERENCES `posting` (`idposting`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_has_posting_user1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posting`
--
ALTER TABLE `posting`
  ADD CONSTRAINT `fk_posting_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
