<?php 

	/* draw page code:
		
			$maps->getMapsList();
			
			foreach($maps as $map) {
				
				$map->drawLinkTo();
				
			}
	 */

	include('header.php');
		
	$ml = new mapLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
	$ml->connectPDO();
	
	$drawList = true;
	
	if(isset($_GET['map'])) {
		
		$map = $ml->getMapWithName($_GET['map']);
		
		if (is_a($map, 'carte')) { //si aucune erreur est survenue on peut charger la carte
			
			if( $map->isPublic() OR (isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) ) {
			
				$map->drawCardWithPoints();
				$drawList = false;
			
			}
			
		}
		
	} 
	
	if ($drawList){
		
		$maps = $ml->getMapsList();
		
		$page = new pageBuilder();
			
		foreach($maps as $gName => $gMaps) { //pour chaque jeux on récupère son noms et les cartes associées.
			
			$drawGame = false;
			
			foreach ($gMaps as $map) {
				if( $map->isPublic() ) {
					$drawGame = true;
					break;
				}
			}
			
			if($drawGame) $page->addToBody('<h1>'.$gName.'</h1>'); //on imprime le titre.
			
			foreach ($gMaps as $map) {
				
				if( $map->isPublic() ) $page->addToBody($map->drawLinkTo()); //on sort les cartes publiques.
				
			}
				
		}
			
		$page->drawPage();
		
	}

?>
