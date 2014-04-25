<?php

	function url_exists($url) {
		
		if(isset($conf) and $conf_values['check_external_url']){
    
			$headers = @get_headers($url);
			if(strpos($headers[0],'200')===false)return false;
			return true;
			
		} else{
			
			return preg_match('@^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$@', $url);
			
		}
	
	}

	function prepareSave($texte){
	
		$retour = preg_replace('#<script(.+)</script>#i', '', $texte);
		$retour = str_replace('\\\'', '&apos;', $retour);
		$retour = str_replace('\"', '"', $retour);
		$retour = preg_replace('#,#', '&#44;', $retour);
		
		return $retour;
		
	}
	
	function prepareSaveSoft($texte){
	
		$retour = preg_replace('#<script(.+)</script>#i', '', $texte);
		$retour = str_replace('\\\'', '&apos;', $retour);
		
		return $retour;
		
	}

?>
