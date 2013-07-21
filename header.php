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

session_start(); //démarrage de session, elle servira à stocker la configuration + d'autre choses.

include('conf.php');

$_SESSION['configuration'] = new config();

?>
