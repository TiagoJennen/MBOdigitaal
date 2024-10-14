<?php
// Database configuratie
$host = "127.0.0.1";
$dbName = "mbodigital";
$user = "mbogodigitalUser";
$password = "Vrieskist@247";

try {
    // Maak verbinding met de database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

// Ontvang de waarden van de checkboxen
$opleidingen = $_GET['opleiding'] ?? [];
$keuzedelen = $_GET['keuzedeel'] ?? [];
$cohorten = $_GET['cohort'] ?? [];

// Controleer of er geselecteerde waarden zijn
if (empty($opleidingen) || empty($keuzedelen) || empty($cohorten)) {
    echo "<p>U moet ten minste één opleiding, keuzedeel en cohort selecteren.</p>";
    exit;
}

// Query om de resultaten op te halen op basis van de geselecteerde checkboxen
$query = "SELECT r.*, 
          e.name AS opleiding_naam, 
          k.title AS keuzedeel_titel, 
          g.name AS cohort_naam, 
          s.naam AS student_naam 
          FROM resultaten r
          JOIN education e ON r.education_id = e.id
          JOIN keuzedeel k ON r.keuzedeel_id = k.id
          JOIN groepen g ON r.groepen_id = g.id
          JOIN student s ON r.student_id = s.id 
          WHERE e.id IN (" . implode(',', array_map('intval', $opleidingen)) . ")
          AND k.id IN (" . implode(',', array_map('intval', $keuzedelen)) . ")
          AND g.id IN (" . implode(',', array_map('intval', $cohorten)) . ")";

try {
    $results = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Fout bij het ophalen van resultaten: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Resultaten</title>
    <?php require '../views/templates/head.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php require '../views/templates/menu.php'; ?>
    <div class="container">
        <h2>Resultaten</h2>

        <?php if (count($results) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Opleiding</th>
                        <th>Keuzedeel</th>
                        <th>Cohort</th>
                        <th>Student</th>
                        <th>Score</th>
                        <th>Datum</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= htmlspecialchars($result['opleiding_naam']) ?></td>
                            <td><?= htmlspecialchars($result['keuzedeel_titel']) ?></td>
                            <td><?= htmlspecialchars($result['cohort_naam']) ?></td>
                            <td><?= htmlspecialchars($result['student_naam']) ?></td>
                            <td><?= htmlspecialchars($result['score']) ?></td>
                            <td><?= htmlspecialchars($result['datum']) ?></td>
                            <td><a href="details.php?id=<?= htmlspecialchars($result['id']) ?>">Bekijk Details</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Geen resultaten gevonden voor de geselecteerde criteria.</p>
        <?php endif; ?>
    </div>
    <?php require '../views/templates/footer.php'; ?>
</body>
</html>
