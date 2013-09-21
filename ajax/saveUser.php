<div align="center" >
<?php 

	require_once 'baseAjax.php';
	
	if( isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights() AND isset($_GET['user'])) { //l'utilisateur a les droits d'administration
	
		$ul = new userLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
		$ul->connectPDO();
		
		$sucess = false;
			
		$user = $ul->getUserWithId($_GET['user']);
		
		if(!$user) exit ('erreur durant la connection à la base de données.'); // si l'user n'est pas chargé.
	
		if(isset($_POST['baseDatas'])){ //on demande de changer les données de bases.
			
			if( isset($_POST['username']) AND isset($_POST['usermail']) AND isset($_POST['userrigths']) AND isset($_POST['mapsList']) ){
			
				if ($ul->updateBaseInfos($user->getIndex(), $_POST['username'], $_POST['usermail'], user::getRigthsAlias()[$_POST['userrigths']], $_POST['mapsList']) ) echo 'enregistré avec succès!';
				else echo 'erreur d\'enregistrement dans la base de données!';
				
			}else echo 'paramètres manquants.';
			
		} elseif(isset($_POST['pswDatas'])){ //on demande la mise à jour du mot de passe.
			
			if( isset($_POST['olUsPsw']) AND isset($_POST['newUsPsw']) AND isset($_POST['newUsPswrep']) ){ 
				
				if($_POST['newUsPsw'] != $_POST['newUsPswrep']) exit ('les nouveaux mots de passes ne sont pas similaires!');
				
				if( $user->PSWMatch($_POST['olUsPsw']) ) $sucess = $ul->upDateUserPSW($user->getIndex(), $user->getPSW(), crypt($_POST['newUsPsw'], '$2a$07'.md5($_POST['newUsPsw']).'$'));
				
				if($sucess) echo 'mot de passe changé avec succès!';
				else echo 'erreur d\'enregistrement';
			}
			
		}
	
	} elseif ( !(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) )
		echo 'droit refusé, vous pouvez retourner à la <a href="../login.php" target="_top" >page de login</a>!';
	
?>
</div>
