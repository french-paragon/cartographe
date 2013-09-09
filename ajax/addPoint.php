<?php

	require_once 'baseAjax.php';
	
	define("DELFAUTPOS", 100);
	define("DELFAUTPOINTSIZE", 20);
	
	$retour = 0;
	
	if( isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights() ) {
		
		if(isset($_GET['mapId']) && isset($_GET['descr'])){
			
			$pl = new pointLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
			$pl->connectPDO();
			
			$pt = new point(DELFAUTPOS.','.DELFAUTPOS,  point::DELFAUTMODELNAME , delfautPointModel::DELFAULTPARAMS, $_GET['mapId']);
			$pt->setWidth(DELFAUTPOINTSIZE);
			$pt->setHeigth(DELFAUTPOINTSIZE);
			$pt->setDescription($_GET['descr']);
			
			$retour = ($pl->registerPoint($pt)) ? $pt->drawEditLinkTo() : 0;
			
		}
		
	}
	
	echo $retour;
	
?>
