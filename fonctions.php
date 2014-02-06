<?php

	function url_exists($url) {
    
		$headers = @get_headers($url);
		if(strpos($headers[0],'200')===false)return false;
		return true;
	
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
