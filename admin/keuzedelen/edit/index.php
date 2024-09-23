<?php

// url: /admin/keuzedelen/edit
// Dit is de controller-pagina voor het bewerkingsformulier van een bestaand keuzedeel.

// Globale variabelen en functies die op bijna alle pagina's gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Controleren of de geb/ruiker de juiste rechten heeft. 
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van GET en of de variabelen bestaan.
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
// Informatie van het bestaande keuzedeel wordt opgehaald uit de database.
require_once __DOCUMENTROOT__ . '/models/Keuzedelen.php';

$keuzedeel = keuzedeel::select($id);

// Controleren of het gelukt is om het keuzedeel op te halen.
if (!$keuzedeel) {
    $message = "Het is niet gelukt om een keuzedeel met de id $id op te halen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// De HTML-pagina (view) wordt hier opgehaald.
$title = "Formulier keuzedeel bewerken";
$editmode = true;
$actionUrl = "/admin/keuzedelen/update/";
$idValue = $keuzedeel["id"];
$codeValue = $keuzedeel["code"];
$titleValue = $keuzedeel["title"];
$sbuValue = $keuzedeel["sbu"];
$descriptionValue = $keuzedeel["description"];
$goalsDescriptionValue = $keuzedeel["goalsDescription"];
$preconditionsValue = $keuzedeel["preconditions"];
$teachingMethodsValue = $keuzedeel["teachingMethods"];
$certificateValue = $keuzedeel["certificate"];
$linkVideoValue = $keuzedeel["linkVideo"];
$linkKDValue = $keuzedeel["linkKD"];

$editUrl = "/admin/keuzedelen/edit/";

require __DOCUMENTROOT__ . '/views/admin/keuzedelen/form.php';
