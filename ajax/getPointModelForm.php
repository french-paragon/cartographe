<?php

	require_once 'baseAjax.php';

	$retour;

	if(isset($_GET['pt']) && isset($_GET['model'])){
		
		$pl = new pointLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
		$pl->connectPDO();
			
		$point = $pl->getPointWithID($_GET['pt']);
		
		if(file_exists('../class/'.$_GET['model'].'.php')){
		
			$model = new $_GET['model']();
			
			$retour = $model->getParamForm($point);
			
		} else $retour = '<div align="center"><b>Le modèle spécifié ne semble pas être un modèle installé, référez vous à la liste déroulante ou assurez vous que le fichier soit bien installé!</b></div>';
		
	} else $retour = '<div align="center"><b>Some params missing! contactez l\'administrateur si le problème persite.</b></div>';
	
	echo $retour;
	
?>
