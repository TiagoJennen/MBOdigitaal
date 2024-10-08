<?php
$host = "127.0.0.1";             
$dbName = "mbodigital";               
$user = "mbogodigitalUser";          
$password = "Vrieskist@247"; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbinding met de database is succesvol!<br>";
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

$username = 'Docent'; 
$plainPassword = 'Docent';

$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT * FROM docenten WHERE username = ?");
$stmt->execute([$username]);
$userExists = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userExists) {
    echo "De gebruiker met de naam '$username' bestaat al.<br>";
} else {
    try {
        $stmt = $pdo->prepare("INSERT INTO docenten (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
        echo "Testgebruiker succesvol toegevoegd!";
    } catch (PDOException $e) {
        echo "Fout bij het toevoegen van gebruiker: " . $e->getMessage();
    }
}
?>
