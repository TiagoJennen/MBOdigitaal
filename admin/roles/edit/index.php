<?php

// url: /admin/roles/edit
// Dit is de controller-pagina voor het bewerkingsformulier van een bestaande rol.

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER['DOCUMENT_ROOT'] . '/config/globalvars.php';
require $_SERVER['DOCUMENT_ROOT'] . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "applicatiebeheerder" en "administrator" hebben toegang. 

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form GET
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Veldnaam id opvangen en opslaan.
    if(isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"]);
    }
    else {
        $errorMessage = "De id van de rol is niet meegegeven.";
        callErrorPage($errorMessage);
    }
}
else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen GET gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina
// wordt getoond.
// Informatie van bestaande rol wordt opgehaald uit de database.
require $_SERVER['DOCUMENT_ROOT'] . '/models/Roles.php';

$role = Role::select($id);

// Controleren of het gelukt is om een rol toe te voegen aan de database.
if (!$role) {
    $message = "Het is niet gelukt om de rol met de id $id op te halen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Formulier rol bewerken";
$editmode = true;
$actionUrl = "/admin/roles/update";
$idValue = $role["id"];
$nameValue = $role["name"];
$levelValue = $role["level"];
require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/roles/form.php';
