<?php 

	class db 
	{
		
		protected $dbName;
		protected $dbHost;
		protected $dbUser;
		protected $dbPsw;
		protected $dbPrefix;
		
		protected $connection;
		
		public function __construct($pdbName, $pdbHost, $pdbUser, $pdbPsw, $pdbPrefix) {
			
			$this->dbName = $pdbName;
			$this->dbHost = $pdbHost;
			$this->dbUser = $pdbUser;
			$this->dbPsw = $pdbPsw;
			$this->dbPrefix = $pdbPrefix;
			
		}
		
		public function isReady() {
		
			if ($this->dbName != null AND $this->dbHost != null AND $this->dbUser != null AND $this->dbPsw != null) {
			
				return true;
				
			} else {
			
				return false;
				
			}
			
		}
		
		public function isPDOConnected(){
		
			if (get_class($this->connection) == "PDO") {
				return true;
			}else {
				return false;
			}
			
		}
		
		public function connectPDO() {
			
			if ($this->isReady()) {
			
				try {
					$this->connection = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName, $this->dbUser, $this->dbPsw);
				} catch (PDOException $e) {
					echo "Erreur !: " . $e->getMessage() . "<br/>";
					return false;
				}
				
				return true;
				
			}
			else {
				return false;
			}
			
		}
		
		public function disconnect() {
				$this->connection = null;
		}
		
		public function setParams($pName, $pHost, $pUser, $pPsw, $pPrefix) { //change les paramètre sauf s'ils sont spécifiés comme étant null
			
			if ($pName != null) {
				$this->dbName = $pName;
			}
			if ($pHost != null) {
				$this->dbHost = $pHost;
			}
			if ($pUser != null){
				$this->dbUser = $pUser;
			}
			if ($pPsw != null){
				$this->dbPsw = $pPsw;
			}
			if($pPrefix != null) {
				$this->dbPrefix = $pPrefix;
			}
			
		}
		
		public function setName($pName){
			$this->dbName = $pName;
		}
		
		public function setHost($pHost){
			$this->dbHost = $pHost;
		}
		
		public function setUser($pUser){
			$this->dbUser = $pUser;
		}
		
		public function setPsw($pPsw){
			$this->dbPsw = $pPsw;
		}
		
		public function setPrefix($pPrefix){
			$this->dbPrefix = $pPrefix;
		}
		
	}

?>
