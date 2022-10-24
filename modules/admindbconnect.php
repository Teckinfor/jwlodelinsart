<?php

include '../modules/checkPermissions.php';

if (!$_SESSION["admin"]) {
    header("Location: /accueil/");
}

ini_set('display_errors', 'On');
ini_set('html_errors', 0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "db_app";
$password = "JWLodelinsart";
$db = "users";
$conn = new mysqli($servername, $username, $password, $db);


// Ajouter une note aux valves

if (isset($_POST["addvalve"])) {

    $stmt = $conn->prepare('INSERT INTO `valve` (`titre`, `message`, `auteur`) VALUES (?, ?, ?);');
    $stmt->bind_param('sss', $_POST["title"], $_POST["content"], $_SESSION["user"]);
    $stmt->execute();
    $stmt->close();

    header("Location: /admin?addedtovalve");

}

// Supprimer une note aux valves

if (isset($_POST["removevalve"])) {

    $stmt = $conn->prepare('DELETE FROM `valve` WHERE ID = ?;');
    $stmt->bind_param('s', $_POST["removevalve"]);
    $stmt->execute();
    $stmt->close();

    header("Location: /accueil/");

}


?>