-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : ven. 10 fév. 2023 à 11:45
-- Version du serveur : 10.3.35-MariaDB
-- Version de PHP : 8.1.7

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `mvcprojets`
--
DROP DATABASE IF EXISTS `mvcprojets`;
CREATE DATABASE IF NOT EXISTS `mvcprojets` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mvcprojets`;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
                                          `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                          `title` varchar(100) NOT NULL,
                                          `content` varchar(800) DEFAULT NULL,
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `title`, `content`) VALUES
                                                      (1, 'BDD SQL', 'SQL (sigle de Structured Query Language, en français langage de requête structurée) est un langage informatique normalisé servant à exploiter des bases de données relationnelles. La partie langage de manipulation des données de SQL permet de rechercher, d\'ajouter, de modifier ou de supprimer des données dans les bases de données relationnelles.'),
                                                      (2, 'BDD NoSQL', 'En informatique et en bases de données, NoSQL désigne une famille de systèmes de gestion de base de données (SGBD) qui s\'écarte du paradigme classique des bases relationnelles. L\'explicitation la plus populaire de l\'acronyme est Not only SQL (« pas seulement SQL » en anglais) même si cette interprétation peut être discutée.'),
                                                      (3, 'BDD alternatives', 'Bases de données alternatives aux SQL et NoSQL'),
                                                      (4, 'Conception de BDD', 'La conception de base de données est l\'organisation des données selon un modèle de base de données . Le concepteur détermine quelles données doivent être stockées et comment les éléments de données sont interdépendants. Avec ces informations, ils peuvent commencer à adapter les données au modèle de base de données.'),
                                                      (5, 'Outils et liens utiles', 'Outils et liens utiles sur les bases de données');

-- --------------------------------------------------------

--
-- Structure de la table `category_has_post`
--

