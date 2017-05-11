-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 11 Mai 2017 à 07:58
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `m1dnr2i_miniframework`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `chapo` text NOT NULL,
  `content` text NOT NULL,
  `publication_status` varchar(65) NOT NULL,
  `creation_date` date NOT NULL,
  `publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id`, `author`, `title`, `chapo`, `content`, `publication_status`, `creation_date`, `publication_date`) VALUES
(159, 'admin', 'Confucius', 'L\'homme sage apprend de ses erreurs, - L\'homme plus sage apprend des erreurs des autres', '<p>Don&#39;t forget it</p>', 'publie', '2017-05-05', '2017-05-10');

-- --------------------------------------------------------

--
-- Structure de la table `cim_article_image`
--

CREATE TABLE `cim_article_image` (
  `idArticle` int(11) NOT NULL,
  `idImage` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `main` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cim_article_image`
--

INSERT INTO `cim_article_image` (`idArticle`, `idImage`, `num`, `main`) VALUES
(159, 56, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `attr_alt` varchar(255) NOT NULL,
  `publication_status` varchar(65) NOT NULL,
  `author` varchar(255) NOT NULL,
  `creation_date` date NOT NULL,
  `publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`id`, `name`, `path`, `attr_alt`, `publication_status`, `author`, `creation_date`, `publication_date`) VALUES
(54, 'medor', 'img83c327cd934188047fd47c6715e708e9.jpg', 'image de mon chien medor', 'publie', 'admin', '2017-05-10', '2017-05-10'),
(55, 'H.U.L.K', 'imgacab852aebc843f7ab5bee08c167e893.jpg', 'HULK', 'publie', 'admin', '2017-05-10', '2017-05-10'),
(56, 'Confucius', 'img500b2630772584abeb759f916824e674.jpg', 'Confucius', 'publie', 'admin', '2017-05-05', '2017-05-05'),
(57, 'B max disney', 'imgec2cd2bebccf8986a34b296694790362.jpg', 'B max', 'publie', 'editor', '2017-05-05', '2017-05-05'),
(58, 'Paysage', 'imgbb7362566da018749890608b63dce47e.jpg', 'Paysage', 'publie', 'editor', '2017-05-05', '2017-05-05'),
(59, 'L - Death Note', 'img9da559b14e8a0d37f6a47f4124494d89.jpg', 'L (personnage Death note)', 'publie', 'admin', '2017-05-05', '2017-05-05'),
(60, 'Doge', 'img257834146e2839d4a994d9685e31d066.jpg', 'Doge', 'publie', 'admin', '2017-05-05', '2017-05-05'),
(61, 'Kakashi Hatake', 'img923699ed0458d51aaeb4023ecd420ba9.jpg', 'Kakashi Hatake (personnage Naruto)', 'publie', 'admin', '2017-05-05', '2017-05-05'),
(62, 'Ron Weasly', 'img5de3abffcb58357a375a38ee577c8986.jpg', 'Ron Weasly', 'publie', 'admin', '2017-05-05', '2017-05-05'),
(63, 'Assassination classroom', 'imgabf106d1d4545155f059b7cf5eb7a828.jpg', 'Assassination classroom', 'publie', 'admin', '2017-05-05', '2017-05-05');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `birthday_date` date NOT NULL,
  `gender` varchar(4) NOT NULL,
  `roles` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `mail`, `name`, `first_name`, `birthday_date`, `gender`, `roles`) VALUES
(16, 'editor', '1553cc62ff246044c683a61e203e65541990e7fcd4af9443d22b9557ecc9ac54', 'editor@gmail.com', 'Editor', 'editoria', '1994-04-30', 'Mme', '["ROLE_EDITOR"]'),
(17, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@gmail.com', 'admin', 'admino', '1994-04-30', 'Mr', '["ROLE_EDITOR", "ROLE_ADMIN"]');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statut_id` (`publication_status`);

--
-- Index pour la table `cim_article_image`
--
ALTER TABLE `cim_article_image`
  ADD PRIMARY KEY (`idArticle`,`idImage`),
  ADD KEY `idArticle` (`idArticle`),
  ADD KEY `idImage` (`idImage`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cim_article_image`
--
ALTER TABLE `cim_article_image`
  ADD CONSTRAINT `cim_article_image_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cim_article_image_ibfk_2` FOREIGN KEY (`idImage`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
