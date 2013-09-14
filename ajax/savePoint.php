<?php

	require_once 'baseAjax.php';

	if(isset($_POST['sauver'])){
		
		if( isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights() ) { //l'utilisateur a les droits d'administration
		
			if(isset($_GET['point']) && isset($_POST['descr']) && isset($_POST['width']) && isset($_POST['height']) && isset($_POST['x']) && isset($_POST['y']) && isset($_POST['model']) ){
				
				$pt = new point($_POST['x'].','.$_POST['y'], prepareSave($_POST['model']) , null, prepareSave($_GET['point']) );
				$pt->setWidth(intval($_POST['width']));
				$pt->setHeigth(intval($_POST['height']));
				$pt->setDescription( prepareSave($_POST['descr']) );
					
				if($pt->getMessage() > point::NOMODELFOUNDMESSAGE) //si le modèle est chargé
					$pt->setModelParam($pt->getModel()->treatParamForm($pt));
				else echo '<b>Le modèle ne semble pas valide, le point comportera des erreurs qui empêcherons probablement son affichage!</b><br><br>';
					
				$pl = new pointLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
				$pl->connectPDO();
				
				if($pl->updatePoint($pt)){
					
					$pt->initOverviewParams();
					
					echo '<script type="text/javascript" src="../js/functions.js"></script><script type="text/javascript" src="../js/carte.js"></script><script type="text/javascript" src="../js/carteEdit.js"></script>';
					echo '<div align="center">enregistré la dernière fois avec succès le '.date("d-m-Y").' &agrave; '.date("H:i").'</div><br><br>';
					echo '<div align="center">'.$pt->drawOverview().'</div>';
					
				} else {
					echo '<div align="center">un problème est survenu durant le transfert dans la base de donnée, contactez l\'administrateur s\'il persiste.</div>';
					echo '<div align="center">'.$pt->drawOverview().'</div>';
				}
				
			}else echo '<b>Some parameters missing! contactez l\'administrateur si le problème persiste.</b><br><br>';
			
		}else echo '<b>Vous n\'avez pas les droits nécéssaires pour sauvegarder des informations! <a href="login.php" target="_top">Relogguez vous si cela semble anormal!</a></b><br><br>';
		
	} elseif (isset($_GET['point'])){
	
		$pl = new pointLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
		$pl->connectPDO();
		
		$pt = $pl->getPointWithID($_GET['point']);
		
		$pt->initOverviewParams();
		
		echo '<script type="text/javascript" src="../js/functions.js"></script><script type="text/javascript" src="../js/carte.js"></script><script type="text/javascript" src="../js/carteEdit.js"></script>';
		echo '<div align="center">'.$pt->drawOverview().'</div>';
		
	}

?>
