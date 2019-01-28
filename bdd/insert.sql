-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  mar. 04 déc. 2018 à 13:39
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `NetWork`
--

--
-- Déchargement des données de la table `contacts`
--
USE NetWork;

INSERT INTO `users` (`id`, `name`, `lastName`, `email`, `phone`, `photo`, `password`, `status`, `job`, `company`, `town`, `active`) VALUES
(1, 'Nahel', 'Lachgar', 'nahellachgar@hotmail.fr', '0623221148', 'nahellachgar@hotmail.fr.png', '$2y$10$31qDNwnyDoLXXtMFehte3.hDIzjBREwmKzQdxBp/sR8D9Sh0OUBTy', 'employee', 'PDG', 'NetWork', 'Ivry', 'activated'),
(2, 'Morgan', 'Mba', 'fred@gmail.com', '0612324561', 'fred@gmail.com.png', '$2y$10$31qDNwnyDoLXXtMFehte3.hDIzjBREwmKzQdxBp/sR8D9Sh0OUBTy', 'employee', 'Ingénieur', 'NetWork', 'Paris', 'activated'),
(3, 'Google', NULL, 'admin@google.com', NULL, 'admin@google.com.png', '$2y$10$31qDNwnyDoLXXtMFehte3.hDIzjBREwmKzQdxBp/sR8D9Sh0OUBTy', 'company', NULL, NULL, 'New York', 'activated'),
(4, 'Kévin', 'Barao Da Silva', 'kevin@gmail.com', '0623457689', 'kevin@gmail.com.png', '$2y$10$31qDNwnyDoLXXtMFehte3.hDIzjBREwmKzQdxBp/sR8D9Sh0OUBTy', 'employee', 'Développeur', 'NetWork', 'Trappes', 'activated'),
(5, 'A', 'A', 'a@gmail.com', '0611111111', 'NetWork.png', '$2y$10$31qDNwnyDoLXXtMFehte3.hDIzjBREwmKzQdxBp/sR8D9Sh0OUBTy', 'employee', 'A', 'A', 'Le Plessis-Bouchard', 'disabled'),
(6, 'Amazon', NULL, 'admin@amazon.com', NULL, 'admin@amazon.com.png', '$2y$10$31qDNwnyDoLXXtMFehte3.hDIzjBREwmKzQdxBp/sR8D9Sh0OUBTy', 'company', NULL, NULL, 'Los Angeles', 'disabled'),
(7, 'Clotilde', 'Charavit', 'ccharavit@intechinfo.fr', '0645672268', 'ccharavit@intechinfo.fr.jpg', '$2y$12$v6yL2/xTQrpmsjjYeJHcZeRa32kw2WWN05d5FREWfFY95FKDR5NRG', 'employee', 'Ingénieur', 'NetWork', 'Sceaux', 'activated');

INSERT INTO `contacts` (`id`, `contact`, `user`,`status`) VALUES
(13, 1, 2,"accepted"),
(15, 4, 2,"accepted"),
(20, 5, 2,"accepted"),
(21, 4, 1,"accepted");

--
-- Déchargement des données de la table `post`
--
INSERT INTO `publications` (`id`, `content`, `postDate`, `type`) VALUES
(5, 'Bonjour', '2018-11-21 21:03:34', 'text'),
(7, 'gt\'rthtyhfhrtegd', '2018-11-21 21:09:21', 'text'),
(8, 'feezaefdqsfq', '2018-11-21 21:16:58', 'text'),
(9, 'deqfs<', '2018-11-21 21:20:05', 'text'),
(13, 'setdfhtrqeshfdstdfgjyrte', '2018-11-21 23:30:12', 'text'),
(14, 'bgrfezdfezda', '2018-11-23 13:44:46', 'text'),
(15, 'rfezaed\r\n', '2018-11-23 14:29:25', 'text'),
(16, 'grzgzesdfs', '2018-11-23 14:29:46', 'text'),
(17, 'rftft', '2018-11-23 14:30:48', 'text'),
(18, 'hello', '2018-11-23 14:34:43', 'text'),
(19, 'BONSOIR', '2018-11-23 14:35:02', 'text'),
(20, 'Salut ', '2018-11-23 14:35:52', 'text'),
(21, ' morgan', '2018-11-23 14:36:39', 'text'),
(22, 'Salut Nahel', '2018-11-23 14:41:03', 'text'),
(23, 'dvrfzefefrezd', '2018-11-23 14:41:10', 'text'),
(24, 'dsds', '2018-11-23 14:47:40', 'text'),
(25, 'sasasas', '2018-11-23 14:48:23', 'text'),
(26, 'salut kevin', '2018-11-23 14:49:57', 'text'),
(27, 'Salut Morgan!', '2018-11-23 14:50:27', 'text'),
(28, 'le Kevin de chez NetWork !!!', '2018-11-23 14:50:53', 'text'),
(29, 'salut', '2018-11-23 14:51:26', 'text'),
(30, 'keeeeeeeeeeevvvvvvvvvvvvv', '2018-11-23 14:54:14', 'text'),
(31, 'Salut', '2018-11-23 15:25:39', 'text'),
(32, 'tanguy', '2018-11-23 15:38:27', 'text'),
(33, '!!', '2018-11-26 09:35:29', 'text'),
(34, ' ', '2018-11-26 09:43:12', 'text'),
(35, 'test', '2018-11-26 13:56:49', 'text'),
(36, 'dsf', '2018-11-28 11:09:06', 'text'),
(37, 'krtnerzfmlkgbntlrefm;scxw', '2018-11-30 15:59:37', 'text'),
(38, '&lt;script&gt;alert(\'a\');&lt;script&gt;', '2018-12-03 18:54:41', 'text');


INSERT INTO `post` (`id`, `publication`, `user`) VALUES
(3, 5, 1),
(5, 7, 2),
(6, 8, 1),
(7, 9, 1),
(11, 13, 1),
(15, 14, 1),
(16, 15, 1),
(17, 16, 1),
(18, 17, 4),
(19, 18, 4),
(20, 19, 4),
(21, 20, 4),
(22, 21, 1),
(23, 22, 4),
(24, 23, 1),
(25, 24, 2),
(26, 25, 2),
(27, 26, 2),
(28, 27, 4),
(29, 28, 2),
(30, 29, 4),
(31, 30, 2),
(32, 31, 4),
(33, 32, 1),
(34, 33, 2),
(35, 34, 1),
(36, 35, 1),
(37, 36, 1),
(38, 37, 1),
(39, 38, 1);

--
-- Déchargement des données de la table `publications`
--


--
-- Déchargement des données de la table `users`
--


