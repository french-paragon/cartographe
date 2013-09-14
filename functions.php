<?php

	function prepareSave($texte){
	
		$retour = preg_replace('#<script(.+)</script>#i', '', $texte);
		$retour = preg_replace('#\'#', '&apos;', $retour);
		$retour = preg_replace('#,#', '&#44;', $retour);
		
		return $retour;
		
	}
	
	function prepareSaveSoft($texte){
	
		$retour = preg_replace('#<script(.+)</script>#i', '', $texte);
		$retour = preg_replace('#\'#', '&apos;', $retour);
		
		return $retour;
		
	}

?>
