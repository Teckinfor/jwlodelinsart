<?php

session_start();

if (isset($_SESSION["user"])) {
    header("location: /accueil/");
}

if (isset($_COOKIE["session"])) {
    $cookie = $_COOKIE["session"];

    include "../modules/dbconnect.php";

    $stmt = $conn->prepare('SELECT ID FROM cookie WHERE cookie = ?');
    $stmt->bind_param("s", $cookie);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (isset($row["ID"])) {
        $_SESSION["user"] = $row["ID"];

        $stmt->close();

        $stmt = $conn->prepare('SELECT * FROM users where ID = ?');
        $stmt->bind_param("s", $_SESSION["user"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $admin = $row["admin"];
        $presentoir = $row["presentoir"];
        $assemblee = $row["assemblee"];
        $sono = $row["sono"];
        $sonoadm = $row["sonoadm"];
        
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

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JW - Lodelinsart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="theme-color" content="#712cf9">
    <link href="../css/signin.css" rel="stylesheet">

</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">

        <?php
        if (isset($_GET["badID"])) {
            echo "
                <div class='alert alert-danger' role='alert'>
                    L'identifiant ou le mot de passe est incorrect !
                </div>
                ";
        } ?>

        <form data-bitwarden-watching="1" action="../modules/dbconnect.php" method="POST">
            <!-- <img class="mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
            <h1 class="h3 mb-3 fw-normal">Assemblée de Lodelinsart</h1>

            <div class="form-floating" style="margin-bottom: 10px;">
                <input type="text" class="form-control" id="floatingInput" name="ID" maxlength="20" placeholder="Identifiant">
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" maxlength="128" placeholder="Mot de passe">
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember" value="yes"> Se souvenir de moi
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="connexion" value="" type="submit">Connexion</button>

        </form>
        <p class="foot mt-5 mb-3 text-muted">Cette application n'est pas un produit officiel de la Watch Tower Bible and Tract Society of Pennsylvania</p>
    </main>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>