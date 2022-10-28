<?php
include '/modules/checkPermissions.php';

session_start();

if(isset($_GET["exit"])){
    if(isset($_COOKIE["session"])){
        header("location: /modules/dbconnect.php?destroy_cookie=".$_COOKIE["session"]);
    } else {
        session_destroy();
        header("location: /accueil/");
        die();
    }
} else {
    header("location: /accueil/?notdeconnected");
}