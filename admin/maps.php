<?php 

	//include('header.php');
	
	define("DELFAUTSIZE", 100);
	
	if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {// si l'utilisateur est identifié.
	
		$ml = new mapLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
		$ml->connectPDO();
		
		$map = null;
		
		if (isset($_GET['new']) ){
				$map = new carte(null, 'nouvelle carte', '', '', '', DELFAUTSIZE, DELFAUTSIZE, '', false, '');
				$ml->registerMap($map);
				
		} elseif(isset($_GET['map'])){
		
			$map = $ml->getMapWithID($_GET['map']);
			
		}
			
		if (is_a($map, 'carte')) { //si aucune erreur est survenue on peut charger la carte
				
			echo $map->drawCardInfosEditable($ml);
				
		} else {
			
			$maps = $ml->getMapsList();
			
			echo '<div align="right" class="editlinks"><a href="admin.php?tool=maps&new=true"> nouvelle carte </a></div><br>';
				
			foreach($maps as $gName => $gMaps) { //pour chaque jeux on récupère son noms et les cartes associées.
				
				echo '<h1>'.$gName.'</h1><hr>'; //on imprime le titre.
					
				foreach ($gMaps as $map) {
						
					$map->drawEditLinkTo(); //on sort les cartes.
						
				}
					
			}
			
		}
	
	}
	
?>
