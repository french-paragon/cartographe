<?php 

	require_once 'baseAjax.php';

	if(isset($_POST['sauver'])){
		
		if( isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights() ) { //l'utilisateur a les droits d'administration
		
			if (isset($_POST['name']) AND isset($_POST['description']) AND isset($_POST['image']) AND isset($_POST['x']) AND isset($_POST['y']) AND isset($_GET['map']) AND isset($_POST['game']) ){
			
				$map = new carte(intval($_GET['map']), $_POST['name'], $_POST['image'], null, null, $_POST['x'], $_POST['y'], $_POST['description'], isset($_POST['visibility']), $_POST['game']);
				
				$ml = new mapLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
				$ml->connectPDO();
				
				if($ml->updateMap($map))
					echo '<div align="center">enregistré la dernière fois avec succès le '.date("d-m-Y").' &agrave; '.date("H:i").'</div>';
				else
					echo '<div align="center">un problème est survenu durant le transfert dans la base de donnée, contactez l\'administrateur s\'il persiste.</div>';
				
				
			} else
				echo '<div align="center">un problème est survenu durant le transfert des données au serveur, contactez l\'administrateur s\'il persiste.</div>';
				
		} else {
			echo '<div align="center" >droit refusé, vous pouvez retourner à la <a href="../login.php" target="_top" >page de login</a>!</div>';
		}

	}

?>
