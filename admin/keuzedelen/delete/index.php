<?php

// url: /admin/keuzedelen/delete
// Dit is de controller-pagina voor het verwijderen van een keuzedeel.

// Globale variabelen en functies die op bijna alle pagina's gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Controleren of de gebruiker de juiste rechten heeft.
require_once __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van GET en of de variabelen wel bestaan.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Verdnaam id opvangen en opslaan.
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
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina wordt getoond.
require __DOCUMENTROOT__ . '/models/Keuzedelen.php';

$result = keuzedeel::delete($id);

// Controleren of het gelukt is om het keuzedeel te verwijderen.
if ($result) {
    $message = "Keuzedeel met id $id is verwijderd.";
} else {
    $message = "Het is niet gelukt om dit keuzedeel te verwijderen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Redirect naar het overzicht van alle keuzedelen.
$url = "/admin/keuzedelen/overview/?message=" . urlencode($message);
header('Location: ' . $url, true);
exit();
