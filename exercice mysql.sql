-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour projetfinal
CREATE DATABASE IF NOT EXISTS `projetfinal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projetfinal`;

-- Listage de la structure de table projetfinal. adresse
CREATE TABLE IF NOT EXISTS `adresse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.adresse : ~0 rows (environ)

-- Listage de la structure de table projetfinal. article
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `origine_id` int DEFAULT NULL,
  `poids` int NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conservation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qte` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66BCF5E72D` (`categorie_id`),
  KEY `IDX_23A0E6687998E` (`origine_id`),
  CONSTRAINT `FK_23A0E6687998E` FOREIGN KEY (`origine_id`) REFERENCES `origine` (`id`),
  CONSTRAINT `FK_23A0E66BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.article : ~0 rows (environ)
INSERT INTO `article` (`id`, `categorie_id`, `origine_id`, `poids`, `libelle`, `description`, `marque`, `prix`, `image`, `conservation`, `qte`) VALUES
	(1, 1, 1, 3, 'test', 'test', 'test', 10, 'Img/expresso.jpg', '6', 20),
	(2, 1, 1, 3, 'test', 'test', 'test', 10, 'Img/expresso.jpg', '6', 20),
	(3, 1, 1, 3, 'test', 'test', 'test', 10, 'Img/expresso.jpg', '6', 20),
	(4, 1, 1, 3, 'test', 'test', 'test', 10, 'Img/expresso.jpg', '6', 20),
	(5, 1, 1, 3, 'test', 'test', 'test', 10, 'Img/expresso.jpg', '6', 20);

-- Listage de la structure de table projetfinal. article_avis
CREATE TABLE IF NOT EXISTS `article_avis` (
  `article_id` int NOT NULL,
  `avis_id` int NOT NULL,
  PRIMARY KEY (`article_id`,`avis_id`),
  KEY `IDX_3FD32CF17294869C` (`article_id`),
  KEY `IDX_3FD32CF1197E709F` (`avis_id`),
  CONSTRAINT `FK_3FD32CF1197E709F` FOREIGN KEY (`avis_id`) REFERENCES `avis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3FD32CF17294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.article_avis : ~0 rows (environ)
INSERT INTO `article_avis` (`article_id`, `avis_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1);

-- Listage de la structure de table projetfinal. article_tag
CREATE TABLE IF NOT EXISTS `article_tag` (
  `article_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`article_id`,`tag_id`),
  KEY `IDX_919694F97294869C` (`article_id`),
  KEY `IDX_919694F9BAD26311` (`tag_id`),
  CONSTRAINT `FK_919694F97294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_919694F9BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.article_tag : ~0 rows (environ)

-- Listage de la structure de table projetfinal. avis
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `note` int NOT NULL,
  `commentaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F91ABF019EB6921` (`client_id`),
  CONSTRAINT `FK_8F91ABF019EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.avis : ~0 rows (environ)
INSERT INTO `avis` (`id`, `client_id`, `note`, `commentaire`) VALUES
	(1, 1, 4, NULL);

-- Listage de la structure de table projetfinal. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.categorie : ~0 rows (environ)
INSERT INTO `categorie` (`id`, `libelle`, `image`) VALUES
	(1, 'Expresso', 'null');

-- Listage de la structure de table projetfinal. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `adresse_id` int DEFAULT NULL,
  `facture_id` int DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_commande` datetime NOT NULL,
  `click_and_collect` tinyint(1) NOT NULL,
  `telephone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6EEAA67D7F2DEE08` (`facture_id`),
  KEY `IDX_6EEAA67D4DE7DC5C` (`adresse_id`),
  KEY `IDX_6EEAA67D19EB6921` (`client_id`),
  CONSTRAINT `FK_6EEAA67D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_6EEAA67D4DE7DC5C` FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`id`),
  CONSTRAINT `FK_6EEAA67D7F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.commande : ~0 rows (environ)

-- Listage de la structure de table projetfinal. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table projetfinal.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231023120748', '2023-10-23 12:08:09', 400);

-- Listage de la structure de table projetfinal. facture
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_client` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_facturation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int NOT NULL,
  `libelle_article` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qte_article` int NOT NULL,
  `numero_de_facturation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_commande` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.facture : ~0 rows (environ)

-- Listage de la structure de table projetfinal. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table projetfinal. origine
CREATE TABLE IF NOT EXISTS `origine` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.origine : ~0 rows (environ)
INSERT INTO `origine` (`id`, `pays`) VALUES
	(1, 'France');

-- Listage de la structure de table projetfinal. tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.tag : ~0 rows (environ)

-- Listage de la structure de table projetfinal. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_letter` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projetfinal.user : ~0 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `news_letter`) VALUES
	(1, 'admin@admin.fr', '["ROLE_ADMIN"]', 'admin', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
