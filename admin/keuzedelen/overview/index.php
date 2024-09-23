<?php

// url: /admin/keuzedelen/overview
// Dit is de controller-pagina voor het genereren van een overzicht
// van alle keuzedelen.

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
// Controleren of de pagina is aangeroepen met behulp van een link (GET).
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Message afkomstig van andere pagina (bijv. na toevoegen of bewerken van een keuzedeel).
    if(isset($_GET["message"])) {
        $message = htmlspecialchars($_GET["message"]);
    }
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste
// informatie te bewerken.
require_once __DOCUMENTROOT__ . '/models/Keuzedelen.php'; // Aangepaste modelnaam

$keuzedelen = keuzedeel::selectAll(); // Ophalen van alle keuzedelen uit de database

// Controleren of het gelukt is om de keuzedelen op te halen uit de database.
// if (!$keuzedelen) {
//     $message = "Het is niet gelukt om alle keuzedelen op te halen uit de database.";
//     callErrorPage($message);
// }

// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$newUrl = "/admin/keuzedelen/new/"; // URL voor het toevoegen van een nieuw keuzedeel
$title = "Overzicht keuzedelen";
require __DOCUMENTROOT__ . '/views/admin/keuzedelen/overview.php'; // Aangepaste view locatie
