--
-- Structure de la table `jeux`
--

CREATE TABLE IF NOT EXISTS `jeux` (
  `index` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full_titre` text COLLATE latin1_general_ci,
  `image_fond` text COLLATE latin1_general_ci,
  `couverture` text COLLATE latin1_general_ci,
  `is_public` tinyint(1) DEFAULT NULL,
  `description` text COLLATE latin1_general_ci,
  `main_page_url` text COLLATE latin1_general_ci,
  PRIMARY KEY (`index`),
  FULLTEXT KEY `full_titre` (`full_titre`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `cartes`
--

CREATE TABLE IF NOT EXISTS `cartes` (
  `index` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_jeu` int(11) unsigned NOT NULL,
  `name` text COLLATE latin1_general_ci,
  `image_fond` text COLLATE latin1_general_ci,
  `deco_style` text COLLATE latin1_general_ci,
  `deco_style_params` text COLLATE latin1_general_ci NOT NULL,
  `x_size` int(11) DEFAULT NULL,
  `y_size` int(11) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  `description` text COLLATE latin1_general_ci,
  PRIMARY KEY (`index`),
  FULLTEXT KEY `name` (`name`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `points`
--

CREATE TABLE IF NOT EXISTS `points` (
  `index` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_carte` int(11) unsigned NOT NULL,
  `model` text COLLATE latin1_general_ci,
  `model_params` text COLLATE latin1_general_ci NOT NULL,
  `x_size` int(11) DEFAULT NULL,
  `y_size` int(11) DEFAULT NULL,
  `x_pos` int(11) DEFAULT NULL,
  `y_pos` int(11) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  `description` text COLLATE latin1_general_ci,
  PRIMARY KEY (`index`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `index` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` text COLLATE latin1_general_ci,
  `user_right` int(11) unsigned DEFAULT NULL,
  `user_mail` text COLLATE latin1_general_ci,
  `userMaps` text COLLATE latin1_general_ci,
  `user_psw` text COLLATE latin1_general_ci,
  PRIMARY KEY (`index`),
  FULLTEXT KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
