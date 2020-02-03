-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour forum
DROP DATABASE IF EXISTS `forum`;
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;
USE `forum`;

-- Listage de la structure de la table forum. post
DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_bin NOT NULL,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_topic` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `post_topic_FK` (`id_topic`),
  KEY `post_user_FK` (`id_user`),
  CONSTRAINT `post_topic_FK` FOREIGN KEY (`id_topic`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `post_user_FK` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum.post : ~4 rows (environ)
DELETE FROM `post`;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id_post`, `text`, `submitted_at`, `id_topic`, `id_user`) VALUES
	(1, 'Mon premier message !!!', '2020-01-30 15:05:36', 1, 1),
	(2, 'Ma premire réponse...', '2020-01-30 15:09:59', 1, 2),
	(3, 'Et ça continue !', '2020-01-30 15:12:33', 1, 1),
	(4, 'Encore et encore...', '2020-01-30 15:23:14', 1, 2),
	(5, 'klmjsdhnflkbqlsdkfkljqsbhdfjfklmbhasdklmfgv;:sdv', '2020-01-30 16:19:18', 2, 1),
	(6, 'C&#39;est sans fin !!!', '2020-01-31 10:10:19', 1, 1);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forum. topic
DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `is_closed` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `topic_user_FK` (`id_user`),
  CONSTRAINT `topic_user_FK` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum.topic : ~5 rows (environ)
DELETE FROM `topic`;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`id_topic`, `title`, `description`, `created_at`, `id_user`, `is_closed`) VALUES
	(1, 'Premier sujet', 'Ceci est le premier sujet du forum', '2020-01-30 10:00:39', 1, 0),
	(2, 'Second sujet', 'Cela constitue un autre sujet sur le forum', '2020-01-30 11:03:37', 1, 1),
	(3, 'Troisième sujet', 'Et un sujet de plus dans le forum !', '2020-01-30 14:19:30', 2, 0),
	(4, 'Quatrième sujet', 'Ceci est un sujet dont le titre est extrêmement long, et dépasse 64 caractères !', '2020-01-30 15:30:42', 1, 0),
	(5, 'Cinquième sujet', 'Ceci est un sujet dont le titre est encore plus long :\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut imperdiet massa quis leo iaculis fermentum. Nam bibendum rhoncus odio, eget ornare purus porta non. Quisque fringilla suscipit mi. Nunc vulputate massa tortor, id convallis augue volutpat convallis. Pellentesque augue ligula, gravida et vehicula et, pretium eget tortor. Nullam nec metus ut quam volutpat efficitur id quis augue. Sed ut gravida neque, id fringilla justo. Sed in erat dolor. Nam efficitur tellus ante, non mattis magna tristique sit amet. Nulla ut tellus ac felis aliquet consectetur ac id ex. Etiam ut lacinia nisi. Phasellus in ligula sodales, mollis justo a, molestie sapien. Fusce sollicitudin vitae mi in imperdiet. Phasellus vestibulum metus eget mauris finibus, et ullamcorper diam dapibus.', '2020-01-30 15:32:30', 1, 0);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table forum. user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `passwd` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '0',
  `registered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_visit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `firstname` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `lastname` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `pseudo` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_AK` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum.user : ~0 rows (environ)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `passwd`, `registered_at`, `last_visit`, `firstname`, `lastname`, `mail`, `pseudo`) VALUES
	(1, '$argon2i$v=19$m=65536,t=4,p=1$Z0lHWXhLZVdkY2Qua05qMQ$aFWWkVITW75aWHP8YlrRLgwlbk5O+cqTrT9BZbgBV3g', '2020-01-29 21:16:07', '2020-01-29 21:16:07', 'Jean-Michel', 'CASAUBON', 'jm_casaubon@orange.fr', 'jean-michel'),
	(2, '$argon2i$v=19$m=65536,t=4,p=1$YkZkV0xPM0ludTc3b0xOZA$NR9tIImIlTcuvqn+F0zc6w28nl0RYR3e+37yF6jUA5o', '2020-01-30 14:17:24', '2020-01-30 14:17:24', 'Sylvain', 'ALLAIN', 'sdeuhelf@gmail.com', 'sylvain');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
