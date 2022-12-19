<?php

include '../modules/checkPermissions.php';

if (!$_SESSION["admin"]) {
    header("Location: /accueil/");
}

// Afficher les erreurs

ini_set('display_errors', 'On');
ini_set('html_errors', 0);


// Fonction pour le remplacement

function replaceNbspWithSpace($content)
{
    $string = htmlentities($content, 0, 'utf-8');
    $content = str_replace("&nbsp;", " ", $string);
    $content = html_entity_decode($content);
    return $content;
}

// Ce programme à pour but de créer automatiquement des Google Sheets basées sur le programme disponible sur le site wol.jw.org.

// Variable pour un potentiel message d'erreur
$errorMsg = Null;

// Traduction de la variable reçue POST

$tradMonths = array(
    "January&February" => ["January", "February"],
    "March&April" => ["March", "April"],
    "May&June" => ["May", "June"],
    "July&August" => ["July", "August",],
    "September&October" => ["September", "October"],
    "November&December" => ["November", "December"],
);

// Détermination du numéro des semaines pour chaque mois

if (!isset($_POST["year"])) {
    $errorMsg = "Aucune année n'est renseignée.";
} else {

    date_default_timezone_set('UTC');

    $months_pair = array(
        "January" => [],
        "February" => [],
        "March" => [],
        "April" => [],
        "May" => [],
        "June" => [],
        "July" => [],
        "August" => [],
        "September" => [],
        "October" => [],
        "November" => [],
        "December" => [],
    );

    $countday = 1;
    $countmonth = 1;
    $year = $_POST["year"];
    $countweek = 1;

    while ($countweek < 52) {

        $countweek = intval(date("W", mktime(0, 0, 0, $countmonth, $countday, $year)));

        while ($countweek == 52) {
            $countday++;
            $countweek = intval(date("W", mktime(0, 0, 0, $countmonth, $countday, $year)));
        }

        $countdaysofmonth = intval(date("t", mktime(0, 0, 0, $countmonth, $countday, $year)));

        $numberOfWeeksInMonth = floor(($countdaysofmonth - ($countday - 1)) / 7);
        if ((($countdaysofmonth - ($countday - 1)) % 7) != 0) {
            $numberOfWeeksInMonth++;
        }

        array_push($months_pair[date("F", mktime(0, 0, 0, $countmonth, 1, $year))], $countweek);

        $countweek += $numberOfWeeksInMonth;

        array_push($months_pair[date("F", mktime(0, 0, 0, $countmonth, 1, $year))], $countweek - 1);

        // echo date("F", mktime(0, 0, 0, $countmonth, 1, $year)) . " : " . $numberOfWeeksInMonth . "<br>";

        $countday = (($numberOfWeeksInMonth * 7) + $countday) - $countdaysofmonth;

        $countmonth++;
    }

    // Vérifier months_pair
    // print_r($months_pair);

}

// 1ère partie : Détermination des semaines à considérer

if ($errorMsg == Null) {

    if (!isset($_POST["months"])) {
        $errorMsg = "Aucune période de mois n'est renseignée.";
    } else {

        $weeksToFetch = array();

        foreach ($months_pair[$tradMonths[$_POST["months"]][0]] as $week) {
            $weeksToFetch[] = $week;
        }
        foreach ($months_pair[$tradMonths[$_POST["months"]][1]] as $week) {
            $weeksToFetch[] = $week;
        }

        // Vérifier months_pair
        // print_r($weeksToFetch);
    }
}

// 2ème partie : Création d'un array reprenant les informations des 2 mois concernés

