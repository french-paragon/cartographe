#Get all maps description with games infos

SELECT ca.`index` , ga.`full_titre` , ga.`index` AS gIndex, ca.`name` , ca.`image_fond` , ca.`deco_style` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description`
FROM cartes AS ca
LEFT JOIN `test`.`jeux` AS ga ON ca.`id_jeu` = ga.`index`

#get map info with id

SELECT ca.`index` , ga.`full_titre` , ga.`index` AS gIndex, ca.`name` , ca.`image_fond` , ca.`deco_style` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description`
FROM cartes AS ca
LEFT JOIN `test`.`jeux` AS ga ON ca.`id_jeu` = ga.`index`
WHERE ca.`index` =1

#get map info with title

SELECT ca.`index` , ga.`full_titre` , ga.`index` AS gIndex, ca.`name` , ca.`image_fond` , ca.`deco_style` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description`
FROM cartes AS ca
LEFT JOIN `test`.`jeux` AS ga ON ca.`id_jeu` = ga.`index`
WHERE ca.`name` = "Chez Gusteau"

#seek in maps

SELECT ca.`index` , ga.`full_titre` , ga.`index` AS gIndex, ca.`name` , ca.`image_fond` , ca.`deco_style` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description`
FROM cartes AS ca
LEFT JOIN `test`.`jeux` AS ga ON ca.`id_jeu` = ga.`index`
WHERE MATCH (ca.`name`,ca.`description`) AGAINST ('des rats gusteau')
