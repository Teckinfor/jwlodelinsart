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

    echo 'file_uploads: '. ini_get('file_uploads'). '<br />';
    echo 'upload_tmp_dir: '. ini_get('upload_tmp_dir'). '<br />';
    echo 'upload_max_filesize: '. ini_get('upload_max_filesize'). '<br />';
    echo 'max_file_uploads: '. ini_get('max_file_uploads'). '<br />';

    $stmt = $conn->prepare('INSERT INTO `valve` (`titre`, `message`, `auteur`, `fichiers`) VALUES (?, ?, ?, ?);');
    $stmt->bind_param('ssss', $_POST["title"], $_POST["content"], $_SESSION["user"], $_FILES["files"]["name"]);

    if (file_exists("/var/www/html/files/".$_FILES["files"]["name"]) && $_FILES["files"]["name"] != null) {
        header("Location: /admin/?fileexistsalready");
    } else {

        $target_file = "/var/www/html/files/" . basename($_FILES["files"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($_FILES["files"]["size"] > 50000000) {
            header("Location: /admin/?filetoobig");
        }
    
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["files"]["name"])). " has been uploaded.";
        } else {
            header("Location: /error/?filenotuploaded");
        }
        
        $stmt->execute();
        $stmt->close();
        header("Location: /admin?addedtovalve");
    }
}

// Supprimer une note aux valves

if (isset($_POST["removevalve"])) {

    $stmt = $conn->prepare('SELECT fichiers FROM `valve` WHERE ID = ?;');
    $stmt->bind_param('s', $_POST["removevalve"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if($row["fichiers"] != null){
        unlink("/var/www/html/files/" . $row["fichiers"]);
        echo "/var/www/html/files/" . $row["fichiers"];

    }
    

    $stmt = $conn->prepare('DELETE FROM `valve` WHERE ID = ?;');
    $stmt->bind_param('s', $_POST["removevalve"]);
    $stmt->execute();
    $stmt->close();

    header("Location: /accueil/");

}

// Ajouter un utilisateur

if (isset($_POST["adduser"])) {

    $stmt = $conn->prepare('SELECT ID FROM `users` WHERE ID=?;');
    $stmt->bind_param('s', strtolower($_POST["login"]));
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if($row["ID"] != null){

        header("Location: /admin/?useralreadyexist");

    } else {

        if(isset($_POST["presentoir"])){
            $presentoir = 1;
        } else {
            $presentoir = 0;
        }
        if(isset($_POST["isAdmin"])){
            $isAdmin = 1;
        } else {
            $isAdmin = 0;
        }
        if(isset($_POST["sono"])){
            $sono = 1;
        } else {
            $sono = 0;
        }
        if(isset($_POST["admsono"])){
            $admsono = 1;
        } else {
            $admsono = 0;
        }

        $ID = strtolower($_POST["login"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $prenom = strtolower($_POST["prenom"]);
        $nom = strtolower($_POST["nom"]);
        $assemblee = strtolower($_POST["assemblee"]);


    }

    $stmt = $conn->prepare('INSERT INTO `users`(`ID`, `password`, `nom`, `prenom`, `assemblee`, `admin`, `presentoir`, `sono`, `sonoadm`) VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssssss', $ID, $password, $nom, $prenom, $assemblee, $isAdmin, $presentoir, $sono, $admsono);
    $stmt->execute();
    $stmt->close();

    header("Location: /admin/?useradded");

}

// Modifier un utilisateur

?>