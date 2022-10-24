<?php

session_start();

// User is currently connected ?
if (!isset($_SESSION["user"])){
    header('Location: ../connexion/');
    exit;
}

?>