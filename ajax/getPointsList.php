<?php 

/* Includes */

include('baseAjax.php');

/* Vars */

$coord1;
$coord2;


/* Arguments Processing */

if (isset($_GET[x_range]) && isset($_GET[y_range])) { //if a range&pos is given
	
		$coord1 = new coordonnee($_GET[x_range]);
		$coord2 = new coordonnee($_GET[y_range]);
	
	}
else {
	
	echo "error:missing arguments!";
	
	}

?>
