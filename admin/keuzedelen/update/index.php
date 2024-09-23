<?php

// url: /admin/keuzedelen/update
// Dit is de controller-pagina voor het updaten van een bestaand keuzedeel
// afkomstig van het formulier /admin/keuzedelen/edit.

// Globale variabelen en functies die op bijna alle pagina's gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "applicatiebeheerder" en "administrator" hebben toegang. 
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van POST en of de variabelen bestaan.
// htmlspecialchars() wordt gebruikt om cross-site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veldnaam id opvangen en opslaan.
    if (isset($_POST["id"])) {
        $id = htmlspecialchars($_POST["id"]);
    } else {
        $errorMessage = "ID van het keuzedeel ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam name opvangen en opslaan.
    if (isset($_POST["name"])) {
        $name = htmlspecialchars($_POST["name"]);
    } else {
        $errorMessage = "Naam van het keuzedeel ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam description opvangen en opslaan.
    if (isset($_POST["description"])) {
        $description = htmlspecialchars($_POST["description"]);
    } else {
        $errorMessage = "Omschrijving van het keuzedeel ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam registerUntil opvangen en opslaan.
    if (isset($_POST["registerUntil"])) {
        $registerUntil = htmlspecialchars($_POST["registerUntil"]);
    } else {
        $errorMessage = "Inschrijfdatum van het keuzedeel ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam graduateUntil opvangen en opslaan.
    if (isset($_POST["graduateUntil"])) {
        $graduateUntil = htmlspecialchars($_POST["graduateUntil"]);
    } else {
        $errorMessage = "Diplomeren tot datum van het keuzedeel ontbreekt.";
        callErrorPage($errorMessage);
    }

} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die nodig zijn om de juiste informatie te updaten.
require_once __DOCUMENTROOT__ . '/models/Keuzedelen.php';

$result = keuzedeel::update(
    $id,
    $name,
    $description,
    $registerUntil,
    $graduateUntil
);

// Controleren of het gelukt is om het keuzedeel te updaten.
if ($result) {
    $message = "Keuzedeel met naam $name is succesvol bijgewerkt.";
} else {
    $message = "Het is niet gelukt om het keuzedeel met naam $name bij te werken.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle keuzedelen.
// Het bericht dat het keuzedeel is bijgewerkt wordt meegestuurd als variabele.
$url = "/admin/keuzedelen/overview/?message=$message";
header('Location: ' . $url, true);
exit();
