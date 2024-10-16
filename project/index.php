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

$opleidingenQuery = $pdo->query('SELECT * FROM education');
$keuzedelenQuery = $pdo->query('SELECT * FROM keuzedeel');
$cohortenQuery = $pdo->query('SELECT * FROM groepen');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecteer Keuzedelen</title>
    <?php require '../views/templates/head.php'; ?>
    <link rel="stylesheet" href="styles.css">
    <script>    	
        function validateForm() {
            const opleidingCheckboxes = document.querySelectorAll('input[name="opleiding[]"]:checked');
            const keuzedeelCheckboxes = document.querySelectorAll('input[name="keuzedeel[]"]:checked');
            const cohortCheckboxes = document.querySelectorAll('input[name="cohort[]"]:checked');

            const errorMessage = document.getElementById('error-message');

            if (opleidingCheckboxes.length < 1 || keuzedeelCheckboxes.length < 1 || cohortCheckboxes.length < 1) {
                errorMessage.textContent = 'U moet ten minste één opleiding, één keuzedeel en één cohort selecteren.';
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
    <?php require '../views/templates/menu.php'; ?>
    <main class="container">
        <section class="search-student">
            <form action="zoek_student.php" method="GET">
                <input type="text" name="student" placeholder="Zoek student..." required>
                <button type="submit">Zoek</button>
            </form>
        </section>

        <h2><strong>Selecteer een opleiding, keuzedeel en cohort</strong></h2>
        <br>
        <form action="resultaten.php" method="GET" onsubmit="return validateForm()">
            <div class="filter">
                <div class="label">
                    <label><strong>Selecteer een opleiding:</strong></label><br>
                    <br>
                    <?php while ($opleiding = $opleidingenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                        <div>
                            <input type="checkbox" name="opleiding[]" value="<?= htmlspecialchars($opleiding['id']); ?>" aria-label="Opleiding <?= htmlspecialchars($opleiding['name']); ?>"> 
                            <?= htmlspecialchars($opleiding['name']) ?: 'Onbekend'; ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="label">
                    <label><strong>Selecteer een keuzedeel:</strong></label><br>
                    <br>
                    <?php while ($keuzedeel = $keuzedelenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                        <div>
                            <input type="checkbox" name="keuzedeel[]" value="<?= htmlspecialchars($keuzedeel['id']); ?>" aria-label="Keuzedeel <?= htmlspecialchars($keuzedeel['title']); ?>"> 
                            <?= htmlspecialchars($keuzedeel['title']) ?: 'Onbekend'; ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="label">
                <label><strong>Selecteer een cohort:</strong></label><br>
                <br>
                    <?php while ($cohort = $cohortenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                        <div>
                            <input type="checkbox" name="cohort[]" value="<?= htmlspecialchars($cohort['id']); ?>" aria-label="Cohort <?= htmlspecialchars($cohort['name']); ?>"> 
                            <?= htmlspecialchars($cohort['name']) ?: 'Onbekend'; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div id="error-message" class="error-message">
                U moet ten minste één opleiding, één keuzedeel en één cohort selecteren.
            </div>

            <div class="search-button-container">
                <button type="submit" class="search-button">Zoek</button>
            </div>
        </form>
    </main>
    <?php require '../views/templates/footer.php'; ?>
</body>
</html>
