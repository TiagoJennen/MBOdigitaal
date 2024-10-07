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

$opleidingenQuery = $pdo->query('SELECT * FROM opleidingen');
$keuzedelenQuery = $pdo->query('SELECT * FROM keuzedelen');
$cohortenQuery = $pdo->query('SELECT * FROM cohorten');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Keuzedelen</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            const opleidingCheckboxes = document.querySelectorAll('input[name="opleiding[]"]:checked');
            const keuzedeelCheckboxes = document.querySelectorAll('input[name="keuzedeel[]"]:checked');
            const cohortCheckboxes = document.querySelectorAll('input[name="cohort[]"]:checked');

            const totalChecked = opleidingCheckboxes.length + keuzedeelCheckboxes.length + cohortCheckboxes.length;

            const errorMessage = document.getElementById('error-message');
            if (totalChecked < 3) {
                errorMessage.style.display = 'block';
                return false; 
            } else {
                errorMessage.style.display = 'none';
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="search-student">
            <form action="zoek_student.php" method="GET">
                <input type="text" name="student" placeholder="Zoek student..." required>
                <button type="submit">Zoek</button>
            </form>
        </div>

        <h2>Selecteer een opleiding, keuzedeel en cohort</h2>

        <form action="resultaten.php" method="GET" onsubmit="return validateForm()">
            <div class="filter">
                <label>Selecteer een opleiding:</label><br>
                <?php while ($opleiding = $opleidingenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                    <input type="checkbox" name="opleiding[]" value="<?= $opleiding['id']; ?>"> <?= htmlspecialchars($opleiding['naam']); ?><br>
                <?php endwhile; ?>
            </div>

            <div class="filter">
                <label>Selecteer een keuzedeel:</label><br>
                <?php while ($keuzedeel = $keuzedelenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                    <input type="checkbox" name="keuzedeel[]" value="<?= $keuzedeel['id']; ?>"> <?= htmlspecialchars($keuzedeel['naam']); ?>
                    <a href="keuzedeel_info.php?id=<?= $keuzedeel['id']; ?>">ℹ️</a><br>
                <?php endwhile; ?>
            </div>

            <div class="filter">
                <label>Selecteer een cohort:</label><br>
                <?php while ($cohort = $cohortenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                    <input type="checkbox" name="cohort[]" value="<?= $cohort['id']; ?>"> <?= htmlspecialchars($cohort['jaar']); ?><br>
                <?php endwhile; ?>
            </div>

            <div id="error-message" style="color: red; display: none;">
                U moet ten minste drie vakjes aanvinken.
            </div>
            <button type="submit">Zoek</button>
        </form>
    </div>
</body>
</html>
