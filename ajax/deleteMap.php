<?php 

	header("Content-Type: text/plain");

	require_once 'baseAjax.php';
	
	$retour = 1;

	if(isset($_GET['toDelete'])){
		
		if( isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights() ) { //l'utilisateur a les droits d'administration
			
			$ml = new mapLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
			$ml->connectPDO();
			
			if ($ml->deleteIndex($_GET['toDelete'])) $retour = 0;
			else $retour = 1;
				
		} else $retour = 1;

	}
	
	echo $retour;

?>
