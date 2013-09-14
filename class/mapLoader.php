<?php 

	class mapLoader extends db {
		
		public function getGameNameList() {
		
			if( $this->isPDOConnected() ){
				
				$retour = array();
				
				try {
				
					$response = $this->connection->query('SELECT `full_titre` FROM `jeux` ORDER BY `full_titre`');
					
					$i = 0;
					
					while ($donnees = $response->fetch()) {
							
						$retour[$i] = $donnees['full_titre'];
						$i++;
						
					}
					
				}catch (PDOException $e){
					
					return false;
					
				}
				
				return $retour;
				
			}else
				return null;
			
		}
	
		public function getMapsList() {
			
			if ($this->isPDOConnected()) {
				
				$retour = array();
					
				try {
					
					$response = $this->connection->query('SELECT ca.`index` , ga.`full_titre`, ca.`name` , ca.`image_fond` , ca.`deco_style`, ca.`deco_style_params` , ca.`x_size` , ca.`y_size` , ca.`is_public` , ca.`description` FROM '.$this->dbPrefix.'cartes AS ca LEFT JOIN `'.$this->dbPrefix.'jeux` AS ga ON ca.`id_jeu` = ga.`index`');


					while ($donnees = $response->fetch()) {
						
						$retour[$donnees['full_titre']][$donnees['index']] = new carte($donnees['index'], $donnees['name'], $donnees['image_fond'], $donnees['deco_style'], $donnees['deco_style_params'], $donnees['x_size'], $donnees['y_size'], $donnees['description'], $donnees['is_public'], $donnees['full_titre']);
						
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
					
					$retour = new carte($donnees['index'], $donnees['name'], $donnees['image_fond'], $donnees['deco_style'], $donnees['deco_style_params'], $donnees['x_size'], $donnees['y_size'], $donnees['description'], $donnees['is_public'], $donnees['full_titre']);
					
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
						$retour[$i]->setWidth(intval($donnees['x_size']));
						$retour[$i]->setHeigth(intval($donnees['y_size']));
						$retour[$i]->setDescription($donnees['description']);
						$i++;
						
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
					
					$retour = new carte($donnees['index'], $donnees['name'], $donnees['image_fond'], $donnees['deco_style'], $donnees['deco_style_params'], $donnees['x_size'], $donnees['y_size'], $donnees['description'], $donnees['is_public'], $donnees['full_titre']);
					
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
		
		public function updateMap(carte &$pMap){
		
			if( $this->isPDOConnected() ){
				
				$iPub = ($pMap->isPublic()) ? 1 : 0 ;
				
				try {
					
					$req = $this->connection->prepare("SELECT `index` FROM `".$this->dbPrefix."jeux` WHERE `full_titre` = :gName LIMIT 1");
					
					$req->execute(array(':gName' => $pMap->getGameName()));
					
					if($req->rowCount() == 0){
					
						$req = $this->connection->prepare("INSERT INTO `".$this->dbPrefix."jeux`
						(`full_titre`) VALUES (:gName)");
						$req->execute(array(':gName' => $pMap->getGameName()));
						
					}
					
					$req = $this->connection->prepare("UPDATE `".$this->dbPrefix."cartes` SET `name` = :name,
					`id_jeu` = (SELECT `index` FROM `".$this->dbPrefix."jeux` WHERE `full_titre` = :gName LIMIT 1),
					`image_fond` = :imageF,
					`deco_style` = :decoS,
					`deco_style_params` = :decoSP,
					`x_size` = :xS,
					`y_size` = :yS,
					`is_public` = :iP,
					`description` = :descr 
					
					WHERE `".$this->dbPrefix."cartes`.`index` = :id;");
					
					$req->execute(array( 
					
					':name' => prepareSave($pMap->getName()),
					':gName' => prepareSave($pMap->getGameName()),
					':imageF' => prepareSave($pMap->getImageFond()),
					':decoS' => prepareSave($pMap->getDecoStyle()),
					':decoSP' => prepareSave($pMap->getDecoStyleParams()),
					':xS' => prepareSave($pMap->getXsize()),
					':yS' => prepareSave($pMap->getYsize()),
					':iP' => $iPub,
					':descr' => prepareSave($pMap->getDescription()),
					':id' => prepareSave($pMap->getId())
					 
					));
					
					if($req->rowCount() > 0)
						return true;
					else
						return false;
					
				}catch (PDOException $e){
					return false;
				}
				
			}
			
			return false;
			
		}
		
		public function registerMap(carte &$pMap){
		
			if( $this->isPDOConnected() ){
				
				$iPub = ($pMap->isPublic()) ? 1 : 0 ;
		
				try {
					
					$req = $this->connection->prepare("INSERT INTO `".$this->dbPrefix."cartes` 
					(`id_jeu`, `name`, `image_fond`, `deco_style`, `deco_style_params`, `x_size`, `y_size`, `is_public`, `description`) 
					VALUES 
					(1, :name, :imageF, :decoS, :decoSP, :xS, :yS, :iP, :descr);");
					
					$req->execute(array( 
					
					':name' => prepareSave($pMap->getName()),
					':imageF' => prepareSave($pMap->getImageFond()),
					':decoS' => prepareSave($pMap->getDecoStyle()),
					':decoSP' => prepareSave($pMap->getDecoStyleParams()),
					':xS' => prepareSave($pMap->getXsize()),
					':yS' => prepareSave($pMap->getYsize()),
					':iP' => $iPub,
					':descr' => prepareSave($pMap->getDescription())
					 
					));
					
					$req = $this->connection->query('SELECT LAST_INSERT_ID();');
					
					$ret = $req->fetch();
					
					$pMap = $this->getMapWithID($ret['LAST_INSERT_ID()']);
					
					return true;
					
				}catch (PDOException $e){
					return false;
				}
			}
		}
	
		public function deleteIndex($index){
		
			if( $this->isPDOConnected() ){
		
				try {
					
					$req = $this->connection->prepare("DELETE FROM `".$this->dbPrefix."cartes` WHERE `index` = :index");
					
					$req->execute(array( 
					
					':index' => $index
					 
					));
					
					if($req->rowCount() > 0)
						return true;
					else
						return false;
					
				}catch (PDOException $e){
					return false;
				}
			}
			
		}
	
	}

?>
