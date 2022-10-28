<?php
include '../modules/checkPermissions.php';
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

        .modal-backdrop.show {
            z-index: 0;
        }

        pre {
            white-space: pre-wrap;
            font-family: var(--bs-body-font-family);
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

            <div class="p-3">

                <?php
                if (isset($_GET["pwdchanged"])) {
                    echo "<div class='alert alert-success' role='alert'>
                                Le mot de passe a été modifié !
                            </div>
                            ";
                } ?>

                <?php
                if (isset($_GET["failconfpwd"])) {
                    echo "<div class='alert alert-danger' role='alert'>
                                    Le mot de passe n'a pas été modifié ! <br>
                                    Raison : Les 2 mots de passes ne correspondent pas.
                            </div>
                            ";
                } ?>

                <?php
                if (isset($_GET["notoldpwd"])) {
                    echo "<div class='alert alert-danger' role='alert'>
                    Le mot de passe n'a pas été modifié ! <br>
                    Raison : Votre ancien mot de passe n'est pas correct.
                            </div>
                            ";
                } ?>

                <?php

                ini_set('display_errors', 'On');
                ini_set('html_errors', 0);
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                $servername = "localhost";
                $username = "db_app";
                $password = "JWLodelinsart";
                $db = "users";
                // Create connection
                $conn = new mysqli($servername, $username, $password, $db);

                $stmt = $conn->prepare('SELECT * FROM valve ORDER BY ID DESC');
                $stmt->execute();
                $result = $stmt->get_result();

                $issmth = False;
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card mt-2 rounded-4"><div class="card-header d-flex justify-content-between"><h5>';
                    echo $row["titre"];
                    echo '</h5>';

                    if ($_SESSION["admin"]) {
                        echo '<button type="submit" name="removevalve" class="btn-close" data-bs-toggle="modal" data-bs-target="#suretodelete';
                        echo $row["ID"];
                        echo '" aria-label="Close"></button>';

                        echo '<div class="modal fade" id="suretodelete';
                        echo $row["ID"];
                        echo '" tabindex="-1" aria-labelledby="suretodeletelabel';
                        echo $row["ID"];
                        echo '" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="suretodeletelabel';
                        echo $row["ID"];
                        echo '">Confirmation</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cette note ?
                                </div>
                                <div class="modal-footer">
                                <form action="/modules/admindbconnect.php" method="POST">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-danger" name="removevalve" value="';
                        echo $row["ID"];
                        echo '">Supprimer</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>';
                    }

                    echo '</div><div class="card-body">';
                    echo '<pre class="card-text">' . $row["message"] . '</pre>';

                    if ($row["fichiers"] != Null) {
                        echo '<a type="button" class="btn btn-primary" style="width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" download="' . $row["fichiers"] . '" href="';
                        echo '/files/' . $row["fichiers"];
                        echo '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                    </svg>  ' . $row["fichiers"] . '</a>';
                    }

                    echo '</div><div class="card-footer text-muted d-flex justify-content-between">Écrit par ';

                    $stmt2 = $conn->prepare('SELECT nom, prenom FROM users WHERE ID = ?');
                    $stmt2->bind_param("s", $row["auteur"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $row2 = $result2->fetch_assoc();

                    echo strtoupper($row2["nom"][0]);
                    echo strtolower(substr($row2["nom"], 1));
                    echo " ";
                    echo strtoupper($row2["prenom"][0]);
                    echo strtolower(substr($row2["prenom"], 1));

                    echo '</div></div>';

                    $issmth = True;
                }

                if (!$issmth) {
                    echo '<div class="text-center m-5 text-muted h2">Rien de nouveau pour le moment !</div>';
                }

                ?>
                <div class="mb-5" style="height: 100px;"></div>

            </div>
        </div>
    </div>

</body>

</html>