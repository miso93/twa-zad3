-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Hostiteľ: localhost
-- Vygenerované: Ne 13.Mar 2016, 20:35
-- Verzia serveru: 5.5.44-0ubuntu0.14.04.1
-- Verzia PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáza: `twa-zad3`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `history_logins`
--

CREATE TABLE IF NOT EXISTS `history_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_type` varchar(10) NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Sťahujem dáta pre tabuľku `history_logins`
--

INSERT INTO `history_logins` (`id`, `login_type`, `login_at`, `user_id`) VALUES
(1, 'local', '2016-03-10 10:32:56', 1),
(2, 'ldap', '2016-03-10 10:33:41', 2),
(3, 'google', '2016-03-10 10:33:56', 7),
(4, 'google', '2016-03-10 10:34:09', 1),
(5, 'google', '2016-03-10 11:14:51', 8),
(6, 'google', '2016-03-10 11:15:32', 8),
(7, 'google', '2016-03-10 11:15:42', 8),
(8, 'ldap', '2016-03-10 17:49:56', 2),
(9, 'ldap', '2016-03-10 17:50:19', 9),
(10, 'ldap', '2016-03-12 18:38:58', 10),
(11, 'ldap', '2016-03-12 21:10:51', 10),
(12, 'google', '2016-03-12 21:11:59', 11),
(13, 'google', '2016-03-12 23:19:08', 11),
(14, 'google', '2016-03-12 23:19:18', 11),
(15, 'google', '2016-03-12 23:53:54', 8),
(16, 'local', '2016-03-13 17:56:11', 1),
(17, 'local', '2016-03-13 18:15:52', 1),
(18, 'local', '2016-03-13 18:18:42', 1),
(19, 'local', '2016-03-13 18:19:33', 1),
(20, 'google', '2016-03-13 18:48:22', 1),
(21, 'google', '2016-03-13 18:48:49', 1),
(22, 'local', '2016-03-13 18:55:23', 1),
(23, 'local', '2016-03-13 18:56:28', 1),
(24, 'local', '2016-03-13 18:56:48', 1),
(25, 'google', '2016-03-13 18:56:58', 7),
(26, 'google', '2016-03-13 19:02:31', 1),
(27, 'google', '2016-03-13 19:06:50', 1),
(28, 'google', '2016-03-13 19:08:15', 1),
(29, 'ldap', '2016-03-13 19:10:41', 2),
(30, 'local', '2016-03-13 19:11:27', 2),
(31, 'google', '2016-03-13 19:29:12', 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `facebookId` varchar(100) DEFAULT NULL,
  `googleId` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `google_id` int(15) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `google_profile` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `last_name`, `facebookId`, `googleId`, `password`, `uid`, `type`, `google_id`, `picture`, `google_profile`, `updated_at`) VALUES
(1, 'cech.michal@gmail.com', 'Michal', 'Cech', NULL, NULL, 'c87365527f5f95e9e7349edac73b95fcb292dd21', NULL, 'local', 2147483647, 'https://lh6.googleusercontent.com/-cYotZ4M7vmU/AAAAAAAAAAI/AAAAAAAARJI/bLdQD_sE-Ns/photo.jpg', 'https://plus.google.com/101879049861434388020', NULL),
(2, 'xcechm4@stuba.sk', 'Michal', 'Cech', NULL, NULL, '12d8015a6b6b302a43bc4db4e9ee9f043fc2369e', 'xcechm4', 'ldap', NULL, NULL, NULL, NULL),
(7, 'cech@visibility.sk', 'Michal', 'Čech', NULL, NULL, NULL, NULL, 'google', 2147483647, 'https://lh5.googleusercontent.com/-qn3sREIfIck/AAAAAAAAAAI/AAAAAAAAAAs/v6ZIcwFP7bQ/photo.jpg', NULL, NULL),
(8, 'axxa764@gmail.com', 'Sss', 'Ggg', NULL, NULL, NULL, NULL, 'google', 2147483647, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'https://plus.google.com/101186148467440004438', NULL),
(9, 'xkolarikk@stuba.sk', 'Kamil', 'Kolarik', NULL, NULL, NULL, 'xkolarikk', 'ldap', NULL, NULL, NULL, NULL),
(10, '5825@is.stuba.sk', 'Maros', 'Polak', NULL, NULL, NULL, 'xpolakm4', 'ldap', NULL, NULL, NULL, NULL),
(11, 'yoginmnv@gmail.com', 'Maroš', 'Polák', NULL, NULL, NULL, NULL, 'google', 2147483647, 'https://lh5.googleusercontent.com/-EJVaMKSOSNo/AAAAAAAAAAI/AAAAAAAAA9k/m5Ui-JmPJPw/photo.jpg', 'https://plus.google.com/+MarošPolák', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
