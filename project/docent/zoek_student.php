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

if (isset($_GET['student'])) {
    $studentNaam = $_GET['student'];

    $studentQuery = $pdo->prepare("SELECT * FROM studenten WHERE naam LIKE :naam");
    $studentQuery->execute(['naam' => '%' . $studentNaam . '%']);
    $student = $studentQuery->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $keuzedelenQuery = $pdo->prepare("SELECT k.naam FROM keuzedelen k
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
        <h2>Zoekresultaten voor <?= htmlspecialchars($studentNaam) ?></h2>

        <?php if ($student): ?>
            <p>Student: <?= htmlspecialchars($student['naam']) ?></p>
            <h3>Keuzedelen:</h3>
            <ul>
                <?php foreach ($keuzedelen as $keuzedeel): ?>
                    <li><?= htmlspecialchars($keuzedeel['naam']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Geen student gevonden met de naam "<?= htmlspecialchars($studentNaam) ?>".</p>
        <?php endif; ?>
    </div>
</body>
</html>
