<?php

// Controlla che l'utente sia già autenticato, per non dover chiedere il login ogni volta che cambi pagina    
require_once 'dbconfig.php';
session_start();
//inserire parte sui coockie
function check_up(){

    if(isset($_SESSION['_sito_user_id'])) {
        return $_SESSION['_sito_user_id'];
    } else 
        return 0;
}
?>