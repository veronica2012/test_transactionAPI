SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `transaction_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `transaction_db`;

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('approved','rejected','','') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reject_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

INSERT INTO `transaction` (`id`, `email`, `amount`, `status`, `create_date`, `reject_reason`) VALUES
(1, 'email@gmail.com', '1000.00', 'rejected', '0000-00-00 00:00:00', 'You are not allowed to perform transaction'),
(2, 'email@gmail.com', '1000.00', 'approved', '2016-10-31 22:00:00', NULL),
(3, 'email@gmail.com', '1000.00', 'rejected', '2015-08-02 12:57:10', 'I don''t like you'),
(4, 'email@gmail.com', '1000.00', 'approved', '2015-10-05 18:34:55', NULL),
(5, 'email@gmail.com', '1000.00', 'rejected', '2015-01-31 12:40:05', 'I don''t want to log your transaction'),
(6, 'email@gmail.com', '1000.00', 'approved', '2016-10-17 02:38:42', NULL),
(7, 'email@gmail.com', '1000.00', 'approved', '2015-10-03 22:56:34', NULL),
(8, 'email@gmail.com', '1000.00', 'approved', '2015-05-18 03:59:32', NULL),
(9, 'email@gmail.com', '1000.00', 'approved', '2015-09-30 01:59:12', NULL),
(10, 'email@gmail.com', '1000.00', 'approved', '2016-06-19 06:35:32', NULL),
(11, 'email@gmail.com', '1000.00', 'approved', '2015-09-20 06:29:06', NULL),
(12, 'email@gmail.com', '1000.00', 'approved', '2015-03-03 05:21:27', NULL),
(13, 'email@gmail.com', '1000.00', 'approved', '2016-07-08 13:38:08', NULL),
(14, 'email@gmail.com', '1000.00', 'approved', '2015-10-08 01:19:59', NULL),
(15, 'email@gmail.com', '1000.00', 'approved', '2015-08-17 17:02:46', NULL),
(16, 'email@gmail.com', '1000.00', 'approved', '2015-10-06 15:30:00', NULL),
(17, 'email@gmail.com', '1000.00', 'rejected', '2015-07-29 12:59:46', 'I think I can''t believe you'),
(18, 'email@gmail.com', '1000.00', 'approved', '2015-09-11 00:06:13', NULL),
(19, 'email@gmail.com', '1000.00', 'rejected', '2016-10-03 21:51:48', 'I don''t like you'),
(20, 'email@gmail.com', '1000.00', 'rejected', '2016-03-16 19:58:27', 'I don''t want to log your transaction'),
(21, 'email@gmail.com', '1000.00', 'rejected', '2016-04-20 08:36:29', 'You are not allowed to perform transaction'),
(22, 'email@gmail.com', '1000.00', 'rejected', '2016-11-02 23:47:41', 'I don''t like you'),
(23, 'email@gmail.com', '1000.00', 'approved', '2016-05-14 01:27:56', NULL),
(24, 'email@gmail.com', '1000.00', 'approved', '2015-01-08 02:27:24', NULL),
(25, 'email@gmail.com', '1000.00', 'rejected', '2016-04-28 16:36:23', 'You are not allowed to perform transaction'),
(26, 'email@gmail.com', '1000.00', 'rejected', '2015-08-29 01:22:02', 'I don''t want to log your transaction'),
(27, 'email@gmail.com', '1000.00', 'rejected', '2015-04-25 11:52:23', 'I think I can''t believe you'),
(28, 'email@gmail.com', '1000.00', 'rejected', '2015-09-18 03:33:31', 'I don''t like you'),
(29, 'email@gmail.com', '1000.00', 'rejected', '2016-10-03 11:12:03', 'I think I can''t believe you'),
(30, 'email@gmail.com', '1000.00', 'approved', '2015-06-19 08:35:54', NULL),
(31, 'email@gmail.com', '1000.00', 'approved', '2015-09-19 10:42:39', NULL),
(32, 'email@gmail.com', '1000.00', 'approved', '2015-03-19 00:37:15', NULL),
(33, 'wwsw@gmail.com', '100.00', 'approved', '2016-11-11 09:13:22', NULL),
(34, 'wwsw@gmail.com', '12.00', 'approved', '2016-05-01 00:53:15', NULL),
(35, 'mels@gmail.com', '12.00', 'approved', '2014-12-20 05:56:03', NULL),
(36, 'mels@gmail.com', '12.00', 'approved', '2015-12-17 22:52:53', NULL),
(37, 'mels@gmail.com', '979.00', 'rejected', '2015-08-27 22:43:29', 'Fraud detected'),
(38, 'mels@gmail.com', '979.21', 'approved', '2016-09-11 19:16:56', NULL),
(39, 'var@gmail.com', '123.00', 'rejected', '2015-05-28 10:11:47', 'I don''t like you'),
(40, 'email@gmail.com', '1480.00', 'rejected', '2015-09-28 01:00:40', 'I don''t like you'),
(41, 'qws@gmail.com', '111.00', 'rejected', '2016-02-20 14:21:42', 'I don''t want to log your transaction'),
(42, 'qws@gmail.com', '111.00', 'rejected', '2015-07-28 14:50:49', 'I think I can''t believe you'),
(43, 'mymail@gmail.com', '22.00', 'approved', '2016-03-25 00:16:57', NULL),
(44, 'gura.s.maxim@gmail.com', '111.00', 'rejected', '2016-06-27 00:08:15', 'I think I can''t believe you'),
(45, 'email@cew.com', '222.00', 'approved', '2015-10-24 08:51:44', NULL),
(46, 'veronica.golskaya@gmail.com', '323.00', 'approved', '2015-04-19 13:44:19', NULL),
(47, 'email@cew.com', '11.00', 'rejected', '2015-10-19 21:03:49', 'You are not allowed to perform transaction'),
(48, 'email@cew.com', '100.00', 'rejected', '2016-06-03 23:37:47', 'I think I can''t believe you'),
(49, 'test@test.com', '100.00', 'rejected', '2015-08-28 04:24:22', 'You are not allowed to perform transaction'),
(50, 'test@test.com', '1.00', 'rejected', '2015-09-27 13:58:42', 'I think I can''t believe you'),
(51, 'v.eronicag.olska.ya@gmail.con', '1.00', 'rejected', '2016-06-02 16:19:34', 'I don''t want to log your transaction'),
(52, 'test@test.com', '11.00', 'rejected', '2015-11-18 06:38:47', 'Fraud detected'),
(53, 'test@test.com', '1.00', 'rejected', '2015-09-05 12:53:51', 'I don''t want to log your transaction'),
(54, 'test@test.com', '1.00', 'rejected', '2016-01-16 18:13:05', 'I think I can''t believe you'),
(55, 'test@test.com', '1.00', 'rejected', '2015-04-10 21:37:11', 'I think I can''t believe you'),
(56, 'veronica.golskaya@gmail.com', '12.00', 'approved', '2016-02-22 14:57:21', NULL),
(57, 'test@tets.com', '12.20', 'rejected', '2016-07-10 05:35:57', 'You are not allowed to perform transaction'),
(58, 'veronica.golskaya@gmail.com', '12.00', 'approved', '2015-12-11 20:23:10', NULL),
(59, '122@gmail.com', '221.00', 'approved', '2016-06-11 18:43:05', NULL),
(60, 'var@gmail.com', '123.00', 'approved', '2016-03-11 10:50:15', NULL);


ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);


ALTER TABLE `transaction`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
