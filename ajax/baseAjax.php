<?php

spl_autoload_register(function ($class) {
    include '../class/'.$class.'.php';
});

session_set_cookie_params (3600); //sessions d'une heure.
session_start(); //démarrage de session, elle servira à stocker la configuration + d'autre choses.

require_once '../conf.php';
require_once '../functions.php';

$conf_values['rootFolder'] = '../';

if(isset($_SESSION["log"]) AND !is_a($_SESSION["log"], 'sessionStorage')){

	unset ($_SESSION["log"]);
	
}

?>
