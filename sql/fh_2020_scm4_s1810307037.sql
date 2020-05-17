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

/* Drop Database */
DROP DATABASE IF EXISTS fh_2020_scm4_S1810307037; 
COMMIT; 

/* Create Database */
CREATE DATABASE IF NOT EXISTS fh_2020_scm4_S1810307037 CHARACTER SET utf8; 
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


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` enum('admin','helpSeeker','helper') NOT NULL,
  `bitCode` bit(7) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- MOCKDATA role table
--
insert into role (id, name, bitCode, deletedFlag) values (1, 'admin', 1111111, false);
insert into role (id, name, bitCode, deletedFlag) values (2, 'helpSeeker', 0000001, false);
insert into role (id, name, bitCode, deletedFlag) values (3, 'helper', 0000002, false);


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `userName` varchar(25) NOT NULL,
  `passwordHash` varchar(250) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- MOCKDATA user table
--
insert into user (id, firstName, lastName, userName, passwordHash, deletedFlag) VALUES (1, 'Gerald', 'Riess', 'Hilfesuchender', '2216d6cdd869e0cbdd4a51f74e17e1ba7150db5f', false);
insert into user (id, firstName, lastName, userName, passwordHash, deletedFlag) VALUES (2, 'Manuel', 'Strasser', 'Freiwilliger', '4b35ad500817192730ce10a1335b469372cd92fd', false);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shoppinglist`
--

CREATE TABLE `shoppinglist` (
  `id` int(11) NOT NULL,
  `ownerId` int(11) DEFAULT NULL,
  `helperId` int(11) DEFAULT NULL,
  `endDate` date NOT NULL,
  `paidPrice` decimal(6,2),
  `state` enum('not published','new','processing','done') NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- MOCKDATA shopping list table
--
insert into shoppinglist (id, ownerId, helperId, endDate, paidPrice, state, name) values (1, 1, NULL, '2/3/2020', 46.55, 'not published', 'Cookley');
insert into shoppinglist (id, ownerId, helperId, endDate, paidPrice, state, name) values (2, 1, NULL, '1/3/2020', 38.67, 'new', 'Sub-Ex');
insert into shoppinglist (id, ownerId, helperId, endDate, paidPrice, state, name) values (3, 1, 2, '2/13/2020', 23.87, 'processing', 'Stringtough');
insert into shoppinglist (id, ownerId, helperId, endDate, paidPrice, state, name) values (4, 1, 2, '1/29/2020', 55.35, 'done', 'Job');

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

--
-- MOCKDATA article table
--
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (1, 1, 'Nut - Pumpkin Seeds', 1, 33.3, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (2, 1, 'Pork - Tenderloin, Frozen', 2, 18.2, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (3, 1, 'Shrimp - 16 - 20 Cooked, Peeled', 3, 3.4, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (4, 1, 'Yogurt - French Vanilla', 4, 35.5, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (5, 2, 'Wine - White, Chardonnay', 5, 33.52, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (6, 2, 'Cranberries - Fresh', 6, 24.23, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (7, 2, 'Potatoes - Fingerling 4 Oz', 7, 89.12, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (8, 2, 'Pepper - Sorrano', 8, 97.65, false, false);
/*
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (9, 3, 'Scampi Tail', 9, 57.11, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (10, 3, 'Coriander', 10, 89.23, false, false);
insert into article (id, shoppingListId, description, amount, highestPrice, deletedFlag, doneFlag) VALUES (11, 3, 'Cheese', 11, 38.78, false, false);
*/

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
-- Indizes für die Tabelle `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerId` (`ownerId`),
  ADD KEY `helperId` (`helperId`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `shoppinglist`
--
ALTER TABLE `shoppinglist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_shoppingList_FK1` FOREIGN KEY (`shoppingListId`) REFERENCES `shoppinglist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD CONSTRAINT `shoppingList_user_FK1` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shoppingList_user_FK2` FOREIGN KEY (`helperId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
