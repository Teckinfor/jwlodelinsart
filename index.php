<?php
include '/modules/checkPermissions.php';

if(isset($_GET["exit"])){
    if(isset($_COOKIE["session"])){
        header("location: /modules/dbconnect.php?destroy_cookie=".$_COOKIE["session"]);
    } else {
        session_destroy();
        header("location: /accueil");
    }
} else {
    header("location: /accueil");
}