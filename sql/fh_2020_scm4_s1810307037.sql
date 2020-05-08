-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Mai 2020 um 18:28
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.2
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

/* Drop Database and User */
DROP DATABASE IF EXISTS fh_2020_scm4_S1810307037; 
DROP USER IF EXISTS 'fh_2020_scm4'@'localhost'; 
COMMIT; 

/* Create Database and User */
CREATE DATABASE IF NOT EXISTS fh_2020_scm4_S1810307037 CHARACTER SET utf8; 
COMMIT; 
CREATE USER IF NOT EXISTS 'fh_2020_scm4'@'localhost' IDENTIFIED BY 'fh_2020_scm4'; 
COMMIT; 


/* privileges */
/*GRANT ALL PRIVILEGES ON fh_2020_scm4_S1810307037 . * TO 'fh_2020_scm4'@'localhost'; */
GRANT ALL PRIVILEGES ON fh_2020_scm4_S1810307037.* TO 'fh_2020_scm4'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES; 
COMMIT; 

--
-- Datenbank: `fh_2020_scm4_s1810307037`
--
-- --------------------------------------------------------
USE fh_2020_scm4_S1810307037;

--
-- Tabellenstruktur für Tabelle `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `shoppingListId` int(11) DEFAULT NULL,
  `description` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL CHECK (`amount` > 0),
  `highestPrice` decimal(6,2) NOT NULL CHECK (`highestPrice` > 0.0),
  `deletedFlag` tinyint(1) NOT NULL,
  `doneFlag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` enum('admin', 'helpSeeker' ,'helper') NOT NULL,
  `bitCode` bit(7) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shoppinglist`
--

CREATE TABLE `shoppinglist` (
  `id` int(11) NOT NULL,
  `ownerId` int(11) DEFAULT NULL,
  `helperId` int(11) DEFAULT NULL,
  `endDate` date NOT NULL,
  `paidPrice` decimal(6,2) NOT NULL,
  `state` enum('not published', 'new', 'processing', 'done' ) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `userName` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`), 
  ADD KEY `name` (`shoppingListId`); 

--
-- Indizes für die Tabelle `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`), 
  ADD KEY `bitCode` (`bitCode`); 

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shoppingList`
--
ALTER TABLE `shoppinglist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerId` (`ownerId`), 
  ADD KEY `helperId` (`helperId`); 


-- 
-- Referenziere Fremdschlüssel
--
ALTER TABLE `article`
  ADD CONSTRAINT article_shoppinglist_FK1 FOREIGN KEY (shoppingListId) REFERENCES shoppinglist (id) ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `shoppinglist`
  ADD CONSTRAINT shoppinglist_user_FK1 FOREIGN KEY (ownerId) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE, 
  ADD CONSTRAINT shoppinglist_user_FK2 FOREIGN KEY (helperId) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE; 

--
-- AUTO_INCREMENT für exportierte Tabellen
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
