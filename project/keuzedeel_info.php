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

$keuzedeelId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($keuzedeelId > 0) {
    $sql = "SELECT naam, beschrijving, SBU, vakgebied FROM keuzedelen WHERE id = :id"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $keuzedeelId]);
    $keuzedeel = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($keuzedeel) {
        $beschrijving = nl2br(htmlspecialchars($keuzedeel['beschrijving']));

        ?>
        <!DOCTYPE html>
        <html lang="nl">
        <head>
            <meta charset="UTF-8">
            <title>Keuzedeel Info</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="container">
                <h2>Informatie over keuzedeel: <?= htmlspecialchars($keuzedeel['naam']); ?></h2>
                <p><strong>Beschrijving:</strong><br> <?= $beschrijving; ?></p>
                <p></p>
                <p><strong>SBU:</strong> <?= htmlspecialchars($keuzedeel['SBU'] ?? 'Niet beschikbaar'); ?></p> 
                <p><strong>Vakgebied:</strong> <?= htmlspecialchars($keuzedeel['vakgebied'] ?? 'Niet beschikbaar'); ?></p>
                <a href="index.php">Terug naar overzicht</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Keuzedeel niet gevonden.</p>";
    }
} else {
    echo "<p>Geen geldig keuzedeel geselecteerd.</p>";
}
?>
