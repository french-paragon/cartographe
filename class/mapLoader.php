<?php 

	class mapLoader extends db {
	
		getMapsList() {
			
			if ($this->isPDOConnected()) {
				
				try {
					
					$response = $this->connection->query('SELECT `jeux`.`full_titre` AS gTitle,`'.$this->dbPrefix.'cartes`.`name` AS mapName,`'.$this->dbPrefix.'cartes`.`image_fond` AS fImage,`'.$this->dbPrefix.'cartes`.`deco_style` AS decoStyle,`'.$this->dbPrefix.'cartes`.`x_size` AS xSize,`'.$this->dbPrefix.'cartes`.`y_size` AS ySize,`'.$this->dbPrefix.'cartes`.`is_public` AS isPublic,`'.$this->dbPrefix.'cartes`.`description` AS description,`'.$this->dbPrefix.'cartes`.`index` AS index FROM '.$this->dbPrefix.'jeux AS jeux
LEFT JOIN `'.$this->dbName.'`.`'.$this->dbPrefix.'cartes` ON `'.$this->dbPrefix.'jeux`.`index` = `'.$this->dbPrefix.'cartes`.`id_jeu`');

					$retour = array();

					while ($donnees = $reponse->fetch();) {
						
						$retour[$donnees['gTitle']]['index'] = new carte($donnees['mapName'], $donnees['fImage'], $donnees['decoStyle'], $donnees['xSize'], $donnees['ySize'], $donnees['description'], $donnees['isPublic']);
						
					}
					
				}catch (PDOException $e){
					
					return false;
					
				}
				
				return $retour;
				
			} else {
			
				return false;
				
			}
			
		}
		
	
	}

?>
