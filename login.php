<?php 

			

?>
<html>
<head>

<script src="mesFonctions.js" type="text/javascript"><!--mce:0--></script>
<script src="cryptMD5.js" type="text/javascript"><!--mce:1--></script>

</head>

<body>

<form action="login.php" method="post" enctype="text/plain">

				<input maxlength="40" name="login" type="text" />
				<input id="password" maxlength="40" name="password" type="password" />
    	<input id="md5" name="md5" type="hidden" />
				<input onclick="loginValidation(document.getElementById('password'), document.getElementById('md5'), document.Connexion);" name="adminLoginButton" type="button" value="Connexion" />

</form>

</body>

</html>