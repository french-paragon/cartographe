CREATE TABLE IF NOT EXISTS jeux
(`index` int(11) unsigned NOT NULL auto_increment, `full_titre` text , `image_fond` text, `couverture` text, `is_public` tinyint(1), `description` text, `main_page_url` text, PRIMARY KEY  (`index`), FULLTEXT (`full_titre`, `description`))
ENGINE=MyISAM
DEFAULT CHARSET=latin1
COLLATE=latin1_general_ci
AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS cartes
(`index` int(11) unsigned NOT NULL auto_increment, `id_jeu` int(11) unsigned NOT NULL, `name` text , `image_fond` text, `deco_style` text, `deco_style_params` text, `x_size` int(11), `y_size` int(11), `is_public` tinyint(1), `description` text, PRIMARY KEY  (`index`), FULLTEXT (`name`, `description`))
ENGINE=MyISAM
DEFAULT CHARSET=latin1
COLLATE=latin1_general_ci
AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS points
(`index` int(11) unsigned NOT NULL auto_increment, `id_carte` int(11) unsigned NOT NULL, `model` text , `model_params` text, `media_id` int(11) unsigned NOT NULL, `media_type` text, `x_size` int(11), `y_size` int(11), `x_pos` int(11), `y_pos` int(11), `is_public` tinyint(1), `description` text, PRIMARY KEY  (`index`), FULLTEXT (`description`))
ENGINE=MyISAM
DEFAULT CHARSET=latin1
COLLATE=latin1_general_ci
AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS medias
(`index` int(11) unsigned NOT NULL auto_increment, `media_type` text, `media_url` text, `media_params` text, `description` text, PRIMARY KEY  (`index`), FULLTEXT (`description`))
ENGINE=MyISAM
DEFAULT CHARSET=latin1
COLLATE=latin1_general_ci
AUTO_INCREMENT=1;
