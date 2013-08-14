<?php 

	class userLoader extends db {
	
		public function getUser($puserName) {
			
			if ($this->isPDOConnected()) {
				
				$retour = null;
					
				try {
					
					$response = $this->connection->prepare('SELECT * FROM `users` WHERE `user_name` = :userName');
					$response->execute(array(':userName' => $puserName));
					
					$donnees = $response->fetchAll();
					
					if (isset($donnees[0])) {
						return new user($donnees[0]['index'], $donnees[0]['user_name'], $donnees[0]['user_right'], $donnees[0]['user_mail'], $donnees[0]['userMaps'], $donnees[0]['user_psw'], true);
					} else {
						return null;
					}
					
				}catch (PDOException $e){
					
					return false;
					
				}
				
				return $retour;
				
			} else {
			
				return false;
				
			}
			
		}
		
		public function getUsers(){
		
			if ($this->isPDOConnected()) {
				
				$retour = null;
				
				try{
					
					$response = $this->connection->query('SELECT * FROM `users`');
					
					while ($donnees = $response->fetch()) {
						$retour[$donnees['index']] = new user($donnees['index'], $donnees['user_name'], $donnees['user_right'], $donnees['user_mail'], $donnees['userMaps'],  $donnees['user_psw'], true);
					}
					
					return $retour;
					
				}catch(PDOException $e){
					return false;
				}
				
			} else {
				return false;
			}
			
		}
		
	
	}

?>
