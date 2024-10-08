<?php
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

if (!empty($_GET['opleiding']) && !empty($_GET['keuzedeel']) && !empty($_GET['cohort'])) {
    $opleidingen = implode(", ", $_GET['opleiding']);
    $keuzedelen = implode(", ", $_GET['keuzedeel']);
    $cohorten = implode(", ", $_GET['cohort']);
    
    $sql = "SELECT studenten.naam, keuzedelen.naam AS keuzedeel_naam, cohorten.jaar 
            FROM studenten
            JOIN student_keuzedeel ON studenten.id = student_keuzedeel.student_id
            JOIN keuzedelen ON student_keuzedeel.keuzedeel_id = keuzedelen.id
            JOIN cohorten ON studenten.cohort_id = cohorten.id
            WHERE studenten.opleiding_id IN ($opleidingen)
            AND keuzedelen.id IN ($keuzedelen)
            AND cohorten.id IN ($cohorten)";
            
    $stmt = $pdo->query($sql);
    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Geen selectie gemaakt.");
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Resultaten</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Resultaten</h2>
        <?php if (!empty($resultaten)): ?>
            <table>
                <tr>
                    <th>Student</th>
                    <th>Keuzedeel</th>
                    <th>Cohort</th>
                </tr>
                <?php foreach ($resultaten as $resultaat): ?>
                    <tr>
                        <td><?= htmlspecialchars($resultaat['naam']); ?></td>
                        <td><?= htmlspecialchars($resultaat['keuzedeel_naam']); ?></td>
                        <td><?= htmlspecialchars($resultaat['jaar']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Geen resultaten gevonden voor de geselecteerde filters.</p>
        <?php endif; ?>
    </div>
</body>
</html>
