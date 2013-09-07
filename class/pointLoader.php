<?php 
	
	class pointLoader extends db {
	
		public function updatePosition($pId, $pX, $pY){
			
			if( $this->isPDOConnected() ){
				
				try {
					
					$req = $this->connection->prepare("UPDATE `points` SET 
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
	}
	
?>
