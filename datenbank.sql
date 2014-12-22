-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 22. Dez 2014 um 16:49
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
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `creationDate`) VALUES
(90, 'marcel', 'asda@asd.de', '$2y$10$uT781VjAbONUIkbTQVtJCeiOubMtxFvTj51OCDFSTTIT/8exFhP4S', '2014-11-29 20:34:07');

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
  `troop1` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `villages`
--

INSERT INTO `villages` (`id`, `user`, `name`, `points`, `x`, `y`, `holz`, `stein`, `eisen`, `main`, `barracks`, `smith`, `church`, `res1`, `res2`, `res3`, `store`, `farm`, `wall`, `troop1`) VALUES
(12, 90, 'marcels Dorf', 0, 0, 0, 4490, 19590, 23500, 5, 15, 0, 0, 10, 6, 4, 0, 0, 0, 732),
(14, 90, 'sir lanzelord', 0, -2, -2, 99996, 0, 0, 0, 0, 0, 0, 78, 0, 0, 0, 0, 0, 0),
(15, 90, 'barbara', 0, 1, -2, 58972, 0, 0, 0, 0, 0, 0, 46, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
