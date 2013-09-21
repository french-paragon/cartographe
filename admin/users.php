<?php 

	define("DELFAUTUSERNAME", 'toto');
	define("DELFAUTPSW", 'toto');
	define("DELFAUTUSERMAIL", 'toto@toto.com');
	
	if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {

		$ul = new userLoader($conf_values['dbName'], $conf_values['dbHost'], $conf_values['dbUser'], $conf_values['dbPsw'], $conf_values['dbPrefix']);
		$ul->connectPDO();
?>
<html>
<head>
<title></title>
<meta name="generator" content="Geany">
<meta name="author" content="Paragon">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">
</head>
<body><?php if(!isset($_GET['action'])){?>
	<table>
		<tr><td><div align="right" class="adminActions" ><a href="admin.php?tool=users&action=new">Nouvel Utilisateur</a></div><hr></td></tr>
		<?php
			
			$users = $ul->getUsers();
			
			foreach($users as $user){
				
				?><tr><td><table><br><tr id="<?php echo $user->getIndex(); ?>"><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/user.png" alt="user face" height="68" width="68"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><div class="userName"><?php echo $user->getName(); ?></div><br>
				<div class="adminActions"><a href="admin.php?tool=users&action=edit&id=<?php echo $user->getIndex(); ?>">Edit</a> | <a onclick="delUser("<?php echo $user->getIndex(); ?>");" href="" >Delete</a></div></td></tr>
				</table><br><br></td></tr>
				<?php
				
			}
			
		?>
	</table>
	<?php 
			
		} elseif ($_GET['action'] == 'new'){
			
			$user = new user (0, DELFAUTUSERNAME, user::VISITORRIGHTS, DELFAUTUSERMAIL, null,  DELFAUTPSW, false);
			
			if( $ul->registerUser($user) ) echo $user->drawEditor();
			else echo 'une erreur semble s\'être produite durant la connexions à la base de donnée.';
			
		} elseif ($_GET['action'] == 'edit' AND isset($_GET['id'])){
			
			$user = $ul->getUserWithId($_GET['id']);
			
			if($user) echo $user->drawEditor();
			else echo 'une erreur semble s\'être produite durant la connexions à la base de donnée.';
		} else {
		
			echo 'unknown action!';
			
		}
		
	?>
</body>
</html>
<?php } else { 
	
	echo 'droits refusés!';
	
} ?>
