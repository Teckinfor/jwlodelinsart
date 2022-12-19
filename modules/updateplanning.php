<?php

include '../modules/checkPermissions.php';

if (!$_SESSION["admin"]) {
    header("Location: /accueil/");
}

// Afficher les erreurs

ini_set('display_errors', 'On');
ini_set('html_errors', 0);

// Vérifier que le programme est déjà généré : 

if (!file_exists("./programmes/" . $_POST["year"] . $_POST["months"] . ".json")) {
    header("Location: ../admin/?havetobegenerated");
}


// Liste des utilisateurs

$annuaire = array();

$servername = "localhost";
$username = "db_app";
$password = "JWLodelinsart";
$db = "users";
$conn = new mysqli($servername, $username, $password, $db);

$stmt = $conn->prepare("SELECT * FROM users ORDER BY nom ASC, prenom asc");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) . ' ' . strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));
    $annuaire[$row["ID"]] = $name;
}

$stmt->close();


// Lecture du programme

$data = file_get_contents("./programmes/" . $_POST["year"] . $_POST["months"] . ".json");
$content = json_decode($data);

// Vars db

$servername = "localhost";
                                    $username = "db_app";
                                    $password = "JWLodelinsart";
                                    $db = "users";
                                    $conn = new mysqli($servername, $username, $password, $db);

