<?php
$host = 'localhost';
$dbName = 'mbogodigital';
$user = 'root';
$password = 'Vista@123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

$username = 'Docent';
$plainPassword = 'Docent'; 

$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO docenten (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

echo "Testgebruiker succesvol toegevoegd!";
?>
