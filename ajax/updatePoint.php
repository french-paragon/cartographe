<?php

	header("Content-Type: text/plain");
	
	require_once 'baseAjax.php';

	$retour = 1;

	if( isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights() ) { //l'utilisateur a les droits d'administration
	
		if(isset($_GET['id']) AND isset($_GET['x']) AND isset($_GET['y'])) {
			
			$pl = new pointLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
			$pl->connectPDO();
			
			if($pl->updatePosition($_GET['id'], $_GET['x'], $_GET['y'])) $retour = 0;
			else $retour = 1;
			
		} else $retour = 1;
	
	} else $retour = 1;
	
	echo $retour;
	
?>