// Interface de modification

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

        <div class="box pb-5">

            <?php

            foreach ($content as $weeknb => $week) {

                echo '

                <div class="p-2">
                <div class="card">

                    <div class="card-header" style="text-align: center">
                        <h4><b>'. $week->date .'</b></h4>
                    </div>
                    <div class="card-body">

                        <div class="text-center">
                            <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                            <h5>Informations</h5>
                            <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                            <div class="d-flex flex-wrap justify-content-center">

                                <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                    <label class="input-group-text" for="'. $weeknb . '-presidence">Président</label>
                                    <select class="form-select" id="'. $weeknb . '-presidence" name="'. $weeknb .'-président" required>';

                                    $vartemp = $week->président;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE ancien ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                </div>
                                <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                    <label class="input-group-text" for="'. $weeknb . '-priere1">Prière initale</label>
                                    <select class="form-select" id="'. $weeknb . '-priere1" name="'. $weeknb .'-prière1" required>';

                                    $vartemp = $week->prière1;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE frere ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                </div>
                                <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                    <label class="input-group-text" for="'. $weeknb . '-priere2">Prière finale</label>
                                    <select class="form-select" id="'. $weeknb . '-priere2" name="'. $weeknb .'-prière2" required>';

                                    $vartemp = $week->prière2;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE frere ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                </div>

                            </div>
                            <div class="d-flex flex-wrap justify-content-center">
                                <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                    <label class="input-group-text" for="'. $weeknb . '-special">Semaine sans réunion</label>
                                    <select class="form-select" id="'. $weeknb . '-special" name="months" required>
                                        <option value="False">Non</option>
                                        <option value="True">Oui</option>
                                    </select>
                                </div>
                                <div class="input-group ms-3 mt-1" style="max-width: 320px; height: calc(2.5rem + 2px);">
                                    <span class="input-group-text" id="'. $weeknb . '-raison">Raison</span>
                                    <input style="height:auto" type="text" class="form-control" placeholder="Raison de la semaine spéciale" aria-label="Username" aria-describedby="'. $weeknb . '-raison">
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                            <h5>
                                Joyaux de la parole de Dieu
                            </h5>
                            <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                            <div class="d-flex flex-wrap justify-content-center">
                                <div class="border border-3 p-3 m-2">
                                    <h6>'. $week->discourJoyauxTitre .'</h6>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                            <label class="input-group-text" for="'. $weeknb . '-joyaux">Orateur</label>
                                            <select class="form-select" id="'. $weeknb . '-joyaux" name="'. $weeknb .'-discourJoyauxOrateur" required>';

                                    $vartemp = $week->discourJoyauxOrateur;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE assistant ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-3  p-3 m-2">
                                    <h6>Perles spirituelles</h6>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                            <label class="input-group-text" for="'. $weeknb . '-perles">Orateur</label>
                                            <select class="form-select" id="'. $weeknb . '-perles" name="'. $weeknb .'-PerlesSpirituellesOrateur" required>';

                                    $vartemp = $week->PerlesSpirituellesOrateur;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE assistant ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-3  p-3 m-2">
                                    <h6>Lecture de la bible : '. $week->lectureDeLaBibleTexte .'</h6>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                            <label class="input-group-text" for="'. $weeknb . '-lecteurbible">Lecteur</label>
                                            <select class="form-select" id="'. $weeknb . '-lecteurbible" name="'. $weeknb .'-lectureDeLaBibleLeçonLecteur" required>';

                                    $vartemp = $week->lectureDeLaBibleLeçonLecteur;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE frere ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                            <h5>
                                Applique-toi au ministère
                            </h5>
                            <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                            <div class="d-flex flex-wrap justify-content-center">

                            ';

                                    foreach($week->AppliqueToiAuMinistere as $sujetid => $sujet){

                                        if ($sujet->Titre != "Discours") {
                                            if (isset($sujet->Leçon)) {
                                            
                                            echo '
                                            
                                            <div class="border border-3 p-3 m-2">
                                                <h6>'.$sujet->Titre.'</h6>
                                                <div class="">
                                                    <div class="input-group m-2" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                                        <label class="input-group-text" for="'. $weeknb . $sujetid . '-p1">Participant</label>
                                                        <select class="form-select" id="'. $weeknb . $sujetid . '-p1" name="'. $weeknb .'sujet-'. $sujetid .'-Participant1" required>';

                                    $vartemp = $sujet->Participant1;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE ecole ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                                    </div>
                                                    <div class="input-group m-2" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                                        <label class="input-group-text" for="'. $weeknb . $sujetid . '-p2">Accompagnant</label>
                                                        <select class="form-select" id="'. $weeknb . $sujetid . '-p2" name="'. $weeknb .'sujet-'. $sujetid .'-Participant2" required>';

                                    $vartemp = $sujet->Participant2;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE ecole ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                                    </div>
                                                </div>
                                            </div>
                                            ';

                                            }

                                        } else {
                                            echo '
                                            <div class="border border-3 p-3 m-2">
                                    <h6> Discours : '. $sujet->Desc .'</h6>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                            <label class="input-group-text" for="'. $weeknb . $sujetid . '-p1">Orateur</label>
                                            <select class="form-select" id="'. $weeknb . $sujetid . '-p1" name="'. $weeknb .'sujet-'. $sujetid .'-Participant1" required>';

                                    $vartemp = $sujet->Participant1;

                                    if ($vartemp == "") {
                                        echo '<option value="" selected>--Personne--</option>';
                                    } else {
                                        echo '<option value="">--Personne--</option>';
                                    }

                                    $stmt = $conn->prepare("SELECT * FROM users WHERE frere ORDER BY nom ASC, prenom asc;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));

                                        if ($vartemp == $name) {
                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                        } else {
                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                        }
                                        
                                    }

                                    $stmt->close();

                                        
                                    echo '</select>
                                        </div>
                                    </div>
                                </div>
                            
                                            ';
                                        }
                                    }

                                
                               echo '
                               
                               </div>
                            <div class="text-center">
                                <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                                <h5>
                                    Vie Chrétienne
                                </h5>
                                <hr class="border border-secondary border-3 opacity-75" style="max-width: 600px; margin-left: auto; margin-right: auto;">

                                <div class="">
                                    <div class="">
                                    <div class="d-flex flex-wrap justify-content-center">';

                                    foreach($week->VieChrétienne as $id => $sujet){
                                        
                                        echo'
                                        <div class="border border-3 p-3 m-2" style="max-width:600px">
                                        <h6>'. $sujet->Titre .'</h6>
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                                <label class="input-group-text" for="'. $weeknb . $id . '-sujetvc">Orateur</label>
                                                <select class="form-select" id="'. $weeknb . $id . '-sujetvc" name="'. $weeknb . $id .'-vc-participant" required>';

                                                $vartemp = $sujet->Participant;
            
                                                if ($vartemp == "") {
                                                    echo '<option value="" selected>--Personne--</option>';
                                                } else {
                                                    echo '<option value="">--Personne--</option>';
                                                }
            
                                                $stmt = $conn->prepare("SELECT * FROM users WHERE assistant ORDER BY nom ASC, prenom asc;");
                                                $stmt->execute();
                                                $result = $stmt->get_result();
            
                                                while ($row = $result->fetch_assoc()) {
                                                    $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));
            
                                                    if ($vartemp == $name) {
                                                        echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                                    } else {
                                                        echo '<option value="'.$name.'">'. $name . '</option>';
                                                    }
                                                    
                                                }
            
                                                $stmt->close();
            
                                                    
                                                echo '</select>
                                            </div>
                                        </div>
                                    </div>
                                        ';
                                    }

                                        
                                        
                                        
                                        echo '</div><div class="m-2 mt-3">
                                            <h6>Etude biblique de l\'assemblée</h6>
                                            <div class="d-flex flex-wrap justify-content-center">
                                                <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                                    <label class="input-group-text" for="'. $weeknb . '-orateuretude">Orateur</label>
                                                    <select class="form-select" id="'. $weeknb . '-orateuretude" name="'. $weeknb .'-EtudeBibliquePresident"" required>';

                                                    $vartemp = $week->EtudeBibliquePresident;
                
                                                    if ($vartemp == "") {
                                                        echo '<option value="" selected>--Personne--</option>';
                                                    } else {
                                                        echo '<option value="">--Personne--</option>';
                                                    }
                
                                                    $stmt = $conn->prepare("SELECT * FROM users WHERE ancien ORDER BY nom ASC, prenom asc;");
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                
                                                    while ($row = $result->fetch_assoc()) {
                                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));
                
                                                        if ($vartemp == $name) {
                                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                                        } else {
                                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                                        }
                                                        
                                                    }
                
                                                    $stmt->close();
                
                                                        
                                                    echo '</select>
                                                </div>
                                                <div class="input-group ms-3 mt-1" style="max-width: 300px; height: calc(2.5rem + 2px);">
                                                    <label class="input-group-text" for="'. $weeknb . '-lecteuretude">Lecteur</label>
                                                    <select class="form-select" id="'. $weeknb . '-lecteuretude" name="'. $weeknb .'-EtudeBibliqueLecteur"" required>';

                                                    $vartemp = $week->EtudeBibliqueLecteur;
                
                                                    if ($vartemp == "") {
                                                        echo '<option value="" selected>--Personne--</option>';
                                                    } else {
                                                        echo '<option value="">--Personne--</option>';
                                                    }
                
                                                    $stmt = $conn->prepare("SELECT * FROM users WHERE frere ORDER BY nom ASC, prenom asc;");
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                
                                                    while ($row = $result->fetch_assoc()) {
                                                        $name = strtoupper($row["prenom"][0]) . strtolower(substr($row["prenom"], 1)) ." ".strtoupper($row["nom"][0]) . strtolower(substr($row["nom"], 1));
                
                                                        if ($vartemp == $name) {
                                                            echo '<option value="'.$name.'" selected>'. $name . '</option>';
                                                        } else {
                                                            echo '<option value="'.$name.'">'. $name . '</option>';
                                                        }
                                                        
                                                    }
                
                                                    $stmt->close();
                
                                                        
                                                    echo '</select>
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
            
            ';
            }

            ?>

            
        </div>
    </div>

</body>

</html>