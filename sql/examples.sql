# Billet Rouge #

INSERT INTO `test`.`jeux` (`index`, `full_titre`, `image_fond`, `couverture`, `is_public`, `description`, `main_page_url`) VALUES (NULL, 'Billet Rouge', 'images/br.jpg', 'images/br.jpg', '1', 'Billet Rouge est le troisième jeu de la collection In-vitro.


Edimbourg à l’aube du 19e siècle : en quarantaine depuis plus d’un siècle et demi, la cité cache derrière ses murs un inquiétant secret. En effet, depuis qu’une mystérieuse épidémie de peste a décimé ses habitants, la ville subit une étrange et lourde malédiction : ses enfants viennent désormais au monde avec d’effrayantes difformités…

Des citoyens isolés du reste du monde, une milice urbaine toute puissante, les débuts chaotiques de la médecine moderne, et un accès à la ville limité aux détenteurs du billet rouge constituent un lourd fardeau pour la Grande-Bretagne.

 

C’est pourquoi le gouvernement royal a crée l’Œil de Londres, une brigade secrète chargée de surveiller cette cité de la honte, et enrôlant pour ce faire les criminels les plus dangereux du pays…

Entre faits historiques troubles et fiction, le jeu de rôle uchronique Billet Rouge, gagnant de la 4e édition du concours des Démiurges en Herbe, propose aux joueurs d’incarner des agents de l’Œil de Londres. Ils devront intervenir et affronter les dangers de cette ville maudite qu’est Edimbourg sans en bouleverser l’équilibre précaire, et plus que tout, ils devront survivre à leur pire ennemi : leurs propres vices…
Grâce à un système original, baptisé Dualité, et au travers d’une fiche de personnage double-face et d’une gestion des sentiments, Billet Rouge met l’accent sur le conflit intérieur auquel devront faire face les personnages.', NULL);

#the map, pay attention to put the right index (the BRs one).

INSERT INTO `test`.`cartes` ( `index` , `id_jeu` , `name` , `image_fond` , `deco_style` , `deco_style_params` , `x_size` , `y_size` , `is_public` , `description` )
VALUES ( NULL , '3', 'Edimbourg', 'images/0_map_edinburgh_1830_large.gif', 'delfaut', '', '2500', '2029', '1', 'La ville derrière des murs.');

