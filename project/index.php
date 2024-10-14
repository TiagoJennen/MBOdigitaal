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
    <title>Selecteer Keuzedelen</title>
    <?php require '../views/templates/head.php'; ?>
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
    <?php require '../views/templates/menu.php'; ?>
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
                <div class="label-container">
                    <div class="label">
                        <label>Selecteer een opleiding:</label><br>
                        <?php while ($opleiding = $opleidingenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                            <div>
                                <input type="checkbox" name="opleiding[]" value="<?= $opleiding['id']; ?>"> 
                                <?= isset($opleiding['name']) ? htmlspecialchars($opleiding['name']) : 'Onbekend'; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="label">
                        <label>Selecteer een keuzedeel:</label><br>
                        <?php while ($keuzedeel = $keuzedelenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                            <div>
                                <input type="checkbox" name="keuzedeel[]" value="<?= $keuzedeel['id']; ?>"> 
                                <?= isset($keuzedeel['title']) ? htmlspecialchars($keuzedeel['title']) : 'Onbekend'; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="label">
                        <label>Selecteer een cohort:</label><br>
                        <?php while ($cohort = $cohortenQuery->fetch(PDO::FETCH_ASSOC)): ?>
                            <div>
                                <input type="checkbox" name="cohort[]" value="<?= $cohort['id']; ?>"> 
                                <?= isset($cohort['name']) ? htmlspecialchars($cohort['name']) : 'Onbekend'; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div id="error-message" style="color: red; display: none; text-align: center; margin-top: 20px; font-size: 18px;">
                U moet ten minste drie vakjes aanvinken.
            </div>
            <div class="search-button-container">
                <button type="submit" style="padding: 12px 25px; background-color: #1D4ED8; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background-color 0.3s;">
                    Zoek
                </button>
            </div>
        </form>
    </div>
    <?php require '../views/templates/footer.php'; ?>
</body>
</html>
