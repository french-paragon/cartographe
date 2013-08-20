<?php
/**
 * SESSION CLASSES
 * Any classes that will be stored in the session can be added here
 * and will be pre-loaded on every page
 */
require_once "class/sessionStorage.php";

spl_autoload_register(function ($class) {
    include 'class/'.$class.'.php';
});

session_set_cookie_params (3600); //sessions d'une heure.
session_start(); //démarrage de session, elle servira à stocker la configuration + d'autre choses.

require_once 'conf.php';

if(isset($_SESSION["log"]) AND !is_a($_SESSION["log"], 'sessionStorage')){

	unset ($_SESSION["log"]);
	
}

//$_SESSION['configuration'] = new config();

?>
