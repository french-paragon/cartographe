<?php 

	require_once 'header.php';
	
	if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {
	
		if(isset($_GET['point'])) {
		
			$pl = new pointLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
			$pl->connectPDO();
			
			$point = $pl->getPointWithID($_GET['point']);
			
			if (is_a($point, 'point')) { //si aucune erreur est survenue on peut charger le point
			
				$point->drawPointInfosEditor();
				
			} else {
			
				echo 'une erreur est survenue durant le chargement de la carte!';
				
			}
		
		}
		
	} else {
		echo 'accès refusé!';
	}
	
	
?>
