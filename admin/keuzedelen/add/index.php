<?php

// url: /admin/keuzedelen/add
// Dit is de controller-pagina voor het toevoegen van een nieuw keuzedeel.

// Globale variabelen en functies die op bijna alle pagina's gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Controleren of de gebruiker de juiste rechten heeft, zoals "applicatiebeheerder" of "administrator".
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met form POST en of de variabelen bestaan.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veldnaam code opvangen en opslaan.
    if (isset($_POST["code"])) {
        $code = htmlspecialchars($_POST["code"]);
    } else {
        $errorMessage = "Code van het keuzedeel is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam title opvangen en opslaan.
    if (isset($_POST["title"])) {
        $title = htmlspecialchars($_POST["title"]);
    } else {
        $errorMessage = "Titel van het keuzedeel is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam description opvangen en opslaan.
    if (isset($_POST["description"])) {
        $description = htmlspecialchars($_POST["description"]);
    } else {
        $errorMessage = "Omschrijving van het keuzedeel is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam sbu (Studiebelastingsuren) opvangen en opslaan.
    if (isset($_POST["sbu"])) {
        $sbu = htmlspecialchars($_POST["sbu"]);
    } else {
        $errorMessage = "Studiebelastingsuren van het keuzedeel zijn niet ingevuld of ontbreken.";
        callErrorPage($errorMessage);
    }

    // Optionele velden zoals doelen, preconditions, etc. opvangen.
    $goalsDescription = isset($_POST["goalsDescription"]) ? htmlspecialchars($_POST["goalsDescription"]) : null;
    $preconditions = isset($_POST["preconditions"]) ? htmlspecialchars($_POST["preconditions"]) : null;
    $teachingMethods = isset($_POST["teachingMethods"]) ? htmlspecialchars($_POST["teachingMethods"]) : null;
    $certificate = isset($_POST["certificate"]) ? (int)$_POST["certificate"] : 0;
    $linkVideo = isset($_POST["linkVideo"]) ? htmlspecialchars($_POST["linkVideo"]) : null;
    $linkKD = isset($_POST["linkKD"]) ? htmlspecialchars($_POST["linkKD"]) : null;
    
} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Acties om het keuzedeel toe te voegen aan de database.
require_once __DOCUMENTROOT__ . '/models/Keuzedelen.php';

$result = keuzedeel::insert(
    $code,
    $title,
    $description,
    $sbu,
    $goalsDescription,
    $preconditions,
    $teachingMethods,
    $certificate,
    $linkVideo,
    $linkKD
);

// Controleren of het gelukt is om een keuzedeel toe te voegen aan de database.
if ($result) {
    $message = "Keuzedeel met titel $title is toegevoegd.";
} else {
    $message = "Het is niet gelukt om een nieuw keuzedeel toe te voegen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Redirect naar het overzicht van alle keuzedelen.
$url = "/admin/keuzedelen/overview/?message=" . urlencode($message);
header('Location: ' . $url, true);
exit();

