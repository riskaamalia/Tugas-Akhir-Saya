-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08 Mei 2015 pada 13.40
-- Versi Server: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `halaman_web`
--

CREATE TABLE IF NOT EXISTS `halaman_web` (
  `ID_URL` int(11) NOT NULL,
  PRIMARY KEY (`ID_URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lsa_halaman_web`
--

CREATE TABLE IF NOT EXISTS `lsa_halaman_web` (
  `ID_URL_1` int(11) NOT NULL,
  `ID_URL_2` int(11) NOT NULL,
  `VALUE` float DEFAULT NULL,
  PRIMARY KEY (`ID_URL_1`,`ID_URL_2`),
  KEY `FK_LSA_HALAMAN_WEB4` (`ID_URL_2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lsa_pdf`
--

CREATE TABLE IF NOT EXISTS `lsa_pdf` (
  `ID_URL_1` int(11) NOT NULL,
  `ID_URL_2` int(11) NOT NULL,
  `VALUE` float DEFAULT NULL,
  PRIMARY KEY (`ID_URL_1`,`ID_URL_2`),
  KEY `FK_LSA_PDF4` (`ID_URL_2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pdf`
--

CREATE TABLE IF NOT EXISTS `pdf` (
  `ID_URL` int(11) NOT NULL,
  `ABSTRAKSI` text,
  PRIMARY KEY (`ID_URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembobotan_pdf`
--

CREATE TABLE IF NOT EXISTS `pembobotan_pdf` (
  `ID_URL` int(11) NOT NULL,
  `ID_TERM` int(11) NOT NULL,
  `FREKUENSI` int(11) DEFAULT NULL,
  `BOBOT` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_URL`,`ID_TERM`),
  KEY `FK_FREKUENSI_TERM_PDF4` (`ID_TERM`),
  KEY `frekuensi_term_web_index_1` (`ID_URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembobotan_web`
--

CREATE TABLE IF NOT EXISTS `pembobotan_web` (
  `ID_URL` int(11) NOT NULL,
  `ID_TERM` int(11) NOT NULL,
  `FREKUENSI` int(11) DEFAULT NULL,
  `BOBOT` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_URL`,`ID_TERM`),
  KEY `FK_FREKUENSI_TERM_WEB4` (`ID_TERM`),
  KEY `frekuensi_term_web_index_1` (`ID_URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `term`
--

CREATE TABLE IF NOT EXISTS `term` (
  `ID_TERM` int(11) NOT NULL,
  `TERM` varchar(63) DEFAULT NULL,
  `PREVIX_TERM` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`ID_TERM`),
  KEY `term_index` (`PREVIX_TERM`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `url`
--

CREATE TABLE IF NOT EXISTS `url` (
  `ID_URL` int(11) NOT NULL,
  `URL` varchar(1024) DEFAULT NULL,
  `DOMAIN` varchar(63) DEFAULT NULL,
  `STATUS_KUNJUNGAN` tinyint(1) DEFAULT NULL,
  `LAST_MAINTENANCE` date DEFAULT NULL,
  `STATUS_EKSTRAKSI` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID_URL`),
  KEY `url_index` (`DOMAIN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
