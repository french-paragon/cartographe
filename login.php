<?php 

	include('header.php');
	
	$executeConnect = false; //cette variable sert à définir si on va connecter l'utilisateur ou le présenter le formulaire avec un message.
	$msg;

	if(!isset($_SESSION["log"]) OR !method_exists($_SESSION["log"], 'getSessionOpenMessage')) { //si aucune session n'a été spécifiée ou que l'objet attendu comme être une session n'en est pas une.

		if(isset($_POST["connexion"])) {
			
			$executeConnect = true; //si la requête est de se connecter alors on va logguer l'utilisateur
			
			if ($_POST["login"] == null OR $_POST["md5"] == null) {
				
				$executeConnect = false;
				$msg += "\n\n Attention de remplir tout les champs!"; //mais si un champs manque alors on refuse le logon.
				
			} else {

				$_SESSION["log"] = new sessionStorage($_POST["login"], $_POST["md5"]); //sinon on crée notre session
				
				if (!$_SESSION["log"]->isUserRegistred()) { //si l'utilisateur n'est pas reconnu
					$executeConnect = false;
					$msg += "\n\n Votre nom d'utilisateur ou mot de passe n'est pas reconnu, prière de recommencer."; //mais si un champs manque alors on refuse le logon.
				}
				
			}
		}
		
		if (!$executeConnect) { //si on ne doit pas éxécuter le logon:
?>
<html>
<head>

<script src="mesFonctions.js" type="text/javascript"><!--mce:0--></script>
<script src="cryptMD5.js" type="text/javascript"><!--mce:1--></script>

</head>

<body>

<?php 
	echo $msg;
?>
<br><br>
<form action="login.php" method="post" enctype="text/plain">

	<input maxlength="40" name="login" type="text" /><br><br>
	<input id="password" maxlength="40" name="password" type="password" /><br><br>
    <input id="md5" name="md5" type="hidden" /><br><br><br><br>
	<input onclick="loginValidation(document.getElementById('password'), document.getElementById('md5'), document.Connexion);" name="connexion" type="button" value="Connexion" /><br><br>

</form>

</body>

</html>
<?php 

	//alors le formulaire de base s'affiche avec le message.

	}

	else { //sinon
	
		$_SESSION["log"]->getSessionOpenMessage(); //on renvoie son message d'accueil à l'utilisateur.
	
	}
	
} else {
	
	$_SESSION["log"]->getSessionOpenMessage(); //si l'utilisateur est déjà logué on lui renvoie son message de bienvenue.
	
}

?>
