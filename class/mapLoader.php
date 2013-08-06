<?php 

	class mapLoader extends db {
	
		public function getMapsList() {
			
			if ($this->isPDOConnected()) {
				
				$retour = array();
					
				try {
					
					$response = $this->connection->query('SELECT ca.`index` , ga.`full_titre`, ca.`name` , ca.`image_fond` , ca.`deco_style`, ca.`deco_style_params` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description` FROM '.$this->dbPrefix.'cartes AS ca LEFT JOIN `'.$this->dbPrefix.'jeux` AS ga ON ca.`id_jeu` = ga.`index`');


					while ($donnees = $response->fetch()) {
						
						$retour[$donnees['full_titre']][$donnees['index']] = new carte($donnees['index'], $donnees['name'], $donnees['image_fond'], $donnees['deco_style'], $donnees['deco_style_params'], $donnees['x_size'], $donnees['y_size'], $donnees['description'], $donnees['is_public']);
						
					}
					
				}catch (PDOException $e){
					
					return false;
					
				}
				
				return $retour;
				
			} else {
			
				return false;
				
			}
			
		}
		
		public function getMapWithID ($pID) {
			
			if ($this->isPDOConnected()) {
				
				$retour = null;
				
				try {
					
					$response = $this->connection->query('SELECT ca.`index` , ga.`full_titre`, ca.`name` , ca.`image_fond` , ca.`deco_style`, ca.`deco_style_params` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description` FROM '.$this->dbPrefix.'cartes AS ca LEFT JOIN `'.$this->dbPrefix.'jeux` AS ga ON ca.`id_jeu` = ga.`index` WHERE ca.`index` = '.$pID.'');
					
					$donnees = $response->fetch();
					
					$retour = new carte($donnees['index'], $donnees['name'], $donnees['image_fond'], $donnees['deco_style'], $donnees['deco_style_params'], $donnees['x_size'], $donnees['y_size'], $donnees['description'], $donnees['is_public']);
					
				}catch (PDOException $e){
					
					return false;
					
				}
				
				$pts = $this->getMapPoints($pID);
				$retour->setPoints($pts);
				
				return $retour;
				
			}
			
			else {
				return false;
			}
			
		}
		
		public function getMapPoints($pId){
			
			if ($this->isPDOConnected()) {
				
				$retour = null;
				
				try {
				
					$retour = array();
					$i = 0;
					
					$response = $this->connection->query('SELECT * FROM `points` WHERE `id_carte` = '.$pId);
					
					$donnees;
					
					while($donnees = $response->fetch()){
					
						$retour[$i] = new point($donnees['x_pos'].','.$donnees['y_pos'],  $donnees['model'] , $donnees['model_params'], $donnees['index']);
						
					}
					
					return $retour;
					
				}catch (PDOException $e){
					
					return null;
					
				}
				
			} else {
			
				return null;
				
			}
			
		}
		
		public function getMapWithName ($pName) {
			
			if ($this->isPDOConnected()) {
				
				$retour = null;
				
				try {
					
					$response = $this->connection->query('SELECT ca.`index` , ga.`full_titre`, ca.`name` , ca.`image_fond` , ca.`deco_style`, ca.`deco_style_params` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description` FROM '.$this->dbPrefix.'cartes AS ca LEFT JOIN `'.$this->dbPrefix.'jeux` AS ga ON ca.`id_jeu` = ga.`index` WHERE ca.`name` = "'.$pName.'"');
					
					$donnees = $response->fetch();
					
					$retour = new carte($donnees['index'], $donnees['name'], $donnees['image_fond'], $donnees['deco_style'], $donnees['deco_style_params'], $donnees['x_size'], $donnees['y_size'], $donnees['description'], $donnees['is_public']);
					
				}catch (PDOException $e){
					
					return false;
					
				}
				
				$pts = $this->getMapPoints($donnees['index']);
				$retour->setPoints($pts);
				
				return $retour;
				
			}
			
			else {
				return false;
			}
			
		}
		
	
	}

?>