if ($errorMsg == Null) {
    $count = $weeksToFetch[0];
    $fullContent = array();

    if (!file_exists("./programmes/" . $_POST["year"] . $_POST["months"] . ".json")) {


        while ($count <= $weeksToFetch[3] && $errorMsg == Null) {

            $program = new DOMDocument;
            @$program->loadHTMLFile("https://wol.jw.org/fr/wol/meetings/r30/lp-f/" . $_POST["year"] . "/" . $count);

            if (false === $program) {
                $errorMsg = "Problème lors de l'accès au programme sur le WEB";
            } else {

                $content = array();

                if (isset($program->getElementById("p2")->firstChild->textContent)) {

                    // Date de la réunion
                    // $tempVar = replaceNbspWithSpace($program->getElementById("p1")->childNodes[1]->textContent);
                    // preg_match_all('/\d\-/', $tempVar, $match, PREG_SET_ORDER, 0);
                    // $content["date"]["jour"] = intval($match[0][0]) + 2;
                    // preg_match_all('/\s[a-zA-Z]{1,100}/', $tempVar, $match, PREG_SET_ORDER, 0);
                    // $content["date"]["mois"] = $match[0][0];
                    $content["date"] = replaceNbspWithSpace($program->getElementById("p1")->childNodes[1]->textContent);

                    $content["special"] = False;

                    // Portion de la bible pour la semaine
                    $content["texteDeLaSemaine"] = $program->getElementById("p2")->firstChild->textContent;

                    // Prières
                    $content["prière1"] = "";
                    $content["prière2"] = "";

                    // Président
                    $content["président"] = "";

                    // Cantiques
                    $content["cantique1"] = explode(chr(0xC2) . chr(0xA0), $program->getElementById("section1")->childNodes[1]->childNodes[1]->childNodes[0]->childNodes[0]->childNodes[0]->textContent, 2)[1];
                    $content["cantique2"] = explode(chr(0xC2) . chr(0xA0), $program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes[0]->childNodes[0]->textContent, 2)[1];
                    $content["cantique3"] = explode(chr(0xC2) . chr(0xA0), $program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes[count($program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes) - 2]->firstChild->firstChild->textContent, 2)[1];

                    // Discours des joyaux
                    if (isset($program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes[0]->childNodes[0]->childNodes[2]->childNodes[0]->textContent)) {
                        $content["discourJoyauxTitre"] = $program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes[0]->childNodes[0]->childNodes[2]->childNodes[0]->textContent;
                    } else {
                        $content["discourJoyauxTitre"] = $program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes[0]->childNodes[0]->childNodes[0]->childNodes[0]->textContent;
                    }

                    $content["discourJoyauxOrateur"] = "";

                    // Perles spirituelles
                    $content["PerlesSpirituellesTitre"] = "Recherchons les perles spirituelles";
                    $content["PerlesSpirituellesOrateur"] = "";

                    // Lecture de la bible
                    $content["lectureDeLaBibleTexte"] = $program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes[count($program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes) - 2]->childNodes[0]->childNodes[2]->textContent;
                    $content["lectureDeLaBibleLeçon"] = explode(chr(0xC2) . chr(0xA0), $program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes[count($program->getElementById("section2")->childNodes[3]->childNodes[1]->childNodes) - 2]->childNodes[0]->childNodes[4]->childNodes[1]->textContent, 2)[1];
                    $content["lectureDeLaBibleLeçonLecteur"] = "";

                    $content["AppliqueToiAuMinistere"] = array();

                    // Devoirs
                    $countSujet = 0;
                    foreach ($program->getElementById("section3")->childNodes[3]->childNodes[1]->childNodes as $sujet) {
                        if (isset($sujet->firstChild)) {

                            $content["AppliqueToiAuMinistere"]["sujet" . $countSujet] = array();

                            // Titre du sujet
                            if (isset($sujet->firstChild->childNodes[2]->childNodes[0]->firstChild->length)) {
                                if ($sujet->firstChild->childNodes[2]->childNodes[0]->firstChild->length > 30) {
                                    $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Titre"] = $sujet->firstChild->childNodes[2]->childNodes[0]->firstChild->textContent;
                                } else {
                                    $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Titre"] = $sujet->firstChild->firstChild->firstChild->textContent;
                                }
                            } else {
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Titre"] = $sujet->firstChild->firstChild->firstChild->textContent;
                            }

                            // Leçon du sujet
                            if (strpos($sujet->firstChild->childNodes[count($sujet->firstChild->childNodes) - 2]->textContent, "th") !== false) {
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Leçon"] = $sujet->firstChild->childNodes[count($sujet->firstChild->childNodes) - 2]->textContent;
                            } else {
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Leçon"]  = null;
                            }

                            if ($content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Leçon"]  != null) {
                                $re = '/([\d]{1,2})/';
                                $string = strval($content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Leçon"] );
                                preg_match_all($re, $string, $match, PREG_SET_ORDER, 0);
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Leçon"]  = $match[0][0];
                            }

                            // Description du sujet
                            $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"]  = "";
                            foreach ($sujet->firstChild->childNodes as $data) {
                                if (isset($data->textContent)) {
                                    if ($data->textContent != $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Titre"]) {
                                        $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] . $data->textContent;
                                    }
                                }
                            }

                            // Durée du sujet

                            if (strpos($content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"], "min)") !== false) {
                                $re = '/([\d]{1,2})/';
                                $string = strval($content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"]);
                                preg_match_all($re, $string, $match, PREG_SET_ORDER, 0);
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Duree"] = $match[0][0];
                            }

                            // Suppression des () pour le temps et les leçons
                            $tempVar = explode(":", $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"]);
                            $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = "";
                            for ($i = 1; $i < count($tempVar); $i++) {
                                if ($i > 1) {
                                    $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] . ": ";
                                }
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] . $tempVar[$i];
                            }

                            $tempVar = explode("(", $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"]);
                            $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = "";
                            for ($i = 0; $i < count($tempVar) - 1; $i++) {
                                if ($i > 0) {
                                    $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] . "(";
                                }
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] = $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Desc"] . $tempVar[$i];
                            }

                            // Participants
                            $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Participant1"] = "";
                            if ($content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Titre"] != "Discours") {
                                $content["AppliqueToiAuMinistere"]["sujet" . $countSujet]["Participant2"] = "";
                            }

                            $countSujet++;
                        }
                    }

                    $content["VieChrétienne"] = array();

                    $countSujet = -1;
                    foreach ($program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes as $sujet) {
                        if (isset($sujet->firstChild)) {

                            // Titre du sujet
                            $content["VieChrétienne"]["sujet" . $countSujet]["Titre"] = $sujet->firstChild->textContent;

                            // Durée du sujet

                            if (strpos($content["VieChrétienne"]["sujet" . $countSujet]["Titre"], "min)") !== false) {
                                $re = '/([\d]{1,2})/';
                                $string = strval($content["VieChrétienne"]["sujet" . $countSujet]["Titre"]);
                                preg_match_all($re, $string, $match, PREG_SET_ORDER, 0);
                                $content["VieChrétienne"]["sujet" . $countSujet]["Duree"] = $match[0][0];
                            }

                            // Suppression (x min) 

                            $regx = '/\([\d]{1,2}.min\)/';
                            $text = replaceNbspWithSpace($content["VieChrétienne"]["sujet" . $countSujet]["Titre"]);
                            $content["VieChrétienne"]["sujet" . $countSujet]["Titre"] = preg_replace($regx, "", $text);
                            $countSujet++;

                            // Ajout des participants
                            $content["VieChrétienne"]["sujet" . $countSujet]["Participant"] = "";

                        }
                    }

                    // Suppression des 2 cantiques + paroles de conclusions + etude biblique
                    unset($content["VieChrétienne"]["sujet-1"]);
                    unset($content["VieChrétienne"]["sujet" . count($content["VieChrétienne"]) - 1]);
                    unset($content["VieChrétienne"]["sujet" . count($content["VieChrétienne"]) - 1]);
                    unset($content["VieChrétienne"]["sujet" . count($content["VieChrétienne"]) - 1]);
                    unset($content["VieChrétienne"]["sujet" . count($content["VieChrétienne"]) - 1]);

                    // Ajout de l'etude biblique

                    $nbsujet = count($program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes);
                    $countelement = count($program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes[$nbsujet - 6]->firstChild->childNodes);
                    $content["EtudeBiblique"] = "";
                    for ($i = 2; $i < $countelement; $i++) {
                        $content["EtudeBiblique"] = $content["EtudeBiblique"] . $program->getElementById("section4")->childNodes[3]->childNodes[1]->childNodes[$nbsujet - 6]->firstChild->childNodes[$i]->textContent;
                    }

                    // President de l'etude
                    $content["EtudeBibliquePresident"] = "";

                    // Lecteur de l'etude
                    $content["EtudeBibliqueLecteur"] = "";


                    // print_r($content);
                    // echo "<br>";
                    // echo "<br>";
                } else {
                    $content["special"] = True;
                    $content["reason"] = "";
                    // print_r($content);
                    // echo "<br>";
                    // echo "<br>";
                }
            }
            $fullContent[$count] = $content;
            $count++;
        }

        $document = json_encode($fullContent);
        file_put_contents("./programmes/" . $_POST["year"] . $_POST["months"] . ".json", $document);
    }
}

if ($errorMsg == Null) {

    header("Location: ../admin/?isGenerated");
    
}

echo $errorMsg;
