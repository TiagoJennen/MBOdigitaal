<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$student = null; 
$keuzedelen = [];
$studentNaam = '';

if (isset($_GET['student'])) {
    $studentNaam = trim($_GET['student']); 

    $studentQuery = $pdo->prepare("
        SELECT s.id, s.naam, e.name AS opleiding, g.cohort AS cohort 
        FROM student s
        LEFT JOIN student_cohort sc ON s.id = sc.student_id  
        LEFT JOIN groepen g ON sc.groep_id = g.id            
        LEFT JOIN education e ON g.educationId = e.id        
        WHERE LOWER(s.naam) LIKE LOWER(:naam)
    ");

    $likeNaam = '%' . $studentNaam . '%'; 
    $studentQuery->execute(['naam' => $likeNaam]);
    $student = $studentQuery->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $keuzedelenQuery = $pdo->prepare("
            SELECT k.title FROM keuzedeel k
            JOIN student_keuzedeel sk ON k.id = sk.keuzedeel_id
            WHERE sk.student_id = :student_id
        ");
        $keuzedelenQuery->execute(['student_id' => $student['id']]);
        $keuzedelen = $keuzedelenQuery->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (isset($_POST['add_student_to_cohort'])) {
    $studentId = $_POST['student_id'];
    $groepId = $_POST['groep_id'];

    $insertQuery = $pdo->prepare("
        INSERT INTO student_cohort (id, student_id, groep_id) 
        VALUES (UUID(), :student_id, :groep_id)
    ");
    
    $insertQuery->execute(['student_id' => $studentId, 'groep_id' => $groepId]);
    header("Location: " . $_SERVER['PHP_SELF'] . "?student=" . urlencode($studentNaam));
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zoek Resultaten</title>
    <?php require '../views/templates/head.php'; ?>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; 
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px; 
            margin: 20px auto; 
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        }

        h2 {
            text-align: center; 
        }

        p {
            text-align: center; 
            font-size: 1.1em;  
        }

        h3 {
            text-align: center; 
        }

        ul {
            list-style-type: none; 
            padding: 0; 
        }

        li {
            text-align: center; 
            margin: 5px 0; 
        }
    </style>
</head>
<body>
    <?php require '../views/templates/menu.php'; ?>
    <div class="container">
        <p><strong>Resultaten </strong></p>
        <br>
        <?php if ($student): ?>
            <p><strong>Student: </strong><?= htmlspecialchars($student['naam']) ?></p>
            <br>
            <p><strong>Opleiding: </strong><?= htmlspecialchars($student['opleiding'] ?? 'Geen opleiding gevonden') ?></p>
            <br>
            <p><strong>Cohort: </strong><?= htmlspecialchars($student['cohort'] ?? 'Geen cohort gevonden') ?></p>
            <br>
            <p><strong>Keuzedelen:</strong></p>
            <ul>
                <?php if (!empty($keuzedelen)): ?>
                    <?php foreach ($keuzedelen as $keuzedeel): ?>
                        <li><?= htmlspecialchars($keuzedeel['title']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Geen keuzedelen gevonden voor deze student.</li>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <p>Geen student gevonden met de naam "<?= htmlspecialchars($studentNaam) ?>".</p>
        <?php endif; ?>
    </div>
    <?php require '../views/templates/footer.php'; ?>
</body>
</html>
