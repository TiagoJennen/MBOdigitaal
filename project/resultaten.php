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

$opleidingen = $_GET['opleiding'] ?? [];
$keuzedelen = $_GET['keuzedeel'] ?? [];
$cohorten = $_GET['cohort'] ?? [];

if (empty($opleidingen) || empty($keuzedelen) || empty($cohorten)) {
    echo "<p>U moet ten minste één opleiding, keuzedeel en cohort selecteren.</p>";
    exit;
}

$opleidingIds = implode(',', array_map('intval', $opleidingen));
$keuzedeelIds = implode(',', array_map('intval', $keuzedelen));
$cohortIds = implode(',', array_map('intval', $cohorten));

$query = "SELECT s.naam AS student_naam
          FROM student s
          JOIN student_keuzedeel sk ON s.id = sk.student_id
          JOIN keuzedeel k ON sk.keuzedeel_id = k.id
          JOIN groepen g ON sk.cohort_id = g.id
          WHERE g.id IN ($cohortIds)
          AND k.id IN ($keuzedeelIds)";

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
    </style>
</head>
<body>
    <?php require '../views/templates/menu.php'; ?> 
    <div class="container">
        <h2>Studenten Resultaten</h2>

        <?php if (count($results) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= htmlspecialchars($result['student_naam']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Geen studenten gevonden voor de geselecteerde criteria.</p>
        <?php endif; ?>
    </div>
    <?php require '../views/templates/footer.php'; ?>
</body>
</html>
