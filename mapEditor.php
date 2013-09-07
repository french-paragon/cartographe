<?php 

	require_once 'header.php';
	
	if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {
	
		if(isset($_GET['map'])) {
		
			$ml = new mapLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
			$ml->connectPDO();
			
			$map = $ml->getMapWithID($_GET['map']);
			
			if (is_a($map, 'carte')) { //si aucune erreur est survenue on peut charger la carte
				
				$map->drawCardEditable();
				
			} else {
			
				echo 'une erreur est survenue durant le chargement de la carte!';
				
			}
		
		}
		
	} else {
		echo 'accès refusé!';
	}
	
	
?>
