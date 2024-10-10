<?php
// Foutmeldingen weergeven
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Databaseverbinding
$host = "127.0.0.1";
$dbName = "mbodigital";
$user = "mbogodigitalUser";
$password = "Vrieskist@247";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Voorbeeld variabelen (vervang deze door de waarden van je formulier)
$opleidingen = "'6c93a885-9c11-4746-af76-b4b79ed3f1d0', '6e606817-054b-4752-b801-0459dd8c2789'"; // Vul hier je opleiding ID's in
$keuzedelen = "'03b9ae14-c7ff-447b-a009-aa365bc1ee8f', 'k0788'"; // Vul hier je keuzedeel ID's in
$cohorten = "'2021', '2022'"; // Vul hier je cohort jaren in

// SQL-query
$sql = "
    SELECT student.id AS student_id, keuzedeel.title AS keuzedeel_naam, groepen.cohort AS jaar 
    FROM student
    JOIN student_keuzedeel ON student.id = student_keuzedeel.student_id
    JOIN keuzedeel ON student_keuzedeel.keuzedeel_id = keuzedeel.id
    JOIN groepen ON groepen.id = student.duoNumber
    WHERE student.id IN (SELECT id FROM education WHERE id IN ($opleidingen)) 
    AND keuzedeel.id IN ($keuzedelen)
    AND groepen.cohort IN ($cohorten)
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        // Verwerk de resultaten
        foreach ($result as $row) {
            echo "Student ID: " . htmlspecialchars($row['student_id']) . " - Keuzedeel: " . htmlspecialchars($row['keuzedeel_naam']) . " - Jaar: " . htmlspecialchars($row['jaar']) . "<br>";
        }
    } else {
        echo "Geen resultaten gevonden.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
