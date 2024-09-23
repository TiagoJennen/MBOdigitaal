<?php

// url: /admin/keuzedelen/new
// Dit is de controller-pagina voor het formulier om een nieuw keuzedeel toe te voegen.

// Globale variabelen en functies die op bijna alle pagina's gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Controleren of de gebruiker is ingelogd en de juiste rechten heeft. 
// Alleen "applicatiebeheerder" en "administrator" hebben toegang.
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van een link (GET).
// Geen specifieke GET-parameters zijn hier vereist, aangezien dit een nieuwe invoerpagina is.

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste informatie klaar te zetten voor het formulier.

// 4. VIEWS OPHALEN
// De HTML-pagina (view) voor het toevoegen van een nieuw keuzedeel wordt hier opgehaald.
// $title is de titel van de HTML-pagina.
$title = "Keuzedeel toevoegen";
$editmode = false;
$actionUrl = "/admin/keuzedelen/add/"; // De URL waar het formulier naartoe wordt verzonden.
require __DOCUMENTROOT__ . '/views/admin/keuzedelen/form.php';
