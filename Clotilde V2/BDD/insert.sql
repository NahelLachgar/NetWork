INSERT INTO `users` VALUES ('1', 'Charavit', 'Clotilde', 'ccharavit@intechinfo.fr', '0678434561', '', 'naruto', 'employee', 'Docteur', 'Hôpital Antony', 'Antony');
INSERT INTO `users` VALUES ('2', 'Lasserre', 'Anthony', 'lasserre@intechinfo.fr', '0634681289', '', 'truc', 'employee', 'Ingénieur informatique', 'Thalès', 'Noisiel');
INSERT INTO `users` VALUES ('3', 'Chirabitsu', 'Ukumy123', 'cloclote@gmail.com', '0614757455', '', '123', 'employee', 'Bénévole', 'SPA', 'Paris');
INSERT INTO `users` VALUES ('4', 'La', 'SPA', 'la-spa@gmail.com', '0608567832', '', '123', 'company', 'Association', 'SPA', 'Paris');

INSERT INTO `contacts` VALUES ('1', '1', '2');
INSERT INTO `contacts` VALUES ('2', '1', '3');
INSERT INTO `contacts` VALUES ('3', '2', '1');
INSERT INTO `contacts` VALUES ('4', '3', '1');
INSERT INTO `contacts` VALUES ('5', '2', '3');
INSERT INTO `contacts` VALUES ('6', '3', '2');

INSERT INTO `privateMessages` VALUES ('1', 'Bonjour', '1', '2018-11-19 08:30:07');
INSERT INTO `privateMessages` VALUES ('2', 'Hello', '1', '2018-11-19 08:33:34');
INSERT INTO `privateMessages` VALUES ('3', 'Konnichiwa', '2', '2018-11-19 08:48:28');
INSERT INTO `privateMessages` VALUES ('4', 'Guten tag', '3', '2018-11-19 09:02:11');

INSERT INTO `sendPrivate` VALUES ('1', '1', '2', '1');
INSERT INTO `sendPrivate` VALUES ('2', '1', '3', '2');
INSERT INTO `sendPrivate` VALUES ('3', '2', '1', '3');
INSERT INTO `sendPrivate` VALUES ('4', '3', '1', '4');

INSERT INTO `events` VALUES ('1', 'Fête de Noël', '2018-12-25 00:00:00', '7 rue Leclerc 92108 Paris', '1');

INSERT INTO `participate` VALUES ('1', '1', '1');
INSERT INTO `participate` VALUES ('2', '2', '1');

INSERT INTO `groups` VALUES ('1', 'Les bras cassés', '2018-11-18', '3');

INSERT INTO `groupAdd` VALUES ('1', '', '2018-11-19 08:12:45', '3', 'member', '1');
INSERT INTO `groupAdd` VALUES ('2', '', '2018-11-19 08:40:58', '1', 'member', '1');
INSERT INTO `groupAdd` VALUES ('3', 'Tu veux bien être mon ami ?', '2018-11-19 08:56:12', '2', 'message', '1');

INSERT INTO `publications` VALUES ('1', 'Je te ferais dire, omg = Om mon dieu. Hum, bizarre.', '2018-11-19 09:22:43');
INSERT INTO `publications` VALUES ('2', 'Sacrée Clotilde, toujours le mot pour rire !', '2018-11-19 09:26:05');
INSERT INTO `publications` VALUES ('3', 'ET MON Q, C DU POULET ?!', '2018-11-19 09:35:55');
INSERT INTO `publications` VALUES ('4', 'TROP LOLOLOLOL', '2018-11-19 09:55:10');

INSERT INTO `post` VALUES ('1', '1', '1');
INSERT INTO `post` VALUES ('2', '2', '2');
INSERT INTO `post` VALUES ('3', '3', '2');
INSERT INTO `post` VALUES ('4', '4', '3');

INSERT INTO `coms` VALUES ('1', 'xD', '2018-11-19 09:37:36', '1');
INSERT INTO `coms` VALUES ('2', 'Tu es bête ou tu le fais exprès ?', '2018-11-19 09:08:58', '2');
INSERT INTO `coms` VALUES ('3', 'Tu exagères...', '2018-11-19 09:49:23', '3');
INSERT INTO `coms` VALUES ('4', 'M-mais euh... :(', '2018-11-19 09:53:49', '1');
INSERT INTO `coms` VALUES ('5', 'OUI !', '2018-11-19 09:57:11', '2');
INSERT INTO `coms` VALUES ('6', 'AH !', '2018-11-19 10:11:07', '3');
INSERT INTO `coms` VALUES ('7', 'Mais MDR QUOI', '2018-11-19 10:22:13', '1');

INSERT INTO `comment` VALUES ('1', '1', '2');
INSERT INTO `comment` VALUES ('2', '2', '1');
INSERT INTO `comment` VALUES ('3', '3', '1');
INSERT INTO `comment` VALUES ('4', '4', '1');
INSERT INTO `comment` VALUES ('5', '5', '3');
INSERT INTO `comment` VALUES ('6', '6', '3');
INSERT INTO `comment` VALUES ('7', '7', '4');