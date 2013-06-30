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

#get map points with index

SELECT pt.`index` , pt.`model` , pt.`model_params` , pt.`media_id` , pt.`media_type` , pt.`x_size` , pt.`y_size` , pt.`x_pos` , pt.`y_pos` , pt.`is_public` , pt.`description`
FROM cartes AS ca
LEFT JOIN `test`.`points` AS pt ON ca.`index` = pt.`id_carte`
WHERE ca.`index` = 3

#get map points with title

SELECT pt.`index` , pt.`model` , pt.`model_params` , pt.`media_id` , pt.`media_type` , pt.`x_size` , pt.`y_size` , pt.`x_pos` , pt.`y_pos` , pt.`is_public` , pt.`description`
FROM cartes AS ca
LEFT JOIN `test`.`points` AS pt ON ca.`index` = pt.`id_carte`
WHERE ca.`name` = "Chez Gusteau"

