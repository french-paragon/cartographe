<?php 

	class user {
	
		const VISITORRIGHTS = 0;
		const EDITORRIGHTS = 1;
		const ADMINRIGHTS = 2;
		
		const FORMLARGNESS = 300;
		
		protected $index;
		protected $user_name;
		protected $user_rigth;
		protected $user_mail;
		protected $user_maps;
		protected $user_psw;
		protected $IsPSWEncrypted;
		
		static private $rigthsAlias = array( 'visiteur' => self::VISITORRIGHTS, 'editeur' => self::EDITORRIGHTS, 'administrateur' => self::ADMINRIGHTS);
		static private $rigthsNames = array (self::VISITORRIGHTS => 'visiteur', self::EDITORRIGHTS => 'editeur', self::ADMINRIGHTS => 'administrateur' );
		
		private $sessionMessages = array( 
		self::VISITORRIGHTS => 'Bienvenue, vous pouvez retournez à la <a href="carte.php">page de sélection des cartes</a>.',
		self::EDITORRIGHTS => 'Bienvenue, vous pouvez retournez à la <a href="admin.php">page d\'administration</a>.',
		self::ADMINRIGHTS => 'Bienvenue, vous pouvez retournez à la <a href="admin.php">page d\'administration</a>.');
		
		public function __construct($pI, $pUN, $pR, $pML, $pMP, $pPSW, $EctPSW = false){
		
			$this->index = $pI;
			$this->user_name = $pUN;
			$this->user_rigth = intval($pR);
			$this->user_mail = $pML;
			$this->user_maps = $pMP;
			$this->user_psw = $pPSW;
			$this->IsPSWEncrypted = $EctPSW;
		
		}
		
		public function drawEditor() {
			
			$htmltext = '<iframe src="ajax/saveUser.php" width="100%" height="40" name="saveFrame" id="saveFrame" frameborder="0"></iframe><br>';
			
			$htmltext .= '<br><form method="post" action="ajax/saveUser.php?user='.$this->index.'" target="saveFrame" accept-charset=\"UTF-8\">
			<fieldset><legend>Informations de base:</legend><br>
			<label for="username">Nom d\'utilisateur: </label><input type="text" id="username" name="username" width="'.self::FORMLARGNESS.'" value="'.$this->getName().'"><br><br>
			<label for="usermail">Adresse mail: </label><input type="text" id="usermail" name="usermail" width="'.self::FORMLARGNESS.'" value="'.$this->getMail().'"><br><br>
			</fieldset><br>
			<fieldset><legend>Droits:</legend><br>
			<label for="userrigths">Droits: </label><input id="userrigths" name="userrigths" list="'.$this->index.'list" type="text" width="'.self::FORMLARGNESS.'" value="'.self::$rigthsNames[$this->user_rigth].'" ><br><br>
			<datalist id="'.$this->index.'list">';
				
			foreach(self::$rigthsNames as $name){
						
				$htmltext .= '<option value="'.$name.'">';
						
			}
				
			$htmltext .= '</datalist>
			
			<label for="mapsList">accès au cartes suivantes:</label><br><br>
			<textarea id="mapsList" name="mapsList" style="height: 150px; width: '.(self::FORMLARGNESS*3).'px ;">'.$this->getMaps().'</textarea>
			</fieldset>
			<div align="right"><br><input type="submit" name="baseDatas" id="baseDatas" value="Sauver les changements"></div></form><br>';
			
			$htmltext .= '<form method="post" action="ajax/saveUser.php?user='.$this->index.'" target="saveFrame" accept-charset=\"UTF-8\" autocomplete="off">
			<fieldset><legend>Changer le mot de passe:</legend><br>
			<label for="olUsPsw">Ancien mot de passe: </label><input type="password" id="olUsPsw" name ="olUsPsw" width="'.self::FORMLARGNESS.'" value=""><br><br>
			<label for="newUsPsw">Nouveau mot de passe: </label><input type="password" id="newUsPsw" name ="newUsPsw" width="'.self::FORMLARGNESS.'" ><br><br>
			<label for="newUsPswrep">Répéter le nouveau mot de passe: </label><input type="password" id="newUsPswrep" name ="newUsPswrep" width="'.self::FORMLARGNESS.'" ><br><br>
			</fieldset><br>
			<div align="right"><input type="submit" name="pswDatas" id="pswDatas" value="Changer le mot de passe."></div></form><br>';
			
			return $htmltext;
		}
		
		public function encryptPSW() {
		
			if(!$this->IsPSWEncrypted){
				$this->user_psw = crypt($this->user_psw, '$2a$07'.md5($this->user_psw).'$');
				$this->IsPSWEncrypted = true;
			}
			
		}
		
		public function getIndex() {
			return $this->index;
		}
		
		public function getName() {
			return $this->user_name;
		}
		
		public function getRigth() {
			return $this->user_rigth;
		}
		
		public function getMail() {
			return $this->user_mail;
		}
		
		public function getPSW(){
			
			if(!$this->IsPSWEncrypted){
				$this->encryptPSW();
			}
			
			return $this->user_psw;
			
		}
		
		public function PSWMatch($pPsw){
			
			if(!$this->IsPSWEncrypted){
				$this->encryptPSW();
			}
			
			return $this->user_psw == crypt($pPsw, '$2a$07'.md5($pPsw).'$');
			
		}
		
		public function getMaps() {
			if(is_array($this->user_maps))
				return implode(',', $this->user_maps);
			else
				return $this->user_maps;
		}
		
		public function asRigthOnMap($pMapName){
			
			if (is_string($this->user_maps)){
				$this->user_maps = explode($this->user_maps, ',');
			}
			
			return in_array($pMapName, $this->user_maps);
			
		}
		
		public function getSessionOpenMessage() {
				return $this->sessionMessages[$this->user_rigth];
		}
		
		static public function getRigthsAlias() { return self::$rigthsAlias; }
		
	}

?>
