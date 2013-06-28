<?php

	class config {
		
		protected static $general_params = array();
		protected $user_params = array();
		
		protected static $general_messages;
		protected $user_messages;
		
		const FOLDERMAXHEIGHT = 2;
		const LOADCONFPARAMFILENAME = 'conf.php';
		
		public function __construct() {
			
			$pref = '';
			
			for ($i = 0; $i <= self::FOLDERMAXHEIGHT; ++$i) {
			
				if (file_exists($pref.self::LOADCONFPARAMFILENAME)) {
				
					include($pref.self::LOADCONFPARAMFILENAME);
					
					break;
					
				} else if ($i = self::FOLDERMAXHEIGHT) { //if no file has been found and we're in the last iteration
				
					$this->user_messages += "\n\n!no load config file found.";
					
				}
				
				$pref += '../'; //go one folder over.
				
			}
			
		}
		
		public function getParam ($paramName) {
			
			if (isset(self::$general_params[$paramName])) {
			
				return self::$general_params[$paramName];
				
			} else if (isset($this->user_params[$paramName])) {
			
				return $this->user_params[$paramName];
				
			}else {
				
				self::$general_messages += '\n\n!no var "'.$paramName.'" define.';
				
				return null;	
				
			}
			
		}
		
		public static function getGeneralParam($paramName){
			
			if (isset(self::$general_params[$paramName])) {
			
				return self::$general_params[$paramName];
				
			}else {
				
				self::$general_messages += '\n\n!no var "'.$paramName.'" define.';
				
				return null;	
				
			}
		}
		
		public static function setGeneraéParam($paramName, $paramValue){
			self::$general_params[$paramName] = $paramValue;
		}
		
		public static function getUserParam($paramName){
			
			if (isset($this->user_params[$paramName])) {
			
				return $this->user_params[$paramName];
				
			}else {
				
				$this->user_messages += '\n\n!no var "'.$paramName.'" define.';
				
				return null;	
				
			}
		}
		
		public function setUserParam($paramName, $paramValue){
			$this->user_params[$paramName] = $paramValue;
		}
		
	}

?>
