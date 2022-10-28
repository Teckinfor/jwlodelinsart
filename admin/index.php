<?php
include '../modules/checkPermissions.php';

if (!$_SESSION["admin"]) {
    header("Location: /accueil/");
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JW - Lodelinsart</title>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="../js/changepwd.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/changepwd.css">

    <meta name="theme-color" content="#712cf9">

    <style>
        .box {
            display: block;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 0.5em 1.5em rgb(0 0 0 / 10%), inset 0 0.125em 0.5em rgb(0 0 0 / 15%);
            width: 100%;
            height: 100vh;
            overflow: auto;
        }

        @media (max-width: 768px) {

            #fulldisplay {
                display: block !important;
            }
        }
    </style>
</head>

<body style="overflow: hidden;">

    <div id="fulldisplay" class="d-flex">

        <?php include '../modules/changepwd.php'; ?>
        <?php include '../modules/sidebar.php'; ?>

        <div class="box">
            <div class="p-4">

                <h2>Administration</h2>

                <div class="mt-5">

                    <?php
                    if (isset($_GET["addedtovalve"])) {
                        echo "<a href='/accueil/'>
                                <div class='alert alert-success' role='alert'>
                                    Votre note à bien été ajoutée au valve ! 
                                    Cliquez-ici pour la voir.
                                </div>
                                </a>
                            ";
                    } ?>

                    <?php
                    if (isset($_GET["useradded"])) {
                        echo "<div class='alert alert-success' role='alert'>
                                L'utilisateur a été ajouté !
                            </div>
                            ";
                    } ?>

                    <?php
                    if (isset($_GET["fileexistsalready"])) {
                        echo "<div class='alert alert-danger' role='alert'>
                                    Votre note n'a pas été ajoutée car un fichier du même nom semble déjà être dans une note !
                            </div>
                            ";
                    } ?>

                    <?php
                    if (isset($_GET["useralreadyexist"])) {
                        echo "<div class='alert alert-danger' role='alert'>
                                    L'utilisateur n'a pas été ajouté ! <br> Raison : login déjà utilisé.
                            </div>
                            ";
                    } ?>

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Ajouter une note au valve
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <form action="/modules/admindbconnect.php" enctype="multipart/form-data" method="post">
                                        <label for="title" class="form-label">Titre</label>
                                        <input name="title" type="text" id="title" class="form-control" maxlength="64" required>
                                        <label for="content" class="mt-2 form-label">Message</label>
                                        <textarea required style="min-height: 200px;" name="content" type="text" id="content" class="form-control" maxlength="2056"></textarea>
                                        <div class="mt-2" style="width:100%">
                                            <div class="mb-3">
                                                <label for="formFileMultiple" class="form-label">Ajouter des fichiers</label>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
                                                <input class="form-control" type="file" id="formFileMultiple" name="files">
                                            </div>
                                        </div>
                                        <div class="mt-4 text-end">
                                            <button name="addvalve" type="submit" class="btn btn-primary">Ajouter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Modification des programmes
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Gérer les utilisateurs
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="accordion accordion-flush" id="accordionUserGestion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingUserOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseUserOne" aria-expanded="false" aria-controls="flush-collapseUserOne">
                                                    Ajouter un utilisateur
                                                </button>
                                            </h2>
                                            <div id="flush-collapseUserOne" class="accordion-collapse collapse" aria-labelledby="flush-headingUserOne" data-bs-parent="#accordionUserGestion">
                                                <div class="accordion-body">
                                                    <form class="text-center" action="/modules/admindbconnect.php" method="post">
                                                        <div class="d-flex justify-content-center flex-wrap">
                                                            <div class="input-group m-2" style="max-width: 250px; min-width: 200px">
                                                                <div class="form-floating">
                                                                    <input maxlength="30" type="text" class="form-control" id="floatingInputNom" placeholder="Nom" name="nom" required>
                                                                    <label for="floatingInputNom">Nom</label>
                                                                </div>
                                                            </div>
                                                            <div class="input-group m-2" style="max-width: 250px; min-width: 200px">
                                                                <div class="form-floating">
                                                                    <input maxlength="30" type="text" class="form-control" id="floatingInputPrenom" placeholder="Prénom" name="prenom" required>
                                                                    <label for="floatingInputPrenom">Prénom</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-center flex-wrap mb-2">
                                                            <div class="input-group m-2" style="max-width: 300px; min-width: 200px">
                                                                <div class="form-floating">
                                                                    <input maxlength="30" type="text" class="form-control" id="floatingInputLogin" placeholder="Login" name="login" required>
                                                                    <label for="floatingInputLogin">Login</label>
                                                                </div>
                                                            </div>
                                                            <div class="input-group m-2" style="max-width: 300px; min-width: 200px">
                                                                <div class="form-floating">
                                                                    <input maxlength="128" type="password" class="form-control" id="floatingInputPassword" placeholder="Mot de passe" name="password" required>
                                                                    <label for="floatingInputLogin">Mot de passe</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-center flex-wrap">
                                                            <div class="input-group mb-3" style="max-width: 700px;">
                                                                <label class="input-group-text" for="inputGroupSelect01">Assemblée</label>
                                                                <select class="form-select" id="inputGroupSelect01" name="assemblee" required>
                                                                    <option value="Lodelinsart">Lodelinsart</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex m-2 justify-content-center flex-wrap">
                                                            <div id="checkboxadmin" class="d-flex px-2 py-1 m-2 text-light rounded-3 bg-secondary bg-gradient">
                                                                <input type="checkbox" id="isAdmin" name="isAdmin" value="yes">
                                                                <label for="isAdmin" class="m-1">Administrateur</label>
                                                            </div>
                                                            <div id="checkboxpresentoir" class="d-flex px-2 py-1 m-2 text-light rounded-3 bg-secondary bg-gradient ">
                                                                <input type="checkbox" id="presentoir" name="presentoir" value="yes">
                                                                <label for="isAdmin" class="m-1">Accès aux présentoirs</label>
                                                            </div>
                                                            <div id="checkboxsono" class="d-flex px-2 py-1 m-2 text-light rounded-3 bg-secondary bg-gradient">
                                                                <input type="checkbox" id="sono" name="sono" value="yes">
                                                                <label for="sono" class="m-1">Accès aux programmes sono</label>
                                                            </div>
                                                            <div id="checkboxsono" class="d-flex px-2 py-1 m-2 text-light rounded-3 bg-secondary bg-gradient">
                                                                <input type="checkbox" id="admsono" name="admsono" value="yes">
                                                                <label for="admsono" class="m-1">Modification des programmes sono</label>
                                                            </div>
                                                        </div>
                                                        <hr class="opacity-75">
                                                        <div class="d-flex m-2 justify-content-center flex-wrap">
                                                            <button type="submit" name="adduser" class="btn btn-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
                                                                </svg>
                                                                Ajouter
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingUserTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseUserTwo" aria-expanded="false" aria-controls="flush-collapseUserTwo">
                                                    Modifier un utilisateur
                                                </button>
                                            </h2>
                                            <div id="flush-collapseUserTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingUserTwo" data-bs-parent="#accordionUserGestion">
                                                <div class="accordion-body d-flex justify-content-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="max-height: 250px; overflow:auto;">
                                                            Utilisateur à modifier
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php

                                                            $servername = "localhost";
                                                            $username = "db_app";
                                                            $password = "JWLodelinsart";
                                                            $db = "users";
                                                            $conn = new mysqli($servername, $username, $password, $db);

                                                            $stmt = $conn->prepare("SELECT * FROM users ORDER BY nom ASC, prenom asc");
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();

                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<li><a class="dropdown-item" href="/admin/?modifyuser=' . $row["ID"] . '">' . strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1)) . ' ' . strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) . '</a></li>';
                                                            }

                                                            $stmt->close();
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingUserThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseUserThree" aria-expanded="false" aria-controls="flush-collapseUserThree">
                                                    Changer le mot de passe d'un utilisateur
                                                </button>
                                            </h2>
                                            <div id="flush-collapseUserThree" class="accordion-collapse collapse" aria-labelledby="flush-headingUserThree" data-bs-parent="#accordionUserGestion">
                                                <div class="accordion-body">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</body>

</html>