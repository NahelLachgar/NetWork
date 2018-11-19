-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  lun. 19 nov. 2018 à 19:38
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `NetWork`
--
CREATE DATABASE IF NOT EXISTS `NetWork` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `NetWork`;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com` int(11) NOT NULL,
  `publication` int(11) NOT NULL,
  PRIMARY KEY (`id`,`com`,`publication`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comment_coms1_idx` (`com`),
  KEY `fk_comment_publications1_idx` (`publication`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `coms`
--

CREATE TABLE IF NOT EXISTS `coms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `comDate` datetime NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_contacts_users1_idx` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `contact`, `user`) VALUES
(1, 2, 1),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `eventDate` datetime NOT NULL,
  `place` varchar(45) DEFAULT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groupAdd`
--

CREATE TABLE IF NOT EXISTS `groupAdd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` char(1) DEFAULT NULL,
  `addDate` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `status` enum('message','member') DEFAULT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`,`group`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_groupMessages_users1_idx` (`user`),
  KEY `fk_groupAdd_groups1_idx` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `createDate` date DEFAULT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `titre_UNIQUE` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `participate`
--

CREATE TABLE IF NOT EXISTS `participate` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `user` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`,`event`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_participate_users1_idx` (`user`),
  KEY `fk_participate_events1_idx` (`event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publication` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`,`publication`,`user`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_post_publications1_idx` (`publication`),
  KEY `fk_post_users1_idx` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `privateMessages`
--

CREATE TABLE IF NOT EXISTS `privateMessages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` char(1) DEFAULT NULL,
  `reicever` int(11) DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `publications`
--

CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `postDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sendPrivate`
--

CREATE TABLE IF NOT EXISTS `sendPrivate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL,
  `privateMessage` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`,`privateMessage`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_sendPrivate_users1_idx` (`user`),
  KEY `fk_sendPrivate_privateMessages1_idx` (`privateMessage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` enum('company','employee') NOT NULL,
  `job` varchar(45) DEFAULT NULL,
  `company` varchar(45) DEFAULT NULL,
  `town` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `mail_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `lastName`, `email`, `phone`, `photo`, `password`, `status`, `job`, `company`, `town`) VALUES
(1, 'Nahel', 'Lachgar', 'nahellachgar@hotmail.fr', '0623221148', '', '$2y$12$2XgUmKl7EX.QGn6f5hFiVuwhnqFGy/hYCIkbE90KYuKIhn40l.cjS', 'employee', 'PDG', 'NetWork', 'Paris'),
(2, 'Fred', 'Mba', 'fred@gmail.com', '0612324561', '', '$2y$12$2XgUmKl7EX.QGn6f5hFiVuwhnqFGy/hYCIkbE90KYuKIhn40l.cjS', 'employee', 'Ingénieur', 'NetWork', 'Paris'),
(3, 'Google', NULL, 'admin@google.com', NULL, '', '$2y$12$2XgUmKl7EX.QGn6f5hFiVuwhnqFGy/hYCIkbE90KYuKIhn40l.cjS', 'company', NULL, NULL, 'New York'),
(4, NULL, 'kévin', 'kevin@gmail.com', '0623457689', '', '$2y$12$m4ZDAKnUYV4DSzAasTdNouXz.qLU/lNtWTKa1bP5RpgLEady2fJbO', 'employee', 'a', 'a', 'a');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_coms1` FOREIGN KEY (`com`) REFERENCES `coms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_publications1` FOREIGN KEY (`publication`) REFERENCES `publications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `groupAdd`
--
ALTER TABLE `groupAdd`
  ADD CONSTRAINT `fk_groupAdd_groups1` FOREIGN KEY (`group`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_groupMessages_users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `participate`
--
ALTER TABLE `participate`
  ADD CONSTRAINT `fk_participate_events1` FOREIGN KEY (`event`) REFERENCES `events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_participate_users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_publications1` FOREIGN KEY (`publication`) REFERENCES `publications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `sendPrivate`
--
ALTER TABLE `sendPrivate`
  ADD CONSTRAINT `fk_sendPrivate_privateMessages1` FOREIGN KEY (`privateMessage`) REFERENCES `privateMessages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sendPrivate_users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
