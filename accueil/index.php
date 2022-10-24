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

        pre{
            white-space: pre-wrap;
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
                    echo '<div class="card mt-2"><div class="card-header d-flex justify-content-between"><h5>';
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
                    echo '</div><div class="card-footer text-muted">Écrit par ';

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

                if (!$issmth){
                    echo '<div class="text-center m-5 text-muted h2">Rien de nouveau pour le moment !</div>';
                }

                ?>
                <div class="mb-5" style="height: 100px;"></div>

            </div>

        </div>
    </div>

</body>

</html>