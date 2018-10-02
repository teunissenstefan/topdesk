-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2018 at 11:18 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `acties`
--

CREATE TABLE `acties` (
  `id` int(11) NOT NULL,
  `incident_id` varchar(20) NOT NULL,
  `behandelaar_id` varchar(15) NOT NULL,
  `actie` text NOT NULL,
  `datum_aangemaakt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` varchar(15) NOT NULL,
  `gebruikersnaam` varchar(255) NOT NULL,
  `voornaam` varchar(64) NOT NULL,
  `achternaam` varchar(64) NOT NULL,
  `wachtwoord` char(64) NOT NULL,
  `salt` char(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefoonnummer` varchar(25) NOT NULL,
  `groep` int(10) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `voornaam`, `achternaam`, `wachtwoord`, `salt`, `email`, `telefoonnummer`, `groep`, `active`) VALUES
('3yvgplts448l', 'admin', 'Admin', 'Man', '46fb2fc87efabf52bb749c2e2c555e8cdf5a595d1ca0316c80e8f9fe0e1d78b7', '41328b345f8ac2f2', 'admin@admin.nl', '0622939021', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers_groepen`
--

CREATE TABLE `gebruikers_groepen` (
  `id` int(10) NOT NULL,
  `groep` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gebruikers_groepen`
--

INSERT INTO `gebruikers_groepen` (`id`, `groep`) VALUES
(1, 'Gebruikers'),
(2, 'ICT'),
(3, 'Facilitair');

-- --------------------------------------------------------

--
-- Table structure for table `hardware`
--

CREATE TABLE `hardware` (
  `id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hardware`
--

INSERT INTO `hardware` (`id`) VALUES
('LAP0001'),
('LAP0002'),
('MON0001'),
('MON0002'),
('PC0001'),
('PC0002');

-- --------------------------------------------------------

--
-- Table structure for table `incidenten`
--

CREATE TABLE `incidenten` (
  `id` varchar(20) NOT NULL,
  `melder` varchar(15) NOT NULL,
  `melding` text NOT NULL,
  `aangemaaktdoor` varchar(15) NOT NULL,
  `behandelaar` varchar(15) DEFAULT NULL,
  `prioriteit` varchar(50) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `gesloten` tinyint(1) NOT NULL DEFAULT '0',
  `hardware` varchar(10) NOT NULL,
  `software` varchar(255) NOT NULL,
  `datum_aangemaakt` datetime NOT NULL,
  `datum_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incidenten_status`
--

CREATE TABLE `incidenten_status` (
  `id` int(10) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incidenten_status`
--

INSERT INTO `incidenten_status` (`id`, `status`) VALUES
(1, 'Wachten op reactie melder'),
(2, 'Afgehandeld'),
(3, 'Wachten op levering'),
(4, 'In behandeling');

-- --------------------------------------------------------

--
-- Table structure for table `prioriteiten`
--

CREATE TABLE `prioriteiten` (
  `id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prioriteiten`
--

INSERT INTO `prioriteiten` (`id`) VALUES
('Prioriteit 1'),
('Prioriteit 2'),
('Prioriteit 3'),
('Prioriteit 4'),
('Prioriteit 5');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`id`) VALUES
('Adobe Illustrator'),
('Adobe Photoshop'),
('Microsoft Office 2010'),
('Microsoft Office 2013'),
('Microsoft Powerpoint'),
('Microsoft Word'),
('Windows 10'),
('Windows 7'),
('Windows 8'),
('Windows Vista');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acties`
--
ALTER TABLE `acties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gebruikers_groepen`
--
ALTER TABLE `gebruikers_groepen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incidenten`
--
ALTER TABLE `incidenten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incidenten_status`
--
ALTER TABLE `incidenten_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prioriteiten`
--
ALTER TABLE `prioriteiten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acties`
--
ALTER TABLE `acties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `gebruikers_groepen`
--
ALTER TABLE `gebruikers_groepen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `incidenten_status`
--
ALTER TABLE `incidenten_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;