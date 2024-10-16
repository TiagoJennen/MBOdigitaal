<?php
session_start();

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

$keuzedelenQuery = $pdo->query("SELECT * FROM keuzedeel");
$keuzedelen = $keuzedelenQuery->fetchAll(PDO::FETCH_ASSOC);

$opleidingenQuery = $pdo->query("SELECT * FROM opleiding");
$opleidingen = $opleidingenQuery->fetchAll(PDO::FETCH_ASSOC);

$cohortenQuery = $pdo->query("SELECT * FROM cohort");
$cohorten = $cohortenQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Student Toevoegen</title>
</head>
<body>
    <h2>Nieuwe Student Toevoegen</h2>
    <form method="POST" action="">
        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" required>

        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required>

        <label for="opleiding">Opleiding:</label>
        <select id="opleiding" name="opleiding_id" required>
            <?php foreach ($opleidingen as $opleiding): ?>
                <option value="<?= $opleiding['id'] ?>"><?= htmlspecialchars($opleiding['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <h3>Selecteer Keuzedelen:</h3>
        <?php foreach ($keuzedelen as $keuzedeel): ?>
            <div>
                <input type="checkbox" id="keuzedeel_<?= $keuzedeel['id'] ?>" name="keuzedelen[]" value="<?= $keuzedeel['id'] ?>">
                <label for="keuzedeel_<?= $keuzedeel['id'] ?>"><?= htmlspecialchars($keuzedeel['title']) ?></label>
            </div>
        <?php endforeach; ?>

        <label for="cohort">Cohort:</label>
        <select id="cohort" name="cohort_id" required>
            <?php foreach ($cohorten as $cohort): ?>
                <option value="<?= $cohort['id'] ?>"><?= htmlspecialchars($cohort['naam']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Voeg Student Toe</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $opleidingId = $_POST['opleiding_id'];
        $keuzedelen = isset($_POST['keuzedelen']) ? $_POST['keuzedelen'] : [];
        $cohortId = $_POST['cohort_id'];

        $insertStudent = $pdo->prepare("INSERT INTO student (voornaam, achternaam, cohort_id) VALUES (:voornaam, :achternaam, :cohort_id)");
        $insertStudent->execute(['voornaam' => $voornaam, 'achternaam' => $achternaam, 'cohort_id' => $cohortId]);
        $studentId = $pdo->lastInsertId(); 

        $insertOpleiding = $pdo->prepare("INSERT INTO studenten_opleidingen (student_id, opleiding_id) VALUES (:student_id, :opleiding_id)");
        $insertOpleiding->execute(['student_id' => $studentId, 'opleiding_id' => $opleidingId]);

        foreach ($keuzedelen as $keuzedeelId) {
            $insertKeuzedeel = $pdo->prepare("INSERT INTO student_keuzedeel (student_id, keuzedeel_id) VALUES (:student_id, :keuzedeel_id)");
            $insertKeuzedeel->execute(['student_id' => $studentId, 'keuzedeel_id' => $keuzedeelId]);
        }

        echo "<p>Student {$voornaam} {$achternaam} succesvol toegevoegd!</p>";
    }
    ?>
</body>
</html>