DROP TABLE IF EXISTS `category_has_post`;
CREATE TABLE IF NOT EXISTS `category_has_post` (
                                                   `category_id` int(10) UNSIGNED NOT NULL,
                                                   `post_id` int(10) UNSIGNED NOT NULL,
                                                   PRIMARY KEY (`category_id`,`post_id`),
                                                   KEY `fk_category_has_post_post1_idx` (`post_id`),
                                                   KEY `fk_category_has_post_category1_idx` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category_has_post`
--

INSERT INTO `category_has_post` (`category_id`, `post_id`) VALUES
                                                               (1, 1),
                                                               (1, 2),
                                                               (1, 3),
                                                               (1, 4),
                                                               (2, 5),
                                                               (3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
                                      `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                      `title` varchar(200) NOT NULL,
                                      `content` text NOT NULL,
                                      `datecreate` datetime DEFAULT current_timestamp(),
                                      `visible` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => not visible\n1 => visible',
                                      `user_id` int(10) UNSIGNED DEFAULT NULL,
                                      PRIMARY KEY (`id`),
                                      KEY `fk_post_user_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `datecreate`, `visible`, `user_id`) VALUES
                                                                                      (1, 'MySQL', 'MySQL est un système de gestion de bases de données relationnelles (SGBDR). Il est distribué sous une double licence GPL et propriétaire. Il fait partie des logiciels de gestion de base de données les plus utilisés au monde, autant par le grand public (applications web principalement) que par des professionnels, en concurrence avec Oracle, PostgreSQL et Microsoft SQL Server.\n\nSon nom vient du prénom de la fille du co créateur Michael Widenius: My. \n\nSQL fait référence au Structured Query Language, le langage de requête utilisé.\n\nMySQL AB a été acheté le 16 janvier 2008 par Sun Microsystems pour un milliard de dollars américains. En 2009, Sun Microsystems a été acquis par Oracle Corporation, mettant entre les mains d\'une même société les deux produits concurrents que sont Oracle Database et MySQL. Ce rachat a été autorisé par la Commission européenne le 21 janvier 2010.\n\nDepuis mai 2009, son créateur Michael Widenius a créé MariaDB (Maria est le prénom de sa deuxième fille) pour continuer son développement en tant que projet Open Source.\n\nMySQL est un serveur de bases de données relationnelles SQL développé dans un souci de performances élevées en lecture, ce qui signifie qu\'il est davantage orienté vers le service de données déjà en place que vers celui de mises à jour fréquentes et fortement sécurisées. Il est multi-thread et multi-utilisateur.\n\nC\'est un logiciel libre, open source, développé sous double licence selon qu\'il est distribué avec un produit libre ou avec un produit propriétaire. Dans ce dernier cas, la licence est payante, sinon c\'est la licence publique générale GNU (GPL) qui s\'applique. Un logiciel qui intègre du code MySQL ou intègre MySQL lors de son installation devra donc être libre ou acquérir une licence payante. Cependant, si la base de données est séparée du logiciel propriétaire qui ne fait qu\'utiliser des API tierces (par exemple en C# ou php), alors il n\'y a pas besoin d\'acquérir une licence payante MySQL. Ce type de licence double est utilisé par d\'autres produits comme le framework de développement de logiciels Qt (pour les versions antérieures à la 4.5).\n\nWikipédia : https://fr.wikipedia.org/wiki/MySQL', '2023-02-10 10:43:08', 1, 1),
                                                                                      (2, 'MariaDB', 'MariaDB est un système de gestion de base de données édité sous licence GPL. Il s\'agit d\'un embranchement communautaire de MySQL : la gouvernance du projet est assurée par la fondation MariaDB, et sa maintenance par la société Monty Program AB, créateur du projet. Cette gouvernance confère au logiciel l’assurance de rester libre.\n\nEn 2009, à la suite du rachat de MySQL par Sun Microsystems et des annonces du rachat de Sun Microsystems par Oracle Corporation, Michael Widenius, fondateur de MySQL, quitte cette société pour lancer le projet MariaDB, dans une démarche visant à remplacer MySQL tout en assurant l’interopérabilité. Le nom vient de la 2e fille de Michael Widenius, Maria (la première s\'appelant My).\n\nLes numéros de version de MariaDB suivent le schéma de numérotation de MySQL jusqu\'à la version 5.5. Étant donné que de nouvelles fonctionnalités spécifiques ont été développées dans MariaDB, les développeurs ont décidé qu\'un changement majeur de numéro de version était nécessaire - la version suivante après 5.5 était 10.0\n\nWikipédia : https://fr.wikipedia.org/wiki/MariaDB', '2023-02-10 10:47:43', 1, 1),
                                                                                      (3, 'SQLite', 'SQLite est une bibliothèque écrite en langage C qui propose un moteur de base de données relationnelle accessible par le langage SQL. SQLite implémente en grande partie le standard SQL-92 et des propriétés ACID.\n\nContrairement aux serveurs de bases de données traditionnels, comme MySQL ou PostgreSQL, sa particularité est de ne pas reproduire le schéma habituel client-serveur mais d\'être directement intégrée aux programmes. L\'intégralité de la base de données (déclarations, tables, index et données) est stockée dans un fichier indépendant de la plateforme.\n\nD. Richard Hipp, le créateur de SQLite, a choisi de mettre cette bibliothèque ainsi que son code source dans le domaine public, ce qui permet son utilisation sans restriction aussi bien dans les projets open source que dans les projets propriétaires. Le créateur ainsi qu\'une partie des développeurs principaux de SQLite sont employés par la société américaine Hwaci.\n\nSQLite est le moteur de base de données le plus utilisé au monde, grâce à son utilisation :\n\ndans de nombreux logiciels grand public comme Firefox, Skype, Google Gears,\ndans certains produits d\'Apple, d\'Adobe et de McAfee,\ndans les bibliothèques standards de nombreux langages comme PHP ou Python.\nDe par son extrême légèreté (moins de 600 Kio), il est également très populaire sur les systèmes embarqués, notamment sur la plupart des smartphones et tablettes modernes : les systèmes d\'exploitation mobiles iOS, Android et Symbian l\'utilisent comme base de données embarquée. Au total, on peut dénombrer plus d\'un milliard de copies connues et déclarées de la bibliothèque5.\n\nWikipédia : https://fr.wikipedia.org/wiki/SQLite', '2023-02-10 10:52:43', 1, NULL),
                                                                                      (4, 'Microsoft Access', 'Microsoft Access (officiellement Microsoft Office Access) est une base de données relationnelle éditée par Microsoft. Ce logiciel fait partie de la suite Microsoft Office.\n\nMS Access est composé de plusieurs programmes : le moteur de base de données Microsoft Jet, un éditeur graphique, une interface de type Query by Example pour interroger les bases de données, et le langage de programmation Visual Basic for Applications.\n\nDepuis les premières versions, l\'interface de Microsoft Access permet de gérer graphiquement des collections de données dans des tables, d\'établir des relations entre ces tables selon les règles habituelles des bases de données relationnelles, de créer des requêtes avec le QBE (Query by Example, ou directement en langage SQL), de créer des interfaces homme/machine et des états d\'impression. Comme pour les autres logiciels Office, le VBA,Visual Basic for Applications, permet de créer des applications complètes et en réseau local, y compris en utilisant, créant ou modifiant les fichiers (documents Word, classeurs Excel, instances Outlook, etc.) des autres logiciels de la suite sans quitter Access.\n\nLa dernière version en date est la version 2019 ; elle fait partie de la suite Microsoft Office 2019 et est incluse dans certaines options de l\'abonnement à Office 365. La version par abonnement, Microsoft Office 365, est actualisée automatiquement comme celle de Windows 10.\n\nWikipédia : https://fr.wikipedia.org/wiki/Microsoft_Access', '2023-02-10 10:55:33', 1, 2),
                                                                                      (5, 'MongoDB', 'MongoDB (de l\'anglais humongous qui peut être traduit par « énorme ») est un système de gestion de base de données orienté documents, répartissable sur un nombre quelconque d\'ordinateurs et ne nécessitant pas de schéma prédéfini des données. Il est écrit en C++. Le serveur et les outils sont distribués sous licence SSPL, les pilotes sous licence Apache et la documentation sous licence Creative Commons. Il fait partie de la mouvance NoSQL.\r\n\r\nMongoDB est développé depuis 2007 par MongoDB. Cette entreprise travaillait alors sur un système de Cloud computing, informatique à données largement réparties, similaire au service Google App Engine de Google.\r\n\r\nIl est depuis devenu un des SGBD les plus utilisés, notamment pour les sites web de Craigslist, eBay, Foursquare, SourceForge.net, Viacom, pagesjaunes et le New York Times.\r\n\r\nMongoDB permet de manipuler des objets structurés au format BSON (JSON binaire), sans schéma prédéterminé. En d\'autres termes, des clés peuvent être ajoutées à tout moment « à la volée », sans reconfiguration de la base.\r\n\r\nLes données prennent la forme de documents enregistrés eux-mêmes dans des collections, une collection contenant un nombre quelconque de documents. Les collections sont comparables aux tables, et les documents aux enregistrements des bases de données relationnelles. Contrairement aux bases de données relationnelles, les champs d\'un enregistrement sont libres et peuvent être différents d\'un enregistrement à un autre au sein d\'une même collection. Le seul champ commun et obligatoire est le champ de clé principale (\"id\"). Par ailleurs, MongoDB ne permet ni les requêtes très complexes standardisées, ni les JOIN, mais permet de programmer des requêtes spécifiques en JavaScript.\r\n\r\nWikipédia : https://fr.wikipedia.org/wiki/MongoDB', '2023-02-10 11:44:04', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
                                      `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                      `username` varchar(80) NOT NULL,
                                      `usermail` varchar(200) NOT NULL,
                                      `userpwd` varchar(255) NOT NULL,
                                      `userscreen` varchar(400) NOT NULL,
                                      `useruniqid` varchar(120) DEFAULT NULL COMMENT 'idententifiant unique',
                                      `actif` tinyint(3) UNSIGNED DEFAULT 0 COMMENT '0 => inactif\n1  => actif\n2 => banni',
                                      PRIMARY KEY (`id`),
                                      UNIQUE KEY `username_UNIQUE` (`username`),
                                      UNIQUE KEY `usermail_UNIQUE` (`usermail`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `usermail`, `userpwd`, `userscreen`, `useruniqid`, `actif`) VALUES
                                                                                                      (1, 'michaeljpitz', 'michael.pitz@cf2m.be', '$2y$10$KYbexAa0gbqSZax/RsK7V.rQ23CPy5im1rwo3v5VfW23DGrO/GlUm', 'Michaël Pitz', 'php_63e608cc756556.00239810', 1),
                                                                                                      (2, 'pierresandron', 'pierre.sandron@cf2m.be', '$2y$10$h02u1E3QfzqInuQupysvA.eYQZ4mBrDh4PblaNvpUiTnIXL60oEvq', 'Pierre Sandron', 'php_63e6095a9828f3.13666748', 1),
                                                                                                      (3, 'clovisreuss', 'webprod@cf2m.be', '$2y$10$QrXku6rYE9M09.UESZnYUO3HW5L4dynMftQm7tZ9AFZIpGfwJgYsO', 'Clovis Reuss', 'php_63e60ac4dfd358.31228917', 0),
                                                                                                      (4, 'andrepalmisano', 'andre.palmisano@cf2m.be', '$2y$10$chNKn69X0oJl/lnJdXctwe54HZYzdpD8ngZuULLBWUz/jMlg3VKga', 'André Palmisano', 'php_63e60bbf70fce4.56128222', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `category_has_post`
--
ALTER TABLE `category_has_post`
    ADD CONSTRAINT `fk_category_has_post_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_category_has_post_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
    ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
