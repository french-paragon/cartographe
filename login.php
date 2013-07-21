<head>

<!--<script src="mesFonctions.js" type="text/javascript"><!--mce:0 onclick="loginValidation(document.getElementById('password'), document.getElementById('md5'), document.Connexion);"</script>-->
<!--<script src="cryptMD5.js" type="text/javascript"><!--mce:1</script>-->

</head>

<body>
<?php 

	include('header.php');
	
	$executeConnect = false; //cette variable sert à définir si on va connecter l'utilisateur ou le présenter le formulaire avec un message.
	$msg = '<br>';
	
	$ul = new userLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
	$ul->connectPDO();

	if(!isset($_SESSION["log"]) OR !is_a($_SESSION["log"], 'sessionStorage')) { //si aucune session n'a été spécifiée ou que l'objet attendu comme être une session n'en est pas une.


		if(isset($_POST["connexion"])) {
			
			$executeConnect = true; //si la requête est de se connecter alors on va logguer l'utilisateur
			
			if (!isset($_POST["login"]) OR !isset($_POST["password"])) {
				
				$executeConnect = false;
				$msg .= "Attention de remplir tout les champs!<br><br> "; //mais si un champs manque alors on refuse le logon.
				
			} else {

				$_SESSION["log"] = new sessionStorage($_POST["login"], $_POST["password"], $ul); //sinon on crée notre session
				
			}
		}
	} else {
		
		$_SESSION["log"]->setUserLoader($ul); //penser à initialiser la connection qui n'a pas pu être sérialisée.
		
		if(isset($_POST["connexion"])) {

			$executeConnect = true;
			
			if (!isset($_POST["login"]) OR !isset($_POST["password"])) {
				
				$executeConnect = false;
				$msg .= "Attention de remplir tout les champs!<br><br> "; //mais si un champs manque alors on refuse le logon.
				
			} else {
				$_SESSION["log"]->reInitUserDatas($_POST["login"], $_POST["password"]);
			}
		}
		
	}
			
	if($executeConnect)	{ //si on doit vérifier que l'utilisateur est bien loggué.
		
		if (!$_SESSION["log"]->isUserRegistred()) { //si l'utilisateur n'est pas reconnu
			$executeConnect = false;
			$msg .= 'Votre nom d\'utilisateur n\'est pas reconnu, prière de recommencer.<br><br> '; //mais si un champs manque alors on refuse le logon.
		} elseif (!$_SESSION["log"]->isUserIdentyfied()){ //si l'utilisateur est enregistré mais que le mot de passe ne corresponds pas.
			$executeConnect = false;
			$msg .= "Votre mot de passe ne semble pas correct!<br><br> ";
		}
					
		if ($_SESSION["log"]->hasTooMuchLog()) {
			$executeConnect = false;
			$msg .= "Vous ne pouvez tentez de vous logguer que ".sessionStorage::MAXLOGTRY."fois par heure, revenez dans une heure!\n
			 Ceci sert à protéger le site contre les attaque par force brute.<br><br> ";
		}
		
	}
	
		
	if (!$executeConnect) { //si on ne doit pas éxécuter le logon:
	
	echo $msg;
?>
<br><br>
<form action="login.php" method="post">

	<label for="login"><strong>Nom d'utilisateur :</strong></label>
	<input maxlength="40" id="login" name="login" type="text" /><br><br>
	<label for="password"><strong>Mot de passe :</strong></label>
	<input id="password" maxlength="40" name="password" type="password" /><br><br>
    <input id="md5" name="md5" type="hidden" /><br><br>
	<input id="connexion" name="connexion" type="submit" value="Connexion" /><br><br>

</form>
<?php 

	//alors le formulaire de base s'affiche avec le message.

	}

	else { //sinon
	
		echo '<br>'.$_SESSION["log"]->getSessionOpenMessage().'<br>'; //on renvoie son message d'accueil à l'utilisateur.
	
	}

?>
</body>
