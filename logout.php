<?php
	include('header.php'); 
?>
<html>
<head>

<!--<script src="mesFonctions.js" type="text/javascript"><!--mce:0 onclick="loginValidation(document.getElementById('password'), document.getElementById('md5'), document.Connexion);"</script>-->
<!--<script src="cryptMD5.js" type="text/javascript"><!--mce:1</script>-->

<meta charset="UTF-8" />

</head>

<body>
<?php

	if (isset($_SESSION["log"]) AND $_SESSION["log"]->isUserIdentyfied()){ //si l'utilisateur est enregistré mais que le mot de passe ne corresponds pas.
			$_SESSION["log"]->logout();
			
			if ($_SESSION["log"]->isUserIdentyfied()) {
			
				echo 'révise ton script!';
				
			}
			
	}
	
	echo 'votre session a été fermée!';
	
?>
</body>
</html>
