<?php

session_start();

ini_set('display_errors', 'On');
ini_set('html_errors', 0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "db_app";
$password = "JWLodelinsart";
$db = "users";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    header("Location: /error/");
}

if (isset($_POST["connexion"])) {
    if (!isset($_POST["ID"]) || !isset($_POST["password"])) {
        header("Location: /error/");
    }

    $ID = $_POST["ID"];
    $password = $_POST["password"];

    $stmt = $conn->prepare('SELECT * FROM users where ID = ?;');
    $stmt->bind_param("s",$ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $admin = $row["admin"];
    $presentoir = $row["presentoir"];
    $assemblee = $row["assemblee"];
    $sono = $row["sono"];
    $sonoadm = $row["sonoadm"];
    

    if (!password_verify($password, $row["password"])) {
        session_destroy();
        header("location: /connexion/?badID");
        die();
        $stmt->close();
    } else {
        $stmt->close();
        if ($_POST["remember"]) {
            //Création du cookie
            $token = hash('sha256', $ID . time());

            setcookie("session", $token, time() + 60 * 60 * 24 * 365, '/');

            $stmt = $conn->prepare("INSERT into cookie (id, cookie) values ( ? , ? )");
            $stmt->bind_param("ss", $ID, $token);
            $stmt->execute();
            
        }
        $_SESSION["user"] = $ID;
        $_SESSION["assemblee"] = $assemblee;

        if($admin){
            $_SESSION["admin"] = True;
        } else {
            $_SESSION["admin"] = False;
        }
        if($presentoir){
            $_SESSION["presentoir"] = True;
        } else {
            $_SESSION["presentoir"] = False;
        }
        if($sono){
            $_SESSION["sono"] = True;
        } else {
            $_SESSION["sono"] = False;
        }
        if($sono){
            $_SESSION["sonoadm"] = True;
        } else {
            $_SESSION["sonoadm"] = False;
        }
        
        header("location: /accueil/");
    }
}

if (isset($_POST["changepassword"])) {

    $stmt = $conn->prepare('SELECT * FROM users where ID = ?;');
    $stmt->bind_param("s",$_SESSION["user"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($_POST["OldPass"], $row["password"])) {
        header("Location: /accueil/?notoldpwd");
        die();
    } elseif ($_POST["Newpass"] != $_POST["ConfNewpass"]) {
        header("Location: /accueil/?failconfpwd");
        die();
    } else {
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE ID = ? ");
        $mdp = password_hash($_POST["Newpass"], PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $mdp, $_SESSION["user"]);
        $stmt->execute();
        $stmt->close();
        header("Location: /accueil/?pwdchanged");
    }
}

if (isset($_GET["destroy_cookie"])) {

    $stmt = $conn->prepare("DELETE FROM `cookie` WHERE cookie = ?");
    $stmt->bind_param("s", $_GET["destroy_cookie"]);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    header("location: /connexion/");
}
