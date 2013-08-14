<?php
	include('header.php'); 
?>
<html>
<head>

<!--<script src="mesFonctions.js" type="text/javascript"><!--mce:0 onclick="loginValidation(document.getElementById('password'), document.getElementById('md5'), document.Connexion);"</script>-->
<!--<script src="cryptMD5.js" type="text/javascript"><!--mce:1</script>-->

<meta charset="UTF-8" />
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

</head>

<body>
<?php

	if (isset($_SESSION["log"]) AND $_SESSION["log"]->isUserIdentyfied()){ //si l'utilisateur est enregistré
			$_SESSION["log"]->logout();
			
			if ($_SESSION["log"]->isUserIdentyfied()) {
			
				echo 'un problème est survenu, veuillez réessayer et si le problème persite contacter l\'administrateur du site.';
				
			} else {
				
				session_destroy();
				echo 'votre session a été fermée!';
			}
			
	} else {
				
		session_destroy();
		echo 'votre session a été fermée!';
	}
	
?>
</body>
</html>
