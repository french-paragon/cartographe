<?php 

	class user {
	
		const VISITORRIGHTS = 0;
		const EDITORRIGHTS = 1;
		const ADMINRIGHTS = 2;
		
		protected $index;
		protected $user_name;
		protected $user_rigth;
		protected $user_mail;
		protected $user_maps;
		protected $user_psw;
		protected $IsPSWEncrypted;
		
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
		
	}

?>
