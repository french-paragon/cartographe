<?php 

	//include('header.php');
	
	if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {// si l'utilisateur est identifié.
	
		$ml = new mapLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
		$ml->connectPDO();
		
		if(isset($_GET['map'])) {
			
			$map = $ml->getMapWithName($_GET['map']);
			
			if (is_a($map, 'carte')) { //si aucune erreur est survenue on peut charger la carte
				
				$map->drawCardEditable();
				
			} else {
			
				$maps = $ml->getMapsList();
				
				foreach($maps as $gName => $gMaps) { //pour chaque jeux on récupère son noms et les cartes associées.
				
					echo '<h1>'.$gName.'</h1><hr>'; //on imprime le titre.
					
					foreach ($gMaps as $map) {
						
						$map->drawEditLinkTo(); //on sort les cartes.
						
					}
					
				}
				
			}
			
		} else {
			
			$maps = $ml->getMapsList();
				
			foreach($maps as $gName => $gMaps) { //pour chaque jeux on récupère son noms et les cartes associées.
				
				echo '<h1>'.$gName.'</h1><hr>'; //on imprime le titre.
					
				foreach ($gMaps as $map) {
						
					$map->drawEditLinkTo(); //on sort les cartes.
						
				}
					
			}
			
		}
	
	}
	
?>
