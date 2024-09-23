<?php

// url: /admin/keuzedelen/detail
// Dit is de controller-pagina voor het genereren van een detailpagina van één keuzedeel.

// Globale variabelen en functies die op bijna alle pagina's gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Controleren of de gebruiker de juiste rechten heeft, zoals "applicatiebeheerder" en "administrator".
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van GET en of de id meegegeven is.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Veldnaam id opvangen en opslaan.
    if (isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"]);
    } else {
        $errorMessage = "De id van het keuzedeel is niet meegegeven.";
        callErrorPage($errorMessage);
    }
} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen GET gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats om de informatie van het keuzedeel op te halen.
require_once __DOCUMENTROOT__ . '/models/Keuzedelen.php';

$keuzedeel = keuzedeel::select($id);

if (!$keuzedeel) {
    $errorMessage = "Het keuzedeel met id $id is niet gevonden.";
    callErrorPage($errorMessage);
}

// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald. 
$title = "Keuzedeel detailoverzicht";
$id = $keuzedeel["id"];
$code = $keuzedeel["code"];
$title = $keuzedeel["title"];
$sbu = $keuzedeel["sbu"];
$description = $keuzedeel["description"];
$goalsDescription = $keuzedeel["goalsDescription"];
$preconditions = $keuzedeel["preconditions"];
$teachingMethods = $keuzedeel["teachingMethods"];
$certificate = $keuzedeel["certificate"];
$linkVideo = $keuzedeel["linkVideo"];
$linkKD = $keuzedeel["linkKD"];

$editUrl = "/admin/keuzedelen/edit/";
$overviewUrl = "/admin/keuzedelen/overview/";

require __DOCUMENTROOT__ . '/views/admin/keuzedelen/detailedview.php';
