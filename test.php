<?php

	include('header.php');

	$ml = new mapLoader('test', '127.0.0.1', user, psw, null);
	
	$ml->connectPDO();
	
	$maps = $ml->getMapsList();
	
	var_dump($maps);

?>
