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
	
	$drawList = false;
	
	if(isset($_GET['map'])) {
		
		$map = $ml->getMapWithName($_GET['map']);
		
		if (is_a($map, 'carte')) { //si aucune erreur est survenue on peut charger la carte
			
			$map->drawCardWithPoints();
			
		} else {
		
			$drawList = true;
			
		}
		
	} 
	
	if ($drawList){
		
		$maps = $ml->getMapsList();
		
		$page = new pageBuilder();
			
		foreach($maps as $gName => $gMaps) { //pour chaque jeux on récupère son noms et les cartes associées.
			
			$page->addToBody('<h1>'.$gName.'</h1>'); //on imprime le titre.
			
			foreach ($gMaps as $map) {
				
				$page->addToBody($map->drawLinkTo()); //on sort les cartes.
				
			}
				
		}
			
		$page->drawPage();
		
	}

?>
