-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  mar. 04 déc. 2018 à 13:38
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

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `com` int(11) NOT NULL,
  `publication` int(11) NOT NULL
) ENGINE=InnoaDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `coms`
--

CREATE TABLE `coms` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `comDate` datetime NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `contact` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `eventDate` datetime NOT NULL,
  `place` varchar(45) DEFAULT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groupAdd`
--

CREATE TABLE `groupAdd` (
  `id` int(11) NOT NULL,
  `message` char(1) DEFAULT NULL,
  `addDate` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `status` enum('message','member') DEFAULT NULL,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `createDate` date DEFAULT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `participate`
--

CREATE TABLE `participate` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `user` int(11) NOT NULL,
  `event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `publication` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `privateMessages`
--

CREATE TABLE `privateMessages` (
  `id` int(11) NOT NULL,
  `content` char(1) DEFAULT NULL,
  `reicever` int(11) DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `postDate` datetime DEFAULT NULL,
  `type` enum('text','image') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sendPrivate`
--

CREATE TABLE `sendPrivate` (
  `id` int(11) NOT NULL,
  `receiver` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL,
  `privateMessage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` enum('company','employee') NOT NULL,
  `job` varchar(45) DEFAULT NULL,
  `company` varchar(45) DEFAULT NULL,
  `town` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`com`,`publication`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_comment_coms1_idx` (`com`),
  ADD KEY `fk_comment_publications1_idx` (`publication`);

--
-- Index pour la table `coms`
--
ALTER TABLE `coms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`,`user`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_contacts_users1_idx` (`user`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `groupAdd`
--
ALTER TABLE `groupAdd`
  ADD PRIMARY KEY (`id`,`user`,`group`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_groupMessages_users1_idx` (`user`),
  ADD KEY `fk_groupAdd_groups1_idx` (`group`);

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `titre_UNIQUE` (`title`);

--
-- Index pour la table `participate`
--
ALTER TABLE `participate`
  ADD PRIMARY KEY (`id`,`user`,`event`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_participate_users1_idx` (`user`),
  ADD KEY `fk_participate_events1_idx` (`event`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`,`publication`,`user`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_post_publications1_idx` (`publication`),
  ADD KEY `fk_post_users1_idx` (`user`);

--
-- Index pour la table `privateMessages`
--
ALTER TABLE `privateMessages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `sendPrivate`
--
ALTER TABLE `sendPrivate`
  ADD PRIMARY KEY (`id`,`user`,`privateMessage`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_sendPrivate_users1_idx` (`user`),
  ADD KEY `fk_sendPrivate_privateMessages1_idx` (`privateMessage`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `mail_UNIQUE` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `coms`
--
ALTER TABLE `coms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groupAdd`
--
ALTER TABLE `groupAdd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `privateMessages`
--
ALTER TABLE `privateMessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sendPrivate`
--
ALTER TABLE `sendPrivate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
