<?php

session_start(); //démarrage de session, elle servira à stocker la configuration + d'autre choses.

spl_autoload_register(function ($class) {
    include 'class/'.$class.'.php';
});

include('conf.php');

?>
