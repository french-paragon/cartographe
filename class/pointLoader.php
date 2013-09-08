<?php 
	
	class pointLoader extends db {
	
		public function updatePosition($pId, $pX, $pY){
			
			if( $this->isPDOConnected() ){
				
				try {
					
					$req = $this->connection->prepare("UPDATE `".$this->dbPrefix."points` SET 
					`x_pos` = :x, 
					`y_pos` = :y 
					
					WHERE `points`.`index` = :id;");
					
					$req->execute([ 
						
						':x' => $pX,
						':y' => $pY,
						':id' => $pId
						 
					]);
					
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
					
					$req->execute([ 
					
					':idM' => $pPoint->getID(),
					':model' => point::DELFAUTMODELNAME,
					':modelP' => $pPoint->getStringModelParam(),
					':xS' => $pPoint->getWidth(),
					':yS' => $pPoint->getHeigth(),
					':xP' => $pPoint->getX(),
					':yP' => $pPoint->getY(),
					':descr' => $pPoint->getDescription()
					 
					]);
					
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
		
		public function deleteIndex($index){
		
			if( $this->isPDOConnected() ){
		
				try {
					
					$req = $this->connection->prepare("DELETE FROM `".$this->dbPrefix."points` WHERE `index` = :index");
					
					$req->execute([ 
					
					':index' => $index
					 
					]);
					
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
