<?php 

$conf = true; //indique que le fichier de configuration a été inclut.

$conf_values = array();

$conf_values['dbName'] = null;
$conf_values['dbHost'] = null;
$conf_values['dbUser'] = null;
$conf_values['dbPsw'] = null;
$conf_values['dbPrefix'] = null;

$conf_values['rootFolder'] = null;

$conf_values['installed_points_model'] = array ('delfautPointModel', 'linkPointModel', 'SVGBGShowerPointModel');

$conf_values['check_external_url'] = false; //par défaut on ne vérifie pas les url extene, juste la séquence de l'url, ceci pour éviter des temps de chargement trops long.

?>
