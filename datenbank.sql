-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Mai 2015 um 22:54
-- Server Version: 5.6.20
-- PHP-Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `leviathalis`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buildOrders`
--

CREATE TABLE IF NOT EXISTS `buildOrders` (
`id` int(10) unsigned NOT NULL,
  `villageId` int(11) NOT NULL,
  `building` text CHARACTER SET utf8 NOT NULL,
  `time` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `recruitOrders`
--

CREATE TABLE IF NOT EXISTS `recruitOrders` (
`id` int(10) unsigned NOT NULL,
  `villageId` int(11) NOT NULL,
  `unit` text CHARACTER SET utf8 NOT NULL,
  `beginTime` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `totalAmount` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `creationDate`) VALUES
(90, 'marcel', 'asda@asd.de', '$2y$10$uT781VjAbONUIkbTQVtJCeiOubMtxFvTj51OCDFSTTIT/8exFhP4S', '2014-11-29 20:34:07'),
(91, 'doris', 'peter@sili.e', '$2y$10$RNrmbuB9boudhB9Uri6mXeDYtw7XwjWDcS1YRAWvZq4vbavL60y8q', '2015-05-10 17:55:52');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `villages`
--

CREATE TABLE IF NOT EXISTS `villages` (
`id` int(10) unsigned NOT NULL,
  `user` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `points` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `holz` int(11) NOT NULL,
  `stein` int(11) NOT NULL,
  `eisen` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '1',
  `barracks` int(11) NOT NULL,
  `smith` int(11) NOT NULL,
  `church` int(11) NOT NULL,
  `res1` int(11) NOT NULL,
  `res2` int(11) NOT NULL,
  `res3` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `farm` int(11) NOT NULL,
  `wall` int(11) NOT NULL,
  `phalanx` int(11) NOT NULL,
  `swordsman` int(11) NOT NULL,
  `archer` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Daten für Tabelle `villages`
--

INSERT INTO `villages` (`id`, `user`, `name`, `points`, `x`, `y`, `holz`, `stein`, `eisen`, `main`, `barracks`, `smith`, `church`, `res1`, `res2`, `res3`, `store`, `farm`, `wall`, `phalanx`, `swordsman`, `archer`) VALUES
(12, 90, 'marcels Dorf', 554, 0, 0, 9000, 9000, 9000, 8, 20, 11, 10, 16, 13, 7, 9, 7, 4, 1750, 83, 138),
(14, 90, 'sir lanzelord', 300, -2, -2, 10000, 10000, 10000, 4, 14, 0, 0, 19, 3, 1, 10, 0, 0, 0, 0, 0),
(15, 90, 'barbara', 281, 1, -2, 10000, 10000, 10000, 5, 12, 1, 1, 18, 0, 0, 10, 1, 0, 0, 0, 0),
(17, 90, 'zweites dorf', 217, -2, 1, 10000, 10000, 10000, 18, 0, 0, 0, 1, 2, 1, 10, 1, 0, 0, 0, 0),
(31, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(33, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(35, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(36, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 91, 's Dorf', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `walkingTroops`
--

CREATE TABLE IF NOT EXISTS `walkingTroops` (
`id` int(10) unsigned NOT NULL,
  `villageId` int(11) NOT NULL,
  `targetId` int(11) NOT NULL,
  `mode` text NOT NULL,
  `beginTime` int(11) NOT NULL,
  `phalanx` int(11) NOT NULL,
  `swordsman` int(11) NOT NULL,
  `archer` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `walkingTroops`
--

INSERT INTO `walkingTroops` (`id`, `villageId`, `targetId`, `mode`, `beginTime`, `phalanx`, `swordsman`, `archer`) VALUES
(1, 12, 17, 'attack', 1431548450, 20, 3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildOrders`
--
ALTER TABLE `buildOrders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recruitOrders`
--
ALTER TABLE `recruitOrders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `walkingTroops`
--
ALTER TABLE `walkingTroops`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildOrders`
--
ALTER TABLE `buildOrders`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `recruitOrders`
--
ALTER TABLE `recruitOrders`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `walkingTroops`
--
ALTER TABLE `walkingTroops`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
