<?php 
	
	class pointLoader extends db {
	
		public function updatePosition($pId, $pX, $pY){
			
			if( $this->isPDOConnected() ){
				
				try {
					
					$req = $this->connection->prepare("UPDATE `".$this->dbPrefix."points` SET 
					`x_pos` = :x, 
					`y_pos` = :y 
					
					WHERE `points`.`index` = :id;");
					
					$req->execute(array( 
						
						':x' => $pX,
						':y' => $pY,
						':id' => $pId
						 
					));
					
					return true;
				
				}catch (PDOException $e){
					return false;
				}
			} else {
				return false;
			}
			
		}
		
		public function registerPoint(point &$pPoint){
			
			if( $this->isPDOConnected() ){
				
				try {
					
					$req = $this->connection->prepare("INSERT INTO `".$this->dbPrefix."points` 
					(`id_carte`, `model`, `model_params`, `x_size`, `y_size`, `x_pos`, `y_pos`, `is_public`, `description`) 
					VALUES 
					(:idM, :model, :modelP, :xS, :yS, :xP, :yP, 0, :descr);");
					
					$req->execute(array( 
					
					':idM' => prepareSave($pPoint->getID()),
					':model' => point::DELFAUTMODELNAME,
					':modelP' => prepareSave($pPoint->getStringModelParam()),
					':xS' => prepareSave($pPoint->getWidth()),
					':yS' => prepareSave($pPoint->getHeigth()),
					':xP' => prepareSave($pPoint->getX()),
					':yP' => prepareSave($pPoint->getY()),
					':descr' => prepareSave($pPoint->getDescription())
					 
					));
					
					$req = $this->connection->query("SELECT `index`, `model`, `model_params`, `x_size`, `y_size`, `x_pos`, `y_pos`, `is_public`, `description` 
					FROM `".$this->dbPrefix."points` WHERE `index` = LAST_INSERT_ID()");
					
					$donnees = $req->fetch();
					
					$pPoint = new point($donnees['x_pos'].','.$donnees['y_pos'],  $donnees['model'] , $donnees['model_params'], $donnees['index']);
						$pPoint->setWidth(intval($donnees['x_size']));
						$pPoint->setHeigth(intval($donnees['y_size']));
						$pPoint->setDescription($donnees['description']);
						
					return true;
					
				} catch (PDOException $e) {
					return false;
				}
				
			} else return false;
			
		}
		
		public function updatePoint(point &$pPoint){
		
			if( $this->isPDOConnected() ){
				
				try {
					
					$req = $this->connection->prepare("UPDATE `".$this->dbPrefix."points` SET
					`model` = :model, 
					`model_params` = :modelP, 
					`x_size` = :xS, 
					`y_size` = :yS, 
					`x_pos` = :xP, 
					`y_pos` = :yP,
					`description` = :descr
					
					WHERE `index` = :idM;");
					
					$req->execute(array( 
					
					':idM' => prepareSave($pPoint->getID()),
					':model' => prepareSave($pPoint->getModelName()),
					':modelP' => prepareSaveSoft($pPoint->getStringModelParam()),
					':xS' => prepareSave($pPoint->getWidth()),
					':yS' => prepareSave($pPoint->getHeigth()),
					':xP' => prepareSave($pPoint->getX()),
					':yP' => prepareSave($pPoint->getY()),
					':descr' => prepareSave($pPoint->getDescription())
					 
					));
						
					if($req->rowCount() > 0)
						return true;
					else
						return false;
					
				} catch (PDOException $e) {
					return false;
				}
				
			} else return false;
			
		}
		
		public function deleteIndex($index){
		
			if( $this->isPDOConnected() ){
		
				try {
					
					$req = $this->connection->prepare("DELETE FROM `".$this->dbPrefix."points` WHERE `index` = :index");
					
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
		
		public function getPointWithID($pId){
				
			$retour = null;
		
			if( $this->isPDOConnected() ){
				
				try {
					
					$req = $this->connection->prepare('SELECT * FROM `points` WHERE `index` = :index LIMIT 1');
					$req->execute(array(':index' => $pId));
					
					$donnees = $req->fetch();
					
					$retour = new point($donnees['x_pos'].','.$donnees['y_pos'],  $donnees['model'] , $donnees['model_params'], $donnees['index']);
					$retour->setWidth(intval($donnees['x_size']));
					$retour->setHeigth(intval($donnees['y_size']));
					$retour->setDescription($donnees['description']);
					
					return $retour;
					
				}catch (PDOException $e){
					
					return null;
					
				}
				
			} else {
			
				return null;
				
			}
			
		}
		
	}
	
?>
