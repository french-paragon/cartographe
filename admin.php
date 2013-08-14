<?php 

	include('header.php');
	
	if(isset($_SESSION["log"])) {// si l'utilisateur est identifié.
		if($_SESSION["log"]->hasUserAdminRights()) {
?>

<!DOCTYPE html>
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
<body>
	<div width="100%" align="right"><a href="logout.php">Logout</a><hr></div>
	<table>
		<tr valign="top">
			
			<td id="menus" ><br><br><br><br>
				<a href="admin.php?tool=maps"><p class="menu" id="maps">Cartes</p></a>
				<a href="admin.php?tool=points"><p class="menu" id="points">Points</p></a>
				<a href="admin.php?tool=medias"><p class="menu" id="medias">Stock Media</p></a>
				<a href="admin.php?tool=users"><p class="menu" id="users">Utilisateurs</p></a>
			</td>
			
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			
			<td id ="content" ><?php 
			
				if(isset($_GET['tool']) AND preg_match("#^maps$|^points$|^medias$|^users$#", $_GET['tool'])){
				
					include('admin/'.$_GET['tool'].'.php');
					
				} else {
				
					include('admin/maps.php');
					
				}
			
			?></td>
			
		</tr>
	</table>
</body>
</html>

<?php
	} else{
			echo "Permission denied!";
	}
	
}else {

		include('login.php');
		
}

?>
