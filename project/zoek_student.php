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
    die("Fout bij verbinden met database: " . $e->getMessage());
}

$student = null; // Start met een lege student

if (isset($_GET['student'])) {
    $studentNaam = $_GET['student'];

    // Zoek naar de student met de opgegeven naam
    $studentQuery = $pdo->prepare("SELECT * FROM student WHERE naam LIKE :naam");
    $studentQuery->execute(['naam' => '%' . $studentNaam . '%']);
    $student = $studentQuery->fetch(PDO::FETCH_ASSOC);

    // Als de student gevonden is, zoek de keuzedelen
    if ($student) {
        // Update deze regel met de juiste kolomnaam
        $keuzedelenQuery = $pdo->prepare("SELECT k.title FROM keuzedeel k
                                            JOIN student_keuzedeel sk ON k.id = sk.keuzedeel_id
                                            WHERE sk.student_id = :student_id");
        $keuzedelenQuery->execute(['student_id' => $student['id']]);
        $keuzedelen = $keuzedelenQuery->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $keuzedelen = [];
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zoek Resultaten</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Zoekresultaten voor <?= isset($studentNaam) ? htmlspecialchars($studentNaam) : ''; ?></h2>

        <?php if ($student): ?>
            <p>Student: <?= htmlspecialchars($student['naam']) ?></p>
            <h3>Keuzedelen:</h3>
            <ul>
                <?php foreach ($keuzedelen as $keuzedeel): ?>
                    <li><?= htmlspecialchars($keuzedeel['title']) ?></li> <!-- Gebruik hier ook de juiste kolomnaam -->
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Geen student gevonden met de naam "<?= htmlspecialchars($studentNaam) ?>".</p>
        <?php endif; ?>
    </div>
</body>
</html>
