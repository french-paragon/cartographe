<?php 

	class userLoader extends db {
	
		public function getUser($puserName) {
			
			if ($this->isPDOConnected()) {
				
				$retour = null;
					
				try {
					
					$response = $this->connection->prepare('SELECT * FROM `users` WHERE `user_name` = :userName');
					$response->execute(array(':userName' => $puserName));
					
					$donnees = $response->fetchAll();
					
					return new user($donnees[0]['index'], $donnees[0]['user_name'], $donnees[0]['user_right'], $donnees[0]['user_mail'], $donnees[0]['userMaps'], $donnees[0]['user_psw'], true);
						
					
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
