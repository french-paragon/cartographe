<?php 

	class db 
	{
		
		protected static $dbName;
		protected static $dbHost;
		protected static $dbUser;
		protected static $dbPsw;
		protected static $dbPrefix;
		
		public function __construct() {
			
			//no constructor needed for the moment
			
		}
		
		public static function isReady() {
		
			if (isset(self::$dbName) AND isset(self::$dbHost) AND isset(self::$dbUser) AND isset(self::$dbPsw)) {
			
				return true;
				
			} else {
			
				return false;
				
			}
			
		}
		
		public static prepareInit($pName, $pHost, $pUser, $pPsw, $pPrefix) {
			
			self::$dbName = $pName;
			self::$dbHost = $pHost;
			self::$dbUser = $pUser;
			self::$dbPsw = $pPsw;
			self::$dbPrefix = $pPrefix;
			
		}
		
	}

?>
