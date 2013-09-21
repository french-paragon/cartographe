<?php 

	class userLoader extends db {
	
		public function getUser($puserName) {
			
			if ($this->isPDOConnected()) {
				
				$retour = null;
					
				try {
					
					$response = $this->connection->prepare('SELECT * FROM `'.$this->dbPrefix.'users` WHERE `user_name` = :userName');
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
		
		public function getUserWithId($puserId){
		
			if ($this->isPDOConnected()) {
				
				$retour = null;
					
				try {
					
					$response = $this->connection->prepare('SELECT * FROM `'.$this->dbPrefix.'users` WHERE `index` = :userid');
					$response->execute(array(':userid' => $puserId));
					
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
					
					$response = $this->connection->query('SELECT * FROM `'.$this->dbPrefix.'users`');
					
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
		
		public function registerUser(user &$pUser){
		
			if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {
				
				if($this->isPDOConnected()) {
					
					try {
						
						$req = $this->connection->prepare("INSERT INTO `".$this->dbPrefix."users` (
							`user_name` ,
							`user_right` ,
							`user_mail` ,
							`userMaps` ,
							`user_psw`
							)
							VALUES (
							:usrName, :userRight, :userMail, :userMaps , :userPSW
						);");
						
						$req->execute(array(
						
							':usrName' => $pUser->getName(),
							':userRight' => $pUser->getRigth(),
							':userMail' => $pUser->getMail(),
							':userMaps' => $pUser->getMaps(),
							':userPSW' => $pUser->getPSW()
						
						));
					
						$req = $this->connection->query('SELECT LAST_INSERT_ID();');
					
						$ret = $req->fetch();
					
						$pUser = $this->getUserWithId($ret['LAST_INSERT_ID()']);
						
						return true;
						
					}catch(PDOException $e){
						return false;
					}
					
				} else return false;
				
			} else return false;
		}
		
		public function upDateUserPSW($pId, $oldPSW, $newPSW){
			
			if($this->isPDOConnected()) {
					
				try {
						
					$req = $this->connection->prepare("UPDATE `".$this->dbPrefix."users` SET
					`user_psw` = :npsw
					WHERE `index` = :userid AND `user_psw` = :opsw");
						
					$req->execute(array(
						
						':userid' => $pId,
						':opsw' => $oldPSW,
						':npsw' => $newPSW
						
					));
					
					if($req->rowCount() > 0)
						return true;
					else
						return false;
						
				}catch(PDOException $e){
					return false;
				}
					
			} else return false;
				
		}
		
		public function updateBaseInfos($pId, $pUn, $pUm, $pUr, $pMl){
		
			if($this->isPDOConnected()) {
					
				try {
						
					$req = $this->connection->prepare("UPDATE `".$this->dbPrefix."users` SET
					`user_name` = :uname,
					`user_right` = :urigths,
					`user_mail` = :umail,
					`userMaps` = :mlist
					WHERE `index` = :userid;");
						
					$req->execute(array(
						
						':userid' => intval($pId),
						':uname' => prepareSaveSoft($pUn),
						':umail' => prepareSaveSoft($pUm),
						':urigths' => intval($pUr),
						':mlist' => prepareSaveSoft($pMl)
						
					));
					
					if($req->rowCount() > 0)
						return true;
					else
						return false;
						
				}catch(PDOException $e){
					return false;
				}
					
			} else return false;
			
		}
		
	
	}

?>
